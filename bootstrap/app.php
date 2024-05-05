<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (ValidationException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation error',
                'data' => $e->errors(),
            ], $e->status);
        });

        $exceptions->renderable(function (NotFoundHttpException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
                'data' => [],
            ], 404);
        });

        $exceptions->renderable(function (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
                'data' => [],
            ], 404);
        });

        $exceptions->renderable(function (AuthenticationException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
                'data' => [],
            ], 401);
        });

        $exceptions->renderable(function (AuthorizationException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
                'data' => [],
            ], 403);
        });

        $exceptions->renderable(function (RouteNotFoundException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
                'data' => [],
            ], 404);
        });

        $exceptions->renderable(function (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
                'data' => [],
            ], 500);
        });
    })->create();
