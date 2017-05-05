<?php
namespace System;

use System\AI;
use System\Facebook;
use System\ChatController;

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
    * void
    */
    private function login_action()
    {
        if (!$this->check_login_status()) {
            $this->fb->login();
        }
        if (!$this->check_login_status()) {
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
        $st = $n->grb(8);
        if ($st===false) {
            chkfile() and print $fb->login();
            $n = new ChatController($fb->go_to($url.'messages'));
            $st = $n->grb(8);
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
        if (!is_array($soruce)) {
            throw new \Exception("Error manage_chat !", 1);
        }
        $action = array();
        foreach ($soruce as $gcname => $link) {
            /**
            *	Ambil isi chat
            */
            $room = $this->fb->get_page(substr($link, 1));
            $chat = ChatController::grchat($room);
            if (count($chat)<2) {
                $room = $this->fb->get_page(substr($link), 1);
                $chat = ChatController::grchat($room);
            }
            if (!is_array($chat)) {
                $rt[$gcn] = "An error occured !";
            }
            foreach ($chat as $sub) {
                foreach ($sub['messages'] as $m) {
                    $salt = $gcname.$m.date("H Ymd");
                    if (check($m, $salt) and $sub['name']!=$this->config['name']) {
                        save($m, $salt);
                        $st = $this->ai->prepare($m, $sub['name']);
                        if ($st->execute()) {
                            $reply = $st->fetch_reply();
                            $this->fb->send_message($reply, null, null, $room);
                            $action['reply'][$sub['name']] = $reply;
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
        $act = $this->manage_chat($this->get_chatroom_url());
        print_r($act);
    }
}
