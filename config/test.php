<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/test_db.php';

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic-tests',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'de-DE',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '9JkIl7rpbpvytphnjmMIbCX9i1zWIjhF',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\user\User',
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
            'useFileTransport' => true,
            'viewPath' => '@app/mail',
            'htmlLayout' => '@app/mail/layouts/html',
            'textLayout' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info', 'trace'],
                    'except' => [
                        'yii\web\Session::open',
                        'yii\db\Command::query',//SQL-Ausgabe in Logs
                        'yii\db\Connection::open',
                        'yii\web\UrlManager::parseRequest',//welche Route gefunden wird
                        'yii\web\UrlRule::parseRequest',//welche URLmanager-Rule gefunden wird
                        'yii\base\Controller::runAction',
                        'yii\base\Action::runWithParams',
                        'yii\base\InlineAction::runWithParams',//welche action ausgeführt wird
                        'yii\base\Module::getModule',
                        'yii\web\Application::handleRequest',
                        'yii\base\Application::bootstrap',
                        'yii\base\View::renderFile',
                    ],
                    'exportInterval' => 1,
                    'logFile' => '@runtime/logs/ttkv-test.log',
                    'logVars' => [],
                    //'logVars' => ['_SERVER'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => false,
            'showScriptName' => true,
            'rules' => [
                '/'=>'site/index',
                '<controller:\w+>/<action>/<p>/<p2>/<p3>/<p4>'=>'<controller>/<action>',
                '<controller:\w+>/<action>/<p>/<p2>/<p3>'=>'<controller>/<action>',
                '<controller:\w+>/<action>/<p>/<p2>'=>'<controller>/<action>',
                '<controller:\w+>/<action>/<p>'=>'<controller>/<action>',
                '<controller:\w+>/<action>'=>'<controller>/<action>',
                '<controller:\w+>/<p:\d+>'=>'<controller>/view',
                //'<controller:\w+>'=>'<controller>/index',
                '<p>'=>'site/index',
            ],
        ],
        'formatter' => [ 
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'dd.MM.Y',
            'datetimeFormat' => 'dd.MM.Y HH:mm:ss',
            'timeFormat' => 'HH:mm:ss', 
            'locale' => 'de-DE',
            'defaultTimeZone' => 'Europe/Berlin',
        ],
        'assetManager' => [
            'converter' => [
                'class' => 'yii\web\AssetConverter',
                'commands' => [
                    'scss' => ['css', 'L:\Tools\Ruby26-x64\bin\sass {from} {to}']
                    
                ],
            ],
            'bundles' => [
                'yii\web\JqueryAsset' => false,
                'yii\bootstrap\BootstrapPluginAsset' => false,
                'yii\bootstrap\BootstrapAsset' => false,
                'yii\web\JqueryAsset' => [
                    'js'=>[]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js'=>[]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
                /*
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,   // do not publish the bundle
                    'js' => [
                        ['https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js','position' => \yii\web\View::POS_HEAD],
                    ]
                ],
                */
            ],
        ],
    ],
    'params' => $params,
];
