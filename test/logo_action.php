<?php
	require("inc.php");

	if (isset($_GET['action'])) // Si l'on demande d'ajouter une image.
	{
		$ID_SOCIETE = $_GET['action'];

		$tabExt = array('jpg','gif','png','jpeg');    // Extensions autorisees
		// Recuperation de l'extension du fichier
	    $extension  = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
	    // On verifie l'extension du fichier
	    if(in_array(strtolower($extension),$tabExt))
	    {
	    	$nom_fichier = $societeContact->societe->id . "_" . $_FILES['logo']['name'];
		    move_uploaded_file($_FILES['logo']['tmp_name'],"images/logos_bas_de_page/".$nom_fichier);
			mysql_query("INSERT INTO societe_logo_bas_de_page(ID_SOCIETE, LOGO) VALUES ($ID_SOCIETE , '$nom_fichier')");
			header('Location : logo_bas_de_page.php');
	    }
	    else 
	    {
	    echo "L'image n'est pas au format jpg";
		echo "<a href='logo_bas_de_page.php'>Retour à la gestion des images</a>";
	    }
	}
?>	