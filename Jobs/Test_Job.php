<?php

declare(strict_types=1);
/**
 * This file is part of Slimxy.
 *
 * @link     http://www.alonexy.com
 * @document https://www.slimframework.com/
 */

namespace Jobs;

/**
 * Created by PhpStorm.
 * User: alonexy
 * Date: 18/3/19
 * Time: 15:56.
 */
class Test_Job extends Jobs
{
    public function setUp()
    {
        // ... Set up environment for this job
        echo "==setUp==\n";
    }

    public function tearDown()
    {
        // ... Remove environment for this job
        echo "==tearDown==\n";
    }

    public function perform()
    {
        // .. Run job
        echo "==perform==\n";
        print_r($this->args);
        print_r($this->container->get('configs'));
    }
}
