<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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

    /**
     * Register the exception handling callbacks for the application.
     */
    public function report(Exception|Throwable $exception)
    {
        parent::report($exception);
    }

    public function render($request, Exception|Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $modelName = class_basename($e->getModel());
            $apiErrorCode = $modelName. 'NotFoundException';
            $message = $modelName. ' not found.';

            return response()->json([
                'error' => $apiErrorCode,
                'message' => $message
            ], 404);
        }

        return parent::render($request, $e);
    }

}
