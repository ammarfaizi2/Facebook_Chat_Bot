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
use Hub\Contracts\DragonContract;
use Hub\Contracts\ThunderContract;
use Hub\Contracts\BlueFishContract;
use Hub\Abstraction\IlluminateAbstraction;

class BotFacebook extends IlluminateAbstraction implements DragonContract, ThunderContract, BlueFishContract
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
            var_dump($chat_event);
            $end = end($chat_event);
            print "\n\n\n\n";
            if (isset($end['name']) and $end['name'] != $this->name) {
                foreach ($chat_event as $key => $val) {
                    if ($val['name'] == $this->name) {
                        $waste_event = $key;
                    }
                }
                self::close_waste_event($chat_event, $waste_event);
                foreach ($chat_event as $key => $val) {
                    if (isset($val['messages']) and isset($val['name']) and $val['name'] != $this->name) {
                        foreach ($val['messages'] as $msg) {
                            if ($reply = $this->ai_isolator($msg, $val['name'])) {
                                if (isset($reply['text'][0])) {
                                    $this->fb->send_message($reply['text'][0], null, null, $src);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * @param string $message
     * @param string $actor
     * @return mixed
     */
    private function ai_isolator($message, $actor = "")
    {
        $ai = new AI();
        $out = false;
        $ai->input($message, $actor);
        if ($ai->execute()) {
            $out = $ai->output();
        }
        return $out;
    }

    /**
     * Close waste event
     */
    private static function close_waste_event(&$chat_event, $waste_event)
    {
        for ($i=0; $i < $waste_event; $i++) { 
            $chat_event[$i] = null;
        }
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
