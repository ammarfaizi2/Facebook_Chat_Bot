<?php
namespace tools;

use Crayner_Machine;

/**
* @author Ammar F.
* @license RedAngel_PHP_Concept (c) 2017
* @package Tools
* @subpackage Google Translate
*/
class Translator extends Crayner_Machine
{
    public function translate($get, $custom=null)
    {
        if (isset($custom)) {
            list($sourceLang, $targetLang) = explode(",", $custom);
            $source = $this->qurl("https://translate.yandex.net/api/v1.5/tr.json/translate?key=trnsl.1.1.20170307T052825Z.ed2719eacd686d42.2d139fb5828b7f30aef44667e8042bf029f1bb9f&lang={$sourceLang}-{$targetLang}&text=".urlencode($get), null, array(CURLOPT_USERAGENT=>"Opera/9.80 (Android; Opera Mini/19.0.2254/37.9389; U; en) Presto/2.12.423 Version/12.16"));
        } else {
            $source = $this->qurl("https://translate.yandex.net/api/v1.5/tr.json/translate?key=trnsl.1.1.20170307T052825Z.ed2719eacd686d42.2d139fb5828b7f30aef44667e8042bf029f1bb9f&lang=id&text=".urlencode($get), null, array(CURLOPT_USERAGENT=>"Opera/9.80 (Android; Opera Mini/19.0.2254/37.9389; U; en) Presto/2.12.423 Version/12.16"));
        }
        return json_decode(html_entity_decode($source, ENT_QUOTES, 'UTF-8'));
    }
}
