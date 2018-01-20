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
        'class' => 'yii\web\User',
        'identityClass' => 'common\models\User',
    ],
    'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'enableStrictParsing' => false,
        'rules' => [
            [
                'class' => 'yii\rest\UrlRule',
                'controller' => 'token',
                'only' => ['create', 'options'],
            ],
        ]
    ],
    'assetManager' => [
        'basePath' => __DIR__ . '/../web/assets',
    ],
];
