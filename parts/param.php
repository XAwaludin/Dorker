<?php

function save($data){
	$f = fopen("parameter.txt", "a");
	fwrite($f, $data."\n");
	fclose($f);
}

function baca($file){
	return file($file, FILE_IGNORE_NEW_LINES);
}

echo ">> File : ";
$a = file(trim(fgets(STDIN)));
foreach ($a as $key => $val) {
	$val = explode(".", $val);
	$val = end($val);
	$ektensi = array("php3", "php4", "php", "cgi", "html", "aspx", "asp", "search");
	$dat = str_replace($ektensi, "", $val);
	$dat = trim($dat);
	if(!in_array($dat, baca("parameter.txt"))){
		save($dat);
		print_r($dat."\n");
	}
}