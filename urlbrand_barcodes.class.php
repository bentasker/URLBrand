<?php


class UrlBrand_barcodes{


/** Uses Google Chart API to generate a QR Code
*
* @arg url - URL to generate the code for
* @arg width - Width
* - Note Height not specified as code must be square!
*
* @return - object - URL to view the Image & HTML code
*/
function generate_QR_Code($url, $width=150){
$url = urlencode($url);


$this->url = "http://chart.apis.google.com/chart?chs=" . $width . "x" . $width .
"&cht=qr&chld=H|0&chl=" . $url;

$this->html = "<img src='{$this->url}' width='$width' height='$width' alt='QR Code " .
"- Scan with barcode scanner to load' title='QR Code - Scan with barcode scanner to load'>";


return $this;

}



}





?>
