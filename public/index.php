<?php
require __DIR__.'/../vendor/autoload.php';
$dotenv = new Dotenv\Dotenv(__DIR__.'/../');
$dotenv->load();
//phpinfo();

$container = new \Core\Containers();
$app = new \Slim\App($container->GetContainers());
#CLi Add
$app->add(new \pavlakis\cli\CliRequest());
require __DIR__.'/../routes.php';
$app->run();
