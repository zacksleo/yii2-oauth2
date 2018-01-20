<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@api', dirname(dirname(__DIR__)) . '/api');
Yii::setAlias('@zacksleo/yii2/oauth2', dirname(dirname(dirname(dirname(__DIR__)))) . '/src');
(new \Dotenv\Dotenv(dirname(dirname(dirname(__DIR__)))))->load();
//Yii::$container->set('user_credentials', 'common\models\User');
//Yii::$container->set('access_token', 'zacksleo\yii2\oauth2\common\models\storage\AccessToken');