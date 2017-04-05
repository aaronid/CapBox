<?php
include_once('waStaticFunction.php');
include_once('waErrorFunction.php');
$waErrorPhpMailReporting=0;
function waSendMail($to,$title,$mess,$reply_to="") 
{
if (strlen($to)==0) $to = "";
if (strlen($to)==0) {
waSetError('No email');
return false;
}
$headers= "";
$headers.= 'Content-type:text/plain;charset=utf-8'."\r\n";
$headers .= waAddToMailHeader('From','[mail]',$reply_to);
$headers .= waAddToMailHeader('Return-Path','[mail]',$reply_to);
if (strlen($reply_to)>0){
$headers.= "Reply-To:".$reply_to."\r\n";
}
if (strlen($to)>0){
$headers=str_replace("[mail]",$to,$headers);
}
$add_headers= "-f[mail]";
if (strlen($to)>0){
$add_headers=str_replace("[mail]",$to,$add_headers);
}
if ((strlen($add_headers)>0) && mail($to,$title,$mess,$headers,$add_headers)) return true;
$res= mail($to,$title,$mess,$headers);
return $res;
}
?>
