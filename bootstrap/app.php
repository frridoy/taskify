<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'isHR' => \App\Http\Middleware\isHR::class,
            'isSuperAdmin' => \App\Http\Middleware\isSuperAdmin::class,
            'isEmployee' => \App\Http\Middleware\isEmployee::class,
            'isHR_isEmployee' => \App\Http\Middleware\isHR_isEmployee::class,
            'isAdmin_isManager' => \App\Http\Middleware\isAdmin_isManager::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
