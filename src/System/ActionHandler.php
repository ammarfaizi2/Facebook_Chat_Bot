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
	public function run()
	{
		print $this->fb->login();
	}
}