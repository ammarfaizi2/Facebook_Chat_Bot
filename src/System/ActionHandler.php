<?php
namespace System;

use AI\AI;
use System\Facebook;
use System\ChatController;
use Curl\CMCurl;

/**
* @author Ammar Faizi <ammarfaizi2@gmail.com>
*/
class ActionHandler
{
    private $ai;
    private $fb;
    private $config;
    public function __construct($config)
    {
        $this->ai = new AI();
        $this->fb = new Facebook($config['email'], $config['pass'], $config['user'], $config['token']);
        $this->config = $config;
    }

    /**
    *	@return bool
    */
    private function check_login_status()
    {
        return file_exists($this->fb->usercookies) ? strpos(file_get_contents($this->fb->usercookies), "c_user")!==false : false;
    }

    /**
    *   @return bool
    */
    private function avoid_brute_login()
    {
        return file_exists(fb_data.'/avoid_brute_login') ? ((int)file_get_contents(fb_data.'/avoid_brute_login')<=20) : true;
    }
    
    /**
    *   @return int
    */
    private function inc_brute_login()
    {
        return file_put_contents(fb_data.'/avoid_brute_login', (file_exists(fb_data.'/avoid_brute_login') ? ((int)file_get_contents(fb_data.'/avoid_brute_login')+1):1));
    }


    /**
    * void
    */
    private function login_action()
    {
        if (!$this->check_login_status() && $this->avoid_brute_login()) {
            $this->inc_brute_login();
            $this->fb->login();
        }
        if (!$this->check_login_status() && $this->avoid_brute_login()) {
            $this->inc_brute_login();
            $this->fb->login();
        }
    }


    private function get_messages_page()
    {
        return $this->fb->get_page('messages');
    }


    /**
    *	@return array
    */
    private function get_chatroom_url()
    {
        $src = $this->get_messages_page();
        $n     = new ChatController($src);
        $st = $n->grb(3);
        if ($st===false and $this->avoid_brute_login()) {
            $this->inc_brute_login() and print $this->fb->login();
            $n = new ChatController($this->fb->get_page($url.'messages'));
            $st = $n->grb(3);
        } elseif ($st===false) {
            die("Error !");
        }
        if (!is_array($st)) {
            die("Error getting messages !");
        }
        return $st;
    }

    /**
    *
    */
    private function manage_chat($soruce)
    {
        $action = array();
        if (is_array($soruce)) {
            foreach ($soruce as $gcname => $link) {
                /**
                *	Ambil isi chat
                */
                $room = $this->fb->get_page(substr($link, 1));
                $chat = Facebook::grchat($room);
                
                if (count($chat)<1 && (rand(0,10)>5)) {
                    $room = $this->fb->get_page(substr($link, 1), 1);
                    $chat = Facebook::grchat($room);
                }
                if (!is_array($chat)) {
                    $rt[$gcname] = "An error occured !";
                }
                $ctnn = count($chat)-1;
                $this->save_chat[] = $chat;
                if ($chat[$ctnn]['name']==$this->config['name']) {
                    continue;
                }
                $pointer = 0;
                foreach ($chat as $key => $val) {
                    if ($val['name']==$this->config['name']) {
                        $pointer = $key;
                    }
                }
                for ($i=0;$i<=$pointer;$i++) {
                    unset($chat[$i]);
                }
                foreach ($chat as $sub) {
                    foreach ($sub['messages'] as $m) {
                        if ($sub['name']!=$this->config['name']) {
                            $st = $this->ai->prepare($m, $sub['name']);
                            if ($st->execute()) {
                                $reply = $st->fetch_reply();
                                if (is_array($reply)) {
                                    $this->fb->send_message($reply[1], null, null, $room);
                                    if (filter_var($reply[0], FILTER_VALIDATE_URL)) {
                                        $fn = md5($reply[0]).'.jpg';
                                        file_put_contents($fn, (new CMCurl($reply[0]))->execute());
                                    } else {
                                        $fn = $reply[0];
                                    }
                                    $this->fb->upload_photo(realpath($fn), '', '', $room);
                                } else {
                                    $this->fb->send_message($reply, null, null, $room);
                                }
                                $action['reply'][$sub['name']] = $reply;
                            }
                        }
                    }
                }
            }
        }
        return $action;
    }

    /**
    * void run
    */
    public function run()
    {
        $this->login_action();
        $act = $this->manage_chat($this->get_chatroom_url(3));
        print_r($act);
        print_r($this->save_chat);
    }
}
