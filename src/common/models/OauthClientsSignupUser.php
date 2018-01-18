<?php

namespace zacksleo\yii2\oauth2\common\models;

use Yii;

/**
 * This is the model class for table "{{%oauth_clients_signup_user}}".
 *
 * @property integer $user_id
 * @property string $client_id
 */
class OauthClientsSignupUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%oauth_clients_signup_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id'], 'string', 'max' => 36],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'client_id' => '客户端',
        ];
    }
}
