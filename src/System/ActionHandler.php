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
	*	@return array
	*/
	private function get_chatroom_url()
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
	*
	*/
	private function manage_chat($soruce)
	{
		if (!is_array($soruce)) {
			throw new \Exception("Error manage_chat !", 1);
		}
		foreach ($soruce as $key => $value) {
			/**
			*	Ambil isi chat
			*/
			$con = $this->fb->get_page(substr($link),1);
		}
	}

	/**
	* void run
	*/
	public function run()
	{
		$this->login_action();
		$this->manage_chat($this->get_chatroom_url());
	}
}