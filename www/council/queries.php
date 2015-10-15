<?php


function get($name, $dbconn, $params = []) {
    switch ($name) {
        case 'all_countries': 
            $out = all_countries($dbconn);
            return $out;
        case 'all_configurations': 
            $out = all_configurations($dbconn);
            return $out;
        case 'mean': 
            $out = mean($dbconn,$params);
            return $out;
        case 'country_means': 
            $out = country_means($dbconn,$params);
            return $out;
        case 'country_data': 
            $out = country_data($dbconn,$params);
            return $out;
        case 'prime_ministers': 
            $out = prime_ministers($dbconn,$params);
            return $out;
        case 'years': 
            $out = years($dbconn,$params);
            return $out;
    }
    return [];
}

// get years for chart
function years($dbconn, $filter) {
    $q = 
#    SELECT count(*),min(year),min(country_code) as country_code, min(start_date) as start_date FROM
#    (SELECT to_char(start_date,'YYYY') as year,min(country_code) as country_code, min(start_date) as start_date
#    FROM council
#    WHERE country_code = ANY($1)
#    AND configuration_code = ANY($2)
#    AND start_date >= $3
#    AND end_date <= $4
#    GROUP BY to_char(start_date,'YYYY'), country_code) as t1
#    ORDER BY country_code,start_date
    "
    SELECT count(*),year,country_code, min(start_date) as start_date FROM
    (SELECT min(to_char(start_date,'YYYY')) as year, country_code, min(start_date) as start_date
    FROM council
    WHERE country_code = ANY($1)
    AND configuration_code = ANY($2)
    AND start_date >= $3
    AND end_date <= $4
    GROUP BY number, country_code) as t1
    GROUP BY year, country_code
    ORDER BY country_code,start_date
    ";
    $result = pg_query_params($dbconn,$q,$filter);
    $out = [];
    $is = [];
    while ($row = pg_fetch_assoc($result)) {
        if (!isset($out[$row['country_code']])) {
            $out[$row['country_code']] = [];
            $is[$row['country_code']] = 0;
        }
        $row['cum_count'] = $is[$row['country_code']];
        $is[$row['country_code']] += (int) $row['count'];
        $out[$row['country_code']][] = $row;
    }
    return $out;
}

// get prime ministers for chart
function prime_ministers($dbconn, $filter) {
    $q = "
    SELECT count(*),prime_minister,country_code, min(start_date) as start_date FROM
    (SELECT max(prime_minister) as prime_minister, country_code, min(start_date) as start_date
    FROM council
    WHERE country_code = ANY($1)
    AND configuration_code = ANY($2)
    AND start_date >= $3
    AND end_date <= $4
    GROUP BY number, country_code) as t1
    GROUP BY prime_minister, country_code
    ORDER BY country_code,start_date
    ";
    $result = pg_query_params($dbconn,$q,$filter);
    $out = [];
    $is = [];
    while ($row = pg_fetch_assoc($result)) {
        if (!isset($out[$row['country_code']])) {
            $out[$row['country_code']] = [];
            $is[$row['country_code']] = 0;
        }
        $row['cum_count'] = $is[$row['country_code']];
        $is[$row['country_code']] += (int) $row['count'];
        $out[$row['country_code']][] = $row;
    }
    return $out;
}

// get country data for filter
function country_data($dbconn,$filter) {
    $q = "
    SELECT * FROM council
    WHERE country_code = ANY($1)
    AND configuration_code = ANY($2)
    AND start_date >= $3
    AND end_date <= $4
    ORDER BY country_code,number
    ";
    $result = pg_query_params($dbconn,$q,$filter);
    $out = [];
    while ($row = pg_fetch_assoc($result)) {
        if (!isset($out[$row['country_code']]))
            $out[$row['country_code']] = [];
        if (!isset($out[$row['country_code']][$row['number']])) {
            $out[$row['country_code']][$row['number']] = 
            [
                'number' => $row['number'],
                'configuration' => $row['configuration'],
                'start_date' => $row['start_date'],
                'end_date' => $row['end_date'],
                'person'=>[],
                'ministry'=>[],
                'office'=>[],
                'party'=>[],
                'minister_present'=>0,
                'prime_minister' => $row['prime_minister'],
                'country_code' => $row['country_code'],
                'configuration_code' => $row['configuration_code']
            ];
        }
        $out[$row['country_code']][$row['number']]['person'][] = $row['person'];
        $out[$row['country_code']][$row['number']]['ministry'][] = $row['ministry'];
        $out[$row['country_code']][$row['number']]['office'][] = $row['office'];
        $out[$row['country_code']][$row['number']]['party'][] = $row['party'];
        $out[$row['country_code']][$row['number']]['minister_present'] = max($out[$row['country_code']][$row['number']]['minister_present'],$row['minister_present']); 
        
    }
    return $out;
}

// calculate mean
function mean($dbconn,$filter) {
    $q = "
    SELECT round(100.0*sum(max)/count(max)) as mean FROM
    (SELECT max(minister_present) FROM council 
    WHERE country_code = ANY($1)
    AND configuration_code = ANY($2)
    AND start_date >= $3
    AND end_date <= $4
    GROUP BY number,country_code) as t1
    ";
    $result = pg_query_params($dbconn,$q,$filter);
    $out = null;
    while ($row = pg_fetch_assoc($result)) {
        $out = $row['mean'];
    }
    return $out;
}

// calculate mean
function country_means($dbconn,$filter) {
    $q = "
    SELECT round(100.0*sum(max)/count(max)) as mean, country_code, count(max) FROM
    (SELECT max(minister_present), country_code FROM council 
    WHERE country_code = ANY($1)
    AND configuration_code = ANY($2)
    AND start_date >= $3
    AND end_date <= $4
    GROUP BY number,country_code) as t1
    GROUP BY country_code
    ORDER BY country_code
    ";
    $result = pg_query_params($dbconn,$q,$filter);
    $out = [];
    while ($row = pg_fetch_assoc($result)) {
        $out[$row['country_code']] = $row;
    }
    return $out;    
}

// get all country codes (which have data)
function all_countries($dbconn) {
    $q = "SELECT * FROM
(SELECT distinct(country_code) FROM council) as t1
LEFT JOIN countries as t2
ON t1.country_code = t2.code
ORDER BY code;";
    $result = pg_query($dbconn,$q);
    $out = [];
    while ($row = pg_fetch_assoc($result)) {
        $out[] = $row;
    }
    return $out;
}

//get all configurations
function all_configurations($dbconn) {
    $q = "SELECT distinct(configuration), max(configuration_code) as configuration_code FROM council
GROUP BY configuration,configuration_code
ORDER BY configuration;";
    $result = pg_query($dbconn,$q);
    $out = [];
    while ($row = pg_fetch_assoc($result)) {
        $out[] = $row;
    }
    return $out;
}
