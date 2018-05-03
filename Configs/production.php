<?php
return [
    'displayErrorDetails' => true,
    'determineRouteBeforeAppMiddleware' => true,
    'debug' => true,
    'db'=>[
        'default'=>[
            'host'=>'127.0.0.1',
            'dbname'=>'push',
            'user'=>'root',
            'pass'=>'',
        ]
    ],
    'redis'=>[
        'default'=>[
            'host'=>'127.0.0.1',
            'port'=>'6379',
            'auth'=>'alonexy',
        ]
    ]
];