<?php

namespace Bot;

/**
 * @author Ammar Faizi
 * @version 2.0.1
 * @license 
 */

use AI\AI;
use Hub\Singleton;
use Facebook\Facebook;

class BotFacebook
{
    const VERSION = "2.0.1";

    /**
     * Use Singleton trait.
     */
    use Singleton;

    /**
     * @var Facebook\Facebook
     */
    private $fb;

    /**
     * @param string $email
     * @param string $pass
     * @param string $user
     */
    public function __construct($email, $pass, $user)
    {
        $this->fb = new Facebook($email, $pass, $user);
    }

    /**
     * Run it.
     */
    public static function run($config)
    {
        $self = self::getInstance();
    }

    /**
     * Login
     */
    protected function loginAction()
    {

    }
}