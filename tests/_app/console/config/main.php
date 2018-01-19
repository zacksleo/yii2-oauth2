<?php
return [
    'id' => 'yii2-test-console',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@zacksleo/yii2/oauth2/' => dirname(dirname(dirname(__DIR__))),
    ],
    'components' => [
        'log' => null,
        'cache' => null,
        'db' => require __DIR__ . '/../../common/config/db.php',
    ],
];
