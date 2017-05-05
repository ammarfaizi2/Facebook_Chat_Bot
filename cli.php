<?php
require __DIR__.'/vendor/autoload.php';
require __DIR__.'/config.php';
use System\AI;
use System\Facebook;
use System\BotFacebook;
use System\ChatController;


define('data', __DIR__.'/data');
define('fb_data',data.'/fb_data');
is_dir(data) or mkdir(data);
is_dir(fb_data) or mkdir(fb_data);


/* debugging here
$a = new AI();
$st = $a->prepare("translate hello");
$st->execute();
var_dump($st->fetch_reply());
//*/

$app = new BotFacebook($config);
$app->run();
