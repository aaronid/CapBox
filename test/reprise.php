<?php
	session_start();
	mysql_connect("localhost","root","");
	mysql_select_db("capbox");
	// mysql_connect("mysql51-9.business", "capboxtest", "test00test");
	// mysql_select_db("capboxtest");
	// mysql_connect("mysql5-23.bdb", "capbox001", "3Ty3FG0O");
	// mysql_select_db("capbox001");
?>
<html>
<head>
</head>
<body>
<?php 
	$interlocQuery = mysql_query("select * from interlocuteur");
	$interlocResult = mysql_fetch_array($interlocQuery);

	while ($interlocResult = mysql_fetch_array($interlocQuery)) {
		// echo "<h1>Login : ".$interlocResult['LOGIN']." - Passe : ".$interlocResult['PASSE']." - Passe crypté : ".md5($interlocResult['PASSE'])."</h1>";
		mysql_query("UPDATE interlocuteur SET PASSWORD='".md5($interlocResult['PASSE'])."' WHERE LOGIN='".$interlocResult['LOGIN']."'");
	}
?>
</body>
</html>