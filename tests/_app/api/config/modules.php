<?php

return [
    'oauth2' => [
        'class' => 'filsh\yii2\oauth2server\Module',
        'components' => [
            'request' => function () {
                return \filsh\yii2\oauth2server\Request::createFromGlobals();
            },
            'response' => [
                'class' => \filsh\yii2\oauth2server\Response::class,
            ],
        ],
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
];
