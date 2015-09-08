<?php

error_reporting(E_ALL);
//error_reporting(0);

require("common.php");

include("queries.php");

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

$smarty->display('mep.tpl');
?>
