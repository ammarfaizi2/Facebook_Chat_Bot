<?php

$data = json_decode(rawurldecode($argv[1]), true);

require __DIR__."/vendor/autoload.php";

$app = new Bot\Action($data);
$app->run();
