<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            '/*',
        ]);

        // Append the Middleware class to the middleware stack
        // $middleware->append([
        //     App\Http\Middleware\ContohMiddleware::class,
        // ]);

        $middleware->group('pzn', [
            'contoh:PZN,401',
        ]);

        $middleware->alias([
            'contoh' => App\Http\Middleware\ContohMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
