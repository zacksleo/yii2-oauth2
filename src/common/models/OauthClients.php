<?php

namespace zacksleo\yii2\oauth2\common\models;

use yii;
use zacksleo\yii2\oauth2\common\behaviors\OauthClientsDeleteBehavior;
use Ramsey\Uuid\Uuid;
use filsh\yii2\oauth2server\models\OauthClients as Clients;
use zacksleo\yii2\oauth2\common\queries\OauthClientsQuery;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

/**
 * This is the model class for table "{{%oauth_clients}}".
 *
 * @inheritdoc
 * @property string $client_name
 * @property string $client_icon
 * @property boolean $one_token_per_user
 */
class OauthClients extends Clients
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%oauth_clients}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['client_name', 'required'],
            ['redirect_uri', 'default', 'value' => ''],
            [['grant_types'], 'required'],
            [['user_id'], 'integer'],
            [['redirect_uri'], 'string', 'max' => 1000],
            [['scope'], 'string', 'max' => 2000],
            ['user_id', 'default', 'value' => 1],
            ['client_id', 'string', 'max' => 36],
            ['client_secret', 'string', 'max' => 36],
            ['client_icon', 'safe'],
            ['one_token_per_user', 'boolean'],
            [['client_name', 'user_id'], 'unique', 'targetAttribute' => ['client_name', 'user_id']],
        ];
    }

    public function beforeValidate()
    {
        $model = Yii::$app->request->post('OauthClients');
        if (isset($model['grant_types'])) {
            $this->grant_types = implode(' ', $model['grant_types']);
        }
        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'client_id' => '应用ID',
            'client_name' => '应用名称',
            'client_secret' => '应用密钥',
            'redirect_uri' => '回跳URL',
            'grant_types' => '授权类型',
            'scope' => '权限范围',
            'user_id' => '用户',
            'client_icon' => '图标',
            'one_token_per_user' => '单设备登录',
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        unset(
            $fields['redirect_uri'],
            $fields['grant_types'],
            $fields['scope'],
            $fields['user_id'],
            $fields['client_id'],
            $fields['client_secret']
        );
        return $fields;
    }

    public function extraFields()
    {
        return [
            'client_id', 'client_secret', 'userCount'
        ];
    }

    public function behaviors()
    {
        return [
            OauthClientsDeleteBehavior::className(),
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            try {
                $uuid = Uuid::uuid5(Uuid::NAMESPACE_DNS, $this->client_name . $this->user_id);
                $this->client_id = $uuid->toString();
            } catch (UnsatisfiedDependencyException $e) {
                $this->addError('app_name', $e->getMessage());
                return false;
            }
            $this->client_secret = Yii::$app->security->generateRandomString();
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     * @return OauthClientsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OauthClientsQuery(get_called_class());
    }

    public function getUserCount()
    {
        return $this->hasMany(OauthClientsSignupUser::className(), ['client_id' => 'client_id'])->count();
    }
}
