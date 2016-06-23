<?php
$params = require(__DIR__.'/params.php');

$config = [
    'id'         => 'basic',
    'basePath'   => dirname(__DIR__),
    'bootstrap'  => ['log'],
    'components' => [
        'request'      => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'kH7m#iH!3<FB',
        ],
        'session'      => [
            'class'        => 'yii\web\DbSession',
            'sessionTable' => 'yii_session',
        ],
        'cache'        => [
            'class' => 'yii\caching\FileCache',
        ],
        'user'         => [
            'identityClass'   => 'dektrium\user\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer'       => [
            'class'            => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'           => require(__DIR__.'/db.php'),
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
        ],
        'view'         => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user-module'
                ],
            ],
        ],
    ],
    'modules'    => [
        'user' => [
            'class'                  => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => TRUE,
            'admins'                 => ['admin', 'fredy.ns'],
        ],
    ],
    'params'     => $params,
];

if (YII_ENV_DEV)
{
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][]      = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][]    = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
