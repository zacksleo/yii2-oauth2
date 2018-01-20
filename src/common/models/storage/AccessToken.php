<?php

namespace zacksleo\yii2\oauth2\common\models\storage;

use yii;
use zacksleo\yii2\oauth2\common\helpers\Predis;
use OAuth2\Storage\AccessTokenInterface;

class AccessToken implements AccessTokenInterface
{
    public function getAccessToken($oauthToken)
    {
        $oauthAccessToken = Predis::getInstance()->getClient()->getToken($oauthToken);
        if (empty($oauthAccessToken)) {
            return [];
        }
        return $oauthAccessToken;
    }

    public function setAccessToken($oauthToken, $clientId, $userId, $expires, $scope = null)
    {
        $model = Yii::$container->get('user_credentials');
        $user = $model::findIdentity($userId);
        $value = [
            'access_token' => $oauthToken,
            'client_id' => $clientId,
            'user_id' => $userId,
            'expires' => $expires,
            'scope' => null,
            'union_id' => $user->getUnionId()
        ];
        Predis::getInstance()->getClient()->setToken($oauthToken, $value);
    }
}
