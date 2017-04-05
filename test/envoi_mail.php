<?php
	require("inc.php");
	$id = $_GET['id'];
	if (!empty($id)) {
		$socCont = new SocieteContact();
		$socCont->findResponsableSociete($id);
		
		$caracteres = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",0,1,2,3,4,5,6,7,8,9);
		$passeNew = "";
		for($j=0; $j<=6; $j++)
		{
			$random = array_rand($caracteres);
			$passeNew .= $caracteres[$random];
		}

		$utili = $socCont->getUtilisateur();
		$utili->password = $passeNew;
		$utili->update();
		
		$message="Bonjour $socCont->prenom $socCont->nom,\n
Veuillez trouvez ci-après le renvoi de votre login et mot de passe concernant votre compte société $socCont->societe->nom.\n
Login : $socCont->login \r
Nouveau mot de passe : $passeNew \n
Conservez les précieusement.\r
Si vous souhaitez les modifier, il vous suffit de vous rendre la rubrique « mon compte » du site http://www.capbox.fr/index.php\n
Christophe LEPRETRE\r
CAP ACHAT\n
Tel : 06 88 86 13 22\r
E-mail : cap.achat@orange.fr\r
Site : www.cap-achat.com";
		mail($socCont->email, 'Renvoi des identifiants de votre compte', utf8_decode($message));
	
?>
		<script language="javascript">
	    	opener.document.getElementById('ENVOI').innerHTML='Mail envoyé !';
	    	window.close();
		</script>
<?php
	} else {
		echo "impossible d'envoyer le mail";
	}

?>