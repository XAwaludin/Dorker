<?php
class base{
	public $dirDork = "results/dork";
	public $dirUrl = "results/url";
	public $fname;
	public $av;

	public function curl($url, $params = null, $header = true, $httpheaders = null, $request = 'GET'){
		//$proxy = "122.50.6.210:8081";
		//$cookies = tempnam('/tmp','cookie.txt');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request);
/*
		if($cookie == true)
		{	
			curl_setopt($ch, CURLOPT_COOKIEJAR, $cookies);
			curl_setopt($ch, CURLOPT_COOKIEFILE, $cookies);
		}
*/
		curl_setopt($ch, CURLOPT_HEADER, $header);
		@curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheaders);

		//curl_setopt($ch, CURLOPT_PROXY, $proxy);

		curl_setopt($ch, CURLOPT_USERAGENT, $this->flist("statics/header.txt")[rand(0, count($this->flist("statics/header.txt")))]);
		$response = curl_exec($ch);
		return $response;
		curl_close($ch);
	}

	public function fetchUrl($source){
		$tamper = array();
		$regxp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
		$av = preg_match_all("/$regxp/siU", $source, $ma);
		foreach($ma as $key => $res) {
			$tamper[] = $res;
      	}
		return $this->filterUrl($tamper[2]);
	}

	public function fetchUrl2($source){
		$tamper = array();
		$regxp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
		$av = preg_match_all("/$regxp/siU", $source, $ma);
		foreach($ma as $key => $res) {
			$tamper[] = $res;
      	}
		return $this->filterUrl2($tamper[2]);
	}

	public function filterUrl($source){
		$this->furl();
		$num = 1;
		foreach ($source as $key => $val) {
			if(preg_match("/http:\/\//", $val) || preg_match("/https:\/\//", $val)){
				$val = trim($val);
				if(!in_array($val, $this->flist($this->dirUrl."/".$this->fname)) && $this->blockDomain($val)){
					$this->furl($val."\n");
					output("\e[32m".$num."\e[0m|".$val);
					$num++;
				}
			}
		}
	}

	public function filterUrl2($source){
		$this->furl();
		$num = 1;
		foreach ($source as $key => $val) {
			if(preg_match("/http:\/\//", $val) || preg_match("/https:\/\//", $val)){
				$val = trim($val);
				$val = explode("/", $val);
				$val = $val[0]."//".$val[2];
				if(!in_array($val, $this->flist($this->dirUrl."/".$this->fname)) && $this->blockDomain($val)){
					$this->furl($val."\n");
					output("\e[32m".$num."\e[0m|".$val);
					$num++;
				}
			}
		}
	}

	public function blockDomain($url){
		$url = explode("/", $url);
		if(!in_array($url[2], $this->flist("statics/domain-block.txt"))){
			return true;
		}else{
			return false;
		}
	}

	public function fetchDork($source){
		$this->fdork();
		$miss = 0;
		$fillter = 0;
		$fresh = 0;

		foreach ($source as $key => $val) {
			$ra = explode("/", $val);
			$en = strpos(end($ra), "=");
			if($en !== FALSE){
				$da = substr(end($ra), 0, strpos(end($ra), "=") + 1);
				$da = trim($da);
				if(!in_array($da, $this->flist($this->dirDork."/".$this->fname))){
					$fresh++;
					$this->fdork($da."\n");
				}else{
					$fillter++;
				}
			}else{
				$miss++;
			}
		}
		output("\e[32m==================================================================");
		output("FILLTER : \e[0m".$fillter." | \e[32mMISS : \e[0m".$miss." | \e[32mFRESH : \e[0m".$fresh);
		output("PATH\t: ".$this->dirDork."/".$this->fname);
		output("\e[32m==================================================================\e[0m");
	}

	public function flist($path){
		$f = file($path, FILE_IGNORE_NEW_LINES);
		return $f;
	}

	public function fdork($data = null){
		if(!is_dir($this->dirDork)){
			mkdir($this->dirDork, 0777, true);
		}
		if($this->fname == null){
			$this->fname = date("H:i:s-d-m-Y").".txt";
		}

		$f = fopen($this->dirDork."/".$this->fname, "a");
		fwrite($f, $data);
		fclose($f);
	}

	public function furl($data = null){
		if(!is_dir($this->dirUrl)){
			mkdir($this->dirUrl, 0777, true);
		}
		if($this->fname == null){
			$this->fname = date("H:i:s-d-m-Y").".txt";
		}

		$f = fopen($this->dirUrl."/".$this->fname, "a");
		fwrite($f, $data);
		fclose($f);
	}
}