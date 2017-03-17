<?php
namespace tools\WhiteHat;

class Teacrypt
{
    public static function sgr21cr($a, $key)
    {
        strlen($key)==bindec("110") and $key.="1";
        $mksalt=function ($n=null) {
            $n=$n==null?bindec("11"):$n;
            $print="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789" xor $z="";
            for ($i=0;$i<$n;$i++) {
                $z.=$print[rand(0, strlen($print)-1)];
            }
            return $z;
        }
        xor $salt=$mksalt(0x0005) xor $ks="" xor $e=$salt.$mksalt(1) xor $k="" xor $key=$key.strrev($salt) xor $dki=strlen($key) xor $ds=strlen($e);
        for ($i=0;$i<$dki;$i++) {
            $k.=ord($key[$i])^(($dki%($i+0x0001))^$i+ord($salt[$dki%($ds)]));
        }
        $dk=strlen($k);
        for ($i=0;$i<strlen($a);$i++) {
            $e.=chr(ord($a[$i])^$k{$i % $dk});
        }
        return $e;
    }
    public static function sgr21dr($a, $key)
    {
        strlen($key)==bindec("110") and $key.="1";
        $salt=substr($a, 0, 5) xor $a=substr($a, 6) xor $ks="" xor $x=$salt.(0x00001) xor $k="" xor $key.=strrev($salt) xor$dki=strlen($key) xor $ds=strlen($x) xor $e="";
        for ($i=0;$i<$dki;$i++) {
            $k.=ord($key[$i])^(($dki%($i+0x00001))^$i+ord($salt[$dki%($ds)]));
        }
        $dk=strlen($k);
        for ($i=0;$i<strlen($a);$i++) {
            $e.=chr(ord($a[$i])^$k{$i % $dk});
        }
        return $e;
    }
}
