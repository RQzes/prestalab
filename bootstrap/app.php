<?php

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Cualquier fallo de MySQL se muestra como mensaje entendible, nunca como error técnico.
        $exceptions->render(function (QueryException $e, $request) {
            Log::error('Error de base de datos: '.$e->getMessage());

            return response()->view('errors.bd', [], 500);
        });
    })->create();
