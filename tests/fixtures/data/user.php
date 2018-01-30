<?php
$password = Yii::$app->security->generatePasswordHash('password');
return [
    'default' => [
        'username' => 'username',
        'password' => $password,
    ],
];
