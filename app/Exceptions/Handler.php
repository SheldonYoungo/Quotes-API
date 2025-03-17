<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Request;
use Throwable;

class Handler extends \Illuminate\Foundation\Exceptions\Handler
{
    public function render($request, Throwable $exception) {
        if($exception instanceof ThrottleRequestsException) {

            return response()->json([
                'message' => 'Has excedido el límite de peticiones. Por favor, intenta de nuevo en ' . $exception->getHeaders()['Retry-After'] . ' segundos.',
            ], 429);
        }

        return parent::render($request, $exception);
    }
}
