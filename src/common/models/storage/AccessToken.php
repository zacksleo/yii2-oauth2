<?php

namespace common\models\storage;

use common\helpers\predis\Predis;
use common\models\User;
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
        $user = User::findIdentity($userId);
        $value = [
            'access_token' => $oauthToken,
            'client_id' => $clientId,
            'user_id' => $userId,
            'expires' => $expires,
            'scope' => null,
            'union_id' => $user->union_id
        ];
        Predis::getInstance()->getClient()->setToken($oauthToken, $value);
    }
}
