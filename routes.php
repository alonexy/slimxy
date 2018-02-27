<?php
/**
 * Created by PhpStorm.
 * User: alonexy
 * Date: 18/2/26
 * Time: 16:22
 */

$app->group('', function() {
    $this->get('/test',\Controller\TestController::class.':Index');
    $this->get('/test_view',\Controller\TestController::class.':TestView')->setName('profile');
})->add( new \Middlewares\ExampleMiddleware() );