<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationData;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Disable CSRF
        // $middleware->validateCsrfTokens(except: [
        //     '/*',
        // ]);

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

        // Report when Errors Occur (Usualy sent to Slack or Sentry)
        $exceptions->report(function (Throwable $e) {
            var_dump($e);
            return false; // Break the exception chain
        });

        // Dont Report when Errors Occur
        $exceptions->dontReport([
            App\Exceptions\ValidationException::class,
        ]);

        // Custom Exception
        $exceptions->renderable(function (App\Exceptions\ValidationException $e, Illuminate\Http\Request $request) {
            return response('Bad Request', 400);
        });
    })->create();
