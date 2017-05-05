<?php
header("Content-type:application/json");
date_default_timezone_set("Asia/Jakarta");
define("dr", __DIR__.'/.gitdw/', true);
define("zip", dr.'pclzip.lib.php');
/**
*		GitHub Master Downloader
*		@author Ammar Faizi <ammarfaizi2@gmail.com>
*		@license RedAngel PHP Concept
*/
class gitdw
{
    public function __construct($url)
    {
        $this->init();
        $this->data = json_decode(file_get_contents(dr.'data.json'), true);
        $this->master = rtrim(trim($url), '/').'/archive/master.zip';
    }
    public function run()
    {
        $a = $this->curl($this->master);
        if (is_array($a)) {
            exit($this->err("Error download repo : ".$a[0]." ".$a[1])."\n");
        }
        $hash = md5($a);
        if ($hash==$this->data['last_commit']['hash']) {
            exit($this->msg(
    "Everything up-to-date"
    )."\n");
        }
        file_put_contents(dr.'files/master_'.(++$this->data['commits']).'.zip', $a);
        require zip;
        $e = new PclZip(realpath(dr.'files/master_'.$this->data['commits'].'.zip'));
        $fq = $e->listContent();
        $fq = $fq[0]['filename'];
        $z = $e->extract(PCLZIP_OPT_PATH, realpath(dr.'..'), PCLZIP_OPT_REMOVE_PATH, $fq);
        if ($z==0) {
            exit($this->err("Error decompress file : ".$e->errorInfo(true)));
        }
        $this->data['last_commit'] = array(
'auth'=>$_COOKIE['auth'],
'date'=>(date("Y-m-d H:i:s")),
'hash'=>$hash
);
        file_put_contents(dr.'/data.json', json_encode($this->data));
        exit($this->msg($this->data));
    }
    private static function rrmdir($dir)
    {
        $files=array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file"))?self::rrmdir("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }
    private function init()
    {
        is_dir(dr) or mkdir(dr);
        is_dir(dr.'files') or mkdir(dr.'files');
        if (!file_exists(zip)) {
            $a = $this->curl("https://raw.githubusercontent.com/ammarfaizi2/RA_Tools/master/pclzip.lib.php");
            if (is_array($a)) {
                exit($this->err(
"Error download lib : ".$a[0]." ".$a[1]
                )."\n");
            }
            file_put_contents(zip, $a);
        }
        if (!isset($_COOKIE['auth'], $_COOKIE['key'])) {
            exit($this->err("Error Auth"));
        }
        if (!file_exists(dr.'data.json')) {
            file_put_contents(dr.'data.json', json_encode(array(
            'author'=>$_COOKIE['auth'],
            'date_init'=>(date("Y-m-d H:i:s")),
            'commits'=>0,
            'last_commit'=>array(
                'hash'=>null,
                'date'=>null,
                'auth'=>null
                ),
            'dir'=>(realpath(__DIR__))
            )));
        }
    }
    private function err($msg)
    {
        return json_encode(array("error_msg"=>$msg)).PHP_EOL;
    }
    private function msg($msg)
    {
        return json_encode(array("msg"=>$msg)).PHP_EOL;
    }
    private function curl($url, $opt=null)
    {
        $ch = curl_init($url);
        $op = array(
CURLOPT_RETURNTRANSFER=>true,
CURLOPT_SSL_VERIFYPEER=>false,
CURLOPT_SSL_VERIFYHOST=>false,
CURLOPT_COOKIEJAR=>dr.'/.cookies',
CURLOPT_COOKIEFILE=>dr.'/.cookies',
CURLOPT_FOLLOWLOCATION=>false,
        );
        if (is_array($opt)) {
            $op = array_merge($op, $opt);
        }
        curl_setopt_array($ch, $op);
        $out = curl_exec($ch);
        $err = curl_error($ch) and $out = array(curl_errno($ch),$err);
        $info = curl_getinfo($ch);
        if (isset($info['redirect_url']) and !empty($info['redirect_url'])) {
            $out = $this->curl($info['redirect_url']);
        }
        curl_close($ch);
        return $out;
    }
}
isset($_POST['url']) or exit(
json_encode(array("error_msg"=>"Error !"))
);
$app = new gitdw($_POST['url']);
$app->run();
