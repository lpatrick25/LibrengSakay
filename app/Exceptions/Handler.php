<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            Log::error('Exception occurred: ' . $e->getMessage());
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {

            // Authorization errors (Spatie / FormRequest)
            if ($exception instanceof AuthorizationException) {
                return response()->json([
                    'message' => 'This action is unauthorized.',
                ], 403);
            }

            // Validation errors
            if ($exception instanceof ValidationException) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $exception->errors(),
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // Resource not found
            if ($exception instanceof ModelNotFoundException) {
                return response()->json([
                    'message' => 'Resource not found',
                ], Response::HTTP_NOT_FOUND);
            }

            // Route not found
            if ($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'message' => 'The requested route was not found',
                ], Response::HTTP_NOT_FOUND);
            }

            // Method not allowed
            if ($exception instanceof MethodNotAllowedHttpException) {
                return response()->json([
                    'message' => 'The HTTP method is not allowed for this route',
                ], Response::HTTP_METHOD_NOT_ALLOWED);
            }

            // Maintenance mode
            if ($exception instanceof ServiceUnavailableHttpException) {
                return response()->json([
                    'message' => 'The service is temporarily unavailable (maintenance mode)',
                ], Response::HTTP_SERVICE_UNAVAILABLE);
            }

            // Database exceptions
            if ($exception instanceof QueryException || $exception instanceof UniqueConstraintViolationException) {

                // Foreign key constraint violation (cannot delete)
                if (($exception instanceof QueryException && $exception->errorInfo[1] == 1451)) {
                    return response()->json([
                        'message' => 'Cannot delete this resource because it is currently in use.',
                    ], 409);
                }

                // Unique constraint violation (duplicate entry)
                if (($exception instanceof UniqueConstraintViolationException) ||
                    ($exception instanceof QueryException && $exception->errorInfo[1] == 1062)
                ) {

                    preg_match("/Duplicate entry '(.+)' for key '(.+)'/", $exception->getMessage(), $matches);
                    $value = $matches[1] ?? 'Value';
                    $field = $matches[2] ?? 'field';

                    // Clean up field name
                    $field = str_replace(['users_', '_unique'], '', $field);

                    return response()->json([
                        'message' => ucfirst($field) . " '{$value}' is already in use.",
                    ], 409);
                }

                // Other DB errors
                return response()->json([
                    'message' => 'A database error occurred',
                    'details' => $exception->getMessage(),
                ], 500);
            }

            // Generic HTTP exception
            if ($exception instanceof HttpException) {
                return response()->json([
                    'message' => $exception->getMessage() ?: 'An error occurred',
                ], $exception->getStatusCode());
            }

            // Catch-all for other exceptions
            return response()->json([
                'message' => 'An unexpected error occurred',
                'details' => $exception->getMessage(),
            ], 500);
        }

        return parent::render($request, $exception);
    }
}
