<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;
use Spatie\Permission\Models\Permission;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            // Alias bawaan Laravel (seperti 'auth', 'guest', dll.)
            // ...
            
            // --- Alias Spatie Laravel Permission ---
            'role' => RoleMiddleware::class,
            'permission' => Permission::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class, // Opsional
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
