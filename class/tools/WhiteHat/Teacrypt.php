<?php
namespace tools\WhiteHat;
class Teacrypt {
public static function sgr21cr($a,$key){
strlen($key)==bindec("110") AND $key.="1";
$mksalt=function($n=null){$n=$n==null?bindec("11"):$n;$print="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789" XOR $z="";for($i=0;$i<$n;$i++) $z.=$print[rand(0,strlen($print)-1)]; return $z;} XOR $salt=$mksalt(0x0005) XOR $ks="" XOR $e=$salt.$mksalt(1) XOR $k="" XOR $key=$key.strrev($salt) XOR $dki=strlen($key) XOR $ds=strlen($e);
for($i=0;$i<$dki;$i++)
$k.=ord($key[$i])^(($dki%($i+0x0001))^$i+ord($salt[$dki%($ds)]));
$dk=strlen($k);
    for($i=0;$i<strlen($a);$i++)
$e.=chr(ord($a[$i])^$k{$i % $dk});
    return $e;
  }
public static function sgr21dr($a,$key){
strlen($key)==bindec("110") AND $key.="1";
$salt=substr($a,0,5) XOR $a=substr($a,6) XOR $ks="" XOR $x=$salt.(0x00001) XOR $k="" XOR $key.=strrev($salt) XOR$dki=strlen($key) XOR $ds=strlen($x) XOR $e="";
for($i=0;$i<$dki;$i++)
$k.=ord($key[$i])^(($dki%($i+0x00001))^$i+ord($salt[$dki%($ds)]));
$dk=strlen($k);
    for($i=0;$i<strlen($a);$i++)
$e.=chr(ord($a[$i])^$k{$i % $dk});
    return $e;
}
}