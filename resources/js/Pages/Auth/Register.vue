<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<template>
  <Head title="Registro" />

  <main class="container">
    <!-- Lado izquierdo -->
    <section class="brand-card">
      <div class="logo">
        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="g" x1="0" x2="1" y1="0" y2="1">
              <stop offset="0" stop-color="#2563eb" />
              <stop offset="1" stop-color="#10b981" />
            </linearGradient>
          </defs>
          <rect width="100" height="100" rx="18" fill="url(#g)" />
          <circle cx="50" cy="50" r="18" fill="#ffffff" opacity="0.9" />
        </svg>

        <div>
          <div class="brand-title">Gestor de Notas</div>
          <div class="brand-sub">Registro de nuevo usuario</div>
        </div>
      </div>

      <p class="hero">
        Crea tu cuenta para acceder al sistema de gestión académica 📘
      </p>

      <p class="foot-note">
        © {{ new Date().getFullYear() }} Gestor de Notas — Aprender con estilo.
      </p>
    </section>

    <!-- Formulario -->
    <section class="form-card">
      <h1>Registro</h1>

      <form @submit.prevent="submit" novalidate>
        <div>
          <label for="name">Nombre</label>
          <input
            id="name"
            type="text"
            v-model="form.name"
            class="input"
            placeholder="Nombre completo"
            required
            autofocus
            autocomplete="name"
          />
          <div v-if="form.errors.name" class="error">{{ form.errors.name }}</div>
        </div>

        <div class="mt-4">
          <label for="email">Correo electrónico</label>
          <input
            id="email"
            type="email"
            v-model="form.email"
            class="input"
            placeholder="correo@dominio.com"
            required
            autocomplete="username"
          />
          <div v-if="form.errors.email" class="error">{{ form.errors.email }}</div>
        </div>

        <div class="mt-4">
          <label for="password">Contraseña</label>
          <input
            id="password"
            type="password"
            v-model="form.password"
            class="input"
            placeholder="••••••••"
            required
            autocomplete="new-password"
          />
          <div v-if="form.errors.password" class="error">{{ form.errors.password }}</div>
        </div>

        <div class="mt-4">
          <label for="password_confirmation">Confirmar contraseña</label>
          <input
            id="password_confirmation"
            type="password"
            v-model="form.password_confirmation"
            class="input"
            placeholder="••••••••"
            required
            autocomplete="new-password"
          />
          <div v-if="form.errors.password_confirmation" class="error">
            {{ form.errors.password_confirmation }}
          </div>
        </div>

        <div class="mt-6 flex items-center justify-between">
          <Link href="/login" class="link">
            ¿Ya tienes cuenta?
          </Link>

          <button
            type="submit"
            class="btn"
            :disabled="form.processing"
          >
            {{ form.processing ? 'Registrando...' : 'Registrar' }}
          </button>
        </div>
      </form>
    </section>
  </main>
</template>

<style>
:root {
  --primary: #003366;  /* Azul SENATI institucional */
  --secondary: #2563eb; /* Azul moderno */
  --accent: #f97316;   /* Naranja energético */
  --neutral: #e5e7eb;
  --text: #1e293b;
  --card-bg: rgba(255, 255, 255, 0.15);
  --radius: 14px;
  --shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
  font-family: 'Inter', system-ui, sans-serif;
}

body {
  margin: 0;
  background: linear-gradient(135deg, var(--primary), var(--secondary));
  background-size: 400% 400%;
  animation: gradientShift 16s ease infinite;
  color: var(--text);
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
}

@keyframes gradientShift {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

.container {
  width: 100%;
  max-width: 960px;
  display: grid;
  grid-template-columns: 420px 1fr;
  gap: 32px;
  align-items: center;
  backdrop-filter: blur(18px);
  padding: 20px;
}

.brand-card {
  background: var(--card-bg);
  border-radius: var(--radius);
  padding: 40px;
  box-shadow: var(--shadow);
  color: #fff;
}
.logo {
  display: flex;
  align-items: center;
  gap: 14px;
}
.brand-title {
  font-size: 22px;
  font-weight: 700;
  color: #fff;
}
.brand-sub {
  color: #dbeafe;
  font-size: 14px;
}
.hero { font-size: 15px; color: #f1f5f9; }
.foot-note { font-size: 12px; color: #cbd5e1; margin-top: auto; }

.form-card {
  background: #ffffffcc;
  border-radius: var(--radius);
  padding: 36px;
  box-shadow: var(--shadow);
  min-width: 380px;
}
h1 {
  margin-bottom: 20px;
  font-size: 26px;
  font-weight: 700;
  color: var(--primary);
  text-align: center;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

label {
  display: block;
  font-size: 14px;
  color: #374151;
  margin-bottom: 6px;
}
.input {
  width: 100%;
  background: #fff;
  border: 1px solid #cbd5e1;
  padding: 12px 14px;
  border-radius: 10px;
  font-size: 15px;
  color: #1e293b;
  transition: all 0.25s ease;
}
.input:focus {
  border-color: var(--secondary);
  box-shadow: 0 0 10px rgba(37, 99, 235, 0.4);
  outline: none;
}

.btn {
  background: linear-gradient(90deg, var(--primary), var(--secondary));
  color: #fff;
  font-weight: 600;
  padding: 12px 20px;
  border-radius: 10px;
  border: none;
  cursor: pointer;
  transition: all 0.25s ease;
}
.btn:hover {
  background: var(--accent);
  transform: scale(1.03);
  box-shadow: 0 6px 18px rgba(249, 115, 22, 0.4);
}
.btn:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.link {
  color: var(--secondary);
  text-decoration: underline;
  font-size: 14px;
}
.link:hover {
  color: var(--accent);
}

.error {
  color: #dc2626;
  font-size: 13px;
  margin-top: 6px;
}

@media (max-width: 880px) {
  .container { grid-template-columns: 1fr; }
  .brand-card { order: 2; text-align: center; }
  .form-card { order: 1; min-width: unset; }
}
</style>





