<?php

namespace tests\common\models;

use tests\unit\TestCase;
use tests\fixtures\UserFixture;
use tests\fixtures\OauthClientsFixture;
use zacksleo\yii2\oauth2\common\models\storage\AccessToken;

class AccessTokenTest extends TestCase
{

    public function _fixtures()
    {
        return [
            'users' => [
                'class' => UserFixture::className(),
                'dataFile' => '@tests/fixtures/data/user.php'
            ],
            'clients' => [
                'class' => OauthClientsFixture::className(),
                'dataFile' => '@tests/fixtures/data/oauth_clients.php'
            ],
        ];
    }

    public function testAccessToken()
    {
        $token = '19b9941d0433ce498507eb8949e90fe28a1d8e61';
        $accessToken = new AccessToken();
        $accessToken->setAccessToken($token, 'client_id', 1, 3600);
        $res = $accessToken->getAccessToken($token);
        $this->assertArrayHasKey('access_token', $res);
        $this->assertArrayHasKey('client_id', $res);
        $this->assertArrayHasKey('user_id', $res);
    }
}
