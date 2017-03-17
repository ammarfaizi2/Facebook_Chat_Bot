<?php
namespace tools;

use Crayner_Machine;

/**
* @author Ammar F. <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
*/
class WhatAnime extends Crayner_Machine
{
    public function __construct($input, $type="url")
    {
        $this->input = $type=="url"? base64_encode($this->qurl($input)) : $input;
    }
    public function fetch_info()
    {
        $get = json_decode($this->qurl("https://whatanime.ga/search", null, "data=".urlencode("data:image/jpeg;base64,".$this->input), array(CURLOPT_REFERER=>"https://whatanime.ga/")), 1);
        return $get['docs'];
    }
}
