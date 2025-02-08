<?php

use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\NoCacheHeaders;
use App\Http\Middleware\PreventCheatingMiddleware;
use App\Http\Middleware\SiswaAuth;
use App\Http\Middleware\KacapAuth;
use App\Http\Middleware\TentorAuth;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
            'SiswaAuth' => SiswaAuth::class,
            'AdminAuth' => AdminAuth::class,
            'KacapAuth' => KacapAuth::class,
            'TentorAuth' => TentorAuth::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Handle exceptions here
    })->create();
