<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    /**
     * Muestra la vista principal con los últimos 10 usuarios registrados.
     */
    public function index()
    {
        // Obtener los últimos 10 usuarios registrados
        $users = User::select('id', 'name', 'email')
                    ->latest()
                    ->take(10)
                    ->get();

        return Inertia::render('Welcome', [
            'activeUsers' => $users
        ]);
    }
}
