<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class ProfesorController extends Controller
{
    public function index()
    {
        return Inertia::render('DashboardProfesor');
    }
}
