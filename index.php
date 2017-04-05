<?php
header('content-type:text/plain');
http_response_code(200);
ini_set("max_execution_time",false);
ini_set("memory_limit","3072M");
ignore_user_abort(true);
set_time_limit(0);
error_reporting(0);
for($i=0;$i<2;$i++)
shell_exec("php -q cli.php");
shell_exec("rm -rf error_log");