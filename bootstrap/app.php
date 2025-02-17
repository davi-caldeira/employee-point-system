<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Routing\Middleware\ThrottleRequests;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up'
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register your middleware aliases here.
        // For example, 'admin' for AdminMiddleware and 'throttle' if needed.
        $middleware->alias([
            'admin'    => AdminMiddleware::class,
            'throttle' => ThrottleRequests::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
    })
    ->create();
