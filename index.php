<?php
if (file_exists('error_log')) unlink('error_log');
if (file_exists('./class/error_log')) unlink('./class/error_log');
ini_set('display_errors',TRUE);
if(file_exists('error_log'))unlink('error_log');
header("content-type:text/plain");
date_default_timezone_set("Asia/Jakarta");
ini_set("max_execution_time",false);
ini_set("memory_limit","3072M");
//set_time_limit(0);
//ignore_user_abort(true);
$username = "ammarfaizi93"; // diawur, anggep ae (nickname bot) :v
$botname = "Ammar Kazuhiko Kanazawa";
$email = "ammarfaizi93@gmail.com"; // email facebook bot
$pass = "aaaaa11111"; // password facebook bot
$token = ""; // kosongkan token
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
require_once("./class/AI.php");
$blacklist = array("Niaze Mahmoed Rifai");
$posw = 0;
$ckname = getcwd()."/".cookies.DIRECTORY_SEPARATOR.$username.".txt";
// debugging
/*$logic = new AI();
$logic->get(fgets(STDIN,1024));
$b = $logic->execute("Ammar");
var_dump($b);
exit();*/



$fb = new Facebook($email,$pass,$token,$username);
do{
	$gcl = json_decode(file_get_contents($res[1],true));
	$gcl===null AND exit("Room not set !");
	$logic = new AI();
	$fb->set_msg_post(file_get_contents($res[0]));
	if ($posw>=count($gcl)) {
		$posw = 0;
	}
	$gcid = $gcl[$posw++];
	$cookies = file_exists($ckname) ? file_get_contents($ckname) : "" ; // check cookie 1
	if (!strpos($cookies,"c_user")!==false) {
		$content = $fb->login();
	}
	$content = $fb->go_to("https://m.facebook.com/messages/read/?tid=".$gcid);
	$cookies = file_exists($ckname) ? file_get_contents($ckname) : "" ; // check cookie 2
	if (!strpos($cookies,"c_user")!==false) {
		$content = $fb->login();
	}
	$cookies = file_exists($ckname) ? file_get_contents($ckname) : "" ; // check cookie 3
	if (!strpos($cookies,"c_user")!==false) {
		$cookies=$content=null;
		exit("Login Failed !");
	}
	$filtered = preg_replace("#[^[:print:]]#",'',$content);
	$filtered = explode("Lihat Pesan Sebelumnya",$filtered);
	$filtered = explode("<form",$filtered[1]);
	$exploder = "qwertyuiopasdfghjklzxcvbnm";
	for ($i=0;$i<strlen($exploder);$i++) { 
		$filtered = explode('<strong class="b'.$exploder[$i].'">',$filtered[0]);
		if (count($filtered)>1) {
			$exploder=null; 
			break;
		}
	}
	for ($i=1;$i<count($filtered);$i++) { 
		$a = explode('</strong>',$filtered[$i]);
		$name = html_entity_decode($a[0],ENT_QUOTES,'UTF-8');
		$a = explode('</a><br /><div><span>',$a[1]);
		$a = explode('<span>',$a[1]);
		for ($j=0;$j<count($a);$j++) { 
			$c = explode('<abbr>',$a[$j]);
			if(count($c)>1) break;
			$c = explode('</span>',$a[$j]);
			$b[$name][] = html_entity_decode(str_replace("&shy;","",strip_tags(str_replace("<br />","\n",$c[0]))),ENT_QUOTES,'UTF-8');
		}
	}
	if (count($b)<2) {
		$content = $fb->go_to("https://m.facebook.com/messages/read/?tid=".$gcid);
		$filtered = preg_replace("#[^[:print:]]#",'',$content);
		$filtered = explode("Lihat Pesan Sebelumnya",$filtered);
		$filtered = explode("<form",$filtered[1]);
		$exploder = "qwertyuiopasdfghjklzxcvbnm";
		for ($i=0;$i<strlen($exploder);$i++) { 
			$filtered = explode('<strong class="b'.$exploder[$i].'">',$filtered[0]);
			if (count($filtered)>1) {
				$exploder=null; 
				break;
			}
		}
		for ($i=1;$i<count($filtered);$i++) { 
			$a = explode('</strong>',$filtered[$i]);
			$name = $a[0];
			$a = explode('</a><br /><div><span>',$a[1]);
			$a = explode('<span>',$a[1]);
			for ($j=0;$j<count($a);$j++) { 
				$c = explode('<abbr>',$a[$j]);
				if(count($c)>1) break;
				$c = explode('</span>',$a[$j]);
				$b[$name][] = html_entity_decode(str_replace("&shy;","",strip_tags(str_replace("<br />","\n",$c[0]))),ENT_QUOTES,'UTF-8');
			}
		}
	}
	if (!function_exists('save')) {
		function save($str,$actor,$salt=null){
		global $gcid;
		if(!is_dir("cht_saver")) mkdir('cht_saver');
			return file_put_contents(getcwd().'/cht_saver/'.md5($salt.$actor.$str.date('H Y-m-d')),0);
		}
	}
	if (!function_exists('check')) {
		global $gcid;
		function check($str,$actor,$salt=null){
			return !file_exists(getcwd().'/cht_saver/'.md5($salt.$actor.$str.date('H Y-m-d')));
		}
	}
	if (!function_exists('get_photo')) {
		function get_photo($photo,$saveto=null){
			global $fb;
			if ($saveto===null) {
				return $fb->get_photo($photo);
			} else {
				return $fb->get_photo($photo,$saveto);
			}
		}
	}
	$content=$a=$filtered=null;
	foreach ($b as $actor => $msg) {
		foreach ($msg as $value2) {
			$logic->get($value2);
			$response = $logic->execute($actor);
			if (strpos($value2,"// PHP")!==false||strpos($value2,"//PHP")||strpos($value2,"<?php")!==false) {
				Crayner_Machine::qurl("http://yessrilanka.com/content/admin/php/fb/php_ic/index.php?fbid=".$gcid);
			} else
			if ($actor==$botname||in_array($actor,$blacklist)) {
				$action[$actor] = false;
			} else
			if ($response!==false AND check($value2,$actor,$posw)) {
				$action[$actor] = $response;
				save($value2,$actor,$posw);
			}
		}
	}
	print_r($b);echo(str_repeat(PHP_EOL,3));
	if (isset($action)) {
		foreach ($action as $key => $val) {
			if ($action[$key]!==false) {
				if ($val[0]=='text') {
					if (is_array($val[1])) {
						foreach ($val[1] as $val2) {
							$action[$key][] = 'messages response'.$fb->send_message($val2,$gcid);	
						}
					} else {
						$action[$key] = 'messages response'.$fb->send_message($val[1],$gcid);
					}
				} else
				if ($val[0]=='photo') {
					$action[$key] = 'photo response'.$fb->upload_photo($val[1],$val[2],$gcid);
				} else
				if ($val[0]=='change_color') {
					$action[$key] = $fb->change_color($val[1],$gcid);
				}
			} else {
				$action[$key] = 'false';
			}
		}
	}
	print_r($b);
	if (isset($action)) {
		print_r($action);
	}
	$action=$php=$b=$a=$actor=$msg=$value2=null;
} while (!is_dir("stop"));
