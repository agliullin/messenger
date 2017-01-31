<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'XXdbCD0XofFLv8rWt00QpyZBWa7W542l',
            
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'ssl://smtp.yandex.com',
                'username' => 'albertagliullinemailadm@yandex.ru',
                'password' => 'albertadmin',
                'port' => '465',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,        
            'rules' => [
                '<controller>/<action>' => '<controller>/<action>',
                'dialog/view/<user_from:\w+>' => 'dialog/view',
                'dialog/view/<user_from:\w+>&delmy=<delmy:\w+>' => 'dialog/view',
                'dialog/view/<user_from:\w+>&delnotmy=<delnotmy:\w+>' => 'dialog/view',
                'admin/viewuser/<id:\w+>' => 'admin/viewuser',
                'admin/viewdialogs/<id:\w+>' => 'admin/viewdialogs',
                'admin/dialog/<user_from:\w+>/<user_to:\w+>' => 'admin/dialog',
                'chat/view/<chat_id:\w+>' => 'chat/view',
                'admin/dialog/<user_from:\w+>/<user_to:\w+>' => 'admin/dialog',
                'admin/dialog/<user_from:\w+>/<user_to:\w+>&delmy=<delmy:\w+>' => 'admin/dialog',
                'admin/dialog/<user_from:\w+>/<user_to:\w+>&delnotmy=<delnotmy:\w+>' => 'admin/dialog',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
