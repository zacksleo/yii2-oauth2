<?php
return [
    'id' => 'yii2-test-console',
    'basePath' => dirname(__DIR__),
    'components' => [
        'cache' => null,
        'db' => require __DIR__ . '/../../common/config/db.php',
    ],
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => [
                '@console/migrations/',
                '@zacksleo/yii2/oauth2/migrations',
            ],
        ],
    ],
];
