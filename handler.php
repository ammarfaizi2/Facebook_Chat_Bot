<?php
set_time_limit(0);
ignore_user_abort(true);
http_response_code(200);
for ($i=0; $i < 5; $i++) {
    shell_exec('php -q cli.php');
}
