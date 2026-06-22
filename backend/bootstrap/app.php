<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        // Domain "not found" errors → 404
        $exceptions->render(function (\RuntimeException $e, Request $request) {
            if ($request->is('api/*') && str_ends_with($e->getMessage(), 'not found.')) {
                return new JsonResponse(['message' => $e->getMessage()], 404);
            }
        });

        // Domain rule violations (invalid status transition, etc.) → 422
        $exceptions->render(function (\DomainException $e, Request $request) {
            if ($request->is('api/*')) {
                return new JsonResponse(['message' => $e->getMessage()], 422);
            }
        });

        // Domain value object validation (invalid UUID, email, etc.) → 422
        $exceptions->render(function (\InvalidArgumentException $e, Request $request) {
            if ($request->is('api/*')) {
                return new JsonResponse(['message' => $e->getMessage()], 422);
            }
        });

        // Duplicate resource errors (email/plate already exists) → 409
        $exceptions->render(function (\RuntimeException $e, Request $request) {
            if ($request->is('api/*') && str_ends_with($e->getMessage(), 'already exists.')) {
                return new JsonResponse(['message' => $e->getMessage()], 409);
            }
        });

        // Laravel form validation → 422 con detalle de campos
        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                return new JsonResponse([
                    'message' => 'The given data was invalid.',
                    'errors'  => $e->errors(),
                ], 422);
            }
        });
    })->create();
