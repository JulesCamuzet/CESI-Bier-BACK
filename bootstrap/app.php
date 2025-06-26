<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',          // tes routes web (si tu en as)
        api: __DIR__.'/../routes/api.php',          // ajout des routes API ici
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            \Illuminate\Http\Middleware\HandleCors::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            '/products',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
