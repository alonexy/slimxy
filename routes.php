<?php

declare(strict_types=1);
/**
 * This file is part of Slimxy.
 *
 * @link     http://www.alonexy.com
 * @document https://www.slimframework.com/
 */

$app->get('/', \Controller\IndexController::class . ':Index');

$app->group('/api', function () {
    $this->get('/test', \Controller\TestController::class . ':Index');
    $this->get('/kline_test', \Controller\TestController::class . ':kline_test');
    $this->get('/addJob', \Controller\TestController::class . ':AddJob');
})->add(new \Tuupola\Middleware\Cors([
    'origin' => ['*'],
    'methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'],
    'headers.allow' => [],
    'headers.expose' => [],
    'credentials' => false,
    'cache' => 0,
]));
$app->group('/api/v1', function () {
    $this->get('/get_house', \Controller\HomeController::class . ':get_house');
})->add(new \Tuupola\Middleware\Cors([
    'origin' => ['*'],
    'methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'],
    'headers.allow' => [],
    'headers.expose' => [],
    'credentials' => false,
    'cache' => 0,
]));
/*
 * @name 任务执行路由 Cli
 */
$app->get('/resque_handle', \Jobs\Resque::class . ':Handle');
