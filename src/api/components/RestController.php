<?php

namespace zacksleo\yii2\oauth2\api\components;

use yii\rest\Controller;
use yii\helpers\ArrayHelper;
use zacksleo\yii2\oauth2\api\filters\ErrorToExceptionFilter;
use yii\filters\ContentNegotiator;
use yii\web\Response;

/**
 * Class AuthController
 */
class RestController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = ArrayHelper::merge(parent::behaviors(), [
            'exceptionFilter' => [
                'class' => ErrorToExceptionFilter::className()
            ],
            [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
                'languages' => [
                    'zh-CN',
                    'zh-TW',
                    'en-US',
                ],
            ],
        ]);
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);
        $behaviors['authenticator'] = $auth;
        $behaviors['authenticator']['except'] = ['options'];
        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'options' => [
                'class' => 'yii\rest\OptionsAction',
            ],
        ];
    }
}
