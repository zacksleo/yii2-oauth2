<?php

namespace zacksleo\yii2\oauth2\common\queries;

/**
 * This is the ActiveQuery class for [[\app\models\OauthClients]].
 *
 * @see zacksleo\yii2\oauth2\common\models\OauthClients
 */
class OauthClientsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \app\models\OauthClients[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\OauthClients|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
