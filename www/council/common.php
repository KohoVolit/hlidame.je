<?php

// Connecting, selecting database

$dbconn = pg_connect($connection_string)
    or die('Could not connect: ' . pg_last_error());

//http://php.net/manual/en/function.checkdate.php#113205
function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

?>
