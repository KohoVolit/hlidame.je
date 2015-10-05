<?php


function get($name, $dbconn, $params = []) {
    switch ($name) {
        case 'all_countries': 
            $out = all_countries($dbconn);
            return $out;
        case 'all_groups': 
            $out = all_groups($dbconn);
            return $out;
        case 'number_of_people':
            $out = number_of_people($dbconn);
            return $out;  
        case 'activities_all_people':
            $out = activities_all_people($dbconn);
            return $out;
        case 'activities_all_parties':
            $out = activities_all_parties($dbconn);
            return $out;
        case 'activities_all_groups':
            $out = activities_all_groups($dbconn);
            return $out;
        case 'activities_all_countries':
            $out = activities_all_countries($dbconn);
            return $out;
        case 'activities_people':
            $out = activities_people($dbconn,$params);
            return $out;
        case 'activities_parties':
            $out = activities_parties($dbconn,$params);
            return $out;
        case 'activities_groups':
            $out = activities_groups($dbconn,$params);
            return $out;
        case 'activities_countries':
            $out = activities_countries($dbconn,$params);
            return $out;
        case 'activities_person':
            $out = activities_person($dbconn,$params);
            return $out;
    }
    return [];
}


// get activities for single person
function activities_person($dbconn,$id) {
    $q = "
    SELECT activity_code, date, activity_title,
t2.id as person_id, t2.name as person_name,
t2.group_code as group_code, t2.party_code as party_code,
t2.country_code as country_code, t2.weight as weight,
t4.name as party_name, t5.name as group_name, t5.picture as group_picture, 
t6.name as country_name, t6.name_en as country_name_en, t6.picture as country_picture
FROM
	(SELECT * FROM activities
	WHERE person_id=$1) as t1
LEFT JOIN 
	people as t2
ON t1.person_id = t2.id
LEFT JOIN
	parties as t4
ON t2.party_code = t4.code
LEFT JOIN
	groups as t5
ON t2.group_code = t5.code
LEFT JOIN
	countries as t6
ON t2.country_code = t6.code
ORDER BY activity_code, date DESC
    ";
    $result = pg_query_params($dbconn,$q,[$id]);
    $out = ['activities'=>[],'meta'=>[]];
    while ($row = pg_fetch_assoc($result)) {
        if (!isset($out['activities'][$row['activity_code']]))
            $out['activities'][$row['activity_code']] = [];
        $out['activities'][$row['activity_code']][] = [
            'activity_code' => $row['activity_code'],
            'activity_title' => $row['activity_title'],
            'date' => $row['date']
        ];  
        $out['meta'] = $row;
    }
    return $out; 
}

// get activities for parties
function activities_parties($dbconn,$filter) {
    $q = "
SELECT t1.n/t2.sum as ave, n, t2.sum as weight, activity_code, 
    t3.code as party_code, t3.name as party_name FROM
    (SELECT count(*) as n, activity_code, person_party_code FROM activities
    WHERE person_country_code = ANY($1)
    AND person_group_code = ANY ($2)
    GROUP BY activity_code, person_party_code) as t1
RIGHT JOIN
    (SELECT sum(weight), party_code FROM people
    WHERE country_code = ANY($1)
    AND group_code = ANY ($2)
    GROUP BY party_code) as t2
ON t1.person_party_code = t2.party_code
LEFT JOIN
	(SELECT * FROM parties
	) as t3
ON t1.person_party_code = t3.code
ORDER BY activity_code, ave DESC
";

    $result = pg_query_params($dbconn,$q,$filter);
    $out = [];
    while ($row = pg_fetch_assoc($result)) {
        if (!isset($out[$row['party_code']]))
            $out[$row['party_code']] = ['activities'=>[]];
        $out[$row['party_code']]['activities'][$row['activity_code']] = [
            'ave' => $row['ave'],
            'n' => $row['n'],
            'activity_code' => $row['activity_code']
        ];
        $out[$row['party_code']]['meta'] = $row;
        
    }
    return $out;  

}

// get activities for groups
function activities_groups($dbconn,$filter) {
    $q = "
SELECT t1.n/t2.sum as ave, n, t2.sum as weight, activity_code, 
    t3.code as group_code, t3.name as group_name, t3.picture as group_picture FROM
    (SELECT count(*) as n, activity_code, person_group_code FROM activities
    WHERE person_country_code = ANY($1)
    AND person_group_code = ANY ($2)
    GROUP BY activity_code, person_group_code) as t1
RIGHT JOIN
    (SELECT sum(weight), group_code FROM people
    WHERE country_code = ANY($1)
    AND group_code = ANY ($2)
    GROUP BY group_code) as t2
ON t1.person_group_code = t2.group_code
LEFT JOIN
	(SELECT * FROM groups
	) as t3
ON t1.person_group_code = t3.code
ORDER BY activity_code, ave DESC
";

    $result = pg_query_params($dbconn,$q,$filter);
    $out = [];
    while ($row = pg_fetch_assoc($result)) {
        if (!isset($out[$row['group_code']]))
            $out[$row['group_code']] = ['activities'=>[]];
        $out[$row['group_code']]['activities'][$row['activity_code']] = [
            'ave' => $row['ave'],
            'n' => $row['n'],
            'activity_code' => $row['activity_code']
        ];
        $out[$row['group_code']]['meta'] = $row;
        
    }
    return $out;  

}

// get activities for countries
function activities_countries($dbconn,$filter) {
    $q = "
SELECT t1.n/t2.sum as ave, n, t2.sum as weight, activity_code, 
    t3.code as country_code, t3.name as country_name, t3.picture as country_picture FROM
    (SELECT count(*) as n, activity_code, person_country_code FROM activities
    WHERE person_country_code = ANY($1)
    AND person_group_code = ANY ($2)
    GROUP BY activity_code, person_country_code) as t1
RIGHT JOIN
    (SELECT sum(weight), country_code FROM people
    WHERE country_code = ANY($1)
    AND group_code = ANY ($2)
    GROUP BY country_code) as t2
ON t1.person_country_code = t2.country_code
LEFT JOIN
	(SELECT * FROM countries
	) as t3
ON t1.person_country_code = t3.code
ORDER BY country_code, activity_code, ave DESC
";

    $result = pg_query_params($dbconn,$q,$filter);
    $out = [];
    while ($row = pg_fetch_assoc($result)) {
        if (!isset($out[$row['country_code']]))
            $out[$row['country_code']] = ['activities'=>[]];
        $out[$row['country_code']]['activities'][$row['activity_code']] = [
            'ave' => $row['ave'],
            'n' => $row['n'],
            'activity_code' => $row['activity_code']
        ];
        $out[$row['country_code']]['meta'] = $row;
        
    }
    return $out;  

}

// get activities of people
function activities_people($dbconn,$filter) {
    $q = "
SELECT t1.n/t2.sum as ave, n, activity_code, 
t3.id as person_id, t3.name as person_name,
t3.group_code as group_code, t3.party_code as party_code, t3.country_code as country_code, t3.weight as weight,
t4.name as party_name, t5.name as group_name, t5.picture as group_picture, 
t6.name as country_name, t6.name_en as country_name_en, t6.picture as country_picture
FROM
    (SELECT count(*) as n, activity_code, person_id FROM activities 
    WHERE person_country_code = ANY($1)
    AND person_group_code = ANY ($2)
    GROUP BY activity_code, person_id) as t1
LEFT JOIN
    (SELECT sum(weight), id FROM people 
    WHERE country_code = ANY($1)
    AND group_code = ANY ($2)
    GROUP BY id) as t2
ON t1.person_id = t2.id
RIGHT JOIN
	(SELECT * FROM people
	WHERE country_code = ANY($1)
    AND group_code = ANY ($2)
	) as t3
ON t1.person_id = t3.id
LEFT JOIN
	parties as t4
ON t3.party_code = t4.code
LEFT JOIN
	groups as t5
ON t3.group_code = t5.code
LEFT JOIN
	countries as t6
ON t3.country_code = t6.code
ORDER BY country_code, party_code, person_name
";

    
    $result = pg_query_params($dbconn,$q,$filter);
    $out = [];
    while ($row = pg_fetch_assoc($result)) {
        if (!isset($out[$row['person_id']]))
            $out[$row['person_id']] = ['activities'=>[]];
        $out[$row['person_id']]['activities'][$row['activity_code']] = [
            'ave' => $row['ave'],
            'n' => $row['n'],
            'activity_code' => $row['activity_code']
        ];
        $out[$row['person_id']]['meta'] = $row;
        
    }
    return $out;        

}

// get activities for parties
function activities_all_parties($dbconn) {
    $q = "
SELECT t1.n/t2.sum as ave, n, t2.sum as weight, activity_code, 
    t3.code as party_code, t3.name as party_name FROM
    (SELECT count(*) as n, activity_code, person_party_code FROM activities
    GROUP BY activity_code, person_party_code) as t1
RIGHT JOIN
    (SELECT sum(weight), party_code FROM people
    GROUP BY party_code) as t2
ON t1.person_party_code = t2.party_code
LEFT JOIN
	(SELECT * FROM parties
	) as t3
ON t1.person_party_code = t3.code
ORDER BY activity_code, ave DESC
";

    $result = pg_query($dbconn,$q);
    $out = [];
    while ($row = pg_fetch_assoc($result)) {
        if (!isset($out[$row['activity_code']]))
            $out[$row['activity_code']] = [];
        $out[$row['activity_code']][] = $row;
    }
    return $out;  

}

// get activities for all groups
function activities_all_groups($dbconn) {
    $q = "
SELECT t1.n/t2.sum as ave, n, t2.sum as weight, activity_code, 
    t3.code as group_code, t3.name as group_name FROM
    (SELECT count(*) as n, activity_code, person_group_code FROM activities
    GROUP BY activity_code, person_group_code) as t1
RIGHT JOIN
    (SELECT sum(weight), group_code FROM people
    GROUP BY group_code) as t2
ON t1.person_group_code = t2.group_code
LEFT JOIN
	(SELECT * FROM groups
	) as t3
ON t1.person_group_code = t3.code
ORDER BY activity_code, ave DESC
";

    $result = pg_query($dbconn,$q);
    $out = [];
    while ($row = pg_fetch_assoc($result)) {
        if (!isset($out[$row['activity_code']]))
            $out[$row['activity_code']] = [];
        $out[$row['activity_code']][] = $row;
    }
    return $out;  

}


// get activities for all countries
function activities_all_countries($dbconn) {
    $q = "
SELECT t1.n/t2.sum as ave, n, t2.sum as weight, activity_code, 
    t3.code as country_code, t3.name as country_name FROM
    (SELECT count(*) as n, activity_code, person_country_code FROM activities
    GROUP BY activity_code, person_country_code) as t1
RIGHT JOIN
    (SELECT sum(weight), country_code FROM people
    GROUP BY country_code) as t2
ON t1.person_country_code = t2.country_code
LEFT JOIN
	(SELECT * FROM countries
	) as t3
ON t1.person_country_code = t3.code
ORDER BY activity_code, ave DESC
";

    $result = pg_query($dbconn,$q);
    $out = [];
    while ($row = pg_fetch_assoc($result)) {
        if (!isset($out[$row['activity_code']]))
            $out[$row['activity_code']] = [];
        $out[$row['activity_code']][] = $row;
    }
    return $out;  

}

// get activities of all people
function activities_all_people($dbconn) {
    $q = 'SELECT t1.n/t2.sum as ave, n, activity_code, id, person_id, sum as weight FROM
                (SELECT count(*) as n, activity_code, person_id FROM activities
                GROUP BY activity_code, person_id) as t1
            LEFT JOIN
                (SELECT sum(weight),id FROM people
                GROUP BY id) as t2
            ON t1.person_id = t2.id
            ORDER BY activity_code, ave DESC';
    $result = pg_query($dbconn,$q);
    $out = [];
    while ($row = pg_fetch_assoc($result)) {
        if (!isset($out[$row['activity_code']]))
            $out[$row['activity_code']] = [];
        $out[$row['activity_code']][] = $row;
    }
    return $out;        
}

// get weighted number of people
function number_of_people($dbconn) {
    $q = "SELECT sum(weight) as s FROM people";
    $result = pg_query($dbconn,$q);
    $out = [];
    while ($row = pg_fetch_assoc($result)) {
        $out[] = $row['s'];
    }
    return $out[0];
}

// get all country codes
function all_countries($dbconn) {
    $q = "SELECT * FROM countries ORDER BY code;";
    $result = pg_query($dbconn,$q);
    $out = [];
    while ($row = pg_fetch_assoc($result)) {
        $out[] = $row;
    }
    return $out;
}

//get all group codes
function all_groups($dbconn) {
    $q = "SELECT * FROM groups ORDER BY abbreviation;";
    $result = pg_query($dbconn,$q);
    $out = [];
    while ($row = pg_fetch_assoc($result)) {
        $out[] = $row;
    }
    return $out;
}

?>
