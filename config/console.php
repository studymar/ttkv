<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/test_db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'components' => [
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
                    'logFile' => '@runtime/logs/ttkv-console.log',
                    'logVars' => [],
                    //'logVars' => ['_SERVER'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
