<?php
http_response_code(200);
for ($i=0; $i < 5; $i++) { 
	shell_exec('php -q cli.php');
}