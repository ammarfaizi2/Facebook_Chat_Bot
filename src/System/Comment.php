<?php
namespace System;
use Facebook;

class Comment extends Facebook
{
	public function comment()
	{
		parent::get_page('home.php');
	}
}