<?php
/**
 * Created by PhpStorm.
 * User: alonexy
 * Date: 18/2/24
 * Time: 17:42
 */

namespace Controller;

use Psr\Container\ContainerInterface;

class BaseController
{
    protected $requests;
    protected $container;
    protected $db;
    protected $view;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        if($this->container->has('db')){
            $this->db = $this->container->get('db');
        }
        if($this->container->has('view')){
            $this->view = $this->container->get('view');
        }
    }
}