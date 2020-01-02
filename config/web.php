<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language'=>'es', // spanish
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => true,
            'confirmWithin' => 21600,
            'cost' => 12,
            'modelMap' => [
                'User' => 'app\models\User',
            ],
            'admins' => ['admin']
        ],
        'gridview' => [ 'class' => '\kartik\grid\Module' ],
        'chartbuilder'=>[
            'class'=> 'yii2learning\chartbuilder\Module'
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module',
        ]
    ],
    'components' => [

        'formatter' => [
            'dateFormat' => 'dd.MM.yyyy',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'EUR',
        ],
        'reCaptcha' =>[

            'name' => 'reCaptcha',
            'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => '6LfSx5EUAAAAAObqorw7hN3YfY-1_fCTQAF-anjh',
            'secret' => '6LfSx5EUAAAAAGhoZHgRRVlpjvftVD01HCHL54GG',
        ],

        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'oYomLhqlw_Am3XIuk2_hG4TxbaD8_fro',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'curl' => [
            'class' => 'ext.Curl',
            'options' => ['CURLOPT_USERAGENT' => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:5.0) Gecko/20110619 Firefox/5.0'],
        ],
        'cache' => [
            'class' => 'yii\caching\MemCache',
            'useMemcached' => true,
            'servers' => [
                [
                    'host' => '127.0.0.1',
                    'port' => 11211,
                    'weight' => 100,
                ],
            ],
        ],
        /*'user' => [
             'identityClass' => 'app\models\User',
             'enableAutoLogin' => true,
         ],*/
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'soporte@bitsteleport.com',
                'password' => '__MMnn11223355',
                'port' => '465',
                'encryption' => 'ssl',
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'monitor'],
            ],
        ],
        'gridview' => [ 'class' => '\kartik\grid\Module' ],

        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/views',
                    '@dektrium/user/views' => '@app/views/user'
                    // '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
                ],
            ],
        ],
        //AdminLTE
        'assetManager' => [
            'bundles' => [
                'Wkii\AdminLTE\Asset\AdminLteAsset' => [
                    'skin' => 'skin-red',
                ],
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
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1','192.168.2.*','201.217.58.*','181.127.14.*','170.51.54.*','201.222.55.*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1','192.168.2.*','201.217.58.*','181.127.14.*','170.51.54.*','201.222.55.*'],
    ];
}

return $config;
