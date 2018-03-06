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
			$this->response();	
		}
	}

	private function response()
	{
		$s = $this->in["body"];
		$a = explode(" ", $s, 2);
		if (strtolower($a[0]) === "brainly") {
			

			exit();
		}

		$sr = [
			[
				"re" => "/^ja?m\sbe?ra?pa?(\se?ka?ra?ng)?$/i",
				"rs" => [
					"Sekarang jam ".date("H:i:s A")
				]
			],
			[
				"re" => "/^(apa|pa|ap)\ska?ba?r$/i",
				"rs" => [
					"Baik",
					"Sehat"
				]
			],
		];
		foreach ($sr as $val) {
			if (preg_match($val["re"], $s)) {
				echo json_encode(
					[
						"text" => $val["rs"][rand(0, count($val["rs"]) - 1)],
						"thread_id" => $this->in["threadID"],
						"send" => true
					]
				);
				exit();
			}
		}
	}
}