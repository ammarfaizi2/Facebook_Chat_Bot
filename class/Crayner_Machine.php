<?php
date_default_timezone_set("Asia/Jakarta");
/**
* @author Ammar F. https://www.facebook.com/ammarfaizi2 <ammarfaizi2@gmail.com>
* @license RedAngel_PHP_Concept (c) 2017
*/
class Crayner_Machine
{
    const USERAGENT = "Mozilla/5.0 (Windows NT 6.1; rv:50.0) Gecko/20100101 Firefox/50.0";
    public static function curl($url, $op=null, $return=null)
    {
        $ch = curl_init();
        $options = array(
                CURLOPT_URL=>$url,
                CURLOPT_RETURNTRANSFER=>true,
                CURLOPT_SSL_VERIFYPEER=>false,
                CURLOPT_SSL_VERIFYHOST=>false,
                CURLOPT_ENCODING=>"",
                CURLOPT_USERAGENT=>self::USERAGENT,
                CURLOPT_TIMEOUT=>30
            );
        if (is_array($op)) {
            foreach ($op as $key => $value) {
                $options[$key] = $value;
            }
        }
        curl_setopt_array($ch, $options);
        $op=$options=null;
        if ($return!==null) {
            if (strpos($return, "curl_getinfo")!==false) {
                curl_exec($ch);
                $a = curl_getinfo($ch);
                curl_close($ch);
                $ch=null;
                return $a;
            } elseif (strpos($return, "curl_error")!==false) {
                curl_exec($ch);
                $a = curl_error($ch);
                curl_close($ch);
                $ch=null;
                return $a;
            } elseif (strpos($return, "curl_errno")!==false) {
                curl_exec($ch);
                $a = curl_errno($ch);
                curl_close($ch);
                $ch=null;
                return $a;
            } elseif (strpos($return, "curl_exec")!==false) {
                $a = curl_exec($ch);
                curl_close($ch);
                $ch=null;
                return $a;
            } elseif (strpos($return, "all")!==false) {
                $return = array(
                        "curl_exec"=>curl_exec($ch),
                        "curl_getinfo"=>curl_getinfo($ch),
                        "curl_error"=>curl_error($ch),
                        "curl_errno"=>curl_errno($ch)
                    );
                curl_close($ch);
                $ch=null;
                return $return;
            } else {
                return "false";
            }
        } else {
            $exec = curl_exec($ch);
            $error = curl_error($ch);
            $errno = curl_errno($ch);
            curl_close($ch);
            $ch=null;
            return $exec;
        }
    }
    public static function qurl($url, $cookie=null, $post=null, $op=null, $return=null)
    {
        $options = $op!==null ? array() : null;
        if ($cookie!==null) {
            $options[CURLOPT_COOKIEJAR] = $cookie;
            $options[CURLOPT_COOKIEFILE] = $cookie;
        }
        if ($post!==null) {
            $options[CURLOPT_POST] = true;
            $options[CURLOPT_POSTFIELDS] = $post;
        }
        if ($op!==null) {
            foreach ($op as $key => $value) {
                $options[$key] = $value;
            }
        }
        return self::curl($url, $options, $return);
    }
    public static function php($file, $contents)
    {
        $file=md5($contents).".php";
        is_dir("php") or mkdir("php");
        file_exists("php/".$file) or file_put_contents("php/".$file, "<?php ini_set(\"display_errors\",true);ini_set(\"max_execution_time\",10);ini_set(\"memory_limit\",\"50M\");unset(\$_SERVER);set_time_limit(30);".$contents);
        $st=microtime(true);
        $mt=memory_get_usage();
        $eoc=Crayner_Machine::qurl("https://www.yessrilanka.com/content/admin/php/fb/php_ic/botfb/php/".$file);
        $st=microtime(true)-$st;
        $mt=memory_get_usage()-$mt;
        $a = array(
                "/home/srilanka/public_html/content/admin/php/fb/php_ic/botfb/",
                "yessrilanka",
                "srilanka"
            );
        $b = array(
                "/root/crayner_system/tmp_action",
                "crayner",
                "crayner"
            );
        return "PHP Output : \n".str_replace($a, $b, $eoc);
    }
}