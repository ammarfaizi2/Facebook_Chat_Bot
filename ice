<?php
require __DIR__.'/PCLZip.php';
$archive = new PClZip(__DIR__.'/de/install.zip');
$v_list = $archive->create('vendor/ammarfaizi2', PCLZIP_OPT_REMOVE_PATH, 'vendor');
print_r($v_list);