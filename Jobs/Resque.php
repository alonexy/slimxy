<?php

declare(strict_types=1);
/**
 * This file is part of Slimxy.
 *
 * @link     http://www.alonexy.com
 * @document https://www.slimframework.com/
 */

namespace Jobs;

use Interop\Container\ContainerInterface;

require __DIR__ . '/../vendor/autoload.php';

if (PHP_SAPI !== 'cli') {
    $error = 'Job execute is Must CLI';
    throw new \Exception($error);
}

class Resque
{
    public $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function Handle()
    {
        $QUEUE = getenv('QUEUE');
        if (empty($QUEUE)) {
            die("Set QUEUE env var containing the list of queues to work.\n");
        }
        $redisConfs = $this->container->get('configs')->get('redis', 'job');

        $dsn = "redis://auth:{$redisConfs['auth']}@{$redisConfs['host']}:{$redisConfs['port']}";
//            $redisServer = new \Resque_Redis($dsn,$redisConfs['db_set']);
        \Resque::setBackend($dsn, $redisConfs['db_set']);

        $logLevel = false;
        $LOGGING = getenv('LOGGING');
        $VERBOSE = getenv('VERBOSE');
        $VVERBOSE = getenv('VVERBOSE');
        if (! empty($LOGGING) || ! empty($VERBOSE)) {
            $logLevel = true;
        } elseif (! empty($VVERBOSE)) {
            $logLevel = true;
        }

        $APP_INCLUDE = getenv('APP_INCLUDE');
        if ($APP_INCLUDE) {
            if (! file_exists($APP_INCLUDE)) {
                die('APP_INCLUDE (' . $APP_INCLUDE . ") does not exist.\n");
            }

            require_once $APP_INCLUDE;
        }

        $interval = 5;
        $INTERVAL = getenv('INTERVAL');
        if (! empty($INTERVAL)) {
            $interval = $INTERVAL;
        }

        $count = 1;
        $COUNT = getenv('COUNT');
        if (! empty($COUNT) && $COUNT > 1) {
            $count = $COUNT;
        }

        if ($count > 1) {
            for ($i = 0; $i < $count; ++$i) {
                $pid = pcntl_fork();
                if ($pid == -1) {
                    die('Could not fork worker ' . $i . "\n");
                }
                // Child, start the worker
                if (! $pid) {
                    $queues = explode(',', $QUEUE);
                    $worker = new \Resque_Worker($queues);
                    $worker->logLevel = $logLevel;
                    fwrite(STDOUT, '*** Starting worker ' . $worker . "\n");
                    $worker->work($interval);
                    break;
                }
            }
        }
        // Start a single worker
        else {
            $queues = explode(',', $QUEUE);
            $worker = new \Resque_Worker($queues);
            $worker->logLevel = $logLevel;

            $PIDFILE = getenv('PIDFILE');
            if ($PIDFILE) {
                file_put_contents($PIDFILE, getmypid()) or
                die('Could not write PID information to ' . $PIDFILE);
            }

            fwrite(STDOUT, '*** Starting worker ' . $worker . "\n");
            $worker->work($interval);
        }
    }

    public function cleanup_children($signal)
    {
        $GLOBALS['send_signal'] = $signal;
    }
}

$container = new \Core\Containers();
new Resque($container->GetContainers());
