<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Inertia\Inertia;
use Throwable;

class Handler extends ExceptionHandler {
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
    public function register() {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render exception in our own way
     */
    public function render($request, Throwable $e) {
        $response = parent::render($request, $e);

        if (app()->environment('production') && in_array($response->getStatusCode(), [500, 503, 404, 403])) {
            return Inertia::render('Error', [
                'status' => $response->getStatusCode(),
                'message' => $e->getMessage()
            ])
            ->toResponse($request)
            ->setStatusCode($response->getStatusCode())
            ;
        } else if ($response->getStatusCode() == 419) {
            return back()->with([
                'message' => 'Page expired, please try again'
            ]);
        }

        return $response;
    }
}
