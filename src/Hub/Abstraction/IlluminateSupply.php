<?php

namespace Hub\Abstraction;

abstract class IlluminateSupply
{
    
    /**
     * Constructor.
     */
    public function __construct()
    {
    }

    /**
     * Invoker
     */
    abstract public function __invoke();

    /**
     * Destructor.
     */
    abstract public function __destruct();

    /**
     * Prevent var_dump
     */
    public function __debugInfo()
    {
        return array();
    }
}
