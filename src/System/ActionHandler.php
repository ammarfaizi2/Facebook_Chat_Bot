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
	public function run()
	{
		$this->login_action();
	}
}