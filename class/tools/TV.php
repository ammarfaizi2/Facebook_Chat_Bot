<?php
namespace tools;

class TV
{
    public function __construct()
    {
        $this->data=file_exists("data/TV.json")?json_decode(file_get_contents("data/TV.json"), true):array();
    }
    public function get_status()
    {
        $s=isset($this->data['status'])?($this->data['status']?"on":"off"):"off";
        $p=($s=="on"?"tv_on":"tv_off");
        $a=scandir("data/".$p);
        $a=$a[rand(2, count($a)-1)];
        return array($s,"data/".$p."/".$a);
    }
    public function power($s=null)
    {
        if ($s===null) {
            return false;
        } else {
            $s=$s=="on"?true:false;
            $c=isset($this->data['status'])?$this->data['status']:false;
            if (!($s xor $c)) {
                $p=($s?"tv_on":"tv_off");
                $a=scandir("data/".$p);
                $a=$a[rand(2, count($a)-1)];
                return array(false,"data/".$p."/".$a);
            } else {
                file_put_contents("data/TV.json", json_encode(array("status"=>$s)));
                $s and sleep(4) or sleep(1);
                $p=($s?"tv_on":"tv_off");
                $a=scandir("data/".$p);
                $a=$a[rand(2, count($a)-1)];
                return array(true,"data/".$p."/".$a);
            }
        }
    }
}
