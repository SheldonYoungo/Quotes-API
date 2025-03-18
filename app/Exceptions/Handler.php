<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Throwable;

class Handler extends ExceptionHandler
{

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ThrottleRequestsException) {
            $retryAfter = $exception->getHeaders()['Retry-After'] ?? 60; // Tiempo de espera en segundos
            return response()->json([
                'message' => 'Has excedido el límite de peticiones. Por favor, intenta de nuevo en ' . $retryAfter . ' segundos.',
            ], 429)->header('Retry-After', $retryAfter);
        }
    
        return parent::render($request, $exception);
    }
}