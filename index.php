<?php
require_once("class/tools/WhiteHat/Teacrypt.php");
use tools\WhiteHat\Teacrypt;
function grchat($a)
{
    $z=function ($l) {
        return strip_tags(html_entity_decode(str_replace('<br />', "\n", $l), ENT_QUOTES, 'UTF-8'));
    };
    $ex="sabcdefghijklmnopqrtuvwxyz";
    $a=explode('pagination', $a);
    if (!isset($a[1])) {
        return false;
    }
    $a=explode('<form', $a[1]);
    $a=explode('href="/', $a[0]);
    for ($i=1;$i<count($a);$i++) {
        $b=explode("</strong>", $a[$i]);
        $b=explode(">", $b[0]);
        $c=($z($b[2]));
        $b=explode('"', $a[$i], 2);
        $u[$c]['link']="https://m.facebook.com/".$z($b[0]);
        $b=explode("<span>", $a[$i]);
        for ($j=1;$j<count($b);$j++) {
            if (strpos($b[$j], '<abbr>')!==false) {
                break;
            }
            $u[$c]['msg'][]=$z($b[$j]);
        }
    }
    return $u;
}
if (file_exists('error_log')) {
    unlink('error_log');
}
if (file_exists('./class/error_log')) {
    unlink('./class/error_log');
}
ini_set('display_errors', true);
if (file_exists('error_log')) {
    unlink('error_log');
}
#header("content-type:text/plain");
date_default_timezone_set("Asia/Jakarta");
ini_set("max_execution_time", false);
ini_set("memory_limit", "3072M");
//set_time_limit(0);
//ignore_user_abort(true);
$username = "ammarfaizi93";
$name = "Ammar Kazuhiko Kanazawa";
$email = "ammarfaizi93@gmail.com";
$pass = Teacrypt::sgr21dr("RTWmh5qwjmrdkvw5;5", "es teh");
$token = "";
define("fb", "fb_data");
define("cookies", fb.DIRECTORY_SEPARATOR."cookies");
define("data", fb.DIRECTORY_SEPARATOR."data");
define("ipath", getcwd().DIRECTORY_SEPARATOR."class".DIRECTORY_SEPARATOR);
$res[0] = fb.DIRECTORY_SEPARATOR.$username."_msg_post.txt";
$res[1] = fb.DIRECTORY_SEPARATOR.$username."_list_room.txt";
if (!is_dir(fb)) {
    mkdir(fb);
}
if (!is_dir(cookies)) {
    mkdir(cookies);
}
if (!is_dir(data)) {
    mkdir(data);
}
if (!is_dir('photos')) {
    mkdir('photos');
    file_put_contents("./photos/not_found.png", base64_decode("iVBORw0KGgoAAAANSUhEUgAAAA0AAAANCAIAAAD9iXMrAAAAA3NCSVQICAjb4U/gAAAAF0lEQVQokWN0St/EQARgIkbRqLohqw4A2kABdRHXnFUAAAAASUVORK5CYII="));
}
foreach ($res as $val) {
    if (!file_exists($val)) {
        file_put_contents($val, "");
    }
}
require_once("class/Crayner_Machine.php");
require_once("class/Facebook.php");
require_once("class/AI.php");

// debugging here
$a = new AI();
$b = $a->prepare("whois facebook.com");
$b->execute("Ammar Faizi");
$c = $b->fetch_reply();

print_r($c);
print PHP_EOL;
exit();
//*/
$count = 0;
$ckname = getcwd()."/".cookies.DIRECTORY_SEPARATOR.$username.".txt";
$fb = new Facebook($email, $pass, $token, $username);
do {
    $cookies = file_exists($ckname) ? file_get_contents($ckname) : "" ;
    if (!strpos($cookies, "c_user")!==false) {
        $content = $fb->login();
    }
    $msglink=null;
    $src = $fb->go_to("https://m.facebook.com/messages");
    $a = explode('/friends/selector/', $src);
    $a = explode('<table', end($a));
    for ($i=1;$i<=4;$i++) {
        $b=explode("<a ", $a[$i]);
        $b=explode('href="', $b[1]);
        $b=explode('"', $b[1]);
        $msglink[]=html_entity_decode($b[0], ENT_QUOTES, 'UTF-8');
    }
    foreach ($msglink as $pp) {
        $content = $fb->go_to("https://m.facebook.com/".$pp);
        $fb->set_msg_post(file_get_contents($res[0]));
        $ai=new AI();
        $rt=null;
        $act=null;
        $a=grchat($content);
        echo json_encode($a);
        flush();
        foreach ($a as $key => $value) {
            if (isset($value['msg'])) {
                foreach ($value['msg'] as $val) {
                    if ($key!=$name and check($val,$key.date("H"))) {
                        $ai->prepare($val);
                        if ($ai->execute($key)) {
                            $rp=$ai->fetch_reply();
                            is_array($rp) and $act[$key]="upload_photo".$fb->upload_photo($rp[1],$rp[2],$pp) or $act[$key]="send_message".$fb->send_message($rp,$pp);
                            save($val,$key.date("H"));
                        }
                    }
                }
            }
        }
    }
    var_dump($rt);
    echo PHP_EOL.PHP_EOL;
    print_r($act);
} while (true);


function save($str, $salt)
{
    is_dir('cht_saver') or mkdir('cht_saver');
    file_put_contents('cht_saver/'.md5($str.$salt), "");
}
function check($str, $salt)
{
    return !file_exists('cht_saver/'.md5($str.$salt));
}

exit();
