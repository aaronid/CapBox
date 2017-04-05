
<?php
	require("inc.php");
	// Est-ce qu'on veut supprimer une image ?
	if (isset($_GET['supprimer_image'])) // Si l'on demande de supprimer une image.
	{
		// Alors on supprime l'image correspondante.
		$_GET['supprimer_image'] = addslashes($_GET['supprimer_image']);
		$resultat = mysql_query("SELECT logo FROM societe_logo_bas_de_page WHERE _ID =".$_GET['supprimer_image']);
		$image = mysql_fetch_assoc($resultat);
		unlink ("images/logos_bas_de_page/".$image['logo']);
		mysql_query("DELETE FROM societe_logo_bas_de_page WHERE _ID =".$_GET['supprimer_image']);
	}
	// Est-ce qu'on veut ajouter une image ?
	if( isset($_POST['upload']) ) // Si l'on demande d'ajouter une image.
	{
		// Récuperation de l'id de la societe
		$ID_SOCIETE = $_GET['action'];

		// Recuperation de l'extension du fichier
	    $type_file = $_FILES['logo']['type'];

		if (strstr($type_file, 'jpg')) // Si l'extension est jpg, on accepte
	    {
	    	$nom_fichier = $societeContact->societe->id . "_" . $_FILES['logo']['name']; 									// On renomme le fichier idsociete_nomfichier
		    move_uploaded_file($_FILES['logo']['tmp_name'],"images/logos_bas_de_page/".$nom_fichier);						// On deplace le fichier dans le bon dossier
			mysql_query("INSERT INTO societe_logo_bas_de_page(ID_SOCIETE, LOGO) VALUES ($ID_SOCIETE , '$nom_fichier')");	// Requete d'insertion de l'image
			header('Location : logo_bas_de_page.php');																		// Redirection
	    }

	    elseif (strstr($type_file, 'jpeg')) // Si l'extension est jpeg, on accepte
	    {
	    	$nom_fichier = $societeContact->societe->id . "_" . $_FILES['logo']['name']; 									// On renomme le fichier idsociete_nomfichier
		    move_uploaded_file($_FILES['logo']['tmp_name'],"images/logos_bas_de_page/".$nom_fichier);						// On deplace le fichier dans le bon dossier
			mysql_query("INSERT INTO societe_logo_bas_de_page(ID_SOCIETE, LOGO) VALUES ($ID_SOCIETE , '$nom_fichier')");	// Requete d'insertion de l'image
			header('Location : logo_bas_de_page.php');																		// Redirection
	    }
	    else // Sinon, message d'erreur
	    {
		    echo "Le fichier que vous venez d'envoyer n'est pas au format jpg";
	    }
	}
?>		
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    
<body>
	<section>
		<div>
		<h2>Liste des logos enregistres :</h2>
			<table border="1" cellpadding="10" cellspacing="1">
			 <!-- Tableau listant les images enregistrées, avec la possibilité de les supprimer -->
				<thead><tr class="success"><td>Logo</td><td>Supprimer</td></tr></thead>
				
				<?php
				// On recupere les images
				// Requete recuperant les images de l'utilisateur
				$resultat = mysql_query('SELECT _ID, LOGO FROM societe_logo_bas_de_page WHERE ID_SOCIETE ='.$societeContact->societe->id);
		
				while ($ligne = mysql_fetch_assoc($resultat)) // Tant qu'il y a des images
				{
				?>
				<tr>
					<!-- Affichage de l'image -->
					<td width="300"><center><img width=40% src="images/logos_bas_de_page/<?php echo $ligne['LOGO'];?>"></center></td>
					<!-- Lien vers la suppression de l'image -->
					<td width="80"><?php echo '<a href="logo_bas_de_page.php?supprimer_image=' . $ligne['_ID'] . '">'; ?><center><img src="images/icones/icone_supprimer.png" ></center></a></td>
				</tr>
				<?php
				} // Fin de la boucle qui liste les images.
				mysql_close();
				?>
			</table>
			</br>
			</br>
			<h2>Ajouter un logo :</h2> <!-- Formulaire permettant d'ajouter une image -->
			<form action="logo_bas_de_page.php?action=<?php echo $societeContact->societe->id ?>" method="POST" enctype="multipart/form-data">
				<input type = "file" name = "logo"><br />
				<input type = "submit" name = "upload" value="Envoyer" />
			</form>
		</div>
	</section>	
</body>
</html>