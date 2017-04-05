
<?php
	require("inc.php");
	// Est-ce qu'on veut supprimer une image ?
	if (isset($_GET['supprimer_image'])) // Si l'on demande de supprimer une image.
	{
		// Alors on supprime l'image correspondante.
		// On protège la variable « _id » pour éviter une faille SQL.
		$_GET['supprimer_image'] = addslashes($_GET['supprimer_image']);
		$resultat = mysql_query("SELECT logo FROM societe_logo_bas_de_page WHERE _ID =".$_GET['supprimer_image']);
		$image = mysql_fetch_assoc($resultat);
		unlink ("images/logos_bas_de_page/".$image['logo']);
		mysql_query("DELETE FROM societe_logo_bas_de_page WHERE _ID =".$_GET['supprimer_image']);
	}	
?>		
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    
<body>
	<section>
		<div>
		<h2>Liste des logos enregistres :</h2>
			<table border="1" cellpadding="10" cellspacing="1">
				<thead><tr class="success"><td>Logo</td><td>Supprimer</td></tr></thead>
				
				<?php
				// On récupère les images.
				// préparation de la requête : recherche de l'utilisateur
				$resultat = mysql_query('SELECT _ID, LOGO FROM societe_logo_bas_de_page WHERE ID_SOCIETE ='.$societeContact->societe->id);
		
				while ($ligne = mysql_fetch_assoc($resultat)) // On fait une boucle pour lister les images.
				{
				?>
				<tr>
					<td width="300"><center><img width=40% src="images/logos_bas_de_page/<?php echo $ligne['LOGO'];?>"></center></td>
					<td width="80"><?php echo '<a href="logo_bas_de_page.php?supprimer_image=' . $ligne['_ID'] . '">'; ?><center><img src="images/icones/icone_supprimer.png" ></center></a></td>
				</tr>
				<?php
				} // Fin de la boucle qui liste les images.
				mysql_close();
				?>
			</table>
			</br>
			</br>
			<h2>Ajouter un logo :</h2>
			<form action="logo_action.php?action=<?php echo $societeContact->societe->id ?>" method="POST" enctype="multipart/form-data">
				<input type = "file" name = "logo"><br />
				<input type = "submit" name = "upload" value="Envoyer" />
			</form>
		</div>
	</section>	
</body>
</html>