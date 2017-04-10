<?php
namespace tools;
use Crayner_Machine;
/**
* @author Ammar F. https://www.facebook.com/ammarfaizi2 <ammarfaizi2@gmail.com>
* @license RedAngel PHP Concept (c) 2017
* @package AI
* @subpackage Brainly
*/
class Brainly extends Crayner_Machine
{
    public function execute($query, $limit=1)
    {
is_dir(data.'/brainly/') or mkdir(data.'/brainly/');
$p=null;
$file = data."/brainly/brainly_".md5($query).".txt";
if (!file_exists($file) or strlen(file_get_contents($file))<10) {
$a = Crayner_Machine::qurl("https://brainly.co.id/api/28/api_tasks/suggester?limit=".((int)$limit<1?1:(int)$limit)."&query=".urlencode($query));
file_put_contents($file, $a);
} else {
$a = file_get_contents($file);}
$a = json_decode(file_get_contents($file), true);
$data = $a['data']['tasks']['items'];
$num_rows = count($data);
if ($num_rows<(int)$limit) {
$a = Crayner_Machine::qurl("https://brainly.co.id/api/28/api_tasks/suggester?limit=".((int)$limit<1?1:(int)$limit)."&query=".urlencode($query));
file_put_contents($file, $a);
$a = json_decode(file_get_contents($file), true);
$data = $a['data']['tasks']['items'];
$num_rows = count($data);
}
for($i=0;$i<$limit;$i++) {
$p[$i] = array($data[$i]['task']['content'],$data[$i]['responses'][0]['content']);
}
return array("num_rows"=>count($p),"result"=>$p);
  }
}