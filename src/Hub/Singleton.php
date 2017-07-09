<?php

namespace Hub;

trait Singleton
{
    protected static $inst = null;
    public static function getInstance()
    {
        if (self::$inst === null) {
            self::$inst = new self();
        }
        return self::$inst;
    }
    
    protected function __clone()
    {
    }
    
    protected function __wakeup()
    {
    }
    
    protected function __sleep()
    {
    }

    protected function __construct()
    {
    }
}
