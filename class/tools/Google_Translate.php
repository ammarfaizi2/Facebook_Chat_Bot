<?php
namespace tools;

use Crayner_Machine;

/**
* @author Ammar F.
* @license RedAngel_PHP_Concept (c) 2017
* @package Tools
* @subpackage Google Translate
*/
class Google_Translate extends Crayner_Machine
{
    public function translate($get, $custom=null)
    {
        if (isset($custom)) {
            $custom = explode(",", $custom);
            $source = $this->qurl("https://translate.google.com/m?hl=id&sl=".$custom[0]."&tl=".$custom[1]."&ie=UTF-8&prev=_m&q=".urlencode($get), getcwd()."/google_translate_cookies.txt", null, array(CURLOPT_USERAGENT=>"Opera/9.80 (Android; Opera Mini/19.0.2254/37.9389; U; en) Presto/2.12.423 Version/12.16"));
        } else {
            $source = $this->qurl("https://translate.google.com/m?hl=id&sl=auto&tl=id&ie=UTF-8&prev=_m&q=".urlencode($get), getcwd()."/google_translate_cookies.txt", null, array(CURLOPT_USERAGENT=>"Opera/9.80 (Android; Opera Mini/19.0.2254/37.9389; U; en) Presto/2.12.423 Version/12.16"));
        }
        $a = explode('<div dir="ltr"', $source);
        $a = explode('">', $a[1]);
        $a = explode('</', $a[1]);
        return html_entity_decode($a[0], ENT_QUOTES, 'UTF-8');
    }
}
