<?php
require_once("class/tools/WhiteHat/Teacrypt.php");
use tools\WhiteHat\Teacrypt;
#header('content-type:text/plain');
function grchat($a){
	$z=function($l){
		return strip_tags(html_entity_decode(str_replace('<br />',"\n",$l),ENT_QUOTES,'UTF-8'));
	};
	$ex="sabcdefghijklmnopqrtuvwxyz";
	$a=explode('pagination',$a);
	if(!isset($a[1])) return false;
	$a=explode('<form',$a[1]);
	$a=explode('href="/',$a[0]);
	for($i=1;$i<count($a);$i++){
		$b=explode("</strong>",$a[$i]);
		$b=explode(">",$b[0]);
		$c=($z($b[2]));
		$b=explode('"',$a[$i],2);
		$u[$c]['link']="https://m.facebook.com/".$z($b[0]);
		$b=explode("<span>",$a[$i]);
		for($j=1;$j<count($b);$j++){
			if(strpos($b[$j],'<abbr>')!==false){
				break;
			}
			$u[$c]['msg'][]=$z($b[$j]);
		}
	}
	return $u;
}
if (file_exists('error_log')) unlink('error_log');
if (file_exists('./class/error_log')) unlink('./class/error_log');
ini_set('display_errors',TRUE);
if(file_exists('error_log'))unlink('error_log');
#header("content-type:text/plain");
date_default_timezone_set("Asia/Jakarta");
ini_set("max_execution_time",false);
ini_set("memory_limit","3072M");
//set_time_limit(0);
//ignore_user_abort(true);
$username = "ammarfaizi93";
$botname = "Ammar Kazuhiko Kanazawa";
$email = "ammarfaizi93@gmail.com";
$pass = Teacrypt::sgr21dr("RTWmh5qwjmrdkvw5;5","es teh");
$token = "";
define("fb","fb_data");
define("cookies",fb.DIRECTORY_SEPARATOR."cookies");
define("data",fb.DIRECTORY_SEPARATOR."data");
define("ipath",getcwd().DIRECTORY_SEPARATOR."class".DIRECTORY_SEPARATOR);
$res[0] = fb.DIRECTORY_SEPARATOR.$username."_msg_post.txt";
$res[1] = fb.DIRECTORY_SEPARATOR.$username."_list_room.txt";
if(!is_dir(fb)) mkdir(fb);
if(!is_dir(cookies)) mkdir(cookies);
if(!is_dir(data)) mkdir(data);
if(!is_dir('photos')) {
	mkdir('photos');
	file_put_contents("./photos/not_found.png",base64_decode("iVBORw0KGgoAAAANSUhEUgAAAA0AAAANCAIAAAD9iXMrAAAAA3NCSVQICAjb4U/gAAAAF0lEQVQokWN0St/EQARgIkbRqLohqw4A2kABdRHXnFUAAAAASUVORK5CYII="));
}
foreach ($res as $val) {
	if (!file_exists($val)) {
		file_put_contents($val,"");
	}
}
require_once("./class/Crayner_Machine.php");
require_once("./class/Facebook.php");
require_once("class/ai2.php");
$blacklist = array("Niaze Mahmoed Rifai");
$posw = 0;
$ckname = getcwd()."/".cookies.DIRECTORY_SEPARATOR.$username.".txt";
// debugging
/*
$logic = new AI();
$logic->get("off");
$b = $logic->execute("Ammar Faizi");
var_dump($b);
exit();
//*/
$fb = new Facebook($email,$pass,$token,$username);
do{
	$cookies = file_exists($ckname) ? file_get_contents($ckname) : "" ;
	if (!strpos($cookies,"c_user")!==false) {
		$content = $fb->login();
	}	
		$msglink=null;
		$src = $fb->go_to("https://m.facebook.com/messages");
		$a = explode('/friends/selector/',$src);
	$a = explode('<table',end($a));
	for($i=1;$i<=10;$i++){
		$b=explode("<a ",$a[$i]);
		$b=explode('href="',$b[1]);
		$b=explode('"',$b[1]);
			$msglink[]=html_entity_decode($b[0],ENT_QUOTES,'UTF-8');
	}
	foreach($msglink as $pp):
	$content = $fb->go_to("https://m.facebook.com/".$pp);
	$fb->set_msg_post(file_get_contents($res[0]));
$ai=new AI();$rt=null;$act=null;
$a=grchat($content);
var_dump($a);flush();
if($a!==false){
foreach($a as $b => $c){
	if(isset($c['msg'])){
	foreach($c['msg'] as $d){
		if(!	check($d,$b.date("H").$pp)&&$b!=$botname
		){
			$st=$ai->prepare($d);
			$exec=$st->execute($b);
			if($exec!==false){
				$rt[$pp][$b][]=$st->fetch_reply();
				save($d,$b.date("H").$pp);
			}
		}
	}
}
}}
endforeach;

if(isset($rt)){
	foreach($rt as $a => $b){
		foreach($b as $aaa => $c){
			foreach($c as $c){
				if(is_array($c)){
					if($c[0]=="img"){
						$act[$aaa]="exec".$fb->upload_photo($c[1],$c[2],$a);
					}
				} else {
				$act[$aaa]="exec".$fb->send_message($c,$a);
				}
			}
		}
	}
}
var_dump($rt);
echo PHP_EOL.PHP_EOL;
print_r($act);







}while(false);


function save($str,$salt){
	is_dir('cht_saver') OR mkdir('cht_saver');
	file_put_contents('cht_saver/'.md5($str.$salt),"");
}
function check($str,$salt){
	return !!file_exists('cht_saver/'.md5($str.$salt));
}

exit();