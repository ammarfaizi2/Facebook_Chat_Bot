<?php
function save($str, $salt=null)
{
    is_dir('cht_saver') or mkdir('cht_saver');
    file_put_contents('cht_saver/'.md5($str.$salt), "");
}
function check($str, $salt=null)
{
    return !file_exists('cht_saver/'.md5($str.$salt));
}
