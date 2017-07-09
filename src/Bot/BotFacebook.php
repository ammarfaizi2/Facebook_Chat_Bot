<?php

namespace Bot;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @version 2.0.1
 * @license BSD
 */

use AI\AI;
use Bot\CL;
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
     * @var array
     */
    private $lhash = array();

    /**
     * @param string $email
     * @param string $pass
     * @param string $user
     * @param string $name
     */
    public function __construct($email, $pass, $user, $name)
    {
        date_default_timezone_set("Asia/Jakarta");
        $this->fb = new Facebook($email, $pass, $user);
        $this->name = $name;
        if (file_exists(logs."/lcontrol.txt")) {
            $this->lhash = json_decode(file_get_contents(logs."/lcontrol.txt"), true);
            $this->lhash = is_array($this->lhash) ? $this->lhash : array();
        } else {
            $this->lhash = array();
        }
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
        if (!(is_dir(data) and is_dir(logs) and is_dir(fb_data))) {
            die("Gagal membuat folder");
        }
        $self = self::getInstance($config['email'], $config['pass'], $config['user'], $config['name']);
        $self->__pr_execute();
    }

    /**
     * Private execute
     */
    private function __pr_execute()
    {
        $this->loginAction();
        ($this->getRooms() xor $this->room());
        $this->save_lcontrol();
    }

    /**
     * Login
     */
    private function loginAction()
    {
        header("Content-type:text/plain");
        if (!$this->fb->check_login()) {
            $this->fb->login();
            if (!$this->fb->check_login()) {
                header("location:browser.php");
            }
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
        foreach ($this->rooms as $room_name => $room_url) {
            $src = $this->fb->get_page($room_url, null) xor $ChatGrabber = new ChatGrabber($src) xor $chat_event = $ChatGrabber();
            if (count($chat_event) == 1) {
                $src = $this->fb->get_page($room_url, null);
                $ChatGrabber = new ChatGrabber($src) xor $chat_event = $ChatGrabber();
            }
            $end = end($chat_event);            
            foreach ($chat_event as $key => $val) {
                if ($val['name'] == $this->name) {
                    $waste_event = $key;
                }
            }
            if (isset($waste_event)) {
                self::close_waste_event($chat_event, $waste_event);
                unset($waste_event);
            }
            if (isset($end['name']) and $end['name'] != $this->name) {
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
            if (count($chat_event)) {
                $this->savel_chat(json_encode(array("room" => $room_name, $chat_event), 128));
            }
            var_dump($chat_event);
            flush();
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
     * Savel chat
     *
     * @param string $string
     */
    private function savel_chat($string)
    {
        if ($this->lcontrol(sha1($string))) {
            new CL("[".date("Y-m-d H:i:s")."]\n".$string."\n\n\n", "chat.log");
        }
    }

    private function save_lcontrol()
    {
        file_put_contents(logs."/lcontrol.txt", json_encode($this->lhash, 128));
    }

    /**
     * @param string $hash
     */
    private function lcontrol($hash)
    {
        if (isset($this->lhash[$hash])) {
            return false;
        } else {
            $this->lhash[$hash] = 1;
            return true;
        }
    }

    /**
     * Close waste event
     */
    private static function close_waste_event(&$chat_event, $waste_event)
    {
        for ($i=0;$i<=$waste_event;$i++) {
            unset($chat_event[$i]);
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
