<?php

declare(strict_types=1);
/**
 * This file is part of Slimxy.
 *
 * @link     http://www.alonexy.com
 * @document https://www.slimframework.com/
 */

namespace Jobs;

require __DIR__ . '/../vendor/autoload.php';

class Jobs
{
    public $container;

    public function __construct()
    {
        $container = new \Core\Containers();
        $this->container = $container->GetContainers();
    }
}
