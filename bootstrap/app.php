<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Auth\Access\Gate as GateDeniedException;



return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        api: __DIR__ . '/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $responder = new class {
            use \App\Traits\HttpResponses;
        };

        $exceptions->render(function (AuthenticationException $e, $request) use ($responder) {
            return $responder->errorResponse('Unauthenticated.', 401);
        });

        $exceptions->render(function (AuthorizationException|GateDeniedException|AccessDeniedHttpException $e, $request) use ($responder) {
            return $responder->errorResponse('Unauthorized action.', 403);
        });

    })->create();
