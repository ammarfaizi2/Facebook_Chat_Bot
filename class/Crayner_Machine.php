<?php
date_default_timezone_set("Asia/Jakarta");
/**
* @author Ammar F. https://www.facebook.com/ammarfaizi2 <ammarfaizi2@gmail.com>
* @license RedAngel_PHP_Concept (c) 2017
*/
class Crayner_Machine{
	const USERAGENT = "Mozilla/5.0 (Windows NT 6.1; rv:50.0) Gecko/20100101 Firefox/50.0";
	public static function curl($url,$op=null,$return=null){
		$ch = curl_init();
		$options = array(
				CURLOPT_URL=>$url,
				CURLOPT_RETURNTRANSFER=>true,
				CURLOPT_SSL_VERIFYPEER=>false,
				CURLOPT_SSL_VERIFYHOST=>false,
				CURLOPT_ENCODING=>"",
				CURLOPT_USERAGENT=>self::USERAGENT,
				CURLOPT_TIMEOUT=>25
			);
		if (is_array($op)) foreach ($op as $key => $value) $options[$key] = $value;
		curl_setopt_array($ch,$options);
		$op=$options=null;
		if ($return!==null){
			if (strpos($return,"curl_getinfo")!==false) {
				curl_exec($ch);
				$a = curl_getinfo($ch);
				curl_close($ch);
				$ch=null;
				return $a;
			} else
			if (strpos($return,"curl_error")!==false) {
				curl_exec($ch);
				$a = curl_error($ch);
				curl_close($ch);
				$ch=null;
				return $a;
			} else
			if (strpos($return,"curl_errno")!==false) {
				curl_exec($ch);
				$a = curl_errno($ch);
				curl_close($ch);
				$ch=null;
				return $a;
			} else
			if (strpos($return,"curl_exec")!==false) {
				$a = curl_exec($ch);
				curl_close($ch);
				$ch=null;
				return $a;
			} else
			if (strpos($return,"all")!==false) {
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
	public static function qurl($url,$cookie=null,$post=null,$op=null,$return=null){
		$options = $op!==null ? array() : null;
		if ($cookie!==null) {
			$options[CURLOPT_COOKIEJAR] = $cookie;
			$options[CURLOPT_COOKIEFILE] = $cookie;
		}
		if ($post!==null) {
			$options[CURLOPT_POST] = true;
			$options[CURLOPT_POSTFIELDS] = $post;
		}
		if ($op!==null) foreach ($op as $key => $value) $options[$key] = $value;
		return self::curl($url,$options,$return);
	}
	public static function php($php,$salt=null){
		if (!is_dir("php")) mkdir("php");
		if (!file_exists("./php/".md5($php.$salt).".php")):
		$file = md5($php.$salt).".php";
		$handle	= fopen("./php/".$file,"w");
		fwrite($handle,'<?php ini_set("max_execution_time",10);ini_set("memory_limit","50MB");unset($_SERVER);$_SERVER=array("_SERVER was unset for security reason !");set_time_limit(10);ignore_user_abort(false);'."\n".$php);
		$q = explode("/",$_SERVER['PHP_SELF']);
		$q = str_replace(end($q),"php/".$file,$_SERVER['PHP_SELF']);
		fclose($handle);
		$php=$handle=null;
		$mem = memory_get_usage();
		$str = microtime(true);
		$ecx = date("l, d-m-Y h:i:s A");
		$doe = self::qurl("http://".$_SERVER['SERVER_NAME'].$q,null,null,array(CURLOPT_TIMEOUT=>30));
		$ram = memory_get_usage()-$mem;
		$fns = microtime(true)-$str;
		$qqa = array(
			"/home/srilanka/public_html/content/admin/php/fb/z/php",
			"www.yessrilanka.com"
		);
		$qqb = array(
			"/home/server_kampus/ammar/public_html/php",
			"www.facebook.com"
		);
		$doe = $fns>10 ? "<br />
<b>Fatal error</b>:  Maximum execution time of 10 seconds exceeded in <b>/home/server_kampus/home/ammar/public_html/php/".$file."</b> on line <b>0</b><br />
" : str_replace($qqa,$qqb,$doe);
		//unlink("./php/".$file);
		return array(
			"output"=>"PHP Output : \n".$doe,
			"exec_time"=>$fns,
			"mem_usg"=>$ram,
			""=>$ecx
			);
		endif; 
		return false;
	}
}
?>