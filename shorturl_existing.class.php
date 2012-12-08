<?php

require_once 'urlshortdb.class.php';


class shorturl_existing{


/** Get the original URL from the database and redirect
*
*/
function load_redir($url){
global $conf;
// Load the URL from the DB and send a redirection header
$this->db = new urlshort_db;
$res = $this->db->load_by_urlcode($url);
$row = mysql_fetch_array($res);


if (empty($row['lURL'])){
echo "URL not found, is it valid?";
die;
}


$location = stripslashes($row['lURL']);
header("Location: $location\n\r");


// Now input the stats
$this->db->increase_hit_count($url);

if ((!empty($_SERVER['HTTP_REFERER'])) && ($_SERVER['HTTP_REFERER'] != $conf['app']['url'] . "/" . $url . "+")){
$this->db->add_referer($url,$_SERVER['HTTP_REFERER']);

}

if (!empty($_SERVER['HTTP_USER_AGENT'])){

$this->db->add_user_agent($url,$_SERVER['HTTP_USER_AGENT']);

}


}









/** Grab the Info needed for the URL summary
*
*/

function load_url_info($url){

$this->db = new urlshort_db;

// Load the URL from the DB along with associated info
$url_info = $this->db->retrieve_full_url_info($url);

if ($url_info){
$row = mysql_fetch_array($url_info,MYSQL_ASSOC);

$this->url->url = $row['lURL'];
$this->url->urlcode = $url;

$created = strtotime($row['Added']);
$this->url->created = date('d/m/Y H:i',$created);



// Get Info on number of hits
$hits = $this->db->retrieve_hitcount($url);

if ($hits){
$row = mysql_fetch_array($hits,MYSQL_ASSOC);
$this->url->hits = $row['Hits'];
}


// Get Info on Top Referers (if any) and user agents
if ($this->url->hits > 0){

$refs = $this->db->retrieve_top_referers($url);

if ($refs){

$X = 1;
while ($row = mysql_fetch_object($refs)){

$this->referers->$X = $row;
$X++;
}


}

// Get info on the most common User-Agents 
$uas = $this->db->retrieve_top_uas($url);

if ($uas){

$X = 1;
while ($row = mysql_fetch_object($uas)){
$this->uas->top->$X = $row;
$X++;
}

}


// Get info on any unusual User-Agents recorded for this URL (based on hits)

$uas = $this->db->retrieve_bottom_uas($url);

if ($uas){

$X = 1;
while ($row = mysql_fetch_object($uas)){
$this->uas->bottom->$X = $row;
$X++;
}

}



}





}else{
// URL not found
$this->error = "Y";
$this->errortext = "The URL you specified was not found";
}



return $this;

}











}


?>
