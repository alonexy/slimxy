<?php
/**
 * Created by PhpStorm.
 * User: alonexy
 * Date: 18/2/26
 * Time: 16:22
 */
$app->group('', function() {
    $this->get('/test',\Controller\TestController::class.':Index');
    $this->get('/monitor_domain',\Controller\TestController::class.':MonitorDomain');
    $this->get('/test_view',\Controller\TestController::class.':TestView')->setName('profile');
})->add( new \Middlewares\ExampleMiddleware());

$app->group('/api', function() {
    $this->get('/check',\Controller\DomainController::class.':Index');
    $this->get('/add',\Controller\DomainController::class.':AddJob');
})->add( new \Middlewares\ExampleMiddleware());

$app->get('/resque_handle', \Jobs\Resque::class.':Handle');
/**
 * new \Tuupola\Middleware\Cors([
"origin" => ["*"],
"methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
"headers.allow" => [],
"headers.expose" => [],
"credentials" => false,
"cache" => 0,
])
 */