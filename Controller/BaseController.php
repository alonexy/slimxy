<?php

declare(strict_types=1);
/**
 * This file is part of Slimxy.
 *
 * @link     http://www.alonexy.com
 * @document https://www.slimframework.com/
 */

namespace Controller;

use Psr\Container\ContainerInterface;

class BaseController
{
    protected $requests;

    protected $container;

    protected $configs;

    protected $db;

    protected $view;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        if ($this->container->has('db')) {
            $this->db = $this->container->get('db');
        }
        if ($this->container->has('configs')) {
            ##==> Demo $this->container->get('configs')->get('db','default');
            $this->configs = $this->container->get('configs');
        }
        if ($this->container->has('view')) {
            $this->view = $this->container->get('view');
        }
    }
}
