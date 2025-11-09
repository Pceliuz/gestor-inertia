<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        // 🔹 Login especial admin hardcoded
        if ($request->email === 'admin@senati.pe' && $request->password === 'admin183') {
            // Crear un usuario admin temporal o buscar uno existente
            $admin = User::firstOrCreate(
                ['email' => 'admin@senati.pe'],
                [
                    'name' => 'Administrador',
                    'password' => bcrypt('admin183'),
                    'role' => 'admin',
                ]
            );

            Auth::login($admin); // 🔹 Iniciar sesión de Laravel
            $request->session()->regenerate(); // 🔹 Regenerar sesión
            return redirect('/welcome'); // 🔹 Redirección
        }

        // 🔹 Login normal para profesor y estudiante
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->role === 'profesor') {
            return redirect()->route('estudiantes.index');
        }

        if ($user->role === 'estudiante') {
            return redirect()->route('estudiantes.create');
        }

        // Fallback
        return redirect('/welcome');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
