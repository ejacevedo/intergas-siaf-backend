<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
// use Illuminate\Auth\Middleware\Authenticate;

// use Illuminate\Database\Eloquent\ModelNotFoundException;


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
            if ($exception instanceof ModelNotFoundException) {
                return response()->json(
                    [
                        'message' => 'External API call failed',
                        'error' => 'Entry for '.str_replace('App', '', $exception->getModel()).' not found'
                    ], 404);
            } else if($exception instanceof AuthenticationException) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            } else if($exception instanceof ValidationException) {
                return response()->json(
                    [ 
                        'message' => 'Validation exception.',  
                        'error' => $exception->getMessage()
                    ],400);
            }
            else {
                return response()->json(
                [ 
                    'message' => 'External API call failed ',  
                    'error' => $exception->getMessage()
                ],500);
            }
        }
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(['error' => '123213Unauthenticated.'], 401);
    }

    // protected function unauthenticated($request, AuthenticationException $exception) 
    // {
    //     if ($request->expectsJson()) {
    //         return response()->json(['error' => 'Unauthenticated11.'], 401);
    //     }

    //     return redirect()->guest('login');
    // }

    // protected function unAuthenticated($request, AuthenticationException $exception)
    // {
    //     return $request->expectsJson()
    //                 ? response()->json(['message' => $exception->getMessage()], 401)
    //                 : redirect()->guest(route('loactions'));
    // }

    // protected function unauthenticated($request, AuthenticationException $exception)
    // {
    //     if ($request->expectsJson()) {
    //         return response()->json(['error' => 'Unauthenticated.'], 401);
    //     }

    //     // return a plain 401 response even when not a json call
    //     return response('Unauthenticated.', 401);
    // }

    // protected function unauthenticated($request, AuthenticationException $exception) 
    // {
    //     if ($request->expectsJson()) {
    //         return response()->json(['error' => 'Unauthenticated.'], 401);
    //     }

    //     return redirect()->guest('login');
    // }

    // protected function unauthenticated($request, AuthenticationException $exception)
    // {
    //     if ($request->expectsJson()) {
    //         return response()->json(['error' => 'Unauthenticated.'], 401);
    //     }

    //     return redirect()->guest(route('locations'));
    // }

    // protected function unauthenticated($request, AuthenticationException $exception)
    // {
    //     if ($request->expectsJson()) {
    //         return response()->json(['error' => 'Unauthenticated.'], 401);
    //     }

    //     // return a plain 401 response even when not a json call
    //     return response('Unauthenticated.', 401);
    // }
}
