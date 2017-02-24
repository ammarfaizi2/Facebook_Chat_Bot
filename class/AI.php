<?php
date_default_timezone_set("Asia/Jakarta");
/**
* @author Ammar F. https://www.facebook.com/ammarfaizi2 <ammarfaizi2@gmail.com>
* @license RedAngel_PHP_Concept (c) 2017
* @package Artificial Intelegence
*/
include_once('tools/Whois/Whois.php');
include_once('tools/SaferScript.php');
include_once('tools/Google_Translate.php');
include_once('tools/Brainly.php');
class AI{
	private $jam;
	private $sapa;
	private $jadwal;
	private $hari;
public function __construct(){
$this->jam = array('#01','#02','#03','#04','#05','#06','#07','#08','#09','#10','#11','#12','#13','#14','#15','#16','#17','#18','#19','#20','#21','#22','#23','#24','#00',);
$this->sapa = array('dini hari','dini hari','dini hari','dini hari','pagi','pagi','pagi','pagi','pagi','menjelang siang','siang','siang','siang','siang','sore','sore','sore','sore','malam','malam','malam','malam','malam','malam','malam');
$this->jadwal 	= array(
"Senin"		=>"Senin\n\nBiologi\nKewirausahaan\nMatematika\nMatematika\nKimia\nKimia\nFisika\n\nPulang jam 16.00",
"Selasa"	=>"Selasa\n\nGeografi\nGeografi\nEkonomi\nEkonomi\nMatematika\nSeni Budaya\nAgama\nKeiran (Japan)\n\nPulang jam 16.30",
"Rabu"		=>"Rabu\n\nB.Indonesia\nB.Indonesia\nB.Inggris\nB.Inggris\nBiologi\nBiologi\nAgama\nMatematika\nMatematika\n\nPulang jam 15.30",
"Kamis"		=>"Kamis\n\nOlahraga\nOlahraga\nOlahraga\nGeografi\nB.Indonesia\nPKN\nFisika\nFisika\n\nPulang jam 15.30",
"Jum'at"	=>"Jum'at\n\nSenam\nMatematika\nMatematika\nKimia\nSejarah\nSejarah\n\nPulang jam 11.00",
"Sabtu"		=>"Sabtu\n\nPKN\nEkonomi\nB.Jawa\nPramuka(jarang)\nPramuka(jarang)\n\nPulang jam 11.00",
"Minggu"	=>"Minggu\n\nNgisi kuliah kalsel\nNgisi kuliah Surabaya\nNgisi kuliah umum\nBebas"
			);
$this->superuser = array("Ammar Faizi");
$this->hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu");
$this->special_word = array(
	"whois"=>1,
	"photo"=>1,
	"list_photo"=>0,
	"jadwal"=>3,
	"bot_menu"=>1,
	"hitung"=>1,
	"translate"=>1,
	"ask"=>1,
	"change_color"=>1,
	"ctranslate"=>3,
	"eval"=>1,
	"shell_exec"=>1,
	"shexec"=>1,
	"add"=>3
);
$this->word_list=array(
//sapaan
"menu,bot_menu,help"=>array(array(
'ask [string]
change_color [void||color_hex]
ctranslate [from] [to] [string]
eval [string]
hitung [math_operation]
jadwal [day]
list_photo [void]
photo [username]
translate [string]
whois [domain]
shell_exec [sting]
shexec [string]

Untuk sementara beberapa fitur belum berfungsi dengan baik',
	),true,false,35,2,null,null),
"hai,hay,hi,hy"=>array(array(
			"hai juga ^@",
			"hai ^@, ada yang bisa saya bantu?"
	),true,false,15,3,null,null),
"halo,hallo,allo,hello,helo"=>array(array(
			"halo juga ^@",
			"halo ^@"
	),true,false,15,3,null,null),
"sholat,solat"=>array(array(
			"mari sholat subuh dulu"=>range(4,5),
			"mari sholat duhur dulu"=>range(11,13),
			"mari sholat ashar dulu"=>range(15,16),
			"mari sholat magrib dulu"=>array(18),
			"mari sholat isya dulu"=>range(19,20),
			"belum waktunya sholat ^@, sekarang masih jam ".date("h:i:s A").""=>array_merge(range(6,10),array(14,17)),
			"belum waktunya sholat, mari kita tunggu waktu subuh ^@, sekarang masih jam ".date("h:i:s A").""=>array_merge(range(21,24),range(0,3)),
	),true,true,20,4,null,null),
"jones,j*nes,jon*s,j*n*s"=>array(array(
			"ciee ^@ jones :v",
			"ciahh ^@ jones... :v",
			"ngenes amat sih ^@, kok dirimu jones :v",
			"ih ^@ jones yaa :v"
	),true,false,25,5,null,null),
"laper,lapar"=>array(array(
			"mari sarapan dulu, mumpung masih pagi"=>range(4,8),
			"ayo buruan sarapan dulu ^@, ini sudah menjelang siang..."=>range(9,10),
			"makan siang dulu"=>range(11,14),
			"lho, belum makan siang kah, segera makan ya"=>range(15,17),
			"ayo makan dulu, biar kenyang"=>array_merge(array(23,24,18),range(0,3)),
			"saatnya makan malam..."=>range(19,22),
	),true,true,20,5,null,null),
":v,v:"=>array(array(
			"lu laper sampe mangap mangap gitu?",
			"kenapa ^@, kok mangap mangap laper ya? :v",
			"^@ dilarang mangap :v",
			"*halah ^@ mangap -_-"
	),true,false,2,1,null,null),
"pagi,pagie"=>array(array(
			"selamat pagi ^@, selamat beraktifitas"=>range(0,12),
			"ini udah siang yak :v"=>range(13,14),
			"ini udah sore kang :v"=>range(15,18),
			"ini udah malem kang :v"=>range(19,24),
	),true,true,15,3,null,null),
"lewat,levvat,lewaat"=>array(array(
			"dilarang lewat !",
			"mampir sekalian, ga usah lewat"
	),false,false,15,3,null,null),
"siang,siangh"=>array(array(
			"selamat siang ^@"=>range(10,15),
			"ini udah sore yak :v"=>range(16,18),
			"ini udah malem kang :v"=>range(19,24),
			"ini masih pagi kang :v"=>range(0,9),
	),true,true,15,3,null,null),
"sore,soree,soreh"=>array(array(
			"selamat sore ^@, selamat beristirahat"=>range(15,18),
			"ini masih pagi kang ^@ :v"=>range(0,10),
			"ini masih siang kang :v"=>range(11,14),
			"ini udah malem kang :v"=>range(19,24),
	),true,true,15,3,null,null),
"malem,malam"=>array(array(
			"selamat malam ^@, selamat beristirahat"=>range(19,24),
			"ini masih sore kang :v"=>range(15,18),
			"ini masih pagi kang ^@ :v"=>range(0,10),
			"ini masih siang kang :v"=>range(11,14),
	),true,true,40,5,null,null),
"oke,okey,ok"=>array(array(
			"oke sip (y)",
			"oke joss (y)",
			"oke (y)",
			"oke",
	),true,false,10,3,null,null),
"sip,sipp,sippp"=>array(array(
			"sip",
			"sipp joss (y)",
			"sipp kang (y)",
			"sipp mantep (y)",
	),true,false,10,3,null,null),
"pa kabar,pa kbr,p kabar,p kbr"=>array(array(
			"kabar baik disini"
	),false,false,30,5,null,null),
"how are you,hw r u,how are u,how r you,how re you"=>array(array(
			"i'm fine",
			"i'm fine great,",
	),false,false,25,4,null,null),
"ohayou,ohayo"=>array(array(
			"ohayou ^@, selamat beraktifitas"=>range(0,12),
			"ini udah siang yak :v"=>range(13,14),
			"ini udah sore kang :v"=>range(15,18),
			"ini udah malem kang :v"=>range(19,24),
	),false,true,15,3,null,null),
"koniciwa,konnichiwa,konichiwa,konniciwa"=>array(array(
			"konniciwa ^@"=>range(10,18),
			"ini udah malem kang :v"=>range(19,24),
			"ini masih pagi kang :v"=>range(0,9),
	),false,true,15,3,null,null),
"konbawa,konbanwa"=>array(array(
			"konbanwa ^@"=>range(10,24),
			"ini masih pagi kang ^@ :v"=>range(0,10),
	),false,true,15,3,null,null),
"oyasumi,oyasumeeh"=>array(array(
			"oyasumi ^@",
			"oyasuminasai"
	),false,false,15,5,null,null),
"besok hari apa,hari apa besok,hari besok"=>array(array(
			(string)$this->hari[date("w",strtotime(date("Y-m-d")."+1day"))],
	),false,false,35,5,null,null),
"kemarin hari apa,hari apa kemarin,hari kemarin"=>array(array(
			(string)$this->hari[date("w",strtotime(date("Y-m-d")."-1day"))],
	),false,false,35,5,null,null),
"besok tanggal,tanggal besok,tanggal berapa besok,besok tanggal berapa,besok tgl brp,bsk tgl brp"=>array(array(
			(string)"besok : ".$this->hari[date("w",strtotime(date("Y-m-d")."+1day"))]." ".date("d-F-Y"),
	),false,false,35,5,null,null),
"jam berapa,jam brp,jm br"=>array(array(
			"sekarang jam ".date("h:i:s")." #".date("H")." ^@"
	),false,false,30,5,null,null),
"tanggal berapa,tanggal brp,tgl berapa,tgl brp"=>array(array(
			$this->hari[date("w")]." ".date("d-F-Y"),
	),false,false,40,8,null,null),
"waktu sekarang"=>array(array(
			"Sekarang : ".$this->hari[date("w")]." ".date("d-F-Y")." ".date("h:i:s A")
	),false,false,25,3,null,null),
"jam berapa,jam brp,jm br"=>array(array(
			"sekarang jam ".date("h:i:s")." #".date("H")." ^@"
	),false,false,20,5,null,null),
"pukul brp,pukul berapa,pkl brp,pkl berapa"=>array(array(
			"sekarang pukul ".date("h:i:s")." #".date("H")." ^@"
	),false,false,20,5,null,null),
"what time"=>array(array(
			"Time ".date("h:i:s A"),
	),false,false,20,5,null,null),
"mksih,makasih,trm kasih,trm ksh,terima kasih,trims,maakasih,makaasih^^,makasih^"=>array(array(
			"sama sama"
	),false,false,20,5,null,null),
"njir,njiir,njiiir,njer,njeer,njeeer"=>array(array(
			"rumahmu kebanjiran ya ^@?",
			"njooorr :v",
			"^@ kebanjiran toh? :v"
	),false,false,25,5,null,null),
"njay"=>array(array(
			"njiy njay :v",
			"njay njoy :v"
	),false,false,25,5,null,null),
"xixi,wkwk,haha,wkeke,wkokok,hhhh,wkaka,wkokok"=>array(array(
			"dilarang ketawa !"
	),false,false,50,10,null,null),
"nyimak,minyak,nyimeng"=>array(array(
			"dilarang nyimak !"
	),false,false,15,3,null,null),
"kleng"=>array(array(
			"sokleng baso tengkleng"
	),false,false,10,4,null,null),
"bot itu siapa"=>array(array(
			"siapa ya?",
	),false,false,17,4,null,null),
"mampos,mampus,mpos,mpus"=>array(array(
			"mampus lu ^@ :p",
			"mampus aja lu @ :p",
	),false,false,20,3,null,null),
"baguslah,syukurlah"=>array(array(
			"(y)",
	),false,false,20,5,null,null),
"ngantuk,ngatuk"=>array(array(
			"^@ kalau ngantuk tidur dong",
			"kalau ngantuk ya tidur :p",
			"segera tidur :v",
			"segera tidur",
	),false,false,20,5,null,null),
"buat makan,buatkan aku makanan,buatkan makan,buatin makan,bikinin makan,bikinkan makan"=>array(array(
			"lain kali aja ya, saya lagi sibuk :v"
	),false,false,35,4,null,null),
"minum"=>array(array(
			"minum sana biar seger :v",
			"nggk ada minuman disini"
	),false,false,35,4,null,null),
"genit"=>array(array(
			"genit itu apaan?",
			"gagaga"
	),false,false,20,4,null,null),
"makan"=>array(array(
			"makan apa?",
			"nggk ada makanan disini"
	),false,false,35,4,null,null),
"bot"=>array(array(
			"ada apa ^@?",
	),false,false,10,3,null,null),
);
}
	private function special_time($needle){
		if (isset($this->word_list[$needle])) {
			foreach ($this->word_list[$needle][0] as $key => $value) {
				if (in_array((int)date("H"),$value)) {
					return $key;
					break;
				}
			}
		}
		return false;
	}
	public function messages_check($haystack,$needle,$word_identical=false,$special_time=false,$max_length=null,$max_word=null,$time_exec=null,$word_expection=null){
		if ($time_exec!==null) {
			if (!is_array($time_exec)) {
				throw new TimeException("Time execution range must be array !",70);
			} else
			if (!in_array((int)date("H"),$time_exec)) {
				return false;
			}
		}
		if ($word_expection!==null) {
			$word_expection = explode(",",$word_expection);
			foreach ($word_expection as $val) {
				if (strpos($haystack,$val)!==false) {
					return false;
					break;
				}
			}
		}
		if ($max_length!==null&&strlen($haystack)>(int)$max_length) {
			return false;
		}
		$haystack = explode(" ",$haystack);
		if ($max_word!==null&&count($haystack)>(int)$max_word) {
			return false;
		}
		$needle = explode(",",$needle);
		if ($word_identical===true) {
			foreach ($haystack as $val) {
				foreach ($needle as $val2) {
					if ($val==$val2) {
						$needle = implode(",",$needle);
						if ($special_time===true) {
							return $this->special_time($needle);
						} else {
							return $this->word_list[$needle][0][array_rand($this->word_list[$needle][0])];
						}	
					}
				}
			}
		} else {
			$haystack = implode(" ",$haystack);
			foreach ($needle as $val) {
				if (strpos($haystack,$val)!==false) {
					$needle = implode(",",$needle);
					if ($special_time===true) {
						return $this->special_time($needle);
					} else {
						return $this->word_list[$needle][0][array_rand($this->word_list[$needle][0])];
					}	
				}
			}
		}
		return false;
	}
	private function ask($query){
		$a = new Brainly();
		$b = $a->execute($query,100);
		$a = null;
		$query = explode(" ",$query);
		$ctn = 0;
		foreach ($b['result'] as $val) {
			$bb[$ctn] = 0;
			foreach ($query as $val2) {
				if (strpos($val[0],$val2)!==false) {
					++$bb[$ctn];
				}
			}
			++$ctn;
		}
		return(($b['result'][array_search(max($bb),$bb)]));
	}
	private function action($key,$action="",$actor=null){
		if ($key=="ask") {
			$actor = explode(" ",$actor);
			$a = $this->ask($action);
			if (empty($a[0])||empty($a[1])) {
				$a = "Mohon maaf, saya tidak bisa menjawab pertanyaan \"".$action."\"";
			} else {
				$a = "Hasil pencarian dari pertanyaan ^@\n\nPertanyaan yang mirip :\n".$a[0]."\n\nJawaban :\n".$a[1]."\n\n\n";
			}
			$a = str_replace("^@",$actor[0],$a);
			$a = str_replace("@",implode(" ",$actor),$a);
			$a = str_replace($this->jam,$this->sapa,$a);
			$a = str_replace("<br />",PHP_EOL,$a);
			$a = array(html_entity_decode(strip_tags($a),ENT_QUOTES,'UTF-8'));
			return array('text',$a,null);
		} else
		if ($key=="whois") {
			$sld = trim($action," ");
			$domain = new tools\Whois\Whois($sld);
			if ($domain->isAvailable()) {
				$sd = "Domain is available".PHP_EOL;
			} else {
				$sd = "Domain is registered".PHP_EOL;
			}
			$c = "";
			$get = array("Domain Name:","Registrar URL:","Updated Date:","Creation Date:","Registrar Registration Expiration Date:","Registrar:","Registrant Name:","Registrant Organization:","Registrant Street:","Registrant State/Province:","Registrant Phone:","Name Server:");
			foreach (explode("\n",str_replace("."," . ",$domain->info())) as $val) {
				foreach ($get as $val2) {
					if (strpos($val,$val2)!==false) {
						$c .= $val.PHP_EOL;
						break;
					}
				}
			}
			return array('text',(empty($c)?$action." not found in database !":$c.PHP_EOL.PHP_EOL.$sd),null);
		} else
		if ($key=="photo") {
			if (strpos($action,"facebook.com/")!==false) {
				$action = explode("facebook.com/",$action);
				$action = preg_replace("/[^a-zA-Z0-9\.]/","~~",$action[1]);
				$action = explode("~~",$action);
				$action = $action[0];
			}
			if (!file_exists("./photos/".$action.".jpg")) {
				global $fb;
				$fb->get_photo($action);
			}
			$q = file_exists("./photos/".$action.".jpg");
			$photo = $q===true ? "./photos/".$action.".jpg" : "./photos/not_found.png";
			$caption = $q===true ? $action." (y)" : "Mohon maaf kang, photo $action tidak ditemukan";
			return array('photo',$photo,$caption);
		} else
		if ($key=='list_photo') {
			$a = scandir("./photos");
			unset($a[0],$a[1]);
			$text = "";
			$jum = count($a);
			$ctn = 1;
			foreach ($a as $val) {
				$text .= ($ctn++).". ".$val.PHP_EOL;
			}
			$text .= PHP_EOL."Total ".$jum;
			return array('text',$text,null);
		} else
		if ($key=='hitung') {
  			$ls = new SaferScript('$q = '.$action.';');
  			$ls->allowHarmlessCalls('hitung');
  			$error = $ls->parse();
  			$return = $ls->execute();
  			$ls = null;
			return array('text',(isset($error[0])?$error[0]:(empty($return)?"Perhitungan tidak ditemukan !":$return)),null);
		} else
		if ($key=='jadwal'||$key=='jadwalku') {
			$a = explode(" ",str_replace("jumat","jum'at",$action));
			$daylist = array('senin','selasa','rabu','kamis','jum\'at','sabtu');
			if (strpos($action,'besok')!==false) {
				$text = $this->jadwal[$this->hari[date('w',strtotime(date('Y-m-d')."+1day"))]];
			} else
			if (strpos($action,'kemarin')!==false) {
				$text = $this->jadwal[$this->hari[date('w',strtotime(date('Y-m-d')."-1day"))]];
			} else
			if (strpos($action,'2 hari+')!==false||strpos($action,'2 hari kedepan')!==false) {
				$text = $this->jadwal[$this->hari[date('w',strtotime(date('Y-m-d')."+2day"))]];
			} else
			if (strpos($action,'3 hari+')!==false||strpos($action,'3 hari kedepan')!==false) {
				$text = $this->jadwal[$this->hari[date('w',strtotime(date('Y-m-d')."+3day"))]];
			} else
			if (strpos($action,'4 hari+')!==false||strpos($action,'4 hari kedepan')!==false) {
				$text = $this->jadwal[$this->hari[date('w',strtotime(date('Y-m-d')."+4day"))]];
			} else
			if (strpos($action,'5 hari+')!==false||strpos($action,'5 hari kedepan')!==false) {
				$text = $this->jadwal[$this->hari[date('w',strtotime(date('Y-m-d')."+5day"))]];
			} else
			if (strpos($action,'6 hari+')!==false||strpos($action,'6 hari kedepan')!==false) {
				$text = $this->jadwal[$this->hari[date('w',strtotime(date('Y-m-d')."+6day"))]];
			} else 
			if (in_array($action,$daylist)) {
				$text = $this->jadwal[ucwords($action)];
			} else {
				$text = $this->jadwal[$this->hari[date('w',strtotime(date('Y-m-d')))]];
			}
			return array('text',$text,null);
		} else
		if ($key=='translate') {
			$a = new Google_Translate();
			return array('text',$a->translate($action),null);
		} else
		if ($key=='ctranslate') {
			$param = explode(" ",$action);
			if (strlen($param[0])==2 || strlen($param[1])==2) {
				$par = $param[0].",".$param[1];
				unset($param[0],$param[1]);
				$a = new Google_Translate();
				$a = $a->translate(implode(" ",$param),$par);	
			} else {
				$a = "Mohon maaf, penulisan parameter custom translate salah.\n\nPenulisan yang benar :\nctranslate [from] [to] [string]\n\nContoh:\nctranslate en id 'how are you?'";
			}
			return array('text',$a,null);
		} else
		if ($key=='change_color') {
			return array('change_color',$action,null);
		} else
		if ($key=='eval') {
			if (in_array($actor,$this->superuser)) {
				$action = explode(" ",$this->msg_abs);
				unset($action[0]);
				$ls = new SaferScript(implode(" ",$action));
				$ls->allowHarmlessCalls();
				$error = $ls->parse(true);
	  			$return = $ls->execute();
	  			$ls = null;
				return array('text',(isset($error[0])?$error[0]:(empty($return)?"success !":$return)),null);
			} else {
				$actor = explode(" ",$actor);
				return array('text',"Mohon maaf ".$actor[0].", anda tidak memiliki izin untuk melakukan eval");
			}
		} else
		if ($key=="shexec"||$key=="shell_exec") {
			if (in_array($actor,$this->superuser)) {
				$action = explode(" ",$this->msg_abs);
				unset($action[0]);
				return array('text',shell_exec(implode(" ",$action)),null);
			} else {
				$actor = explode(" ",$actor);
				return array('text',"Mohon maaf ".$actor[0].", anda tidak memiliki izin untuk melakukan shell_exec");
			}
		}
	}
	public function get($str){
		$this->messages = trim(strtolower($str));
		$this->msg_abs = $str;
	}
	public function execute($actor=null){
		if (!isset($this->messages)||empty($this->messages)) return false;
		$messages = explode(" ",$this->messages);
		if ($messages[0]=="@bot") {
			$tobot = true;
			unset($messages[0]);
			$this->messages = implode(" ",$messages);
			$messages = explode(" ",implode(" ",$messages));
		}
		foreach ($this->special_word as $key => $val) {
			if ($messages[0]==$key) {
				unset($messages[0]);
				return $this->action($key,implode(" ",$messages),$actor);
			}	
		}
		foreach ($this->word_list as $key => $val) {
			if ($a=$this->messages_check($this->messages,$key,(isset($val[1])?$val[1]:false),(isset($val[2])?$val[2]:false),(isset($val[3])?$val[3]:null),(isset($val[4])?$val[4]:null),(isset($val[5])?$val[5]:null),(isset($val[6])?$val[6]:null))) {
				$actor = explode(" ",$actor);
				$a = str_replace("^@",$actor[0],$a);
				$a = str_replace("@",implode(" ",$actor),$a);
				$a = str_replace($this->jam,$this->sapa,$a);
				return array('text',$a.PHP_EOL,null);
				break;
			}
		}
		if (isset($tobot)) {
			$error_msg = array(
					"Mohon maaf ^@, saat ini saya belum mengerti ' #msg ', terima kasih sudah mengirim pesan, saya akan mempelajari pesan pesan anda untuk dijawab lain waktu :)",
				);
			$a = $error_msg[array_rand($error_msg)];
			$actor = explode(" ",$actor);
			$a = str_replace("^@",$actor[0],$a);
			$a = str_replace("@",implode(" ",$actor),$a);
			$a = str_replace("#msg",$this->messages,$a);
			return array('text',$a,null);
		}
		return false;
	}
}
