<?php


class UrlBrandPrude{

/** Check the supplied string for any naughty strings
*
* @arg string - The string to be checked
*
* @return boolean - String approved by the censor? 
*/

function naughty_words($string){

global $conf;

foreach ($conf['app']['bannedstrings'] as $value){

if(strpos($value,$string) === false){
continue;
}else{
 return 0;
}

}

return 1;




}







}







?>