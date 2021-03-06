<?php

session_start();

//error_reporting(E_ALL);
error_reporting(0);

$path2root = "../";
require($path2root . "common.php");

require("common.php");
include("queries.php");

$smarty->assign('page','mep');

// CALCULATE 1/3s
$thirds = thirds('people',$dbconn);
$smarty->assign('thirds',$thirds);

//GET DATA
if (isset($_GET['id'])) {
    if (intval($_GET['id'])) {
        $id = intval($_GET['id']);
    }
    else
        $id = 0;
        
}
$data = get('activities_person',$dbconn, $id);

$smarty->assign('data',$data);

$smarty->assign('last_updated',last_updated("activities.json"));

$smarty->display('mep.tpl');
?>
