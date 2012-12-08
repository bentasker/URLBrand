<?php

require_once 'config.php';


$url = $_GET['url'];

// Should we show the main page?
if (($url == "index.php") || (empty($url))){

require_once 'shorturl.html.php';
$html = new shorturl_html;


// Are we adding an URL?
if (!empty($_POST['newurl'])){
// Authenticate the request
require_once 'urlbrand_auth.class.php';

$auth = new UrlBrand_auth;
$authres = $auth->simpleauth($_POST['pass']);

if (!$authres){
echo "Access Denied - Invalid Password";
die;
}


// Add an URL
require_once 'newurl.class.php';
$url = new newurl;
$shortened_url = $url->add_url($_POST['newurl']);

}


$html->html_init($shortened_url);





}else{

// See if this request is the result of a QR Code being scanned
if ($_GET['qr'] == 1){

$url = substr($url,0,-1);

$_SERVER['HTTP_REFERER'] = "QR Code";
}


// No, need to redirect or show info page

require_once 'shorturl_existing.class.php';

$info = new shorturl_existing;




if ($_GET['info'] == "1"){
// Show info page

require_once 'shorturl.html.php';
$html = new shorturl_html;

$origurl = substr($url,0,-1);
$info->load_url_info($origurl);


// Call the template
$html->html_init($info);




}else{
// Load the original url and redirect
$info->load_redir($url);
}





}


















?>
