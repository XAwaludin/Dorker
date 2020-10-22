<?php
require "parts/dorker.php";

$pan = "
________________[ Xaynet Project ]________________
________                __    ___________       
\______ \   ___________|  | __\_   _____/______ 
 |    |  \ /  _ \_  __ \  |/ / |    __)_\_  __ \
 |    `   (  <_> )  | \/    <  |        \|  | \/
/_______  /\____/|__|  |__|_ \/_______  /|__|   
        \/                  \/        \/        
________________[ Version : 1.0 ]_________________\n\n";

$app = new dorker();
print_r($pan);
menu();
$menu = 0;
do{
	out(">> Input Number Menu : ");
	$menu = trim(fgets(STDIN));
}while($menu == 0);

switch ($menu) {
	case 1:
		k2u();
		break;

	case 2:
		u2d();
		break;
	case 3:
		k2d();
		break;
	default:
		output("[\e[31mINFO\e[0m]> Menu Not Found");
		break;
}

