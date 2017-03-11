<?php
namespace tools;

use Crayner_Machine;

class saklar extends Crayner_Machine
{
    public function __construct()
    {
        $this->url =    "https://saklar.kangarie.com/nodemcu.php";
    }
    public function saklar($gp, $st)
    {
        return $this->qurl($this->url."?gpio=".$gp."&mode=".$st);
    }
    public function get_status()
    {
        $a=$this->qurl($this->url);
        $a=explode("<h1>", $a, 5);
        for ($i=1;$i<count($a);$i++) {
            $b=explode(':', $a[$i]);
            $c[]=str_replace('saklar', 'lampu', $b[0]);
        }
        return implode(PHP_EOL, $c);
    }
    public function get_image()
    {
        $a=$this->qurl($this->url."?webcam=1");
        file_put_contents("lampu.jpg", $a);
        return true;
    }
}
