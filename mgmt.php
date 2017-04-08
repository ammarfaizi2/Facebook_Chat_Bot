<?php
class mgmt
{
public function __construct($str)
{
	$this->str = $str;
}
private function tw($s){
	return trim(html_entity_decode($s,ENT_QUOTES,'UTF-8'));
}
public function grb($n=10)
{
$a = explode("#search_section",$this->str);
if(count($a)<2) return false;
$a = explode("see_older_threads",$a[1]);
$a = explode("<table ",$a[0]);
for($i=1;$i<$n;$i++){
	$b = explode("href=\"",$a[$i]);
	$b = explode("\"",$b[1],3);
	$z = explode("<",$b[1]);
	$rt[$this->tw(substr($z[0],1))] = $this->tw($b[0]);
}
return $rt;
}
public function grchat($a)
{
$a = explode("table ",$a);
$a = explode("<form",$a[2]);
$a = explode("<strong",$a[0]);
for($i=1;$i<count($a);$i++){
	$n = null;
	$b = explode("href=\"",$a[$i-1]);
	$b = explode("\"",end($b));
	$c = explode(">",$a[$i],2);
	$c = explode("</",$c[1],2);
	preg_match("#<img src=\"(.*)\"#",$c[1],$n);
	if(isset($n[1])){
		$z = explode("\"",$n[1],2);
		$att = $this->tw($z[0]);
	} else {
		$att = '';
	}
	$d = explode("<span>",$c[1]);
	$msg = array();
	for($j=1;$j<count($d);$j++){
		if(strpos($d[$j],"<abbr>")!==false){
			preg_match("#<abbr>(.*)</abbr>#",$d[$j],$n);
			$time = isset($n[1])?$n[1]:null; break;
		} else {
			$f = "<span>".$d[$j];
			preg_match("#<span>(.*)</span>#",$f,$n);
			$msg[] = $this->tw(str_replace("<br />","\n",$n[1]));
		}
	}
	$e[] = $d;
	$rt[$i-1] = array(
		'name'=>$this->tw($c[0]),
		'messages'=>$msg,
		'time'=>$time,
	);
	!empty($att) and $rt[$i-1]['attachment'] = $att;
}
return isset($rt)?$rt:null;
}
}