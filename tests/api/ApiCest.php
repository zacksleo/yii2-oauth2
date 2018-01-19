<?php

namespace tests\api;

use \Codeception\Util\HttpCode;

class ApiCest
{
    public function indexTest(\ApiTester $I)
    {
        $I->wantTo('API列表');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET('client/v1');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
    }
}
