<?php
define("dbuser", "minister");
define("dbname", "golos");
define("dbpswd", "br3x1t");
define("dbhost", "localhost");

function dbconnect() {
    // Connect to the database:
    $dbcon = new mysqli(dbhost, dbuser, dbpswd, dbname);
    if ($dbcon->connect_errno) {
	echo "Failed to connect to MySQL: " . $dbcon->connect_error;
    }
    else { 
	$dbcon->query("SET time_zone = '+0:00'");
	return $dbcon;
    }
}

function dbfetch($sql, $dbcon) {
    // Fetch a query. 
    $res = $dbcon->query($sql);
    if ($dbcon->errno) {
	echo "Database error (" . $dbcon->errno . "): " . $dbcon->error;
    } else {
	return $res;
    }
}

function computeBins($binsMin, $binsMax, $numBins)
{ // compute the bins labels.
    $precision = 2; // Number of digits after the decimal point.
    $bins = array();
    $h = ($binsMax - $binsMin)/$numBins;
    for ($i=0; $i<$numBins; $i++) {
	$bins[] = round($binsMin + $i*$h, $precision);
    }
    $bins[] = $binsMax;
    return $bins;
}

function makeSeed()
{
    list($usec, $sec) = explode(' ', microtime() );
    return (float) $sec + ((float) $usec * 100000);
}

function genClickerName($length = 6) {
    $method = 'rand';
    switch ($method) {
    	case 'rand':
	    mt_srand(makeSeed());
	    $cname = '';
	    $chars = '0123456789abcdefghijklmnopqrstuvwxyz';
	    $nchars = strlen($chars);
	    for ($i = 0; $i < $length; $i++) {
		    $cname .= $chars[mt_rand(0, $nchars-1)];
	    }
	    break;
	case 'md5':
	    $cname = substr(str_shuffle(MD5(microtime())), 0, $length); 
	    break;
    	default:
	    $cname = '';
	    break;
    }
    return $cname;

}

function pluralize($count, $text, $end=' ') {
    return ($count > 1 ? $count .' '. $text ."s". $end : ($count == 0 ? '' : $count .' '.  $text.$end));
}
?>
