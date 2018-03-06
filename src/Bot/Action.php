<?php

namespace Bot;

use Brainly\Brainly;

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
			$st = new Brainly($a[1]);
			$st->limit(1);
			$st = $st->exec();
			if (count($st)) {
				$msg = "Pertanyaan yang mirip: \n".strip_tags($st[0]["content"])."\n\nJawaban: \n".strip_tags(str_replace("<br />", "\n", $st[0]["responses"][0]["content"]));
			} else {
				$msg = "Pertanyaan tidak ditemukan!";
			}
			echo json_encode(
				[
					"text" => $msg,
					"thread_id" => $this->in["threadID"],
					"send" => true
				]
			);
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