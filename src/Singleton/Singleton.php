<?php

namespace App\Singleton;

class Singleton
{
    private static Singleton $singleton;

    private function __construct() {}

    public static function getInstance()
    {
        return self::$singleton ?? self::$singleton = new static();
    }
}