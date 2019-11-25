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
        ],
        'test1'=>[
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
            'db_set'=>0,
        ],
        'job'=>[
            'host'=>'127.0.0.1',
            'port'=>'6379',
            'auth'=>'alonexy',
            'db_set'=>0,
        ]
    ],
    'mongodb'=>[
        'default'=>[
            'uri'=>'mongodb://127.0.0.1:27017',
            'appname'=>'test',
            'authSource'=>'admin',
            'username'=>'admin',
            'password'=>'123456'
        ]
    ]
];