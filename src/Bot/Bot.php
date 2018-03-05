<?php

namespace Bot;

class Bot
{
	public function __construct()
	{

	}

	public static function stream_exec($cmd)
	{
		while (@ob_end_flush());
		$proc = popen("node handle.js", 'r');
		echo "\n";
		while (! feof($proc)) {
		    echo fread($proc, 4096);
		    @flush();
		}
		pclose($proc);
		echo "\n";
	}
}
