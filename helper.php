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
function grchat($a)
{
    $a = explode('<table',$a);
    $a = explode('<form',$a[2]);
    $a = explode('<strong',$a[0]);
    for($j=1;$j<count($a);$j++){
        $b = explode('<div',$a[$j]);
        for ($i=1; $i < count($b); $i++) { 
            if (strpos($b[$i],"<abbr>")) {
                break;
            }
            $c = trim(html_entity_decode(strip_tags(str_replace("<br />","\n","<".trim($b[$i]))),ENT_QUOTES,'UTF-8'));
            !empty($c) and $sv[strip_tags("<".trim($b[0]))][] = $c;
        }
    }
    return isset($sv)?$sv:false;
}