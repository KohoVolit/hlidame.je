<?php

//error_reporting(E_ALL);
error_reporting(0);

include ("cache.php");

$path2root = "../";
require($path2root . "common.php");

require("common.php");
include("queries.php");

$smarty->assign('page','ep');

//COUNTRIES
//get all possible
$all_countries_db = get('all_countries',$dbconn);
$all_countries = [];
foreach ($all_countries_db as $country) {
    $all_countries[$country['code']] = $country;
    $all_countries[$country['code']]['internal_link'] = create_link('cc',$country['code'],'people');
}
$smarty->assign('all_countries',$all_countries);
//get selected countries
$selected_countries = [];
$all_ccs = array_keys($all_countries);
if (isset($_GET['cc'])) {
    if (!is_array($_GET['cc']))
        $_GET['cc'] = [$_GET['cc']];
    foreach($_GET['cc'] as $cc) {
        if (in_array($cc,$all_ccs))
            $selected_countries[$cc] = $all_countries[$cc];
    }
}
//default: all
if (count($selected_countries) == 0) {
    $selected_countries = $all_countries;
}
$smarty->assign('selected_countries',$selected_countries);

//GROUPS
//get all possible
$all_groups_db = get('all_groups',$dbconn);
$all_groups = [];
foreach ($all_groups_db as $group) {
    $all_groups[$group['code']] = $group;
    $all_groups[$group['code']]['internal_link'] = create_link('g',$group['code'],'people');
}
$smarty->assign('all_groups',$all_groups);
//get selected groups
$selected_groups = [];
$all_gs = array_keys($all_groups);
if (isset($_GET['g'])) {
    if (!is_array($_GET['g']))
        $_GET['g'] = [$_GET['g']];
    foreach($_GET['g'] as $g) {
        if (in_array($g,$all_gs))
            $selected_groups[$g] = $all_groups[$g];    
    }
}
//default: all
if (count($selected_groups) == 0) {
    $selected_groups = $all_groups;
}
$smarty->assign('selected_groups',$selected_groups);

// FILTER
$filter = [
    '{' . implode(', ', array_keys($selected_countries)) . '}',
    '{' . implode(', ', array_keys($selected_groups)) . '}'
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

$smarty->assign('last_updated',last_updated("activities.json"));

$smarty->display('table.tpl');


?>
