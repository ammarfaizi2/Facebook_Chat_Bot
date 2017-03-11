<?php
require("class/tools/WhiteHat/Teacrypt.php");
if (file_exists('error_log')) {
    unlink('error_log');
}
if (file_exists('./class/error_log')) {
    unlink('./class/error_log');
}
if (file_exists('error_log')) {
    unlink('error_log');
}
date_default_timezone_set("Asia/Jakarta");
ini_set('display_errors', true);
ini_set("max_execution_time", false);
ini_set("memory_limit", "3072M");
ignore_user_abort(true);
set_time_limit(0);
$username = "ammarfaizi93";
$name = "Ammar Kazuhiko Kanazawa";
$email = "ammarfaizi93@gmail.com";
$pass = tools\WhiteHat\Teacrypt::sgr21dr("RTWmh5qwjmrdkvw5;5", "es teh");
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
require_once("helper.php");

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
$fb = new Facebook($email, $pass, $token, $username);
$ai=new AI();
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
        $act=null;
        $a=grchat($content);
        echo json_encode($a);
        flush();
        if ($a!==false) {
            foreach ($a as $key => $value) {
                if (isset($value['msg'])) {
                    foreach ($value['msg'] as $val) {
                        if ($key!=$name and check($val, $key.date("H"))) {
                            $ai->prepare($val);
                            if ($ai->execute($key)) {
                                $rp=$ai->fetch_reply();
                                is_array($rp) and $act[$key]="upload_photo".$fb->upload_photo($rp[1], $rp[2], $pp) or $act[$key]="send_message".$fb->send_message($rp, $pp);
                                save($val, $key.date("H"));
                            }
                        }
                    }
                }
            }
        }
    }
    echo PHP_EOL.PHP_EOL;
    print_r($act);
    $count++;
} while ($count<=5);
$counter = file_exists("counter.txt")?(int)file_get_contents("counter.txt"):0;
if ($counter>=1000) {
    $counter = 0;
    if (is_dir("cht_saver")) {
        $scan = scandir("cht_saver");
        unset($scan[0], $scan[1]);
        foreach ($scan as $val) {
            unlink("cht_saver".DIRECTORY_SEPARATOR.$val);
        }
    }
}
file_put_contents("counter.txt", ++$counter);
exit();
