<?php
namespace Jobs;
/**
 * Created by PhpStorm.
 * User: alonexy
 * Date: 18/3/19
 * Time: 15:56
 */
class DomainMonitor_Job
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
    }

    public function tearDown()
    {
        // ... Remove environment for this job
        echo "==tearDown==\n";
    }
}