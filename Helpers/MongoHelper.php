<?php

declare(strict_types=1);
/**
 * This file is part of Slimxy.
 *
 * @link     http://www.alonexy.com
 * @document https://www.slimframework.com/
 */

namespace Helpers;

class MongoHelper
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

    public function Get()
    {
        $Confs = $this->ck;
        $opts = [
            'appname' => $Confs['appname'],
            'authMechanism' => 'SCRAM-SHA-1',
            'authSource' => $Confs['authSource'],
            'username' => $Confs['username'],
            'password' => $Confs['password'],
            'retryWrites' => true,
        ];
        return new \MongoDB\Client(
            $Confs['uri'],
            $opts
        );
    }

    public static function connections($conf)
    {
        if (! self::$instance instanceof self) {
            self::$instance = new self($conf);
        }
        return self::$instance;
    }
}
