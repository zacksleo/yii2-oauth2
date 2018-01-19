<?php

return [
    'modules' => [
        'oauth2' => [
            'class' => 'filsh\yii2\oauth2server\Module',
            'tokenParamName' => 'access_token',
            'tokenAccessLifetime' => 3600 * 24 * 7,
            'storageMap' => [
                'user_credentials' => 'app\models\User',
                'access_token' => 'zacksleo\yii2\oauth2\common\models\storage\AccessToken',
            ],
            'grantTypes' => [
                'client_credentials' => [
                    'class' => 'OAuth2\GrantType\ClientCredentials',
                    'allow_public_clients' => true
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
    ],
];
