<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['*'],           // Aquí está configurado ya para todas las rutas api/...   OJO, api/ no es el archivo api.php.
                                    // Recuerda que las rutas que configuramos en web.php se invocan   www.dominio.com/index.php
                                    // ...mientras que las rutas que configuramos en api.php se invocan   www.dominio.com/api/index.php 
                                    // Por lo tanto, si quiero asignar el CORS también a las rutas de web.php, debo poner ['*'] y no ['web/*'], ya que no existe ninguna ruta  www.dominio.com/web/...   a no ser que la creemos explícitamente.

    'allowed_methods' => ['*'],

    'allowed_origins' => ['*'],              // ['http://localhost:8080', '*']

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
