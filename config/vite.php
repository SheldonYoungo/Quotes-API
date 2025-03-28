<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Vite Manifest Path
    |--------------------------------------------------------------------------
    |
    | This option defines the path to the Vite manifest file. This file is
    | generated when building your assets for production and is used to
    | resolve the hashed file names.
    |
    */

    'manifest_path' =>  public_path('build/manifest.json'),

    /*
    |--------------------------------------------------------------------------
    | Vite Dev Server URL
    |--------------------------------------------------------------------------
    |
    | This option defines the URL of the Vite development server. This is
    | used to load assets during local development.
    |
    */

    'dev_server_url' => env('VITE_DEV_SERVER_URL', 'http://localhost:5173'),
];