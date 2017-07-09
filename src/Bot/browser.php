<?php
require __DIR__."/vendor/autoload.php";
require __DIR__."/config.php";
$app = new \Facebook\PHPFB($config['email'], $config['pass'], $config['user']);
$app->run();
