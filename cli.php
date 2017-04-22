<?php
header("Content-Type:text/plain");
//exit('maintenance');

require "config.php";
require "class/tools/WhiteHat/Teacrypt.php";
require "class/Crayner_Machine.php";
require "class/Facebook.php";
require "class/AI.php";
require "helper.php";
require "mgmt.php";


/*// pg debug
#$a = file_get_contents("aa");
#exit($a);
*/

date_default_timezone_set($config['timezone']);
ini_set('display_errors', $config['development_mode']);
ini_set("max_execution_time", $config['max_execution_time']);
ini_set("memory_limit", $config['memoy_limit']);
ignore_user_abort(true);
set_time_limit(0);
                                 
define("fb", "fb_data");
define("cookies", fb.DIRECTORY_SEPARATOR."cookies");
define("data", fb.DIRECTORY_SEPARATOR."data");

(file_exists('./class/error_log') and unlink('./class/error_log')) XOR (file_exists('error_log') and unlink('error_log')) XOR (!is_dir(fb) and mkdir(fb)) XOR (!is_dir(cookies) and mkdir(cookies)) XOR (!is_dir(data) and mkdir(data));
if (!is_dir('photos')) {
mkdir('photos') and file_put_contents("./photos/not_found.png", base64_decode("iVBORw0KGgoAAAANSUhEUgAAAA0AAAANCAIAAAD9iXMrAAAAA3NCSVQICAjb4U/gAAAAF0lEQVQokWN0St/EQARgIkbRqLohqw4A2kABdRHXnFUAAAAASUVORK5CYII="));
}

/*// debugging here
while(1){
print "input : ";
$a = new AI();
$b = $a->prepare("q_anime shigatsu wa kimi");
echo $b->execute("Ammar Faizi");
$c = $b->fetch_reply();

var_dump($c);
print PHP_EOL;
exit();	}
//*/
function chkck($ck)
{
	return file_exists($ck)?(strpos(file_get_contents($ck),'c_user')===false):true;
}
function chkfile()
{
	if(!file_exists("login_avoid")){
		file_put_contents("avoid_brute_login","0");
	}
	return ((int)file_get_contents("avoid_brute_login")<5);
}
function void_log()
{
	return (bool)file_put_contents("avoid_brute_login",(((int)file_get_contents("avoid_brute_login"))+1));
}
$url = "https://m.facebook.com/";
$count = 0; 
$ckname = getcwd()."/".cookies.DIRECTORY_SEPARATOR.$username.".txt";
$fb = new Facebook($config['email'], $config['pass'], "", $config['username']);
$ai = new AI();
do{
// do
if(chkck($ckname) && chkfile()){
 print $fb->login();
 void_log();
}
$zz = new mgmt($fb->go_to($url.'messages'));
$zza = $zz->grb(8);
if($zza===false){
 chkfile() and print	$fb->login();
	$zz = new mgmt($fb->go_to($url.'messages'));
	$zza = $zz->grb(8);
} 
if(!is_array($zza)){
	die("Error getting messages !");
}
/**
*
*		gcn = nama chat
*		link = link chat
*
*/

$act = array();
foreach($zza as $gcn => $link){
	/**
	*
	*		get chat contents
	*
	*/
	$con = $fb->go_to($url.$link);
	$data = $zz->grchat($con);
	if(count($data)<2){
		$con = $fb->go_to($url.$link);
		$data = $zz->grchat($con);
	}
	if(!is_array($data)){
		$rt[$gcn] = "An error occured !";
	} else {
// foreach data from user
foreach($data as $q){
// foreach message
foreach($q['messages'] as $m){
	// check message
	$salt = $gcn.$m.date("H Ymd");
	if(check($m,$salt) and $q['name']!=$name){
		save($m,$salt);
		
		if(substr(strtolower($m),0,5)=="<?php"){
$act[$q['name']][] = "php".$fb->send_message($q['name'].PHP_EOL.Crayner_Machine::php($q['name'],preg_replace("#[^[:print:]]#","",substr($m,5))), null, null, $con);
			
		} else {
// prepare statement
$st = $ai->prepare($m,$gcn);
// execute statement
if($st->execute($q['name'])){
	$reply = $st->fetch_reply();	
// reply
if(is_array($reply)){
		if($reply[0]=="img/text"){
			$fb->upload_photo($reply[0],'',null,$con);
			$fb->send_messages($reply[1],null,null,$con);
			$act[$q['name']][] = "img/text";
		}} else {
			$fb->send_message($reply,null,null,$con);
			
			$act[$q['name']][] = "text";
			}
// end reply
}}
} else if($q['name']==$name and file_exists("writer") and check($m,$name.date("H dmy"))){
	save($m,$name.date("H dmy"));
	$st = $ai->prepare($m,$gcn);
	$st->writer();
} // end check message
} // end foreach message
if(isset($q['attachment'])){
	
}
}

} // end foreach data from user
		$rt[$gcn] = array(
		'url'=>$link,
		'data'=>$data
	);
}

isset($rt) and print_r($rt);
isset($act) and print_r($act);
unset($rt,$act);
flush(); break;
// while 
} while(++$ctntt<=$config['cycle']);