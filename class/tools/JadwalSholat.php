<?php
namespace tools;

use Crayner_Machine;

/**
* @author Ammar F. <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
* @license RedAngel PHP Concept 2017
*/
class JadwalSholat extends Crayner_Machine
{
    public function get_jadwal($query=null)
    {
        $data = array(1=>"Ambarawa",2=>"Ambon",3=>"Amlapura",4=>"Amuntai",5=>"Argamakmur",6=>"Atambua",7=>"Babo",8=>"Bagan Siapiapi",9=>"Bajawa",10=>"Balige",11=>"Balik Papan",12=>"Banda Aceh",13=>"Bandarlampung",14=>"Bandung",15=>"Bangkalan",16=>"Bangkinang",17=>"Bangko",18=>"Bangli",19=>"Banjar",20=>"Banjar Baru",21=>"Banjarmasin",22=>"Banjarnegara",23=>"Bantaeng",24=>"Banten",25=>"Bantul",26=>"Banyuwangi",27=>"Barabai",28=>"Barito",29=>"Barru",30=>"Batam",31=>"Batang",32=>"Batu",33=>"Baturaja",34=>"Batusangkar",35=>"Baubau",36=>"Bekasi",37=>"Bengkalis",38=>"Bengkulu",39=>"Benteng",40=>"Biak",41=>"Bima",42=>"Binjai",43=>"Bireuen",44=>"Bitung",45=>"Blitar",46=>"Blora",47=>"Bogor",48=>"Bojonegoro",49=>"Bondowoso",50=>"Bontang",51=>"Boyolali",52=>"Brebes",53=>"Bukit Tinggi",54=>"Bulukumba",55=>"Buntok",56=>"Cepu",57=>"Ciamis",58=>"Cianjur",59=>"Cibinong",60=>"Cilacap",61=>"Cilegon",62=>"Cimahi",63=>"Cirebon",64=>"Curup",65=>"Demak",66=>"Denpasar",67=>"Depok",68=>"Dili",69=>"Dompu",70=>"Donggala",71=>"Dumai",72=>"Ende",73=>"Enggano",74=>"Enrekang",75=>"Fakfak",76=>"Garut",77=>"Gianyar",78=>"Gombong",79=>"Gorontalo",80=>"Gresik",81=>"Gunung Sitoli",82=>"Indramayu",83=>"Jakarta",84=>"Jambi",85=>"Jayapura",86=>"Jember",87=>"Jeneponto",88=>"Jepara",89=>"Jombang",90=>"Kabanjahe",91=>"Kalabahi",92=>"Kalianda",93=>"Kandangan",309=>"Karanganyar",94=>"Karanganyar Kebumen",95=>"Karawang",96=>"Kasungan",97=>"Kayuagung",98=>"Kebumen",99=>"Kediri",100=>"Kefamenanu",101=>"Kendal",102=>"Kendari",103=>"Kertosono",104=>"Ketapang",105=>"Kisaran",106=>"Klaten",107=>"Kolaka",108=>"Kota Baru Pulau Laut",109=>"Kota Bumi",110=>"Kota Jantho",111=>"Kota Mobagu",112=>"Kuala Kapuas",113=>"Kuala Kurun",114=>"Kuala Pembuang",115=>"Kuala Tungkal",116=>"Kudus",117=>"Kuningan",118=>"Kupang",119=>"Kutacane",120=>"Kutoarjo",121=>"Labuhan",122=>"Lahat",123=>"Lamongan",124=>"Langsa",125=>"Larantuka",126=>"Lawang",127=>"Lhoseumawe",128=>"Limboto",129=>"Lubuk Basung",130=>"Lubuk Linggau",131=>"Lubuk Pakam",132=>"Lubuk Sikaping",133=>"Lumajang",134=>"Luwuk",135=>"Madiun",136=>"Magelang",137=>"Magetan",138=>"Majalengka",139=>"Majene",140=>"Makale",141=>"Makassar",142=>"Malang",143=>"Mamuju",144=>"Manna",145=>"Manokwari",146=>"Marabahan",147=>"Maros",148=>"Martapura",149=>"Masohi",150=>"Mataram",151=>"Maumere",152=>"Medan",153=>"Mempawah",154=>"Menado",155=>"Mentok",156=>"Merauke",157=>"Metro",158=>"Meulaboh",159=>"Mojokerto",160=>"Muara Bulian",161=>"Muara Bungo",162=>"Muara Enim",163=>"Muara Teweh",164=>"Muaro Sijunjung",165=>"Muntilan",166=>"Nabire",167=>"Negara",168=>"Nganjuk",169=>"Ngawi",170=>"Nunukan",171=>"Pacitan",172=>"Padang",173=>"Padang Panjang",174=>"Padang Sidempuan",175=>"Pagaralam",176=>"Painan",177=>"Palangkaraya",178=>"Palembang",179=>"Palopo",180=>"Palu",181=>"Pamekasan",182=>"Pandeglang",183=>"Pangkajene",184=>"Pangkajene Sidenreng",185=>"Pangkalanbun",186=>"Pangkalpinang",187=>"Panyabungan",188=>"Pare",189=>"Parepare",190=>"Pariaman",191=>"Pasuruan",192=>"Pati",193=>"Payakumbuh",194=>"Pekalongan",195=>"Pekan Baru",196=>"Pemalang",197=>"Pematangsiantar",198=>"Pendopo",199=>"Pinrang",200=>"Pleihari",201=>"Polewali",202=>"Pondok Gede",203=>"Ponorogo",204=>"Pontianak",205=>"Poso",206=>"Prabumulih",207=>"Praya",208=>"Probolinggo",209=>"Purbalingga",210=>"Purukcahu",211=>"Purwakarta",212=>"Purwodadigrobogan",213=>"Purwokerto",214=>"Purworejo",215=>"Putussibau",216=>"Raha",217=>"Rangkasbitung",218=>"Rantau",219=>"Rantauprapat",220=>"Rantepao",221=>"Rembang",222=>"Rengat",223=>"Ruteng",224=>"Sabang",225=>"Salatiga",226=>"Samarinda",227=>"Sampang",228=>"Sampit",229=>"Sanggau",230=>"Sawahlunto",231=>"Sekayu",232=>"Selong",233=>"Semarang",234=>"Sengkang",235=>"Serang",236=>"Serui",237=>"Sibolga",238=>"Sidikalang",239=>"Sidoarjo",240=>"Sigli",241=>"Singaparna",242=>"Singaraja",243=>"Singkawang",244=>"Sinjai",245=>"Sintang",246=>"Situbondo",247=>"Slawi",248=>"Sleman",249=>"Soasiu",250=>"Soe",251=>"Solo",252=>"Solok",253=>"Soreang",254=>"Sorong",255=>"Sragen",256=>"Stabat",257=>"Subang",258=>"Sukabumi",259=>"Sukoharjo",260=>"Sumbawa Besar",261=>"Sumedang",262=>"Sumenep",263=>"Sungai Liat",264=>"Sungai Penuh",265=>"Sungguminasa",266=>"Surabaya",267=>"Surakarta",268=>"Tabanan",269=>"Tahuna",270=>"Takalar",271=>"Takengon",272=>"Tamiang Layang",273=>"Tanah Grogot",274=>"Tangerang",275=>"Tanjung Balai",276=>"Tanjung Enim",277=>"Tanjung Pandan",278=>"Tanjung Pinang",279=>"Tanjung Redep",280=>"Tanjung Selor",281=>"Tapak Tuan",282=>"Tarakan",283=>"Tarutung",284=>"Tasikmalaya",285=>"Tebing Tinggi",286=>"Tegal",287=>"Temanggung",288=>"Tembilahan",289=>"Tenggarong",290=>"Ternate",291=>"Tolitoli",292=>"Tondano",293=>"Trenggalek",294=>"Tual",295=>"Tuban",296=>"Tulung Agung",297=>"Ujung Berung",298=>"Ungaran",299=>"Waikabubak",300=>"Waingapu",301=>"Wamena",302=>"Watampone",303=>"Watansoppeng",304=>"Wates",305=>"Wonogiri",306=>"Wonosari",307=>"Wonosobo",308=>"Yogyakarta");
        if ($query===null) {
            $a = $this->qurl("http://jadwalsholat.pkpu.or.id/");
        } else {
            $query=array_search(ucfirst(strtolower($query)), $data);
            if ($query===false) {
                return false;
            }
            $query=$data[$query];
            $a = $this->qurl("http://jadwalsholat.pkpu.or.id/monthly.php?id=".urlencode($query));
        }
        if (!empty($a)) {
            $a = explode('<tr class="table_highlight" align="center"><td><b>', $a);
            $a = explode('</tr>', $a[1], 2);
            $a = explode('<td>', str_replace("</td>", "", $a[0]));
            if (!isset($a[1], $a[2], $a[3], $a[4], $a[5], $a[6])) {
                return false;
            }
            $a = "Jadwal Sholat ".$query." dan Sekitarnya\nSubuh : ".$a[1]."\nTerbit : ".$a[2]."\nDhuhur : ".$a[3]."\nAshar : ".$a[4]."\nMagrib : ".$a[5]."\nIsya : ".$a[6];
        }
        return empty($a)?false:$a;
    }
}