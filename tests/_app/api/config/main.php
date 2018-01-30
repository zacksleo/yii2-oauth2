<?php
return [
    'id' => 'app-api',
    'name' => 'api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'components' => require(__DIR__ . '/components.php'),
    'modules' => require(__DIR__ . '/modules.php'),
];
