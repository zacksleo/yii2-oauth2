<?php

namespace tests;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\db\Schema;

/**
 * This is the base class for all yii framework unit tests.
 */
class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->mockApplication();

        $this->setupTestDbData();

        $this->createRuntimeFolder();
    }

    protected function tearDown()
    {
        $this->destroyApplication();
    }

    /**
     * Populates Yii::$app with a new application
     * The application will be destroyed on tearDown() automatically.
     *
     * @param array $config The application configuration, if needed
     * @param string $appClass name of the application class to create
     */
    protected function mockApplication($config = [], $appClass = '\yii\web\Application')
    {
        new $appClass(ArrayHelper::merge([
            'id' => 'testapp',
            'basePath' => __DIR__,
            'vendorPath' => $this->getVendorPath(),
            'components' => [
                'db' => [
                    'class' => 'yii\db\Connection',
                    'dsn' => 'sqlite::memory:',
                ],
                'request' => [
                    'hostInfo' => 'http://domain.com',
                    'scriptUrl' => 'index.php',
                ],
                'i18n' => [
                    'translations' => [
                        'zacksleo/yii2/cms/*' => [
                            'class' => 'yii\i18n\PhpMessageSource',
                            'basePath' => '@zacksleo/yii2/cms/messages',
                            'sourceLanguage' => 'en-US',
                            'fileMap' => [
                                'zacksleo/yii2/cms/cms' => 'cms.php',
                                'zacksleo/yii2/cms/tree' => 'tree.php',
                            ],
                        ]
                    ],
                ],
            ],
            'modules' => [
                'cms' => [
                    'class' => 'zacksleo\yii2\cms\Module',
                ],
                'treemanager' => [
                    'class' => '\kartik\tree\Module',
                ],
                'attachments' => [
                    'class' => \nemmo\attachments\Module::className(),
                    'tempPath' => '@tests/data/uploads/temp',
                    'storePath' => '@tests/data/uploads/store',
                    'rules' => [ // Rules according to the FileValidator
                        'maxFiles' => 5, // Allow to upload maximum 3 files, default to 3
                        //'mimeTypes' => 'image/png, image/jpg', // Only png images
                        'extensions' => ['png', 'jpg', 'gif'],
                        'maxSize' => 600 * 1024 // 1 MB
                    ],
                    'tableName' => '{{%attachments}}' // Optional, default to 'attach_file'
                ]
            ],
        ], $config));
    }

    /**
     * @return string vendor path
     */
    protected function getVendorPath()
    {
        return dirname(__DIR__) . '/vendor';
    }

    /**
     * Destroys application in Yii::$app by setting it to null.
     */
    protected function destroyApplication()
    {
        Yii::$app = null;
    }

    /**
     * Setup tables for test ActiveRecord
     */
    protected function setupTestDbData()
    {
        $adminSql = <<<EOF
SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `mops_oauth_access_tokens`
-- ----------------------------
DROP TABLE IF EXISTS `mops_oauth_access_tokens`;
CREATE TABLE `mops_oauth_access_tokens` (
  `access_token` varchar(40) NOT NULL COMMENT '访问令牌',
  `client_id` varchar(36) NOT NULL COMMENT '客户端ID',
  `user_id` int(11) DEFAULT NULL COMMENT '用户',
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '期限',
  `scope` varchar(2000) DEFAULT NULL COMMENT '权限范围',
  PRIMARY KEY (`access_token`),
  KEY `client_id` (`client_id`),
  CONSTRAINT `mops_oauth_access_tokens_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `mops_oauth_clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `mops_oauth_authorization_codes`
-- ----------------------------
DROP TABLE IF EXISTS `mops_oauth_authorization_codes`;
CREATE TABLE `mops_oauth_authorization_codes` (
  `authorization_code` varchar(40) NOT NULL COMMENT '授权码',
  `client_id` varchar(36) NOT NULL COMMENT '客户端ID',
  `user_id` int(11) DEFAULT NULL COMMENT '用户',
  `redirect_uri` varchar(1000) NOT NULL COMMENT '回跳地址',
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '期限',
  `scope` varchar(2000) DEFAULT NULL COMMENT '权限范围',
  PRIMARY KEY (`authorization_code`),
  KEY `client_id` (`client_id`),
  CONSTRAINT `mops_oauth_authorization_codes_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `mops_oauth_clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `mops_oauth_clients`
-- ----------------------------
DROP TABLE IF EXISTS `mops_oauth_clients`;
CREATE TABLE `mops_oauth_clients` (
  `client_name` varchar(36) NOT NULL COMMENT '客户端名称',
  `client_icon` varchar(255) NOT NULL COMMENT '图标',
  `client_id` varchar(36) NOT NULL COMMENT '客户端ID',
  `client_secret` varchar(32) DEFAULT NULL COMMENT '客户端密钥',
  `redirect_uri` varchar(1000) NOT NULL DEFAULT '' COMMENT '回跳地址',
  `grant_types` varchar(100) NOT NULL COMMENT '授权类型',
  `scope` varchar(2000) DEFAULT NULL COMMENT '权限范围',
  `user_id` int(11) DEFAULT NULL COMMENT '用户',
  `one_token_per_user` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `mops_oauth_jwt`
-- ----------------------------
DROP TABLE IF EXISTS `mops_oauth_jwt`;
CREATE TABLE `mops_oauth_jwt` (
  `client_id` varchar(36) NOT NULL COMMENT '客户端ID',
  `subject` varchar(80) DEFAULT NULL COMMENT '接收者',
  `public_key` varchar(2000) DEFAULT NULL COMMENT '公钥',
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `mops_oauth_public_keys`
-- ----------------------------
DROP TABLE IF EXISTS `mops_oauth_public_keys`;
CREATE TABLE `mops_oauth_public_keys` (
  `client_id` varchar(255) NOT NULL COMMENT '客户端ID',
  `public_key` varchar(2000) DEFAULT NULL COMMENT '公钥',
  `private_key` varchar(2000) DEFAULT NULL COMMENT '私钥',
  `encryption_algorithm` varchar(100) DEFAULT 'RS256' COMMENT '加密算法'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `mops_oauth_refresh_tokens`
-- ----------------------------
DROP TABLE IF EXISTS `mops_oauth_refresh_tokens`;
CREATE TABLE `mops_oauth_refresh_tokens` (
  `refresh_token` varchar(40) NOT NULL COMMENT '刷新令牌',
  `client_id` varchar(36) NOT NULL COMMENT '客户端ID',
  `user_id` int(11) DEFAULT NULL COMMENT '用户',
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '期限',
  `scope` varchar(2000) DEFAULT NULL COMMENT '权限范围',
  PRIMARY KEY (`refresh_token`),
  KEY `client_id` (`client_id`),
  CONSTRAINT `mops_oauth_refresh_tokens_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `mops_oauth_clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `mops_oauth_scopes`
-- ----------------------------
DROP TABLE IF EXISTS `mops_oauth_scopes`;
CREATE TABLE `mops_oauth_scopes` (
  `scope` varchar(2000) NOT NULL COMMENT '权限范围',
  `is_default` tinyint(1) NOT NULL COMMENT '默认'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
        $userSql = <<<EOF
        -- auto-generated definition
        create table `test_user`
        (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `username` varchar(32) NOT NULL,
            `auth_key` varchar(32) NOT NULL,
            `password_hash` varchar(256) NOT NULL,
            `password_reset_token` varchar(256),
            `email` varchar(256) NOT NULL,
            `status` integer not null default 10,
            `created_at` integer not null,
            `updated_at` integer not null
        )ENGINE=InnoDB DEFAULT CHARSET=utf8;
EOF;
        try {
            $db = Yii::$app->getDb();
            $db->createCommand($adminSql)->execute();
            $db->createCommand($userSql)->execute();
        } catch (yii\db\Exception $e) {
            //var_dump($e->getMessage());
            return;
        }
    }

    /**
     * Create runtime folder
     */
    protected function createRuntimeFolder()
    {
        FileHelper::createDirectory(dirname(__DIR__) . '/tests/runtime');
    }
}
