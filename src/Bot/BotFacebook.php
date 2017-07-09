<?php

namespace Bot;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @version 2.0.1
 * @license BSD
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
     * @var array
     */
    private $rooms = array();

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
        is_dir(data) or mkdir(data);
        is_dir(logs) or mkdir(logs);
        is_dir(fb_data) or mkdir(fb_data);
        $self = self::getInstance($config['email'], $config['pass'], $config['user']);
        $self->__pr_execute();
    }

    /**
     * Private execute
     */
    private function __pr_execute()
    {
        $this->loginAction();
        $this->getRooms();
        $this->room();
    }

    /**
     * Login
     */
    private function loginAction()
    {
        if (!$this->fb->check_login()) {
            print $this->fb->login();
        }
    }

    /**
     * Get room
     */
    private function getRooms()
    {
        $RoomGrabber = new RoomGrabber($this->fb->get_page("https://m.facebook.com/messages", null, null));
        $this->rooms = $RoomGrabber();
    }

    /**
     * Room.
     */
    private function room()
    {
        foreach ($this->rooms as $room_url) {
            $src = 
        }
    }

    /**
     * Override
     *
     * @param string $email
     * @param string $pass
     * @param string $user
     */
    public static function getInstance($email, $pass, $user)
    {
        if (self::$inst === null) {
            self::$inst = new self($email, $pass, $user);
        }
        return self::$inst;
    }
}