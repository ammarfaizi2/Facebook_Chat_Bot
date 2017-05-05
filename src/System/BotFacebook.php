<?php
namespace System;
use System\ActionHandler;

/**
* 
*/
class BotFacebook extends ActionHandler
{
	private $sup;
	public function __construct($cofig)
	{
		$this->sup = parent::__construct($config);
	}
	public function run()
	{
		parent::run();
	}
}