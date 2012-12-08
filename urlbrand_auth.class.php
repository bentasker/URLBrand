<?php



class UrlBrand_auth{


/** Checks whether the password matches one set in the config
*
* @arg pass - supplied password
*
* @return boolean
*/
function simpleauth($pass){

global $conf;

$pass = md5($pass);
if ($pass == $conf['app']['submitpass']){
return true;
}

return false;


}










}
















?>
