<?php
require __DIR__.'/vendor/autoload.php';
require __DIR__.'/config.php';
use System\AI;
use System\Install;
use System\Facebook;
use System\BotFacebook;
define('data', __DIR__.'/data');
define('fb_data', data.'/fb_data');
is_dir(data) or mkdir(data);
is_dir(fb_data) or mkdir(fb_data);
header('Content-type:text/plain');
$ins = new Install();
if (!$ins->is_installed()) {
    $ins->install();
}
unset($ins);

/*// debugging here
$a = new AI();
$st = $a->prepare("ask penemu lampu");
$st->execute();
var_dump($st->fetch_reply());
die;
//*/

$app = new BotFacebook($config);
$app->run();