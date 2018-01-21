<?php

namespace tests\common\models;

use tests\fixtures\OauthClientsSignupUserFixture;
use tests\unit\TestCase;
use tests\fixtures\OauthClientsFixture;
use zacksleo\yii2\oauth2\common\models\OauthClients;

class OauthClientsTest extends TestCase
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

    public function testRules()
    {
        $model = new OauthClients();
        $this->assertTrue($model->isAttributeRequired('client_name'));
        $this->assertTrue($model->isAttributeRequired('grant_types'));
        $model->client_name = 'client name';
        //$_POST['OauthClients']['grant_types'] = ['client_credentials'];
        $model->grant_types = 'client_credentials';
        $model->user_id = 1;
        $model->client_secret = 'client secret';
        $model->one_token_per_user = 0;
        $model->save();
        $this->assertTrue($model->save());
    }

    public function testAttributeLabels()
    {
        $model = new OauthClients();
        $labels = $model->attributeLabels();
        $this->assertArrayHasKey('client_id', $labels);
    }

    public function testFields()
    {
        $model = $this->tester->grabFixture('clients', 'default');
        $fields = $model->fields();
        $this->assertArrayHasKey('client_name', $fields);
        $this->assertArrayNotHasKey('client_id', $fields);
        $extraFields = $model->extraFields();
        $this->assertTrue(in_array('client_id', $extraFields));
        $this->assertTrue(in_array('client_secret', $extraFields));
        $this->assertTrue(in_array('userCount', $extraFields));
    }

    public function testView()
    {
        $client = $this->tester->grabFixture('clients', 'default');
        $this->assertEquals(1, $client->getUserCount());
    }
}
