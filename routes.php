<?php
/**
 * Created by PhpStorm.
 * User: alonexy
 * Date: 18/2/26
 * Time: 16:22
 */
$app->get('/',\Controller\IndexController::class.':Index');

$app->group('/api', function() {
    $this->get('/test',\Controller\TestController::class.':Index');
    $this->get('/addJob',\Controller\TestController::class.':AddJob');
})->add(new \Tuupola\Middleware\Cors([
    "origin" => ["*"],
    "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
    "headers.allow" => [],
    "headers.expose" => [],
    "credentials" => false,
    "cache" => 0,
]));
$app->group('/api/v1', function() {
    $this->get('/get_house',\Controller\HomeController::class.':get_house');
})->add(new \Tuupola\Middleware\Cors([
    "origin" => ["*"],
    "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
    "headers.allow" => [],
    "headers.expose" => [],
    "credentials" => false,
    "cache" => 0,
]));
/**
 * @name 任务执行路由 Cli
 */
$app->get('/resque_handle', \Jobs\Resque::class.':Handle');
