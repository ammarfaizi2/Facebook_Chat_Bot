<?php
#header("Content-Type:text/plain");
/*$a = file_get_contents("msg.txt");
exit($a);*/
date_default_timezone_set("Asia/Jakarta");
ini_set('display_errors', true);
ini_set("max_execution_time", false);
ini_set("memory_limit", "3072M");
ignore_user_abort(true);
set_time_limit(0);
require("class/tools/WhiteHat/Teacrypt.php");
require("class/Crayner_Machine.php");
/*                                                                                                    */
$username = "ammarfaizi93";
$name = "Ammar Kazuhiko Kanazawa";
$email = "ammarfaizi93@gmail.com";
$pass = "triosemut123";
define("fb", "fb_data");
define("cookies", fb.DIRECTORY_SEPARATOR."cookies");
define("data", fb.DIRECTORY_SEPARATOR."data");
/*                                                                                                    */
require("class/Facebook.php");
require("class/AI.php");
require("helper.php");
file_exists('./class/error_log') and unlink('./class/error_log');
file_exists('error_log') and unlink('error_log'); set_time_limit(0);
!is_dir(fb) and mkdir(fb) xor !is_dir(cookies) and mkdir(cookies) xor !is_dir(data) and mkdir(data);
if (!is_dir('photos')) {
mkdir('photos') and file_put_contents("./photos/not_found.png", base64_decode("iVBORw0KGgoAAAANSUhEUgAAAA0AAAANCAIAAAD9iXMrAAAAA3NCSVQICAjb4U/gAAAAF0lEQVQokWN0St/EQARgIkbRqLohqw4A2kABdRHXnFUAAAAASUVORK5CYII="));
}

/*// debugging here
while(1){
$a = new AI();
$b = $a->prepare(trim(fgets(STDIN,1024)));
$b->execute("Ammar Faizi");
$c = $b->fetch_reply();

var_dump($c);
print PHP_EOL;}
exit();
//*/

$count = 0;
$ckname = getcwd()."/".cookies.DIRECTORY_SEPARATOR.$username.".txt";
$fb = new Facebook($email, $pass, "", $username);
/*$a = new AI();
$b = $a->prepare("q_anime sword art online");
$b->execute("Ammar Faizi");
$c = $b->fetch_reply();
print $fb->upload_photo($c[1],$c[2],"/messages/read/?tid=mid.1432428093419%3A73c5e631100196f169&gfid=AQD7mGw71ijNURcx&refid=11#fua");


exit();*/
do{
    $ai = new AI();
    strpos(file_get_contents($ckname),"c_user")!==false or $fb->login();
    strpos(file_get_contents($ckname),"c_user")!==false or exit("Login Failed !");
    $src = $fb->go_to("https://m.facebook.com/messages");
    $src = empty($src) ? $fb->go_to("https://m.facebook.com/messages") : $src;
    $a = explode('#search_section',$src);
    $a = explode('see_older_threads',$a[1]);
    $a = explode('href="',$a[0]);
    for ($i=1; $i < count($a)-4; $i++) { 
        $b = explode('">',$a[$i]);
        $msglink[] = html_entity_decode($b[0],ENT_QUOTES,'UTF-8');
    } unset($a); $i = 0; $act = null;
    //$msglink = array("/messages/read/?tid=mid.1432428093419%3A73c5e631100196f169&gfid=AQD7mGw71ijNURcx&refid=11"); //debug
    foreach($msglink as $link){
        $src2 = $fb->go_to("https://m.facebook.com".$link);
        exit(json_encode(grchat($src2)));
        $a = grchat($src2); flush();
        if (count($a)<=1) {
            $src2 = $fb->go_to("https://m.facebook.com".$link);
            $g = grchat($src2);
            !is_array($a) and $a = array();
            is_array($g) and $a = array_merge($a,$g);
        }
        if (is_array($a)) {
            foreach ($a as $key => $value) {
                foreach ($value as $val) {
                    if ($key!=$name and check($val,$key.date("Hdmy").$link) xor save($val,$key.date("Hdmy").$link)) {
      if(file_exists("writing")){
      include_once "class/tools/Writer.php";
    		$aa = new Writer();
    		$bb = (int)file_get_contents("c_materi");
    		$aa->open("materi_".$bb.".json");
    		$aa->write($actor,$this->_msg);
    		$aa->save("materi_".$bb.".json");
    	}             	
                    	
                        if (strtolower(substr($val,0,5))=="<?php") {
/*if(file_exists("writing")){
	$st = $ai->prepare($val);
	$st->execute($key,true);
}        */                	
                        	
                            $act[$link][$key][] = "php".$fb->send_message($key.PHP_EOL.Crayner_Machine::php($key,preg_replace("#[^[:print:]]#","",substr($val,5))), $link, null, $src2);
                        } else {
                            $st = $ai->prepare($val);
                            if ($st->execute($key)) {
                                $_t = $st->fetch_reply();
                                if (is_array($_t)) {
                                    $act[$link][$key][] = "photo".$fb->upload_photo($_t[1],"",$link,$src2)."exec".$fb->send_message($_t[2],$link,null,$src2);
                                } else {
                                    $act[$link][$key][] = "exec".$fb->send_message($_t,$link,null,$src2);
                                }
                            }
                        }
                    }
                }
            }
        }
    } unset($msglink);
    isset($a) and print_r($a);
    flush();

    if (isset($act) and is_array($act)) {
        print_r($act); flush();
        unset($act); 
    }
} while (++$count<=2);