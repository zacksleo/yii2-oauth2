<?php

namespace tests\unit\common\behaviors;

use common\models\User;
use tests\fixtures\UserFixture;
use tests\unit\TestCase;

class UserRedisBehaviorTest extends TestCase
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _fixtures()
    {
        return [
            'users' => [
                'class' => UserFixture::className(),
                'dataFile' => '@tests/fixtures/data/user.php'
            ],
        ];
    }

    public function testAfterDelete()
    {
        /* @var $user User */
        $user = $this->tester->grabFixture('users', 'default');
        $this->assertEquals(1, $user->delete());
    }
}
