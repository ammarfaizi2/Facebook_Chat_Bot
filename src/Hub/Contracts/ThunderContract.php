<?php

namespace Hub\Contracts;

interface ThunderContract
{
    /**
     * @param string $email
     * @param string $pass
     * @param string $user
     * @param string $name
     */
    public function __construct($email, $pass, $user, $name);

    /**
     * Run it.
     *
     * @param array $config
     */
    public static function run($config);

    /**
      * Destructor.
      */
    public function __destruct();

    /**
     * Override
     *
     * @param string $email
     * @param string $pass
     * @param string $user
     */
    public static function getInstance($email, $pass, $user, $name);
}
