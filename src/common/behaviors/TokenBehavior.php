<?php

namespace zacksleo\yii2\oauth2\common\behaviors;

use zacksleo\yii2\oauth2\common\helpers\Predis;
use yii;
use yii\base\Behavior;
use yii\web\Controller;
use zacksleo\yii2\oauth2\common\models\storage\AccessToken;
use zacksleo\yii2\oauth2\common\models\OauthClients;

/**
 * Class TokenBehavior
 * @package common\models\behaviors
 * @property $owner \common\helpers\utils\Token
 */
class TokenBehavior extends Behavior
{
    const EVENT_AFTER_TOKEN_CREATE = 'afterTokenCreate';

    public function events()
    {
        return [
            Controller::EVENT_AFTER_ACTION => 'afterAction',
            self::EVENT_AFTER_TOKEN_CREATE => 'afterTokenCreate'
        ];
    }

    public function afterAction($event)
    {
        $grantType = Yii::$app->request->getBodyParam('grant_type');
        $clientId = Yii::$app->request->getBodyParam('client_id');
        $clientSecret = Yii::$app->request->getBodyParam('client_secret');
        if (!in_array($grantType, ['password', 'refresh_token'])) {
            return true;
        }
        $token = Yii::$app->getModule('oauth2')->getServer()->getResponse()->getParameters();
        /* @var $oauthAccessToken array */
        $oauthAccessToken = (new AccessToken())->getAccessToken($token['access_token']);
        $this->revokeUserTokens($oauthAccessToken);
    }

    public function afterTokenCreate()
    {
        /**
         * Array
            (
            [access_token] => 97d7445c03e1551b5d22bfd4306c86f94ea0f9b3
            [expires_in] => 604800
            [token_type] => Bearer
            [scope] =>
            [refresh_token] => 8e01cc423cd74935fccd7b84bb0b6b3794ceed62
            )
         */
        $token = $this->owner->getToken();
        /* @var $oauthAccessToken array */
        $oauthAccessToken = (new AccessToken())->getAccessToken($token['access_token']);
        $this->revokeUserTokens($oauthAccessToken);
    }

    /**
     * 删除该用户该设备下的其他Token
     * @param $oauthAccessToken array
     */
    protected function revokeUserTokens($oauthAccessToken)
    {
        $client = OauthClients::findOne(['client_id' => $oauthAccessToken['client_id']]);
        if ($client->one_token_per_user) {
            //删除缓存
            Predis::getInstance()->getClient()->deleteOldUserClientToken($oauthAccessToken['access_token'], $oauthAccessToken['client_id'], $oauthAccessToken['user_id']);
        }
    }
}
