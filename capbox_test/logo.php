<?
require("inc.php");
///////////////////
if( isset($_POST['upload']) ) // si formulaire soumis
{

	$ID_SOCIETE = $_GET['action'];

    $type_file = $_FILES['fichier']['type'];
     	  
    if (strstr($type_file, 'jpg')) // Si l'extension est jpg, on accepte
	{
	   	$nom_fichier = $societeContact->societe->id . "_" . $_FILES['fichier']['name'];
		move_uploaded_file($_FILES['fichier']['tmp_name'],"images/logos/".$nom_fichier);
		mysql_query("UPDATE societe SET LOGO = '$nom_fichier' WHERE _ID = $ID_SOCIETE");
	}
	elseif (strstr($type_file, 'jpeg')) // Si l'extension est jpeg, on accepte
	{
	   	$nom_fichier = $societeContact->societe->id . "_" . $_FILES['fichier']['name'];
		move_uploaded_file($_FILES['fichier']['tmp_name'],"images/logos/".$nom_fichier);
		mysql_query("UPDATE societe SET LOGO = '$nom_fichier' WHERE _ID = $ID_SOCIETE");
	}
	else
	{
		echo "Le fichier que vous venez d'envoyer n'est pas au format jpg";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Document sans nom</title>
	</head>
	<body>
		<h2>Transfert de votre logo</h2>
		<form method="post" enctype="multipart/form-data" action="logo.php?action=<?php echo $societeContact->societe->id ?>">
			<p>
				<input type="file" name="fichier" size="30"/>
				<input type="submit" name="upload" value="Envoyer"/>
			</p>
		</form>
	</body>
</html>
