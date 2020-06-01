<?php

declare(strict_types=1);
/**
 * This file is part of Slimxy.
 *
 * @link     http://www.alonexy.com
 * @document https://www.slimframework.com/
 */

namespace Helpers;

use Swoole\Process;
use function file_exists;
use function sleep;
use function time;
use function unlink;
use function usleep;

class ServerHelper
{
    /**
     * Do shutdown process and wait it exit.
     *
     * @param int $pid Process Pid
     * @param int $signal SIGTERM = 15
     * @param int $waitTime Seconds
     */
    public static function killAndWait(
        int $pid,
        int $signal = 15,
        string $name = 'process',
        bool $force = false,
        int $waitTime = 10
    ): bool {
        // Do stop
        if (! self::sendSignal($pid, $signal)) {
            echo "Send stop signal to the {$name}(PID:{$pid}) failed!" . PHP_EOL;
            return false;
        }

        // not wait, only send signal
        if ($waitTime <= 0) {
            echo "The {$name} process stopped." . PHP_EOL;
            return true;
        }

        $errorMsg = '';
        $startTime = time();
        echo 'Stopping .';

        // wait exit
        while (true) {
            if (! self::isRunning($pid)) {
                break;
            }

            if (time() - $startTime > $waitTime) {
                $errorMsg = "Stop the {$name}(PID:{$pid}) failed(timeout)!";
                break;
            }

            echo '.';
            sleep(1);
        }

        if ($errorMsg) {
            echo PHP_EOL . $errorMsg;
            return false;
        }

        echo PHP_EOL . 'Stop success !' . PHP_EOL;

        return true;
    }

    /**
     * Send signal to the server process.
     */
    public static function sendSignal(int $pid, int $signal, int $timeout = 0): bool
    {
        if ($pid <= 0) {
            return false;
        }

        // do send
        if ($ret = Process::kill($pid, $signal)) {
            return true;
        }

        // don't want retry
        if ($timeout <= 0) {
            return $ret;
        }

        // failed, try again ...
        $timeout = $timeout > 0 && $timeout < 10 ? $timeout : 3;
        $startTime = time();

        // retry stop if not stopped.
        while (true) {
            // success
            if (! $isRunning = Process::kill($pid, 0)) {
                break;
            }

            // have been timeout
            if ((time() - $startTime) >= $timeout) {
                return false;
            }

            // try again kill
            $ret = Process::kill($pid, $signal);
            usleep(10000);
        }

        return $ret;
    }

    public static function removePidFile(string $pidFile): bool
    {
        if ($pidFile && file_exists($pidFile)) {
            return unlink($pidFile);
        }

        return false;
    }

    /**
     * 获取MsterPID.
     */
    public static function getPid(string $pidFile): int
    {
        if ($pidFile && file_exists($pidFile)) {
            return (int) file_get_contents($pidFile);
        }
        return 0;
    }

    public static function isRunning(int $pid): bool
    {
        return ($pid > 0) && Process::kill($pid, 0);
    }
}
