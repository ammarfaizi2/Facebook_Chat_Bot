<?php
require __DIR__."/vendor/autoload.php";
require __DIR__."/config.php";
ini_set("display_errors", true);
ini_set("max_execution_time", false);
ignore_user_abort(true);
set_time_limit(0);
for ($i=0;$i<10;$i++) { 
	Bot\BotFacebook::run($config);
}
