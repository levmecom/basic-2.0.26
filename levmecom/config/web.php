<?php

//php composer.phar require --prefer-dist yiisoft/yii2-bootstrap 安装扩展到（vendor）

require __DIR__ . '/bootstrap.php';

$config = [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'id' => 'levme',
    'name' => 'Levmecom',
    'timeZone' => 'Asia/Shanghai',
    'basePath' => dirname(__DIR__),
    'language' => 'zh-CN',
    'layout' => 'F7_v4410',
    'bootstrap' => [],//'log'
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'appendTimestamp' => YII_ENV_DEV,
            'linkAssets' => true,
        ],
        'urlManager' => require __DIR__ . '/urlManager.php',

//        'view' => [//主题文件存在替换，不存在使用默认。
//            'theme' => [
//                'basePath' => '@app/views/themes/basic',
//                'baseUrl'  => '@web/views/themes/basic',
//                'pathMap'  => [
//                    '@app/views'   => '@app/views/themes/basic',
//                    '@app/modules' => '@app/views/themes/basic/modules',
//                    '@app/widgets' => '@app/views/themes/basic/widgets',
//                ],
//            ],
//        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'common' => 'common.php',
                    ],
                ],
//                'forum' => [
//                    'class' => 'yii\i18n\PhpMessageSource',
//                    'sourceLanguage' => 'en-US',
//                    'basePath' => '@modules/forum/messages',
//                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '7G1sJ7U7gg0FfhzFARn65ZpR69DpgfqJ',
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ],
        'session' => [
            'name' => 'redis_session',
            'class' => 'yii\redis\Session',
        ],
        'cache' => [
            //'class' => 'yii\caching\FileCache',
            'class' => 'yii\redis\Cache',
        ],
        'user' => require __DIR__ . '/user.php',
        'errorHandler' => [
            'errorAction' => 'ucenter/default/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => require __DIR__ . '/db.php',

    ],
    'params' => require __DIR__ . '/params.php',
    'modules' => require __DIR__ . '/modules.php',
];

if (YII_ENV_DEV) {
    if (YII_DEBUG ==2) {
        // configuration adjustments for 'dev' environment
        $config['bootstrap'][] = 'debug';
        $config['modules']['debug'] = [
            'class' => 'yii\debug\Module',
            // uncomment the following to add your IP if you are not connecting from localhost.
            //'allowedIPs' => ['127.0.0.1', '::1'],
        ];
    }

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1', '192.168.1.2'],
        'generators' => [
            'crud' => [ //生成器名称
                //'class' => 'yii\gii\generators\crud\Generator',
                'class' => 'app\gii\generators\crud\Generator',
                'templates' => [
                    'levmecomCrud' => '@app/gii/generators/crud/levme',
                ]
            ],
            'module' => [
                //'class' => 'yii\gii\generators\module\Generator',
                'class' => 'app\gii\generators\module\Generator',
                'templates' => [
                    'levmecomModule' => '@app/gii/generators/module/levme',
                    'default' => '@yii/gii/generators/module/default',
                ],
            ],
            'controller' => [
                'class' => 'app\gii\generators\controller\Generator',
                'templates' => [
                    'levmecomController' => '@app/gii/generators/controller/levme',
                ],
            ],
            'form' => [
                'class' => 'yii\gii\generators\form\Generator',
                'templates' => [
                    'levmecomForm' => '@app/gii/generators/form/levme',
                ],
            ],
        ],
    ];
}

return $config;
