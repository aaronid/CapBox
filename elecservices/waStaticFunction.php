<?php

function waAddToMailHeader($var_name,$to,$reply_to) 
{
	$headers= "";
	if (strlen($reply_to)>0){
	$headers .= $var_name.":".$reply_to."\r\n";
	}
	if ((strlen($headers)==0) && (strlen($to)>0) ){
	$headers .= $var_name.":".$to."\r\n";
	}
	return $headers;
}



function waRetrievePostParameter($k)
{
$val='';
if (isset($HTTP_POST_VARS)&&array_key_exists($k,$HTTP_POST_VARS)) $val= $HTTP_POST_VARS[$k];
if (isset($_POST)&&array_key_exists($k,$_POST)) $val= $_POST[$k];
return stripslashes( $val );
}

function waRetrieveGetParameter($k)
{
$val='';
if (isset($HTTP_GET_VARS)&&array_key_exists($k,$HTTP_GET_VARS)) $val= $HTTP_GET_VARS[$k];
if (isset($_GET)&&array_key_exists($k,$_GET)) $val= $_GET[$k];
return stripslashes( $val );
}

function waRetrieveGetServer($k)
{
$val='';
if (isset($HTTP_SERVER)&&array_key_exists($k,$HTTP_SERVER)) $val= $HTTP_SERVER[$k];
if (isset($_SERVER)&&array_key_exists($k,$_SERVER)) $val= $_SERVER[$k];
return $val;
}

function waRetrieveSession($k)
{
$val='';
if (isset($HTTP_SESSION_VARS)&&array_key_exists($k,$HTTP_SESSION_VARS)) $val= $HTTP_SESSION_VARS[$k];
if (isset($_SESSION)&&array_key_exists($k,$_SESSION)) $val= $_SESSION[$k];
return $val;
}
?>