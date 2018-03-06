<?php

require __DIR__."/vendor/autoload.php";
require __DIR__."/credentials.php";

$app = new \Bot\Bot($email, $pass);
$app->run();
