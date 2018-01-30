<?php

namespace tests\unit\common\queries;

use tests\unit\TestCase;
use tests\fixtures\OauthClientsFixture;
use zacksleo\yii2\oauth2\common\models\OauthClients;

class OauthClientsQueryTest extends TestCase
{
    public function _fixtures()
    {
        return [
            'clients' => [
                'class' => OauthClientsFixture::className(),
                'dataFile' => '@tests/fixtures/data/oauth_clients.php'
            ],
        ];
    }

    public function testAll()
    {
        $all = OauthClients::find()->all();
        $this->assertEquals(1, count($all));
    }

    public function testOne()
    {
        $client = OauthClients::find()->one();
        $this->assertInstanceOf('zacksleo\yii2\oauth2\common\models\OauthClients', $client);
    }
}
