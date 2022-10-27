<?php

namespace App\Exceptions;

use Error;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use function PHPUnit\Framework\throwException;

class Handler extends ExceptionHandler
{

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        ExecuteException::class
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
    public function register()
    {
        $this->reportable(function (Throwable $e) {
        });

        $this->renderable(function (Throwable $e, $request) {
            $debugMode = env('app_debug');
            if ($request->is('api/*')){
                if ($e instanceof ValidationException){
                    return restful_error($e->validator->errors()->first(),$e->status);
                }elseif ($e instanceof ExecuteException){
                    return restful_error($e->getMessage());
                }
                if ($e instanceof MethodNotAllowedHttpException){
                    return restful_error('Method not allow',405);
                }
                elseif ($e instanceof AuthenticationException){
                    return restful_error('Authentication',401);
                }
                elseif ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException){
                    return restful_error($e->getMessage());
                }elseif ($e instanceof QueryException){
                    if ($debugMode){
                        return restful_error(
                            'File: ' . $e->getFile() .
                            ', Line: ' . $e->getLine() .
                            ', Message: ' . $e->getMessage(),
                            409);
                    }else{
                        return restful_error(
                            "loi query db",
                            409);
                    }
                }
                else{
                    if ($debugMode){
                        return restful_error(
                            'File: ' . $e->getFile() .
                            ', Line: ' . $e->getLine() .
                            ', Message: ' . $e->getMessage(),
                            503);
                    }else{
                        return restful_error("Service Unavailable",503);
                    }
                }
            }

        });
    }

}
