<?php

include("../" . $path2root . "settings.php");

//set up Smarty
require(SMARTY_PATH);
$smarty = new Smarty();
$smarty->setTemplateDir(APP_PATH . 'smarty/templates');
$smarty->setCompileDir(APP_PATH . 'smarty/templates_c');

//get language
$lang = lang($path2root);
$smarty->assign('lang',$lang);

//include texts
    //page specific
$handle = fopen($path2root . 'texts_' . $lang . '.csv', "r");
$texts = csv2array($handle);
$smarty->assign('t',$texts);

$smarty->assign('app_url',APP_URL);


/**
* set language
*/
function lang($path2root) {
    if (isset($_GET['lang']) and (is_readable($path2root . 'texts_' . $_GET['lang'] . '.csv')))
        {
            $_SESSION["lang"] = $_GET['lang'];
            return $_GET['lang'];
        }
    else 
        {
        if (isset($_SESSION['lang']))
            return $_SESSION['lang'];
        else //default language
            return 'cs';
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
            $array[$row[0]] = (isset($row[1]) ? $row[1] : "");
        }
        if (!feof($handle)) {
            /*echo "Error: unexpected fgets() fail\n";*/
        }
    } 
    return $array;  
}
?>
