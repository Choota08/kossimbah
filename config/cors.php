<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    // ❌ JANGAN '*'
    'allowed_origins' => [
        'http://localhost:8080',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // 🔥 WAJIB TRUE kalau login
    'supports_credentials' => true,

];
