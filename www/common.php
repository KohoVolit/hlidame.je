<?php

session_start();

include("settings.php");

//set up Smarty
require(SMARTY_PATH);
$smarty = new Smarty();
$smarty->setTemplateDir(APP_PATH . 'smarty/templates');
$smarty->setCompileDir(APP_PATH . 'smarty/templates_c');

//ACTIVITIES
$acts = [
    "CRE","MOTION","REPORT","REPORT-SHADOW","COMPARL","COMPARL-SHADOW","WDECL","QP"
];
$smarty->assign('acts',$acts);

//get language
$lang = lang();
$smarty->assign('lang',$lang);

//include texts
    //page specific
$handle = fopen('texts_' . $lang . '.csv', "r");
$texts = csv2array($handle);
$smarty->assign('t',$texts);

$smarty->assign('app_url',APP_URL);

// Connecting, selecting database

$dbconn = pg_connect($connection_string)
    or die('Could not connect: ' . pg_last_error());

// CALCULATE 1/3s
function thirds($show,$dbconn) {
    $thirds = [];
    switch ($show) {
        case 'people':  
            $aap = get('activities_all_people',$dbconn); 
            break;
        case 'parties':
            $aap = get('activities_all_parties',$dbconn);
            break;
        case 'groups':
            $aap = get('activities_all_groups',$dbconn);
            break;
        case 'countries':
            $aap = get('activities_all_countries',$dbconn);
            break;
                
    }

    #print_r($aap);die();
    $total = get('number_of_people',$dbconn);
    foreach ($aap as $ac=>$activity) {
    #    print_r($aap);die();
        $sum = 0;
        $lookfor = ['lower' => true, 'upper' => true, 'median' => true];
        $thirds[$ac] = ['lower' => 0, 'upper' => 0, 'median' => 0];
        foreach ($activity as $a) {
            if($lookfor['upper'] and ($sum > $total/3)) {
                $thirds[$ac]['upper'] = $a['ave'];
                $lookfor['upper'] = false;   
            }
            if($lookfor['lower'] and ($sum > 2*$total/3)) {
                $thirds[$ac]['lower'] = $a['ave'];
                $lookfor['lower'] = false;   
            }
            if($lookfor['median'] and ($sum > $total/2)) {
                $thirds[$ac]['median'] = $a['ave'];
                $lookfor['median'] = false;   
            }
            $sum += $a['weight'];
        }
    }
    
    return $thirds;
}



/**
* set language
*/
function lang() {
    if (isset($_GET['lang']) and (is_readable('texts_' . $lang . '.csv')))
        {
            $_SESSION["lang"] = $_GET['lang'];
            return $_GET['lang'];
        }
    else 
        {
        if (isset($_SESSION['lang']))
            return $_SESSION['lang'];
        else //default language
            return 'en';
        }
}


/**
* reads csv file into associative array
* 
*/
function csv2array($handle, $pre = "") {
    $array = $fields = [];
    if ($handle) {
        while (($row = fgetcsv($handle, 4096)) !== false) {
            if (empty($fields)) {
                $fields = $row;
                continue;
            }
            $array[$row[0]] = $row[1];
        }
        if (!feof($handle)) {
            /*echo "Error: unexpected fgets() fail\n";*/
        }
    } 
    return $array;  
}
?>
