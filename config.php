<?php


// Database details
$conf['db']['dbhost'] = 'localhost';
$conf['db']['dbname'] = '';
$conf['db']['dbuser'] = '';
$conf['db']['dbpass'] = '';

// Domain name to use for generated links
$conf['app']['url'] = "http://virya.co.uk";

// Number of characters to use when generating short URLs
$conf['app']['urichars'] = 6;

// Maximum number of retries before giving up (when generating an urlcode)
$conf['app']['retries'] = 10;

// The display name of the site
$conf['app']['name'] = "URL Brand";


// Add any strings you don't want appearing into the array (rude word protection!)
// Not yet implemented
$conf['app']['bannedstrings'] = array("it","17","i7","ck","nt","ag","4g");

$conf['app']['submitpass'] = "";





?>
