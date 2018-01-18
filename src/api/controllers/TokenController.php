<?php

namespace zacksleo\yii2\oauth2\api\controllers;

use zacksleo\yii2\oauth2\common\behaviors\TokenBehavior;
use zacksleo\yii2\oauth2\api\components\RestController;
use yii;
use yii\helpers\ArrayHelper;

class TokenController extends RestController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'behaviors' => [
                'class' => TokenBehavior::className(),
            ]
        ]);
    }

    public function actionCreate()
    {
        /** @var $response \OAuth2\Response */
        $response = Yii::$app->getModule('oauth2')->getServer()->handleTokenRequest();
        return $response->getParameters();
    }
}
