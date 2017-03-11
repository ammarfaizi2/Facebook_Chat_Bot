<?php
/**
* @author Ammar F. https://www.facebook.com/ammarfaizi2 <ammarfaizi2@gmail.com>
* @license RedAngel_PHP_Concept (c) 2017
* @package Facebook
*/
defined("cookies")||exit("Cookies not defined !");
class Facebook extends Crayner_Machine
{
    private $email;
    private $password;
    private $username;
    private $access_token;
    private $private_access_token;
    public function __construct($email, $password, $access_token, $username=null, $private_access_token=null)
    {
        $this->email = strtolower($email);
        $this->password = $password;
        $this->access_token = urlencode($access_token);
        $this->username = $username!==null ? strtolower($username) : (strpos($email, "@")!==false ? substr($email, 0, strpos($email, "@")) : $email);
        $this->cookies = getcwd()."/".cookies.DIRECTORY_SEPARATOR.$this->username.".txt";
        $this->private_access_token = $private_access_token!==null ? urlencode($private_access_token) : null;
    }
    public function login()
    {
        $_ps = array("email"=>$this->email,"pass"=>$this->password,"login"=>true);
        $a=$this->qurl("https://m.facebook.com", $this->cookies, null, array(52=>true,19913=>true,13=>4));
        $a=explode('<form', $a);
        $a=explode('</form>', $a[1]);
        $a=explode('type="hidden"', $a[0]);
        for ($i=1;$i<count($a);$i++) {
            $b=explode('name="', $a[$i]);
            $b=explode('"', $b[1]);
            $c=explode('value="', $a[$i]);
            $c=explode('"', $c[1]);
            $_ps[$b[0]] = $c[0];
        }
        return $this->qurl("https://m.facebook.com/login.php", $this->cookies, $_ps, array(52=>true));
    }
    public function go_to($url, $post=null)
    {
        return $this->qurl($url, $this->cookies, $post);
    }
    public function send_message($messages, $to, $stpr=null, $source=null)
    {
        $source = $source!==null ? $source : $this->qurl("https://m.facebook.com/".$to, $this->cookies, null, array(52=>true));
        $q = explode('action="/messages/send/', $source);
        $q = explode('</form>', $q[1]);
        $a = explode('<input type="hidden"', $q[0]);
        $postfields = array();
        for ($i=1;$i<count($a);$i++) {
            $b = explode(">", $a[$i]);
            $c = explode('name="', $b[0]);
            $d = explode('"', $c[1]);
            $e = explode('value="', $a[$i]);
            $f = isset($e[1]) ? explode('"', $e[1]) : array("","");
            $postfields[$d[0]] = $f[0];
        }
        $action = explode('"', $q[0]);
        $action = $action[0];
        $source=$q=$a=$b=$c=$d=$e=$f=null;
        if ($stpr===null) {
            $postfields['body'] = empty($messages)?"~":$messages;
            $postfields['Send'] = 'Kirim';
            $rt = null;
        } else {
            $postfields['send_photo'] = true;
            $rt = "curl_getinfo";
        }
        return $this->qurl("https://m.facebook.com/messages/send/?".$action, $this->cookies, $postfields, array(52=>false), $rt);
    }
    public function set_msg_post($post)
    {
        $this->msg_post = $post;
    }
    public function change_color($color, $gcid)
    {
        if (!isset($this->msg_post)||$color===false) {
            return $this->send_message("\$this->msg_post['change_color'] not defined !", $gcid);
        }
        return $this->go_to("https://www.facebook.com/messaging/save_thread_color/?source=thread_settings&dpr=1", $this->msg_post."&color_choice=".urlencode($color)."&thread_or_other_fbid=".urlencode($gcid));
    }
    public function upload_photo($photo, $caption, $to)
    {
        $get_form = $this->send_message(null, $to, true);
        $a = $this->qurl($get_form['redirect_url'], $this->cookies, null, array(52=>false));
        $a = explode('enctype="multipart/form-data">', $a);
        $a = explode('<input type="', $a[1]);
        for ($i=1;$i<count($a);$i++) {
            if (substr($a[$i], 0, 4)!="file") {
                $b = explode('name="', $a[$i]);
                $b = explode('"', $b[1]);
                $c = explode('value="', $a[$i]);
                $c = explode('"', $c[1]);
                $postfields[$b[0]] = $c[0];
            }
        }
        if (function_exists('curl_file_create')) {
            $cFile = curl_file_create($photo);
        } else {
            $cFile = '@'.realpath($photo);
        }
        $postfields['body'] = $caption;
        $postfields['file1'] = $cFile;
        return $this->qurl("https://upload.facebook.com/_mupload_/mbasic/messages/attachment/photo/", $this->cookies, $postfields, array(52=>false));
    }
    public function get_photo($username, $saveto="./photos")
    {
        if (strpos($username, "http")!==false and strpos($username, '://')!==false) {
            $username = str_replace("www.", "m.", $username);
            $source = $this->go_to($username);
            $username = explode("facebook.com/", $username);
            $username = preg_replace("/[^a-zA-Z0-9]/", "~~", $username[1]);
            $username = explode("~~", $username);
            $username = $username[0];
        } else {
            $source = $this->go_to("https://m.facebook.com/".urlencode($username));
        }
        $a = explode('photo.php?fbid=', $source);
        if (count($a)<2) {
            return false;
        }
        $a = explode('"', $a[1]);
        $a = $this->go_to("https://m.facebook.com/photo.php?fbid=".html_entity_decode($a[0], ENT_QUOTES, 'UTF-8'));
        $a = explode('<div style="text-align:center;"><img src="', $a);
        $a = explode('"', $a[1]);
        $a = $this->go_to(html_entity_decode($a[0], ENT_QUOTES, 'UTF-8'));
        $handle = fopen($saveto.DIRECTORY_SEPARATOR.$username.".jpg", "w");
        fwrite($handle, $a);
        fclose($handle);
        $a=$handle=null;
        return file_exists($saveto.DIRECTORY_SEPARATOR.$username.".jpg")&&strlen(file_get_contents($saveto.DIRECTORY_SEPARATOR.$username.".jpg"))>10 ? realpath($saveto.DIRECTORY_SEPARATOR.$username.".jpg") : false;
    }
}
