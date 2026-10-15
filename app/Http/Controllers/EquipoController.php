<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

/** Solo accesible para el Encargado (ver routes/web.php). */
class EquipoController extends Controller
{
    private const MSG_BD = 'No pudimos completar la operación por un problema con la base de datos. Inténtalo de nuevo en unos minutos.';

    public function index()
    {
        $equipos = Equipo::with('prestatario')->orderBy('codigo')->get();
        $estudiantes = User::where('rol', User::ESTUDIANTE)->orderBy('name')->get();

        return view('equipos.index', compact('equipos', 'estudiantes'));
    }

    public function create()
    {
        return view('equipos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate($this->reglas());

        try {
            Equipo::create($datos + ['estado' => Equipo::DISPONIBLE]);
        } catch (QueryException $e) {
            return $this->falloBd($e)->withInput();
        }

        return redirect()->route('equipos.index')->with('ok', 'Equipo registrado correctamente.');
    }

    public function edit(Equipo $equipo)
    {
        return view('equipos.edit', compact('equipo'));
    }

    public function update(Request $request, Equipo $equipo): RedirectResponse
    {
        $datos = $request->validate($this->reglas($equipo));

        try {
            $equipo->update($datos);
        } catch (QueryException $e) {
            return $this->falloBd($e)->withInput();
        }

        return redirect()->route('equipos.index')->with('ok', 'Equipo actualizado correctamente.');
    }

    public function destroy(Equipo $equipo): RedirectResponse
    {
        if ($equipo->estaPrestado()) {
            return back()->with('error', 'No puedes eliminar un equipo que está prestado. Primero registra su devolución.');
        }

        try {
            $equipo->delete();
        } catch (QueryException $e) {
            return $this->falloBd($e);
        }

        return redirect()->route('equipos.index')->with('ok', 'Equipo eliminado.');
    }

    public function prestar(Request $request, Equipo $equipo): RedirectResponse
    {
        $request->validate([
            'estudiante_id' => ['required', Rule::exists('users', 'id')->where('rol', User::ESTUDIANTE)],
        ], [
            'estudiante_id.required' => 'Debes elegir a qué estudiante se le presta el equipo.',
            'estudiante_id.exists' => 'El estudiante elegido no es válido.',
        ]);

        try {
            $prestado = DB::transaction(function () use ($equipo, $request) {
                // Bloqueo de fila: evita prestar dos veces el mismo equipo a la vez.
                $actual = Equipo::lockForUpdate()->findOrFail($equipo->id);

                if ($actual->estaPrestado()) {
                    return false;
                }

                $actual->update([
                    'estado' => Equipo::PRESTADO,
                    'prestado_a' => $request->estudiante_id,
                ]);

                return true;
            });
        } catch (QueryException $e) {
            return $this->falloBd($e);
        }

        return $prestado
            ? back()->with('ok', "Equipo {$equipo->codigo} prestado correctamente.")
            : back()->with('error', 'Ese equipo ya está prestado.');
    }

    public function devolver(Equipo $equipo): RedirectResponse
    {
        if (! $equipo->estaPrestado()) {
            return back()->with('error', 'Ese equipo ya estaba disponible.');
        }

        try {
            $equipo->update(['estado' => Equipo::DISPONIBLE, 'prestado_a' => null]);
        } catch (QueryException $e) {
            return $this->falloBd($e);
        }

        return back()->with('ok', "Equipo {$equipo->codigo} devuelto: vuelve a estar disponible.");
    }

    private function reglas(?Equipo $equipo = null): array
    {
        return [
            'codigo' => ['required', 'string', 'max:50', Rule::unique('equipos', 'codigo')->ignore($equipo?->id)],
            'nombre' => ['required', 'string', 'max:100'],
            'categoria' => ['required', 'string', 'max:50'],
        ];
    }

    private function falloBd(QueryException $e): RedirectResponse
    {
        Log::error('Error de base de datos: '.$e->getMessage());

        return back()->with('error', self::MSG_BD);
    }
}
