<?php

namespace yii\web;

/**
 * Mock for the is_uploaded_file() function for web classes.
 * @return boolean
 */
function is_uploaded_file($filename)
{
    return file_exists($filename);
}

/**
 * Mock for the move_uploaded_file() function for web classes.
 * @return boolean
 */
function move_uploaded_file($filename, $destination)
{
    return copy($filename, $destination);
}

namespace tests\unit;

use yii;
use Codeception\Test\Unit;
use common\helpers\utils\Phone;

class TestCase extends Unit
{
    /**
     * 生成随机手机号
     * @return int|string
     */
    protected function randomPhone()
    {
        $numberPlace = array(30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 50, 51, 58, 59, 89);
        $mobile = 1;
        $mobile .= $numberPlace[rand(0, count($numberPlace) - 1)];
        $mobile .= str_pad(rand(0, 99999999), 8, 0, STR_PAD_LEFT);
        return $mobile;
    }

    /**
     * 获取国际手机号
     * @return string
     */
    protected function randomI18nPhone()
    {
        $codes = ['US', 'GB', 'AU', 'CA', 'HK', 'FR', 'JP', 'IT', 'MO', 'MX', 'NZ', 'SG', 'CH'];
        $phoneNumberUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $obj = $phoneNumberUtil->getExampleNumberForType($codes[array_rand($codes)], \libphonenumber\PhoneNumberType::MOBILE);
        return '+' . $obj->getCountryCode() . ' ' . $obj->getNationalNumber();
    }

    /**
     * 模拟发送短信验证码
     * @param $phone
     * @param $smsCode
     */
    protected function sendSmsCode($phone, $smsCode)
    {
        Yii::$app->cache->set(Phone::phoneI18n($phone), $smsCode, 600);
    }

    /**
     * 模拟发送邮箱验证码
     * @param $email
     * @param $smsCode
     */
    protected function sendEmailCode($email, $smsCode)
    {
        Yii::$app->cache->set($email, $smsCode, 600);
    }

    /**
     * Invokes a inaccessible method
     * @param $object
     * @param $method
     * @param array $args
     * @param bool $revoke whether to make method inaccessible after execution
     * @return mixed
     * @since 2.0.11
     */
    protected function invokeMethod($object, $method, $args = [], $revoke = true)
    {
        $reflection = new \ReflectionObject($object);
        $method = $reflection->getMethod($method);
        $method->setAccessible(true);
        $result = $method->invokeArgs($object, $args);
        if ($revoke) {
            $method->setAccessible(false);
        }
        return $result;
    }

    /**
     * Sets an inaccessible object property to a designated value
     * @param $object
     * @param $propertyName
     * @param $value
     * @param bool $revoke whether to make property inaccessible after setting
     * @since 2.0.11
     */
    protected function setInaccessibleProperty($object, $propertyName, $value, $revoke = true)
    {
        $class = new \ReflectionClass($object);
        while (!$class->hasProperty($propertyName)) {
            $class = $class->getParentClass();
        }
        $property = $class->getProperty($propertyName);
        $property->setAccessible(true);
        $property->setValue($object, $value);
        if ($revoke) {
            $property->setAccessible(false);
        }
    }

    /**
     * Gets an inaccessible object property
     * @param $object
     * @param $propertyName
     * @param bool $revoke whether to make property inaccessible after getting
     * @return mixed
     */
    protected function getInaccessibleProperty($object, $propertyName, $revoke = true)
    {
        $class = new \ReflectionClass($object);
        while (!$class->hasProperty($propertyName)) {
            $class = $class->getParentClass();
        }
        $property = $class->getProperty($propertyName);
        $property->setAccessible(true);
        $result = $property->getValue($object);
        if ($revoke) {
            $property->setAccessible(false);
        }
        return $result;
    }

}
