<?phpnamespace tools\Whois;class Whois{    private $domain;    private $TLDs;    private $subDomain;    private $servers;    /**     * @param string $domain full domain name (without trailing dot)     */    public function __construct($domain){        $this->domain = $domain;        // check $domain syntax and split full domain name on subdomain and TLDs        if (            preg_match('/^([\p{L}\d\-]+)\.((?:[\p{L}\-]+\.?)+)$/ui', $this->domain, $matches)            || preg_match('/^(xn\-\-[\p{L}\d\-]+)\.(xn\-\-(?:[a-z\d-]+\.?1?)+)$/ui', $this->domain, $matches)        ) {            $this->subDomain = $matches[1];            $this->TLDs = $matches[2];        } else            //throw new \InvalidArgumentException("Invalid $domain syntax");        // setup whois servers array from json file        $this->servers = json_decode(file_get_contents( __DIR__.'/whois.servers.json' ), true);    }    public function info(){        if ($this->isValid()) {            $whois_server = $this->servers[$this->TLDs][0];            // If TLDs have been found            if ($whois_server != '') {                // if whois server serve replay over HTTP protocol instead of WHOIS protocol                if (preg_match("/^https?:\/\//i", $whois_server)) {                    // curl session to get whois reposnse                    $ch = curl_init();                    $url = $whois_server . $this->subDomain . '.' . $this->TLDs;                    curl_setopt(
