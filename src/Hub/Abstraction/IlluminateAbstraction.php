<?php

namespace Hub\Abstraction;

abstract class IlluminateAbstraction
{
	/**
     * @param string $email
     * @param string $pass
     * @param string $user
     * @param string $name
     */
	abstract public function __construct($email, $pass, $user, $name);

	/**
     * Run it.
     *
     * @param array $config
     */
	abstract public static function run($config);

	 /**
	  * Destructor.
	  */
	abstract public function __destruct();

	/**
     * Override
     *
     * @param string $email
     * @param string $pass
     * @param string $user
     */
    abstract public static function getInstance($email, $pass, $user, $name);
}