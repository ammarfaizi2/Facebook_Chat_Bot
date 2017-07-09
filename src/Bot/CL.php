<?php

namespace Bot;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @version 2.0.1
 * @license BSD
 */

class CL
{	
	/**
	 * @var string
	 */
	private $string;

	/**
	 * Constructor.
	 *
	 * @param string $string
	 * @param string $log_file
	 */
	public function __construct($string, $log_file)
	{
		$this->string = $string;
		file_put_contents(logs."/".$log_file, $string, FILE_APPEND | LOCK_EX);
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->string;
	}

	/**
	 * Destructor.
	 */
	public function __destruct()
	{

	}
}