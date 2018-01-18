<?php
/**
 * Created by PhpStorm.
 * User: zjw
 * Date: 2017/8/25
 * Time: 下午3:45
 */

namespace zacksleo\yii2\oauth2\common\predis;

use monsterhunter\oauth2\redis\RedisClient;

class Predis
{
    private static $instance;

    private static $clientSet;

    /**
     * @return Predis
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @return \monsterhunter\oauth2\redis\RedisClient
     */
    public function getClient()
    {
        if (!isset(self::$clientSet['PredisClient'])) {
            $client = new RedisClient($this->getParams());
            self::$clientSet['PredisClient'] = $client;
        }
        return self::$clientSet['PredisClient'];
    }

    private function getParams()
    {
        $params = [
            'host' => getenv('TOKEN_REDIS_HOST'),
            'port' => getenv('TOKEN_REDIS_PORT'),
            'database' => getenv('TOKEN_REDIS_DATABASE'),
            'password' => getenv('TOKEN_REDIS_PASSWORD')
        ];
        if ($params['password'] == 'null' || empty($params['password'])) {
            unset($params['password']);
        }
        return $params;
    }
}
