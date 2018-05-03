<?php
/**
 * Created by PhpStorm.
 * User: alonexy
 * Date: 18/5/3
 * Time: 15:15
 */

namespace Jobs;

require __DIR__.'/../vendor/autoload.php';

class Jobs
{
    public $container;
    public function __construct()
    {
        $container = new \Core\Containers();
        $this->container = $container->GetContainers();
    }
}
