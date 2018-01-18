<?php
namespace zacksleo\yii2\oauth2\common\behaviors;

use zacksleo\yii2\oauth2\common\predis\Predis;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class UserRedisBehavior extends Behavior
{

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }

    public function afterDelete($event)
    {
        /* @var $user \common\models\User */
        $user = $this->owner;
        if (!empty($model)) {
            //删除缓存
            Predis::getInstance()->getClient()->deleteUserToken($user->id);
            $model->delete();
        }
    }
}
