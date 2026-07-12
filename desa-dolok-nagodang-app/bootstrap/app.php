<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'track.visitor' => \App\Http\Middleware\TrackVisitor::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $shouldRenderJson = static function (Request $request): bool {
            return $request->is('api/*') || $request->expectsJson();
        };

        $exceptions->render(function (ValidationException $exception, Request $request) use ($shouldRenderJson) {
            if (! $shouldRenderJson($request)) {
                return null;
            }

            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $exception->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        });

        $exceptions->render(function (AuthenticationException $exception, Request $request) use ($shouldRenderJson) {
            if (! $shouldRenderJson($request)) {
                return null;
            }

            return response()->json([
                'success' => false,
                'message' => 'Anda belum login atau sesi Anda sudah berakhir.',
                'errors' => [
                    'auth' => ['Autentikasi diperlukan untuk mengakses resource ini.'],
                ],
            ], Response::HTTP_UNAUTHORIZED);
        });

        $exceptions->render(function (AuthorizationException $exception, Request $request) use ($shouldRenderJson) {
            if (! $shouldRenderJson($request)) {
                return null;
            }

            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk melakukan aksi ini.',
            ], Response::HTTP_FORBIDDEN);
        });

        $exceptions->render(function (ModelNotFoundException $exception, Request $request) use ($shouldRenderJson) {
            if (! $shouldRenderJson($request)) {
                return null;
            }

            return response()->json([
                'success' => false,
                'message' => 'Data yang diminta tidak ditemukan.',
            ], Response::HTTP_NOT_FOUND);
        });

        $exceptions->render(function (HttpExceptionInterface $exception, Request $request) use ($shouldRenderJson) {
            if (! $shouldRenderJson($request)) {
                return null;
            }

            $statusCode = $exception->getStatusCode();

            return response()->json([
                'success' => false,
                'message' => match ($statusCode) {
                    Response::HTTP_NOT_FOUND => 'Endpoint yang diminta tidak ditemukan.',
                    Response::HTTP_METHOD_NOT_ALLOWED => 'Metode request tidak diizinkan untuk endpoint ini.',
                    Response::HTTP_FORBIDDEN => 'Anda tidak memiliki izin untuk mengakses resource ini.',
                    default => 'Permintaan tidak dapat diproses.',
                },
            ], $statusCode, $exception->getHeaders());
        });

        $exceptions->render(function (\Throwable $exception, Request $request) use ($shouldRenderJson) {
            if (! $shouldRenderJson($request)) {
                return null;
            }

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        });
    })->create();
