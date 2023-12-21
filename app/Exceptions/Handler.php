<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Symfony\Component\HttpFoundation\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e ): \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
    {
        if ($e instanceof ModelNotFoundException) {
            return response()->json([
                'message' => 'Sorry OBJECT not found',
                'success' => false
            ], Response::HTTP_NOT_FOUND);
        }
        if ($e instanceof QueryException) {
            return response()->json([
                'message' => $e->getMessage(),
                'success' =>  false
            ], Response::HTTP_EXPECTATION_FAILED);
        }
        if ($e instanceof BindingResolutionException) {
            return response()->json([
                'message' => $e->getMessage(),
                'success' =>  false
            ], Response::HTTP_EXPECTATION_FAILED);
        }
        if ($e instanceof ValidationException) {
            return response()->json([
                'message' => $e->getMessage(),
                'success' =>  false
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if ($e instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'message' => $e->getMessage(),
                'success' =>  false
            ], Response::HTTP_METHOD_NOT_ALLOWED);
        }
        if ($e instanceof NotFoundHttpException) {
            return response()->json([
                'message' => 'Sorry request route not found.',
                'data' => [
                    'route' => request()->path(),
                    'method' => request()->method(),
                    'time' => now()->toDateTimeString(),
                    'info' => [
                        'message' => 'For more details you can reach out to our engineering team',
                        'data' => [
                            'email' => 'dev@meremco.com',
                            'phoneNumber' => '+2348100788859'
                        ]
                    ]
                ],
                'success' => false
            ], Response::HTTP_NOT_FOUND);
        }
        if ($e instanceof AuthenticationException) {
            return  response()->json([
                'message' =>  $e->getMessage(),
                'success' => false
            ], Response::HTTP_UNAUTHORIZED);
        }
        if ($e instanceof DatabaseException) {
            return $e->render();
        }
        return  response()->json([
            'message' => 'Sorry there was an  error contact the backend team',
            'error' => $e->getMessage(),
            'data' => [
                'route' => request()->path(),
                'method' => request()->method(),
                'time' => now()->toDateTimeString(),
                'info' => [
                    'message' => 'For more details you can reach out to our engineering team',
                    'data' => [
                        'email' => 'dev@meremco.com',
                        'phoneNumber' => '+2348100788859'
                    ]
                ]
            ],
            'success' => false
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

}
