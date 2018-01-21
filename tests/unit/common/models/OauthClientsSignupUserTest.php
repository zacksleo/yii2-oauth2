<?php

namespace tests\common\models;

use tests\fixtures\OauthClientsSignupUserFixture;
use tests\unit\TestCase;
use tests\fixtures\OauthClientsFixture;
use zacksleo\yii2\oauth2\common\models\OauthClientsSignupUser;

class OauthClientsSignupUserTest extends TestCase
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _fixtures()
    {
        return [
            'users' => [
                'class' => OauthClientsSignupUserFixture::className(),
                'dataFile' => '@tests/fixtures/data/oauth_clients_signup_user.php'
            ],
            'clients' => [
                'class' => OauthClientsFixture::className(),
                'dataFile' => '@tests/fixtures/data/oauth_clients.php'
            ],
        ];
    }

    public function testSave()
    {
        $model = new OauthClientsSignupUser();
        $model->client_id = 'client_id';
        $model->user_id = 100;
        $this->assertTrue($model->save());
    }
}
