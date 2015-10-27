<?php

session_start();

//error_reporting(E_ALL);
error_reporting(0);

include ("cache.php");

$path2root = "";
require($path2root . "common.php");

$smarty->assign('page','front_page');

$smarty->display('front_page.tpl');


?>
