<?php

namespace SAASBoilerplate\App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     * @param  Throwable  $exception
     * @throws Throwable
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }


    /**
     * @param  Request  $request
     * @param  Throwable  $exception
     * @return JsonResponse|\Illuminate\Http\Response|Response
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    }
}
