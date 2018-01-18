<?php

namespace zacksleo\yii2\oauth2\api\filters;

use Yii;
use yii\base\Controller;
use filsh\yii2\oauth2server\Module;
use filsh\yii2\oauth2server\exceptions\HttpException;
use zacksleo\yii2\oauth2\api\Module as ApiModule;

class ErrorToExceptionFilter extends \yii\base\Behavior
{
    /**
     * @inheritdoc
     */
    public function events()
    {
        return [Controller::EVENT_AFTER_ACTION => 'afterAction'];
    }

    /**
     * @param ActionEvent $event
     * @return boolean
     * @throws HttpException when the request method is not allowed.
     */
    public function afterAction($event)
    {
        $response = Module::getInstance()->getServer()->getResponse();

        $isValid = true;
        if ($response !== null) {
            $isValid = $response->isInformational() || $response->isSuccessful() || $response->isRedirection();
        }
        if (!$isValid) {
            throw new HttpException(
                $response->getStatusCode(),
                $this->getErrorMessage($response),
                $response->getParameter('error_uri')
            );
        }
    }

    protected function getErrorMessage(\OAuth2\Response $response)
    {
        $message = ApiModule::t('oauth2server', $response->getParameter('error_description'));
        if ($message == 'Invalid username and password combination') {
            $message = 'Incorrect account or password';
        }
        if ($message === null) {
            $message = ApiModule::t('oauth2server', 'An internal server error occurred.');
        }
        return $message;
    }
}
