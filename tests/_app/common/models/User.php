<?php

namespace common\models;

use OAuth2\Storage\UserCredentialsInterface;
use yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use filsh\yii2\oauth2server\exceptions\HttpException;

/**
 * User model
 *
 * @property integer $id
 * @property string $phone
 * @property string $created_at
 * @property string $updated_at
 */
class User extends ActiveRecord implements IdentityInterface, UserCredentialsInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'string', 'max' => 15],
            ['password', 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'id'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        /* @var \filsh\yii2\oauth2server\Module $module */
        $module = Yii::$app->getModule('oauth2');
        $accessToken = $module->getServer()->getStorage('access_token')->getAccessToken($token);
        //$token = $module->getServer()->getResourceController()->getToken();
        return !empty($accessToken['user_id']) ? static::findIdentity($accessToken['user_id']) : null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return null;
    }

    /**
     * Implemented for Oauth2 Interface
     * @param $username
     * @param $password
     * @return bool
     * @throws HttpException
     */
    public function checkUserCredentials($username, $password)
    {
        /* @var $user \common\models\User */
        $user = static::find()->where(['username' => $username])->one();
        if (empty($user)) {
            throw new HttpException(401, 'user does not exist');
        }
        return $user->validatePassword($password);
    }

    /**
     * Implemented for Oauth2 Interface
     * @param $username
     * @return array
     */
    public function getUserDetails($username)
    {
        /* @var $user \common\models\User */
        $user = static::find()->where(['username' => $username])->one();
        return [
            'user_id' => $user->getId()
        ];
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function validatePassword($password)
    {
        return true;
    }

    public function getUnionId()
    {
        return $this->id;
    }
}
