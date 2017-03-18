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
    $a = explode('<table class="m" role="presentation">',$a);
    $a = explode('<form',$a[2]);
    $a = explode('<strong',$a[0]);
    for ($i=1; $i < count($a); $i++) { 
        $b = explode('>',$a[$i]);
        $b = explode('<',$b[1]);
        $c = explode("</strong>",$a[$i]);
        $c = explode('<abbr>',$c[1]);
        $c = explode("\n",trim(html_entity_decode(strip_tags(str_replace("<br />","\n",$c[0])),ENT_QUOTES,'UTF-8')));
        if (count($c)>1) {
            $d = "";
            for ($k=0;$k<count($c);$k++) { 
                $d.=trim($c[$k])."\n";
            }
        } else {
            $d = $c[0];
        }
        $sv[$b[0]][] = $d;
    }
    return $sv;
}