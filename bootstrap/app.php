<?php


use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Tymon\JWTAuth\Http\Middleware\Authenticate as JwtAuthenticate;
use Tymon\JWTAuth\Http\Middleware\RefreshToken as JwtRefresh;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Ensure CORS runs for all requests
        // $middleware->append(HandleCors::class);

        // (optional) or only for the API group:
        // $middleware->group('api', [HandleCors::class]);
        // Register JWT aliases (Laravel 11)
        $middleware->alias([
            'jwt.auth'    => JwtAuthenticate::class,
            'jwt.refresh' => JwtRefresh::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

