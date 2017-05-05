<?php
require __DIR__.'/vendor/autoload.php';
use System\AI;
define('data',__DIR__.'/data');
is_dir(data) or mkdir(data);
$a = new AI();
$st = $a->prepare("translate hello");
$st->execute();
var_dump($st->fetch_reply());