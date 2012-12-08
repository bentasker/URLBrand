<?php

class urlshort_db{


function open_db(){
global $conf;

// Open the Database connection
$this->link = mysql_connect($conf['db']['dbhost'], $conf['db']['dbuser'], $conf['db']['dbpass']);

if (!$this->link) {
    die('Could not connect: ' . mysql_error());
}
else
{

// Connect to a specific database if one is named
if (!empty($conf['db']['dbname'])){
$db_selected = mysql_select_db($conf['db']['dbname'], $this->link);
if (!$db_selected) {
    die ('Can\'t use ' . $conf['db']['dbname'] . ': ' . mysql_error());
}

}
}
return $this->link;





}




function close_db(){



mysql_close($this->link);


}






/** Retrieve URL information from the Database using the URL code
*
*/
function load_by_urlcode($code){
// Need to open the DB
$this->open_db();

$code = mysql_real_escape_string($code);

$query = "SELECT lURL FROM URLs WHERE shURL='$code'";
$result = mysql_query($query);
$this->close_db();
return $result;



}



/** Retrieve URL details using the Long URL
*
*/
function load_by_longurl($url){
$this->open_db();
$url = mysql_real_escape_string($url);

$query = "SELECT shURL FROM URLs WHERE lURL='$url'";
$result = mysql_query($query);

$this->close_db();
return $result;

}






/** Store a new URL in the database
*
*/
function save_new_url($data){

// Need to Open the DB

$this->open_db();

$shURL = mysql_real_escape_string($data->urlcode);
$lURL = mysql_real_escape_string($data->url);
$user = mysql_real_escape_string($data->user);


$query = "INSERT INTO URLs(shURL,lURL,Added,User)" .
" VALUES('$shURL','$lURL','{$data->created_date}','$user')";

$result = mysql_query($query);
echo mysql_error();

$this->close_db();
return $result;

}



/** Record a new hit on a Short URL
*
*/
function increase_hit_count($url){

// Need to open the DB
$this->open_db();

$url = mysql_real_escape_string($url);
$query = "INSERT INTO Stats (URLID,Hits) VALUES ('$url','1') " . 
"ON DUPLICATE KEY UPDATE Hits=Hits+1";

$result = mysql_query($query);
echo mysql_error();

$this->close_db();
return $result;

}



/** Record a new referer or update the hit count if referer exists
*
*/
function add_referer($url,$referer){

// Need to Open the DB
$this->open_db();
$referer = mysql_real_escape_string($referer);
$url = mysql_real_escape_string($url);
$date = date('Y-m-d H:i:s');

$query = "INSERT INTO Referers (URLID,Referer,Hits,Firstseen,lastseen) VALUES('$url','$referer','1','$date','$date')" .
" ON DUPLICATE KEY UPDATE Hits=Hits+1,lastseen='$date'";
$result = mysql_query($query);
echo mysql_error();

$this->close_db();
return $result;


}


/** Record a new useragent or update the hit count if referer exists
*
*/
function add_user_agent($url,$ua){

// Need to Open the DB
$this->open_db();
$ua = mysql_real_escape_string($ua);
$url = mysql_real_escape_string($url);
$date = date('Y-m-d H:i:s');

$query = "INSERT INTO UserAgents (URLID,UserAgent,Hits,FirstSeen,lastseen) VALUES('$url','$ua','1','$date','$date')" .
" ON DUPLICATE KEY UPDATE Hits=Hits+1,lastseen='$date'";
$result = mysql_query($query);
echo mysql_error();

$this->close_db();
return $result;


}


/** Retrieve URL data for the stats page
*
*/
function retrieve_full_url_info($url){
// Need to open the db
$this->open_db();


$url = mysql_real_escape_string($url);

$query = "SELECT * FROM URLs WHERE shURL='$url'";
$result = mysql_query($query);


$this->close_db();
return $result;


}


/** Retrieve the number of times a URL has been loaded
*
*/
function retrieve_hitcount($url){
$this->open_db();
$url = mysql_real_escape_string($url);
$query = "SELECT Hits FROM Stats WHERE URLID='$url'";
$result = mysql_query($query);

$this->close_db();
return $result;



}



/** Retrieve the top 10 referers
*
*/
function retrieve_top_referers($url){
$this->open_db();

$url = mysql_real_escape_string($url);
$query = "SELECT * FROM Referers WHERE URLID='$url' ORDER BY Hits Desc LIMIT 10";
$result = mysql_query($query);


$this->close_db();
return $result;


}




/** Retrieve the top 10 user-agents
*
*/
function retrieve_top_uas($url){
$this->open_db();

$url = mysql_real_escape_string($url);
$query = "SELECT * FROM UserAgents WHERE URLID='$url' ORDER BY Hits Desc LIMIT 10";
$result = mysql_query($query);


$this->close_db();
return $result;


}

/** Retrieve the top 10 user-agents
*
*/
function retrieve_bottom_uas($url){
$this->open_db();

$url = mysql_real_escape_string($url);
$query = "SELECT * FROM UserAgents WHERE URLID='$url' ORDER BY Hits Asc LIMIT 10";
$result = mysql_query($query);


$this->close_db();
return $result;


}


}






?>
