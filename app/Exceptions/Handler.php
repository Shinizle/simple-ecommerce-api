<?php

namespace App\Exceptions;

use Error;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
            //
        });

        $this->renderable(function (UnauthorizedException $e, $request) {
            return response()->json(['message' => $e->getMessage()], $e->getStatusCode());
        });

        $this->renderable(function (\ParseError $e, $request) {
            return response()->json(['message' => 'Server Error', 'error' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], 500);
        });

        $this->renderable(function (Error $e, $request) {
            return response()->json(['message' => 'Server Error', 'error' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], 500);
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($e->getMessage()) {
                return response()->json(['message' => $e->getMessage()], 404);
            }

            return response()->json(['message' => 'Page not found or URL is invalid.'], 404);
        });
    }
}
