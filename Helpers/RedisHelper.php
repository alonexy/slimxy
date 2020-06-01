<?php

declare(strict_types=1);
/**
 * This file is part of Slimxy.
 *
 * @link     http://www.alonexy.com
 * @document https://www.slimframework.com/
 */

namespace Helpers;

use Predis\Client;

class RedisHelper
{
    public static $instance;

    public static $rc;

    private $ck;

    private function __construct($conf)
    {
        $this->ck = $conf;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    public function get()
    {
        $redisConfs = $this->ck;
        $options = [
            'parameters' => [
                'password' => $redisConfs['auth'],
                'database' => $redisConfs['db_set'],
            ],
        ];
        return new Client(["tcp://{$redisConfs['host']}:{$redisConfs['port']}"], $options);
    }

    public static function connections($conf)
    {
        if (! self::$instance instanceof self) {
            self::$instance = new self($conf);
        }
        return self::$instance;
    }
}
