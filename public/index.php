<?php
require '../vendor/autoload.php';

$container = new \Slim\Container;
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler('../logs/app.log');
    $logger->pushHandler($file_handler);
    return $logger;
};
//  ======数据库配置=====
$container['db'] = function ($c) {
    $db = $c['settings']['db'];
//    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
//        $db['user'], $db['pass']);
//    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $dsn = 'mysql:host='.$db['host'].';dbname='.$db['dbname'].';charset=utf8';
    $pdo = new \Slim\PDO\Database($dsn, $db['user'], $db['pass']);
    return $pdo;
};
$container['view'] = new \Slim\Views\PhpRenderer('../templates/');
$settings = $container->get('settings');
//配置更新
$settings->replace([
    'displayErrorDetails' => true,
    'determineRouteBeforeAppMiddleware' => true,
    'debug' => true,
    'db'=>[
        'host'=>'127.0.0.1',
        'dbname'=>'push',
        'user'=>'root',
        'pass'=>'',
    ]
]);
$app = new \Slim\App($container);
require '../routes.php';
$app->run();
