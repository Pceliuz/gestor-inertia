<?php

namespace App\Http\Controllers\Notas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NotasController extends Controller
{
    /**
     * Muestra la lista de notas simuladas.
     */
    public function index()
    {
        $simulaciones = session()->get('simulaciones', []);

        return Inertia::render('Notas/Index', [
            'notas' => $simulaciones,
        ]);
    }

    /**
     * Muestra el formulario de simulación.
     */
    public function simulacion()
    {
        return Inertia::render('Notas/Simulacion');
    }

    /**
     * Procesa los datos del formulario y calcula la simulación.
     */
    public function calcularSimulacion(Request $request)
    {
        $data = $request->validate([
            'participacion' => 'required|numeric|min:0|max:20',
            'habilidades' => 'required|numeric|min:0|max:20',
            'asistencia' => 'required|numeric|min:0|max:20',
            'video_test' => 'required|array|min:1',
            'video_test.*' => 'numeric|min:0|max:20',
            'evaluacion_parcial' => 'required|array|min:1',
            'evaluacion_parcial.*' => 'numeric|min:0|max:20',
            'entregable' => 'required|numeric|min:0|max:20',
            'examen_final' => 'required|numeric|min:0|max:20',
        ]);

        $notas = [
            'participacion' => $data['participacion'],
            'habilidades' => $data['habilidades'],
            'asistencia' => $data['asistencia'],
            'video_test' => $data['video_test'],
            'evaluacion_parcial' => $data['evaluacion_parcial'],
            'entregable' => $data['entregable'],
            'examen_final' => $data['examen_final']
        ];

        $pesos = [
            'participacion' => 10,
            'habilidades' => 10,
            'asistencia' => 10,
            'video_test' => 20,
            'evaluacion_parcial' => 20,
            'entregable' => 30,
            'examen_final' => 30
        ];

        $sum_ponderada = 0;
        $sum_pesos = 0;

        foreach ($notas as $modulo => $nota) {
            $promedio = is_array($nota) ? array_sum($nota) / count($nota) : $nota;
            $sum_ponderada += $promedio * $pesos[$modulo];
            $sum_pesos += $pesos[$modulo];
        }

        $promedio_final = round($sum_ponderada / $sum_pesos, 2);
        $estado = $promedio_final >= 10.5 ? 'APROBADO ✅' : 'REPROBADO ❌';

        // Guardamos simulaciones en sesión
        $simulaciones = session()->get('simulaciones', []);
        $simulaciones[] = [
            'participacion' => $data['participacion'],
            'habilidades' => $data['habilidades'],
            'asistencia' => $data['asistencia'],
            'video_test' => implode(', ', $data['video_test']),
            'evaluacion_parcial' => implode(', ', $data['evaluacion_parcial']),
            'entregable' => $data['entregable'],
            'examen_final' => $data['examen_final'],
            'promedio_final' => $promedio_final,
            'estado' => $estado,
        ];
        session()->put('simulaciones', $simulaciones);

        return Inertia::render('Notas/Simulacion', [
            'resultado' => [
                'promedio_final' => $promedio_final,
                'estado' => $estado,
            ]
        ]);
    }
}
