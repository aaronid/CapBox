<?php
$admin_adress = "wa-admin/wa_admin.php";
if (@file_exists($admin_adress))
{
	require_once($admin_adress);
}
else
{
?>
<html>
	<head>
		<title>WA4 administration page is not available !</title>
		<meta name="robots" content="noindex" />
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
	</head>
	<body>
	WebAcappella administration page is not available.<br>
	You must use an Blog element in your site and publish this one !<br>
	<br>
	<br>
	La page d'administration WebAcappella n'est pas disponible.<br>
	Vous devez utiliser un element blog dans votre site et publier celui ci !<br>
	</body>
</html>
<?php
}
?>