<?php


require_once 'urlshortdb.class.php';









class newurl{


/** Generate a URL identifier
*
*/
function generate_urlcode(){
global $conf;

// Load the chars array
$chars = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
 'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
 '0','1','2','3','4','5','6','7','8','9');



// Generate the random string
$X = 1;
while ($X <= $conf['app']['urichars']){

$selection_no = rand(1,62);

$str .= $chars[$selection_no];
$X++;
}


$this->urlcode = $str;


}




/** See if the submitted URL already exists in the database
*
*/
function check_longurl_exist(){

$this->exists = $this->db->load_by_longurl($this->url);


}





/** Check whether the provided URLCode is actually unique
*
*/
function check_urlcode_unique(){


$result = $this->db->load_by_urlcode($this->urlcode);

if($result){

$this->unique = 1;
}else{
$this->unique = 0;
}



}





/** Main Entry Point
* 
* @arg $url - String containing URL to be shortened
*
* @return string - Shortened URL
*
*/
function add_url($url){

// Set some vars
global $conf;
$this->url = $url;
$this->db = new urlshort_db;

// Check if the URL already exists in the DB - TODO
$this->check_longurl_exist();

$row = mysql_fetch_object($this->exists);

if (!isset($row->shURL)){

// load the Censor
require_once 'UrlbrandPrude.class.php';

// Generate the URL code (might take a few tries to get a unique one)
// Cap maximum number of retries
$X = 1;
while (($this->unique != 1) && ($this->approved != 1)){
$this->generate_urlcode();
$this->check_urlcode_unique();


$prude = new UrlBrandPrude;
$this->approved = $prude->naughty_words($this->urlcode);


if ($X == $conf['app']['retries']){

$this->error = Y;
$this->errortext = "Maximum number of URL generation retries hit - could not continue";
return $this;
}

$X++;
}

$this->created_date = date('Y:m:d H:i:s');

// Add the Url to the database

$this->add_status = $this->db->save_new_url($this);
}else{




$this->add_status = true;
$this->urlcode = $row->shURL;

}



return $this;

}





}








?>
