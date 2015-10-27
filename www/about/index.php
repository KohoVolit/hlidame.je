<?php

session_start();

//error_reporting(E_ALL);
error_reporting(0);

include ("cache.php");

$path2root = "../";
require($path2root . "common.php");

$smarty->assign('page','about');

$smarty->assign('about_text',file_get_contents("about.html"));
$smarty->assign('methodology_text',file_get_contents("methodology.html"));
$smarty->assign('studies_text',file_get_contents("studies.html"));

$smarty->display('about.tpl');
