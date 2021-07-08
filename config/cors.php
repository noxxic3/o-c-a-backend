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

    'paths' => ['*'],
    /*
    Here CORS is already configured for all ('*')  web (/) and  api (api/) paths. NOTE, api/ is not the api.php file.
    This 'paths' configuration would affect in this way:   www.domain.com/*
    Remember that the routes that we configure in web.php are invoked www.domain.com/index.php
    ... while the routes that we configure in api.php are invoked     www.domain.com/api/index.php
    Therefore, if I want to assign CORS only to api.php paths, I should put ['api/*'].
    */

    'allowed_methods' => ['*'],

    'allowed_origins' => ['*'],              // ['http://localhost:8080', '*']       // http://localhost:8080  is the local frontend

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
