<?php
header("Content-Type:text/plain");
date_default_timezone_set("Asia/Jakarta");
ini_set('display_errors', true);
ini_set("max_execution_time", false);
ini_set("memory_limit", "3072M");
ignore_user_abort(true);
require("class/tools/WhiteHat/Teacrypt.php");
require("class/Crayner_Machine.php");
/*                                                                                                    */
$username = "rizkiy.affan.1";
$name = "Rizkiy Affan";
$email = "rizkiy.affan.1";
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
$a = new AI();
$b = $a->prepare("jm brp?");
$b->execute("Ammar Faizi");
$c = $b->fetch_reply();

var_dump($c);
print PHP_EOL;
exit();
//*/

$count = 0;
$ckname = getcwd()."/".cookies.DIRECTORY_SEPARATOR.$username.".txt";
$fb = new Facebook($email, $pass, "", $username);
$ai = new AI();
strpos(file_get_contents($ckname),"c_user")!==false or $fb->login();
strpos(file_get_contents($ckname),"c_user")!==false or exit("Login Failed !");
$src = $fb->go_to("https://m.facebook.com/messages");
$a = explode('/friends/selector/', $src);
$a = explode('<table', end($a));
for ($i=1;$i<=2;$i++) {
    $b=explode("<a ", $a[$i]);
    $b=explode('href="', $b[1]);
    $b=explode('"', $b[1]);
    $msglink[]=html_entity_decode($b[0], ENT_QUOTES, 'UTF-8');
} unset($a); $i = 0; $act = null;
foreach($msglink as $link){
    $a = grchat($fb->go_to("https://m.facebook.com/".$link));
    foreach ($a as $key => $value) {
        foreach ($value as $val) {
            if (check($val,$key.date("H").$link)) {
                save($val,$key.date("H").$link);
                $st = $ai->prepare($val);
                if ($st->execute($key)) {
                    $_t = $st->fetch_reply();
                    if (is_array($_t)) {
                        $act[$link][$key][] = "photo".$fb->upload_photo($_t[1],$_t[2],$link);
                    } else {
                        $act[$link][$key][] = "exec".$fb->send_message($_t,$link);
                    }
                }
            }
        }
    }
}
print_r($a);


if (is_array($act)) {
    print_r($act); unset($act);
}