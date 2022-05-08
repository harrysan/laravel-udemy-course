<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // $this->renderable(function (NotFoundHttpException $e, $request) {
        //     return Route::respondWithRoute('api.fallback');
        // });
    }

    // public function render($request, Throwable $exception)
    // {
    //     if ($exception instanceof ModelNotFoundException && $request->wantsJson()) {
    //         return response()->json(
    //             [
    //                 'message' => 'Resource not found'
    //             ],
    //             404
    //         );
    //     }
    
    //     return parent::render($request, $exception);
    // }

    // or

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException && $request->wantsJson()) {
            return Route::respondWithRoute('api.fallback');
        }

        if ($request->expectsJson() && $exception instanceof AuthorizationException) {
            return response()->json(['message' => $exception->getMessage()], 403);
        }

        // dd(get_class($exception));
        // AuthorizationException
    
        return parent::render($request, $exception);
    }
}
