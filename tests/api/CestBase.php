<?php

namespace tests\api;

use tests\fixtures\OauthClientsFixture;
use tests\fixtures\UserFixture;
use yii;

class CestBase
{
    public $clientId = 'client_id';
    public $clientSecret = 'client_secret';
    public $username = 'username';
    public $password = 'password';
    public $accessToken;


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
            ]
        ];
    }


    /**
     * 生成随机手机号
     * @return int|string
     */
    protected function randomPhone()
    {
        $numberPlace = array(30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 50, 51, 58, 59, 89);
        $mobile = 1;
        $mobile .= $numberPlace[rand(0, count($numberPlace) - 1)];
        $mobile .= str_pad(rand(0, 99999999), 8, 0, STR_PAD_LEFT);
        return $mobile;
    }

    protected function auth(\ApiTester $I)
    {
        $I->amBearerAuthenticated($this->accessToken);
    }

    protected function fetchPasswordAccessToken(\ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('tokens', [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'password',
            'username' => $this->username,
            'password' => $this->password
        ]);
        $this->accessToken = $I->grabDataFromResponseByJsonPath('access_token')[0];
    }

    protected function fetchClientAccessToken(\ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('tokens', [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'client_credentials'
        ]);
        $this->accessToken = $I->grabDataFromResponseByJsonPath('access_token')[0];
    }

    /**
     * 复原修改
     */
    protected function cleanup()
    {
        $this->clientId = 'client_id';
        $this->clientSecret = 'client_secret';
        $this->username = 'username';
        $this->password = 'password';
    }
}
