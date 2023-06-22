<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Http\Response;
use App\Providers\RouteServiceProvider;

use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($request->isJson()) {
            $message = __('An unexpected error has occurred, please try again in the next few minutes. If this error persists, contact your support team.');
            $error = $exception->getMessage();

            if ($exception instanceof ModelNotFoundException) {
                $message = __('Resource not found.');
                $error = 'Entry for ' . str_replace('App', '', $exception->getModel()) . ' not found';
                return response()->json(['message' => $message, 'error' => $error], Response::HTTP_NOT_FOUND);
            }

            if ($exception instanceof AuthenticationException) {
                return response()->json(['error' => 'Unauthenticated', 'message' => __('Not authenticated.')], Response::HTTP_UNAUTHORIZED);
            }

            if ($exception instanceof ValidationException) {
                $message = __('Validation exception.');
                $error = $exception->getMessage();
                return response()->json(['message' => $message, 'error' => $error], Response::HTTP_BAD_REQUEST);
            }

            if ($exception instanceof UnauthorizedException) {
                $message = __('You do not have sufficient permissions to access this resource.');
                return response()->json(['error' => __('Unauthenticated.'), 'message' => $message], Response::HTTP_FORBIDDEN);
            }

            return response()->json(['message' => $message, 'error' => $error], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($exception instanceof UnauthorizedException) {
            return redirect()->intended(RouteServiceProvider::UNAUTHORIZED);
        }

        return parent::render($request, $exception);
    }
}
