<?php
/**
* Common for EP
*/

//ACTIVITIES
$acts = [
    "CRE","MOTION","REPORT","REPORT-SHADOW","COMPARL","COMPARL-SHADOW","WDECL","QP"
];
$smarty->assign('acts',$acts);

// Connecting, selecting database

$dbconn = pg_connect($connection_string)
    or die('Could not connect: ' . pg_last_error());


// CREATE LINKS
function create_link($key,$value,$show) {
    $out = $_GET;
    $out[$key] = [$value];
    $out['show'] = $show;
    return http_build_query($out);
}

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
?>
