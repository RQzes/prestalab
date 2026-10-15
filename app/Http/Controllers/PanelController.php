<?php

namespace App\Http\Controllers;

use App\Models\Equipo;

class PanelController extends Controller
{
    /** Cada rol ve un panel distinto. */
    public function index()
    {
        if (auth()->user()->esEncargado()) {
            $resumen = [
                'total' => Equipo::count(),
                'disponibles' => Equipo::disponibles()->count(),
                'prestados' => Equipo::where('estado', Equipo::PRESTADO)->count(),
            ];

            return view('panel.encargado', compact('resumen'));
        }

        // El estudiante solo consulta: únicamente equipos disponibles.
        $equipos = Equipo::disponibles()->orderBy('categoria')->orderBy('nombre')->get();

        return view('panel.estudiante', compact('equipos'));
    }
}
