<script setup>
import { Head, router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
  activeUsers: Array
})

const processing = ref(false)
const showToast = ref(false)

const logout = () => {
  if (processing.value) return
  processing.value = true

  router.post('/logout', {}, {
    onSuccess: () => {
      showToast.value = true
      setTimeout(() => {
        showToast.value = false
        window.location.href = '/login'
      }, 2000)
    },
    onFinish: () => {
      processing.value = false
    }
  })
}
</script>

<template>
  <Head title="Bienvenido" />

  <!-- Fondo animado -->
  <div id="app-background" class="min-h-screen flex flex-col font-sans text-white">

    <!-- Toast -->
    <transition name="fade">
      <div
        v-if="showToast"
        class="fixed top-6 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 text-sm font-medium animate-fadeIn z-50"
      >
        ✅ Sesión cerrada correctamente
      </div>
    </transition>

    <!-- Header -->
    <header class="flex items-center justify-between px-8 py-4 bg-white/10 backdrop-blur-lg border-b border-white/20 shadow-md">
      <div class="flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="w-10 h-10 text-yellow-300 drop-shadow-lg">
          <circle cx="32" cy="32" r="30" fill="currentColor" opacity="0.15" />
          <path d="M16 36l8 8 24-24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <h1 class="text-2xl font-extrabold tracking-wide">
          <span class="text-yellow-300">Gestor</span> de Notas
        </h1>
      </div>

      <button
        @click="logout"
        :disabled="processing"
        class="bg-gradient-to-r from-red-600 to-rose-600 hover:from-rose-600 hover:to-red-600 transition-all duration-200 px-5 py-2 rounded-xl font-semibold shadow-md hover:shadow-rose-400/30 flex items-center gap-2 hover-glow disabled:opacity-60 disabled:cursor-not-allowed"
      >
        <span v-if="processing" class="flex items-center gap-2">
          <svg class="w-5 h-5 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
          </svg>
          Cerrando sesión...
        </span>
        <span v-else>🚪 Cerrar sesión</span>
      </button>
    </header>

    <!-- Main -->
    <main class="flex-grow flex flex-col justify-center items-center px-6 py-10">
      <div class="text-center bg-white/10 backdrop-blur-xl p-10 rounded-3xl shadow-2xl border border-white/20 w-[90%] md:w-[600px] animate-fadeIn">
        <h2 class="text-4xl font-extrabold mb-6 drop-shadow-md">
          🌙 ¡Bienvenido de nuevo!
        </h2>

        <div class="flex flex-col gap-6 mt-4">
          <a
            href="/estudiantes"
            class="bg-gradient-to-r from-blue-700 to-indigo-600 hover:from-indigo-600 hover:to-blue-700 text-white font-semibold py-4 rounded-xl shadow-md hover:shadow-blue-400/40 transition-all transform hover:-translate-y-1 hover-glow flex items-center justify-center gap-3 text-lg"
          >
            🎓 <span>Estudiantes</span>
          </a>
        </div>

        <!-- Lista de últimos 10 usuarios -->
        <div class="mt-10 bg-white/10 rounded-2xl p-6 shadow-lg border border-white/10">
          <h3 class="text-xl font-bold mb-4 text-yellow-300">👥 Últimos usuarios registrados</h3>

          <table v-if="activeUsers && activeUsers.length" class="w-full text-sm text-left border-collapse">
            <thead class="border-b border-white/20 text-yellow-200 uppercase text-xs">
              <tr>
                <th class="py-2 px-3">#</th>
                <th class="py-2 px-3">Nombre</th>
                <th class="py-2 px-3">Correo</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(user, index) in activeUsers"
                :key="user.id"
                class="border-b border-white/10 hover:bg-white/10 transition"
              >
                <td class="py-2 px-3 text-gray-300">{{ index + 1 }}</td>
                <td class="py-2 px-3">{{ user.name }}</td>
                <td class="py-2 px-3 text-gray-400">{{ user.email }}</td>
              </tr>
            </tbody>
          </table>

          <p v-else class="text-white/60 italic">
            No hay usuarios registrados todavía.
          </p>
        </div>

        <p class="text-sm text-white/60 mt-10">
          © {{ new Date().getFullYear() }} — <span class="text-violet-400 font-medium">Gestor de Notas</span><br />
          Todos los derechos reservados.
        </p>
      </div>
    </main>
  </div>
</template>

<style>
/* Fondo animado tipo SENATI */
#app-background {
  background: linear-gradient(-45deg, #2563eb, #3b82fa, #1e40af, #77aac7ad);
  background-size: 400% 400%;
  animation: gradientShift 12s ease infinite;
}

/* Animaciones */
@keyframes gradientShift {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

.animate-fadeIn {
  animation: fadeIn 0.8s ease-out;
}

/* Glow hover */
.hover-glow:hover {
  box-shadow: 0 0 20px rgba(139, 92, 246, 0.4);
  transform: translateY(-2px);
}

/* Toast fade */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
