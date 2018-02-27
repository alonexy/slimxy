<?php
require '../vendor/autoload.php';
//phpinfo();
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
    $dsn = 'mysql:host='.$db['host'].';dbname='.$db['dbname'].';charset=utf8';
    $pdo = new \Slim\PDO\Database($dsn, $db['user'], $db['pass']);
    return $pdo;
};
//======视图=====
$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig('../Templates', [
        'cache' => false
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new \Slim\Views\TwigExtension($c['router'], $basePath));

    return $view;
};
//配置更新
$settings = $container->get('settings');
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
