<?php

namespace Bot;

class Action
{
	private $in = [];

	public function __construct($in)
	{
		$this->in = $in;
	}

	public function run()
	{
		if (isset($this->in["body"])) {
			echo 123123123;
		}
	}
}