<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\ResultType;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



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
        //
    }
    public function render($request, Throwable $exception)
    
    {
        if ($exception instanceof ModelNotFoundException)
        return (new ApiController)->apiResponse(ResultType::Errors, null, str_replace('App\\', '', $exception->getModel()) .
         ' Not Found', JsonResponse::HTTP_NOT_FOUND);
        
        if ($exception instanceof NotFoundHttpException)
        return (new ApiController)->apiResponse(ResultType::Errors, null, 
        'Page Not Found', JsonResponse::HTTP_NOT_FOUND);

        return parent::render($request, $exception);
    }
}
