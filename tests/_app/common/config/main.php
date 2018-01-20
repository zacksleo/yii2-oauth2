<?php
return [
    'id' => 'yii2-user-tests',
    'language' => 'en-US',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(dirname(dirname(__DIR__)))) . '/vendor',
    'components' => [
        'db' => require __DIR__ . '/db.php',
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['trace', 'error', 'info', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
    ],
    'params' => [],
];
