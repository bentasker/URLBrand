<?php



class shorturl_html{

/** Generate Stats Page for specified URL
*
*/
function url_info($url){

require_once 'urlbrand_barcodes.class.php';

$urlbrand = new UrlBrand_barcodes;
$link = "{$this->url_pref}/{$url->url->urlcode}*";
$qr = $urlbrand->generate_QR_Code($link);

$str .= "<span class='title'>Information for URL {$this->url_pref}/{$url->url->urlcode}</span>\n <br /><br>\n" .
'<table class="urlinfo"><tbody>' .
'<tr class="infohead"><td>URL</td><td>Short URL</td><td>Created</td><td>Hits</td><td>QR Code</td></tr>' . "\n" .
'<tr class="infodata"><td>' .
"\n <a href=\"{$url->url->url}\" target=_blank class=\"originallink\">{$url->url->url}</a>\n</td><td>" .
"\n <a href=\"{$this->url_pref}/{$url->url->urlcode}\" target=_blank class=\"shortlink\">{$url->url->urlcode}</a>\n</td><td>" .
"\n {$url->url->created}\n</td><td>\n" .
"\n {$url->url->hits}\n</td><td>{$qr->html}</td></tr>\n" .
"</tbody>\n</table>";



// The query may have failed, or hits might be 0 so check before trying to generate the referers table
if (isset($url->referers)){

// Generate the table
$str .= "<br /><br />\n\n\n<span class=\"toprefererstitle\">Top Referers</span><br />" .
"<table class=\"topreferers\"><tbody>\n" .
"<tr class=\"toprefererstitle\"><td>Referer</td><td>Hits</td><td>First Seen</td><td>Last Seen</td></tr>";

foreach ($url->referers as $value){

$str .= "<tr class=\"toprefersdata\"><td><a href=\"{$value->Referer}\" rel=\"nofollow\" class=\"originallink\">{$value->Referer}</a>" .
"</td><td>{$value->Hits}</td><td>{$value->FirstSeen}</td><td>{$value->lastseen}</td></tr>\n";



}


$str .= "</tbody>\n</table>\n";


}




if (isset($url->uas->top)){

// Generate the table
$str .= "<br /><br />\n\n\n<span class=\"toprefererstitle\">Most Common User Agent</span><br />" .
"<table class=\"topreferers\"><tbody>\n" .
"<tr class=\"toprefererstitle\"><td>User Agent</td><td>Hits</td><td>First Seen</td><td>Last Seen</td></tr>";

foreach ($url->uas->top as $value){

$str .= "<tr class=\"toprefersdata\"><td>{$value->UserAgent}" .
"</td><td>{$value->Hits}</td><td>{$value->FirstSeen}</td><td>{$value->lastseen}</td></tr>\n";



}


$str .= "</tbody>\n</table>\n";




}



if (isset($url->uas->bottom)){

// Generate the table
$str .= "<br /><br />\n\n\n<span class=\"toprefererstitle\">Least Common User Agent</span><br />" .
"<table class=\"topreferers\"><tbody>\n" .
"<tr class=\"toprefererstitle\"><td>User Agent</td><td>Hits</td><td>First Seen</td><td>Last Seen</td></tr>";

foreach ($url->uas->bottom as $value){

$str .= "<tr class=\"toprefersdata\"><td>{$value->UserAgent}" .
"</td><td>{$value->Hits}</td><td>{$value->FirstSeen}</td><td>{$value->lastseen}</td></tr>\n";



}


$str .= "</tbody>\n</table>\n";




}





$this->htmlcontent = $str;

}



/** Generate page content following submission of a URL
*
*/
function shortened_url($url){
require_once 'urlbrand_barcodes.class.php';

$urlbrand = new UrlBrand_barcodes;
$qr = $urlbrand->generate_QR_Code($this->url_pref."/".$url->url->urlcode."*");


$this->htmlcontent .= '<table class="urlinfo"><tbody>' .
'<tr class="infohead"><td>URL</td><td>Short URL</td><td>View Stats</td><td>QR Code</td></tr>' . "\n" .
'<tr class="infodata"><td>' .
"\n <a href=\"{$url->url}\" target=_blank class=\"originallink\">{$url->url}</a>\n</td><td>" .
"\n <a href=\"{$this->url_pref}/{$url->urlcode}\" target=_blank class=\"shortlink\">{$url->urlcode}</a>\n</td><td>" .
"\n <a href=\"{$this->url_pref}/{$url->urlcode}+\" target=_blank class=\"statslink\">URL Stats\n</td><td>{$qr->html}</td></tr>\n" .
"</tbody>\n</table>";



}



/** Generate form allowing submission of URL for shortening
*
*/
function generate_shorten_form(){


$this->htmlcontent .= '<form action="index.php" method="post" class="submitform">' .
'<input type="text" name="newurl" class="inputbox" value="' . $_POST['newurl'] . '">' . "\n";
global $conf;

if (!empty($conf['app']['submitpass'])){
$this->htmlcontent .= '<input type="password" name="pass">';

}

$this->htmlcontent .= '<input type="submit" value="Shorten!" class="button"></form>';


}




// Generate the HTML content before invoking the template
function html_init($url){

global $conf;
$this->url_pref=$conf['app']['url'];
$this->app_name = $conf['app']['name'];

$this->generate_shorten_form();

if ($url->error=="Y"){
$this->htmlcontent = "<span class='error'>{$this->errortext}</span>\n";
}


// Have we added?
if ($url->add_status){
$this->shortened_url($url);
}


// We are displaying the URL info page
if (isset($url->url->url)){
$this->url_info($url);
}



// invoke the template
include 'template.php';

}




}

?>
