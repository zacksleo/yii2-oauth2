<?php

namespace zacksleo\yii2\oauth2\api;

use yii;
use yii\base\Module as BaseModule;

/**
 * api module definition class
 */
class Module extends BaseModule
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'zacksleo\yii2\oauth2\api\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }

    /**
     * Registers the translation files
     */
    protected function registerTranslations()
    {
        Yii::$app->i18n->translations['zacksleo/yii2/oauth2/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@vendor/zacksleo/yii2-oauth2/src/messages',
            'fileMap' => [
                'zacksleo/yii2/oauth2/core' => 'core.php',
                'zacksleo/yii2/oauth2/user' => 'user.php',
                'zacksleo/yii2/oauth2/client' => 'client.php',
                'zacksleo/yii2/oauth2/oauth2server' => 'oauth2server.php',
            ],
        ];
    }

    /**
     * Translates a message. This is just a wrapper of Yii::t
     *
     * @see Yii::t
     *
     * @param $category
     * @param $message
     * @param array $params
     * @param null $language
     * @return string
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('zacksleo/yii2/oauth2/' . $category, $message, $params, $language);
    }
}
