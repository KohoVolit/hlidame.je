<?php

error_reporting(E_ALL);
//error_reporting(0);

require("common.php");

include("queries.php");


//COUNTRIES
//get all possible
$all_ccs = get('all_countries_codes',$dbconn);
$smarty->assign('all_countries',$all_ccs);
//get ccs
$ccs = [];
if (isset($_GET['cc'])) {
    if (!is_array($_GET['cc']))
        $_GET['cc'] = [$_GET['cc']];
    foreach($_GET['cc'] as $cc) {
        if (in_array($cc,$all_ccs))
            $ccs[] = $cc;    
    }
}
//default: all
if (count($ccs) == 0) {
    $ccs = $all_ccs;
}
$smarty->assign('countries',$ccs);

//GROUPS
//get all possible
$all_gs = get('all_groups_codes',$dbconn);
$smarty->assign('all_groups',$all_gs);
//get gs
$gs = [];
if (isset($_GET['g'])) {
    if (!is_array($_GET['g']))
        $_GET['g'] = [$_GET['g']];
    foreach($_GET['g'] as $g) {
        if (in_array($g,$all_gs))
            $gs[] = $g;    
    }
}
//default: all
if (count($gs) == 0) {
    $gs = $all_gs;
}
$smarty->assign('groups',$gs);

// FILTER
$filter = [
    '{' . implode(', ', $ccs) . '}',
    '{' . implode(', ', $gs) . '}'
];

// SHOW, default: countries
if (isset($_GET['show'])) {
    if (in_array($_GET['show'],['groups','countries','parties','people']))
        $show = $_GET['show'];
    else
        $show = 'countries';
} else {
    $show = 'countries';
}
$smarty->assign('show',$show);

// CALCULATE 1/3s
$thirds = thirds($show,$dbconn);
$smarty->assign('thirds',$thirds);


// DATA
switch ($show) {
    case 'people':
        $as = get('activities_people',$dbconn, $filter);
        break;
    case 'parties':
        $as = get('activities_parties',$dbconn, $filter);
        break;
    case 'groups':
        $as = get('activities_groups',$dbconn, $filter);
        break;
    case 'countries':
        $as = get('activities_countries',$dbconn, $filter);      
        
}  
#print_r($as);die();     
$smarty->assign('data',$as);

$smarty->display('table.tpl');


?>
