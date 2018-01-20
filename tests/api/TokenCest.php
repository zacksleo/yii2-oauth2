<?php

namespace tests\api;

use Codeception\Util\Fixtures;

class TokenCest extends CestBase
{
    private $refreshToken;

    public function clientTokenTest(\ApiTester $I)
    {
        $I->wantTo('客户端模式获取令牌');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('tokens', [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'client_credentials'
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'access_token' => 'string',
            'expires_in' => 'integer',
            'token_type' => 'string',
            'scope' => 'string|null',
        ]);
    }

    public function passwordTokenTest(\ApiTester $I)
    {
        $I->wantTo('密码模式获取令牌');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('tokens', [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'username' => $this->username,
            'password' => $this->password,
            'grant_type' => 'password'
        ]);
        $this->refreshToken = $I->grabDataFromResponseByJsonPath('refresh_token')[0];
        $token = $I->grabDataFromResponseByJsonPath('access_token')[0];
        Fixtures::add('passwordToken', $token);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'access_token' => 'string',
            'expires_in' => 'integer',
            'token_type' => 'string',
            'scope' => 'string|null',
            'refresh_token' => 'string'
        ]);
    }

    public function userNotExist4PasswordTokenTest(\ApiTester $I)
    {
        $I->wantTo('密码模式获取令牌：用户不存在时的提示');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Accept-Language', 'en-US');
        $I->sendPOST('tokens', [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'username' => 'userNotExist',
            'password' => $this->password,
            'grant_type' => 'password'
        ]);
        $I->seeResponseCodeIs(401);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'name' => 'string',
            'message' => 'string',
            'code' => 'integer',
            'status' => 'integer',
            'type' => 'string'
        ]);
        $I->seeResponseContainsJson([
            'name' => 'Unauthorized',
            'message' => 'user does not exist',
            'status' => 401,
        ]);
    }

    /**
     * @param \ApiTester $I
     * @depends passwordTokenTest
     */
    public function refreshPasswordTokenTest(\ApiTester $I)
    {

        $I->wantTo('刷新令牌');
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPOST('tokens', [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->refreshToken
        ]);
        $I->seeResponseCodeIs(200);
    }
}