<?php

return [
    'url' => env('API_URL', env('API_BASE_URL')), // URL de la API de citas
    'limitRequest' => env('API_LIMIT', env('RATE_LIMIT')), // Límite de peticiones por minuto
    'windowTime' => env('API_WINDOW_TIME', env('RATE_LIMIT_DURATION')), // Duración de ventana de tiempo en segundos
];