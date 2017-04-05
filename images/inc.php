<?php
    	session_start();
		if(isset($_SESSION['client'])){
	
	mysql_connect("mysql5-23.bdb","capbox001","3Ty3FG0O"); 
	mysql_select_db("capbox001");
	$client=$_SESSION['client'];
	$interlocuteur=$_SESSION['interlocuteur'];
	$marge=$_SESSION['marge'];
	$catalogue=$_SESSION['catalogue'];	
	$consult=$_SESSION['consult'];
	
function urld($rurl){
$fin_url="";
$durl=explode("_", $rurl);
$durl=$durl[0].".php";
$url= explode("?", $_SERVER['PHP_SELF']);
		if($url[0]==$rurl){
		echo "<a href=\"#\" class=\"flomenu2\">";
		}else if($url[0]==$durl){
		echo "<a href=\"$rurl\" class=\"flomenu2\">";
		$fin_url="</a>";
		}else{
		echo "<a href=\"$rurl\" class=\"flomenu\">";
		$fin_url="</a>";
		}
		
} 

		
	}else{?>
<script language="JavaScript">
window.location='index.php';
</script>
<?	}
	?>