<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Muestra la vista de login.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'profesor') {
                return redirect()->route('dashboard.profesor');
            } else {
                return redirect()->route('dashboard.estudiante');
            }
        }

        return view('auth.login');
    }

    /**
     * Procesa el inicio de sesión.
     */
    public function login(Request $request)
    {
        // Validar los datos del formulario
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Intentar iniciar sesión
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // 🔹 Redirección por rol
            if ($user->role === 'profesor') {
                return redirect()->route('dashboard.profesor');
            } else {
                return redirect()->route('dashboard.estudiante');
            }
        }

        // Si falla, mostrar mensaje de error
        return back()->withErrors([
            'email' => 'Las credenciales no son correctas.',
        ])->onlyInput('email');
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
