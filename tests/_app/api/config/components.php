<?php
return [
    'request' => [
        'baseUrl' => '/api',
    ],
    'response' => [
        'format' => \yii\web\Response::FORMAT_JSON
    ],
    'errorHandler' => [
        'errorAction' => 'site/error',
    ],
    'user' => [
        'identityClass' => 'app\models\User',
        'enableAutoLogin' => true,
        'loginUrl' => ['site/login'],
        'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true, 'path' => '/api'],
    ],
    'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'enableStrictParsing' => false,
        'rules' => [
            [
                'class' => 'yii\rest\UrlRule',
                'controller' => 'v1/token',
                'only' => ['create', 'options'],
            ],
        ]
    ],
    'assetManager' => [
        'basePath' => __DIR__ . '/../web/assets',
    ],
];
