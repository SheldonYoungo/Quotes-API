<?php

return [
    'url' => env('API_URL', 'https://dummyjson.com/quotes'), // URL de la API de citas
    'limitRequest' => env('API_LIMIT', 60), // Límite de peticiones por minuto
    'windowTime' => env('API_WINDOW_TIME', 60), // Duración de ventana de tiempo en segundos
];