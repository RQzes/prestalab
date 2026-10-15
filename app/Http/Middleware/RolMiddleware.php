<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Deja pasar solo a usuarios con el rol indicado: ->middleware(RolMiddleware::class.':encargado')
 */
class RolMiddleware
{
    public function handle(Request $request, Closure $next, string $rol): Response
    {
        if ($request->user()?->rol !== $rol) {
            return redirect()->route('dashboard')
                ->with('error', 'No tienes permiso para entrar a esa página.');
        }

        return $next($request);
    }
}
