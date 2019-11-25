<?php

namespace Helpers;

class MongoHelper
{

    static $instance;
    private $ck;
    static $rc;

    private function __construct($conf)
    {
        $this->ck = $conf;
    }

    public function Get()
    {
        $Confs  = $this->ck;
        $opts   = [
            "appname" => $Confs['appname'],
            "authMechanism" => "SCRAM-SHA-1",
            "authSource" => $Confs['authSource'],
            "username" => $Confs['username'],
            "password" => $Confs['password'],
            "retryWrites" => true,
        ];
        $client = new \MongoDB\Client(
            $Confs["uri"], $opts
        );
        return $client;
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