# yii2-oauth2

yii2 oauth2 module based on [yii2-oauth2-server](https://github.com/Filsh/yii2-oauth2-server)


[![Latest Stable Version](https://poser.pugx.org/zacksleo/yii2-oauth2/version)](https://packagist.org/packages/zacksleo/yii2-oauth2)
[![Total Downloads](https://poser.pugx.org/zacksleo/yii2-oauth2/downloads)](https://packagist.org/packages/zacksleo/yii2-oauth2)
[![License](https://poser.pugx.org/zacksleo/yii2-oauth2/license)](https://packagist.org/packages/zacksleo/yii2-oauth2)
[![StyleCI](https://styleci.io/repos/117953253/shield?branch=master)](https://styleci.io/repos/117953253)
[![Code Climate](https://img.shields.io/codeclimate/github/zacksleo/yii2-oauth2.svg)]()
[![Build Status](https://travis-ci.org/zacksleo/yii2-oauth2.svg?branch=master)](https://travis-ci.org/zacksleo/yii2-oauth2)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/zacksleo/yii2-oauth2/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/zacksleo/yii2-oauth2/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/zacksleo/yii2-oauth2/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/zacksleo/yii2-oauth2/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/zacksleo/yii2-oauth2/badges/build.png?b=master)](https://scrutinizer-ci.com/g/zacksleo/yii2-oauth2/build-status/master)


## Config module

### for API or frontend


```php

 'modules' => [
     'oauth2' => [
         'class' => 'filsh\yii2\oauth2server\Module',
         'tokenParamName' => 'access_token',
         'tokenAccessLifetime' => 3600 * 24 * 7,
         'storageMap' => [
             'user_credentials' => 'common\models\User',
             'access_token' => 'zacksleo\yii2\oauth2\common\models\storage\AccessToken',
         ],
         'grantTypes' => [
             'client_credentials' => [
                 'class' => 'OAuth2\GrantType\ClientCredentials',
                 'allow_public_clients' => false
             ],
             'user_credentials' => [
                 'class' => 'OAuth2\GrantType\UserCredentials',
             ],
             'refresh_token' => [
                 'class' => 'OAuth2\GrantType\RefreshToken',
                 'always_issue_new_refresh_token' => true,
             ],
             'authorization_code' => [
                 'class' => 'OAuth2\GrantType\AuthorizationCode',
                 'require_exact_redirect_uri' => false,
             ]
         ]
     ]
 ]

```

### for backend

```php

  'modules' => [
      'oauth2' => [
          'class' => 'zacksleo\yii2\oauth2\backend\Module',
      ]
  ]

```

