<?php

namespace Bot;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @version 2.0.1
 * @license BSD
 */

use AI\AI;
use Hub\Singleton;
use Bot\RoomGrabber;
use Bot\ChatGrabber;
use Facebook\Facebook;
use Hub\Contracts\BotContract;
use Hub\Abstraction\IlluminateAbstraction;

class BotFacebook extends IlluminateAbstraction implements BotContract
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
     * @param string $name
     */
    public function __construct($email, $pass, $user, $name)
    {
        $this->fb = new Facebook($email, $pass, $user);
        $this->name = $name;
        $this->ai = new AI();
    }

    /**
     * Run it.
     *
     * @param array $config
     */
    public static function run($config)
    {
        is_dir(data) or mkdir(data);
        is_dir(logs) or mkdir(logs);
        is_dir(fb_data) or mkdir(fb_data);
        $self = self::getInstance($config['email'], $config['pass'], $config['user'], $config['name']);
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
        $this->rooms = $RoomGrabber(3);
    }

    /**
     * Room.
     */
    private function room()
    {
        foreach ($this->rooms as $room_url) {
            $src = $this->fb->get_page($room_url, null);
            $ChatGrabber = new ChatGrabber($src);
            $chat_event = $ChatGrabber();
            if (count($chat_event) == 1) {
                $src = $this->fb->get_page($room_url, null);
                $ChatGrabber = new ChatGrabber($src);
                $chat_event = $ChatGrabber();
            }
            var_dump($chat_event);die;
        }
    }

    private function ai_isolator($message)
    {

    }

    /**
     * Override
     *
     * @param string $email
     * @param string $pass
     * @param string $user
     */
    public static function getInstance($email, $pass, $user, $name)
    {
        if (self::$inst === null) {
            self::$inst = new self($email, $pass, $user, $name);
        }
        return self::$inst;
    }

    public function __destruct()
    {
        
    }
}
