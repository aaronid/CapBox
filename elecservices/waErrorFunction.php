<?php

function waSetError($str) 
{
$HTTP_SESSION_VARS['error_message']=strip_tags($str);
$_SESSION['error_message']=strip_tags($str);
}

function waGetError()
{
	$ret="";
$k='error_message';
if (isset($HTTP_SESSION_VARS)&&array_key_exists($k,$HTTP_SESSION_VARS)) 
$ret=$HTTP_SESSION_VARS[$k];
if ((strlen($ret)==0)&&isset($_SESSION)&&array_key_exists($k,$_SESSION))
$ret=$_SESSION[$k];

$ret = str_replace("\n", " ", $ret);
return $ret;
}

function waErrorHandler($errno, $errstr, $errfile, $errline)
{
$error_message = '';
switch ($errno) 
{
case E_USER_WARNING:
 break;
default:
  $error_message .= '['.$errno.']'.$errstr;
 break;
}
 waSetError($error_message);
}

waSetError('');
set_error_handler('waErrorHandler');

?>