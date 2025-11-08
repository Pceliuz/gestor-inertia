<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class EstudianteController extends Controller
{
    public function index()
    {
        return Inertia::render('DashboardEstudiante');
    }
}
