<?php
namespace System;
use System\Facebook;
use System\ChatController;
/**
* @author Ammar Faizi <ammarfaizi2@gmail.com>
*/
class ActionHandler
{
	
	public function __construct($config)
	{
		$this->fb = new Facebook($config['email'],$config['pass'],$config['user'],$config['token']);
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
	*
	*/
	private function get_chat_room()
	{
		$src = $this->get_messages_page();
		$n	 = new ChatController($src);
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
	* void run
	*/
	public function run()
	{
		$this->login_action();
		$this->get_chat_room();
	}
}




function chkck($ck)
{
    return file_exists($ck)?(strpos(file_get_contents($ck), 'c_user')===false):true;
}
function chkfile()
{
    if (!file_exists("login_avoid")) {
        file_put_contents("avoid_brute_login", "0");
    }
    return ((int)file_get_contents("avoid_brute_login")<5);
}
function void_log()
{
    return (bool)file_put_contents("avoid_brute_login", (((int)file_get_contents("avoid_brute_login"))+1));
}
