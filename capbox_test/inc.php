<?php // admin capachat$494860182
	require("business/tableauBordUtils.php");
	require("business/societeContact.php");
	
	session_start();
	ini_set ('session.bug_compat_42', 0);
	ini_set ('session.bug_compat_warn', 0);

	// header("Location: maintenance.php");
	
	$fin_url="";
	if (!isset($_SESSION['societeContact'])) {
		header("Location: index.php");
	} else {
		// mysql_connect("localhost", "root", "");
		// mysql_select_db("capbox");
		mysql_connect("mysql51-9.business", "capboxtest", "test00test");
		mysql_select_db("capboxtest");
		// mysql_connect("mysql5-23.bdb", "capbox001", "3Ty3FG0O");
		// mysql_select_db("capbox001");

		$societeContact = $_SESSION['societeContact'];

		function urld($rurl) {
			$fin_url="";
			$durl = explode("_", $rurl);
			if ($durl[0] == "/admin"){
				$durl = $durl[0]."_".$durl[1].".php";
			}
			else{
				$durl = $durl[0].".php";
			}
			$url = explode("?", $_SERVER['PHP_SELF']);
			if ($url[0] == $rurl) {
				echo "<a href=\"#\" class=\"flomenu2\">";
			}
			else if ($url[0] == $durl) {
				echo "<a href=\"$rurl\" class=\"flomenu2\">";
				$fin_url = "</a>";
			}
			else {
				echo "<a href=\"$rurl\" class=\"flomenu\">";
				$fin_url = "</a>";
			}

		}
	}
?>