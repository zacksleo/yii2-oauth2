<?php

namespace zacksleo\yii2\oauth2\common\behaviors;

use zacksleo\yii2\oauth2\common\predis\Predis;
use common\models\OauthClients;
use filsh\yii2\oauth2server\models\OauthAuthorizationCodes;
use filsh\yii2\oauth2server\models\OauthRefreshTokens;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class OauthClientsDeleteBehavior extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete'
        ];
    }

    public function afterDelete($event)
    {
        /* @var $model OauthClients */
        $model = $this->owner;
        //删除缓存
        Predis::getInstance()->getClient()->deleteClientToken($model->client_id);
        //删除Token
        //OauthAccessTokens::deleteAll(['client_id' => $model->client_id]);
        //删除授权码
        OauthAuthorizationCodes::deleteAll(['client_id' => $model->client_id]);
        //删除刷新Token
        OauthRefreshTokens::deleteAll(['client_id' => $model->client_id]);
    }
}
