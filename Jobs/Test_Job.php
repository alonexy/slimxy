<?php
namespace Jobs;
/**
 * Created by PhpStorm.
 * User: alonexy
 * Date: 18/3/19
 * Time: 15:56
 */
class Test_Job extends Jobs
{
    public function setUp()
    {
        // ... Set up environment for this job
        echo "==setUp==\n";
    }

    public function perform()
    {
        // .. Run job
        echo "==perform==\n";
        print_r($this->args);
        print_r($this->container->get('configs'));
    }

    public function tearDown()
    {
        // ... Remove environment for this job
        echo "==tearDown==\n";
    }
}