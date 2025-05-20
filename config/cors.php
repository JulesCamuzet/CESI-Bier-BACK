<?php
return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'], // assure-toi que 'api/*' est bien là

    'allowed_methods' => ['*'],

    'allowed_origins' => ['http://localhost:5173'], // ou ['*'] temporairement

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false, // ou true si tu utilises des cookies

];
