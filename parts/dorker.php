<?php
require "base.php";
require "function.php";

class dorker extends base{

	function bings($keyword, $page = 100){
		out("\e[32mFIND KEYWORD : \e[0m".$keyword." => ");
		$keyword = urlencode($keyword);
		$tamper = array();
		$getUrl = array();
		$st = 0;
		for($i = 0; $i < $page; $i++){
			$ab = $this->curl("https://www.bing.com/search?q=$keyword&pq=$keyword&first=$st");
			$ab = $this->fetchUrl($ab);
			$getUrl = array_merge($getUrl, $ab);
			$st+= 11;
		}

		$ca = $this->fetchDork($getUrl);
		$tamper = array_merge($tamper, $ca);
		
		return $tamper;
	}

	function bing($keyword, $pages = 10){
		$page = 0;
		out("\e[32mFIND URL FROM KEYWORD => \e[0m".$keyword);
		$keyword = urlencode($keyword);
		for($i = 1; $i < $pages; $i++){
			output("\e[31m=========================[ \e[0mPAGE : $i\e[31m ]=========================");
			$search = $this->curl("https://www.bing.com/search?q=$keyword&pq=$keyword&first=$page");
			$this->fetchUrl($search);
			$page+= 11;
		}
		output("\e[32m=========================================================");
		output("Path File\t : \e[0m".$this->dirUrl."/".$this->fname);
		output("\e[32mTotal URL\t : \e[0m".count($this->flist($this->dirUrl."/".$this->fname)));
		output("\e[32m=========================================================\e[0m");
	}

	function domain($keyword, $pages){
		$page = 0;
		out("\e[32mFIND DOMAIN FROM KEYWORD => \e[0m".$keyword);
		$keyword = urlencode($keyword);
		for($i = 1; $i < $pages; $i++){
			output("\e[31m=========================[ \e[0mPAGE : $i\e[31m ]=========================");
			$search = $this->curl("https://www.bing.com/search?q=$keyword&pq=$keyword&first=$page");
			//$search = explode("/", $search);
			$this->fetchUrl2($search);
			$page+= 11;
		}
		output("\e[32m=========================================================");
		output("Path File\t : \e[0m".$this->dirUrl."/".$this->fname);
		output("\e[32mTotal URL\t : \e[0m".count($this->flist($this->dirUrl."/".$this->fname)));
		output("\e[32m=========================================================\e[0m");

	}
}