<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
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
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report( $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof UnauthorizedHttpException) {
            $preException = $exception->getPrevious();

            if ($preException instanceof
                \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json([
                    'status'  => false,
                    'error'   => 'TOKEN_EXPIRED',
                    'message' => 'Token is expired'
                ], 401);
            } else if ($preException instanceof
                \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json([
                    'status'  => false,
                    'error'   => 'TOKEN_INVALID',
                    'message' => 'Token is invalid'
                ], 401);
            } else if ($preException instanceof
                \Tymon\JWTAuth\Exceptions\TokenBlacklistedException) {
                return response()->json([
                    'status'  => false,
                    'error'   => 'TOKEN_BLACKLISTED',
                    'message' => 'Token is blacklisted'
                ], 401);
            }
            if ($exception->getMessage() === 'Token not provided') {
                return response()->json([
                    'status'  => false,
                    'error'   => 'Token not provided',
                    'message' => 'Token not provided'
                ], 401);
            }
        }

        if ($exception instanceof AuthorizationException)
        {
            return response()->json([
                'status' => false,
                'message' => 'Not authorize'
            ], 403);
        }


        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'status' => false,
                'message' => 'API is not found'
            ], 404);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage()
            ], 404);
        }

        if ($exception instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }


        return parent::render($request, $exception);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        if ($e->response) {
            return $e->response;
        }
        return $this->invalidJson($request, $e);
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
            'status'     => false,
            'message'    => $exception->getMessage(),
            'messages' => $exception->errors(),
        ], 400);
    }
}
