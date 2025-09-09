<?php

// return [

//     // CORS applies to API routes only
//     'paths' => ['api/*'],

//     'allowed_methods' => ['*'],

//     // Pull allowed origins from env (comma-separated)
//     'allowed_origins' => array_map('trim', explode(',', env('CORS_ALLOWED_ORIGINS', '*'))),

//     // You can keep this empty unless you prefer regex patterns
//     'allowed_origins_patterns' => [
//         // Example to allow all Vercel previews for your project:
//         // '^https://aprillia-porto(-.*)?\.vercel\.app$',
//     ],

//     // Allow common headers (incl. Authorization for Bearer tokens)
//     'allowed_headers' => ['*'],

//     'exposed_headers' => [],

//     'max_age' => 0,

//     // Token/Bearer auth = false. (If you later use cookie auth, set true)
//     'supports_credentials' => false,
// ];


return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => array_map('trim', explode(',', env('CORS_ALLOWED_ORIGINS', '*'))),
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false, // token mode; change to true only if you later use cookies
];

