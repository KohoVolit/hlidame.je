<?php

error_reporting(E_ALL);
//error_reporting(0);

$path2root = "../";
require($path2root . "common.php");

require("common.php");
include("queries.php");

//COUNTRIES
$all_countries_db = get('all_countries',$dbconn);
$all_countries = [];
foreach ($all_countries_db as $country) {
    $all_countries[$country['code']] = $country;
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

//CONFIGURATIONS
//get all possible
$all_configurations_db = get('all_configurations',$dbconn);
$all_configurations = [];
foreach ($all_configurations_db as $configuration) {
    $all_configurations[$configuration['configuration_code']] = $configuration;
}
$smarty->assign('all_configurations',$all_configurations);
//get selected configurations
$selected_configurations = [];
$all_cos = array_keys($all_configurations);
if (isset($_GET['co'])) {
    if (!is_array($_GET['co']))
        $_GET['co'] = [$_GET['co']];
    foreach($_GET['co'] as $co) {
        if (in_array($co,$all_cos))
            $selected_configurations[$co] = $all_configurations[$co];    
    }
}
//default: all
if (count($selected_configurations) == 0) {
    $selected_configurations = $all_configurations;
}
$smarty->assign('selected_configurations',$selected_configurations);

//DATES
if (isset($_GET['sd']) and validateDate($_GET['sd'],'Y-m-d')) {
    $start_date = $_GET['sd'];
    $smarty->assign('sd',$_GET['sd']);
} else {
    $start_date = '-infinity';
    $smarty->assign('sd','');
}
if (isset($_GET['ed']) and validateDate($_GET['ed'],'Y-m-d')) {
    $end_date = $_GET['ed'];
    $smarty->assign('ed',$_GET['ed']);
} else {
    $end_date = 'infinity';
    $smarty->assign('ed',date('Y-m-d'));
}

// FILTER
$filter = [
    '{' . implode(', ', array_keys($selected_countries)) . '}',
    '{' . implode(', ', array_keys($selected_configurations)) . '}',
    $start_date,
    $end_date
];

// CALCULATE means
$mean = get('mean',$dbconn,$filter);
$smarty->assign('mean',$mean);
$country_means = get('country_means',$dbconn,$filter);
$smarty->assign('country_means',$country_means);
//print_r($country_means);//die();

// GET data by countries
$country_data = get('country_data',$dbconn,$filter);
$smarty->assign('country_data',$country_data);
//print_r($country_data);die();
$chart_data = [];
foreach($country_data as $key=>$cd) {
    $chart_data[$key] = [];
    foreach ($cd as $item) {
        $chart_data[$key][] = (int) $item['minister_present'];
    }
}
$smarty->assign('chart_data',$chart_data);
//print_r($chart_data);die();

//GET prime minister
$prime_ministers = get('prime_ministers',$dbconn,$filter);
$smarty->assign('prime_ministers',$prime_ministers);
$chart_prime_ministers = [];
foreach ($prime_ministers as $key=>$country) {
    $chart_prime_ministers[$key] = [];
    foreach ($country as $item)
        $chart_prime_ministers[$key][] = ["position"=> $item['cum_count']/$country_means[$key]['count'], "label"=> $item['prime_minister']];
}
$smarty->assign('chart_prime_ministers',$chart_prime_ministers);
#print_r($country_means);
#print_r($chart_prime_ministers);die();

//GET years
$years = get('years',$dbconn,$filter);
$smarty->assign('years',$years);
foreach ($years as $key=>$country) {
    $chart_years[$key] = [];
    $la = [];
    $po = [];
    foreach ($country as $item) {
        $po[] = $item['cum_count']/$country_means[$key]['count'];
        $la[] = $item['year'];
    }
    $chart_years[$key] = ["positions"=> $po, "labels"=> $la];
}
$smarty->assign('chart_years',$chart_years);
#print_r($chart_years);die();

$smarty->display('council.tpl');

