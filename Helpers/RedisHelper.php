<?php
namespace Helpers;

use Predis\Client;

class RedisHelper
{
    static $instance;
    private $ck;
    static $rc;

    private function __construct($conf)
    {
        $this->ck = $conf;
    }

    public function get()
    {
        $redisConfs = $this->ck;
        $options    = [
            'parameters' => [
                'password' => $redisConfs['auth'],
                'database' => $redisConfs['db_set'],
            ],
        ];
        return new Client(["tcp://{$redisConfs['host']}:{$redisConfs['port']}"], $options);
    }

    static public function connections($conf)
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self($conf);
        }
        return self::$instance;
    }

    private function __clone() { }

    private function __wakeup() { }


}