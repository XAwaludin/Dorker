<?php

function output($str = null){
	print_r($str."\n");
}

function out($str){
	print_r($str);
}

function menu(){
	output("[1]> Keyword To URL");
	output("[2]> URL To Dork");
	output("[3]> Keyword To Domain");
}

function k2u(){
	global $app;
	$file = null;
	$pages = null;
	do{
		out(">> Keyword Location[File] : ");
		$t = trim(fgets(STDIN));
		if(!file_exists($t)) {
			$file = null;
			output("[ERROR]> File Not Found.");
		}elseif (!is_file($t)) {
			$file = null;
			output("[ERROR]> is Not File.");
		}elseif(!is_readable($t)) {
			$file = null;
			output("[ERROR]> File can't Readable.");
		}else{
			$file = file($t);
		}
	}while($file == null);

	out(">> Total Pages[Default: 10] : ");
	$pages = trim(fgets(STDIN));
	if($pages == null || !filter_var($pages, FILTER_VALIDATE_INT)){
		output("[\e[32mINFO\e[0m]> Pages Set To 10");
		$pages = 10;
	}
	foreach ($file as $key => $val) {
		$app->bing($val, $pages);
		output();
	}
}

function u2d(){
	global $app;
	$file = null;
	do{
		out(">> URL Location[File] : ");
		$t = trim(fgets(STDIN));
		if(!file_exists($t)) {
			$file = null;
			output("[ERROR]> File Not Found.");
		}elseif (!is_file($t)) {
			$file = null;
			output("[ERROR]> is Not File.");
		}elseif(!is_readable($t)) {
			$file = null;
			output("[ERROR]> File can't Readable.");
		}else{
			$file = file($t);
		}
	}while($file == null);
	$app->fetchDork($file);
}

function k2d(){
	global $app;
	$file = null;
	$pages = null;
	do{
		out(">> Keyword Location[File] : ");
		$t = trim(fgets(STDIN));
		if(!file_exists($t)) {
			$file = null;
			output("[ERROR]> File Not Found.");
		}elseif (!is_file($t)) {
			$file = null;
			output("[ERROR]> is Not File.");
		}elseif(!is_readable($t)) {
			$file = null;
			output("[ERROR]> File can't Readable.");
		}else{
			$file = file($t);
		}
	}while($file == null);

	out(">> Total Pages[Default: 10] : ");
	$pages = trim(fgets(STDIN));
	if($pages == null || !filter_var($pages, FILTER_VALIDATE_INT)){
		output("[\e[32mINFO\e[0m]> Pages Set To 10");
		$pages = 10;
	}
	foreach ($file as $key => $val) {
		$app->domain($val, $pages);
		output();
	}
}