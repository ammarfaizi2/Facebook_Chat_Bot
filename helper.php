<?php
function save($str, $salt)
{
    is_dir('cht_saver') or mkdir('cht_saver');
    file_put_contents('cht_saver/'.md5($str.$salt), "");
}
function check($str, $salt)
{
    return !file_exists('cht_saver/'.md5($str.$salt));
}
function grchat($a)
{
    $z=function ($l) {
        return strip_tags(html_entity_decode(str_replace('<br />', "\n", $l), ENT_QUOTES, 'UTF-8'));
    };
    $ex="sabcdefghijklmnopqrtuvwxyz";
    $a=explode('pagination', $a);
    if (!isset($a[1])) {
        return false;
    }
    $a=explode('<form', $a[1]);
    $a=explode('href="/', $a[0]);
    for ($i=1;$i<count($a);$i++) {
        $b=explode("</strong>", $a[$i]);
        $b=explode(">", $b[0]);
        $c=($z($b[2]));
        $b=explode('"', $a[$i], 2);
        $u[$c]['link']="https://m.facebook.com/".$z($b[0]);
        $b=explode("<span>", $a[$i]);
        for ($j=1;$j<count($b);$j++) {
            if (strpos($b[$j], '<abbr>')!==false) {
                break;
            }
            $u[$c]['msg'][]=$z($b[$j]);
        }
    }
    return $u;
}
