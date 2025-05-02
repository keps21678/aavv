<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            return redirect()->route('home'); // Redirige a la vista welcome
        }

        if ($exception instanceof \ErrorException) {
            return response()->view('errors.custom', ['message' => $exception->getMessage()], 500);
        }

        return parent::render($request, $exception);
    }
}
