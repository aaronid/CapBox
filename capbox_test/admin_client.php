<?php
require("inc.php");
$id = "";
if (isset($_GET['id'])) {
	$id = $_GET['id'];
}
$NOM="";
if (isset($_POST['NOM'])) {
	$NOM=$_POST['NOM'];
}
$PRENOM="";
if (isset($_POST['PRENOM'])) {
	$PRENOM=$_POST['PRENOM'];
}
$FONCTION="";
if (isset($_POST['FONCTION'])) {
	$FONCTION=$_POST['FONCTION'];
}
$CIVILITE="";
if (isset($_POST['CIVILITE'])) {
	$CIVILITE=$_POST['CIVILITE'];
}

if (!empty($_POST['hid'])) {
	$societe = new Societe();
	if (!empty($id)) {
		$societe->findById($id);
	}
	
	$societe->nom = $_POST['SOCIETE'];
	$societe->adresse1 = $_POST['ADRESSE1'];
	$societe->adresse2 = $_POST['ADRESSE2'];
	$societe->codePostal = $_POST['CP'];
	$societe->ville = $_POST['VILLE'];
	$societe->telFix = $_POST['TEL'];
	$societe->fax = $_POST['FAX'];
	$societe->telMob = $_POST['MOB'];
	$societe->catalogue = $_POST['CATALOGUE'];
	$societe->email = $_POST['MAIL'];
	$societe->bloc = $_POST['BLOC'];
	if (isset($_POST['CONSULT'])) {
		$societe->consult = "1";
	}
	$societe->dateCreation = implode('-',array_reverse(explode('/',$_POST['DATE1'])));
	if (!empty($_POST['DATE2'])) {
		$societe->dateFermeture = implode('-',array_reverse(explode('/',$_POST['DATE2'])));
		$societe->inactif = "1";
	}
	
	if (empty($id)) {
		$societe->insert();

		////////////Creation login / mot de passe////////
		$newUtilisateur = new Utilisateur();
		$newUtilisateur->codeRole = Role::$CODE_ENTREPRENEUR;
		$newUtilisateur->login = strtoupper(substr($NOM,0,3).substr($PRENOM,0,3)).$societe->id;
		$newUtilisateur->login = strtr($newUtilisateur->login, 'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ', 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');

		$caracteres = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",0,1,2,3,4,5,6,7,8,9);
		$newUtilisateur->password = "";
		for($j=0; $j<=6; $j++)
		{
			$random = array_rand($caracteres);
			$newUtilisateur->password .= $caracteres[$random];
		}
		$message = "Bonjour $PRENOM $NOM,\nNous avons le plaisir de vous informer que votre compte société $societe->nom vient d'être créé.\n
Veuillez trouvez ci-après votre login et mot de passe.\n
Login : " . $newUtilisateur->login . "\nMot de passe : " . $newUtilisateur->password . "\r\n
Conservez les précieusement.\n
Si vous souhaitez les modifier, il vous suffit de vous rendre à la rubrique « mon compte » du site http://www.capbox.fr/index.php\n
Pour débuter l'utilisation de l'application, rendez-vous dans la rubrique « Besoin d'aide ? », une démontration pas à pas y est disponible.\r\n
Christophe LEPRETRE\n
CAP ACHAT\n
Tel : 06 88 86 13 22\r
E-mail : cap.achat@orange.fr\r
Site : www.cap-achat.com";
		if (!empty($NOM)){
			mail($societe->email, 'Identifiants de votre compte', utf8_decode($message));
		}
		/////////////
		$newUtilisateur->insert();
		
		$newSocContact = new SocieteContact();
		$newSocContact->codeProfil = Profil::$CODE_CLIENT;
		$newSocContact->idSociete = $societe->id;
		$newSocContact->initiale = $NOM{0} . $PRENOM{0};
		$newSocContact->nom = $NOM;
		$newSocContact->prenom = $PRENOM;
		$newSocContact->fonction = $FONCTION;
		$newSocContact->civilite = $CIVILITE;
		$newSocContact->email = $societe->email;
		$newSocContact->login = $newUtilisateur->login;
		
		$newSocContact->insert();
	} else {
		$societe->update();
		
		$theSocContact = new SocieteContact();
		if (isset($_POST['createClient']) && !empty($_POST['createClient'])) {
			$theSocContact->findProspectSocieteContact($societe->id);
			$theSocContact->codeProfil = Profil::$CODE_CLIENT;

			$newUtilisateur = new Utilisateur();
			$newUtilisateur->codeRole = Role::$CODE_ENTREPRENEUR;
			$newUtilisateur->login = strtoupper(substr($NOM,0,3).substr($PRENOM,0,3)).$societe->id;
			$newUtilisateur->login = strtr($newUtilisateur->login, 'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ', 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
	
			$caracteres = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",0,1,2,3,4,5,6,7,8,9);
			$newUtilisateur->password = "";
			for($j=0; $j<=6; $j++)
			{
				$random = array_rand($caracteres);
				$newUtilisateur->password .= $caracteres[$random];
			}
			$message = "Bonjour $PRENOM $NOM,\nNous avons le plaisir de vous informer que votre compte société $societe->nom vient d'être créé.\n
Veuillez trouvez ci-après votre login et mot de passe.\n
Login : " . $newUtilisateur->login . "\nMot de passe : " . $newUtilisateur->password . "\r\n
Conservez les précieusement.\n
Si vous souhaitez les modifier, il vous suffit de vous rendre à la rubrique « mon compte » du site http://www.capbox.fr/index.php\n
Pour débuter l'utilisation de l'application, rendez-vous dans la rubrique « Besoin d'aide ? », une démontration pas à pas y est disponible.\r\n
Christophe LEPRETRE\n
CAP ACHAT\n
Tel : 06 88 86 13 22\r
E-mail : cap.achat@orange.fr\r
Site : www.cap-achat.com";
			if (!empty($NOM)){
				mail($societe->email, 'Identifiants de votre compte', utf8_decode($message));
			}
			/////////////
			$newUtilisateur->insert();
			
			$theSocContact->login = $newUtilisateur->login;
		} else {
			$theSocContact->findResponsableSociete($societe->id);
		}
		$theSocContact->initiale = $NOM{0} . $PRENOM{0};
		$theSocContact->nom = $NOM;
		$theSocContact->prenom = $PRENOM;
		$theSocContact->fonction = $FONCTION;
		$theSocContact->civilite = $CIVILITE;
		$theSocContact->email = $societe->email;
		
		$theSocContact->update();
	}

	?>
	<script language="JavaScript">
		window.location='admin_client_liste.php'
	</script>
<?php
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
<head>
    <!--
    Created by Artisteer v2.4.0.25435
    Base template (without user's data) checked by http://validator.w3.org : "This page is valid XHTML 1.0 Transitional"
    -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <title>CAP BOX</title>

    <link rel="stylesheet" href="style.css" type="text/css"  />
    <!--[if IE 6]><link rel="stylesheet" href="style.ie6.css" type="text/css"  /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="style.ie7.css" type="text/css"  /><![endif]-->

    <script type="text/javascript" src="script.js"></script>
    <style type="text/css">
<!--
.Style1 {color: #FFFFFF}
.Style4 {font-size: 85%}
.Style6 {font-size: 85%; font-weight: bold; }
.Style7 {font-size: 85%; font-weight: bold; color: #FFFFFF; }
-->
    </style>
</head>
<body>
 	<div id="art-page-background-simple-gradient">
        <div id="art-page-background-gradient"></div>
    </div>
    <div id="art-main">
        <div class="art-sheet">
            <div class="art-sheet-tl"></div>
            <div class="art-sheet-tr"></div>
            <div class="art-sheet-bl"></div>
            <div class="art-sheet-br"></div>
            <div class="art-sheet-tc"></div>
            <div class="art-sheet-bc"></div>
            <div class="art-sheet-cl"></div>
            <div class="art-sheet-cr"></div>
            <div class="art-sheet-cc"></div>
            <div class="art-sheet-body">
                <div class="art-header">
                    <div class="art-header-png"></div>
                </div>
                <?php require("topmenu.php"); ?>
                                    
                <div class="art-content-layout">
                    <div class="art-content-layout-row">
                        <div class="art-layout-cell art-content">
                        <div class="art-post">
                                <div class="art-post-tl"></div>
                                <div class="art-post-tr"></div>
                                <div class="art-post-bl"></div>
                                <div class="art-post-br"></div>
                                <div class="art-post-tc"></div>
                                <div class="art-post-bc"></div>
                                <div class="art-post-cl"></div>
                                <div class="art-post-cr"></div>
                                <div class="art-post-cc"></div>
                                <div class="art-post-body">
                                    <div class="art-post-inner art-article">
                                            <h2 class="art-postheader">
                                                <img src="images/postheadericon.png" width="26" height="26" alt="postheadericon" />
                                                Administration - Edition de votre contact</h2>
                                            <div class="art-postcontent">
                                                <!-- article-content -->
                                               <form action="?id=<?php echo $id; ?>" method="post" name="frm">
                                                
                                                
                                                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="art-article">
                                                  <tbody>
                                                    <?php require("admin_turl.php"); ?>
                                                    <tr>
                                                      <td colspan="8">
<?php
	$CODE_PROFIL = Profil::$CODE_CLIENT;
    if (!empty($id)) {
    	$select = mysql_query("select soco.NOM as 'NOM_C', soco.PRENOM, soco.CIVILITE, soco.FONCTION, soco.CODE_PROFIL, so.* " . 
    			"from utilisateur uti, societe_contact soco, societe so " . 
    			"WHERE (uti.CODE_ROLE = '" . Role::$CODE_ENTREPRENEUR . "' AND uti.LOGIN = soco.LOGIN AND soco.ID_SOCIETE = so._ID AND so._ID = $id) " .
    			"OR (so._ID = $id AND so._ID = soco.ID_SOCIETE AND soco.CODE_PROFIL = '" . Profil::$CODE_PROSPECT . "')");
    	$val = mysql_fetch_array($select) or die(mysql_error());
    	$NOM = $val['NOM_C'];
    	$PRENOM = $val['PRENOM'];
    	$CIVILITE = $val['CIVILITE'];
    	$FONCTION = $val['FONCTION'];
    	$CONSULT = $val['CONSULT'];
    	$CODE_PROFIL = $val['CODE_PROFIL'];
    } else if (isset($_GET['idClientProspect'])) {
    	$clientProspect = new SocieteClient();
    	$clientProspect->findByLogin($_GET['idClientProspect']);
    	
    	$NOM = $clientProspect->nom;
    	$PRENOM = $clientProspect->prenom;
    	$CIVILITE = $clientProspect->civilite;
    	$FONCTION = $clientProspect->fonction;
    }
?>
  <table width="100%">
  <tbody>
    <tr>
      <td height="32" colspan="3" background="images/fd_nav_ss_menu.png" bgcolor="#F0F0F0" class="componentheading">
      	<span style="font-weight: bold">
			<input type="hidden" id="createClient" name="createClient" value="0" />
      		<img src="images/icones/enregistrer-page-icone-7705-32.png" width="24" height="24" align="absmiddle" />
      		<a href="javascript:;" onclick="document.frm.submit()">Sauvegarder </a>
      		<img src="images/menuseparator.png" width="1" height="24" align="absmiddle" />
      		<img src="images/icones/demande-afficher-la-liste-icone-8709-32.png" width="24" height="24" align="absmiddle" />
      		<a href="admin_client_liste.php">Retour à la liste des clients</a>
<?php
	if ($CODE_PROFIL == Profil::$CODE_PROSPECT) { 
?>
      		<img src="images/menuseparator.png" width="1" height="24" align="absmiddle" />
      		<img src="images/icones/demande-afficher-la-liste-icone-8709-32.png" width="24" height="24" align="absmiddle" />
      		<a href="" onclick="document.getElementById('createClient').value = '1';document.frm.submit()">Créer un compte utilisateur à ce client</a>
<?php
	} 
    if (!empty($id)) {
?>
      		<img src="images/menuseparator.png" width="1" height="24" align="absmiddle" />
      		<img src="images/icones/demande-afficher-la-liste-icone-8709-32.png" width="24" height="24" align="absmiddle" />
      		<a href="" onclick="window.open('admin_client_contact_liste_pop.php?idSociete=<?php echo $id;?>','','scrollbars=yes,resizable=yes,width=1200,height=800');return false;">Afficher les contacts de ce client</a>
<?php
	} 
?>
      	</span>
      </td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F9F9F9" class="componentheading">&nbsp;</td>
      <td width="50%" align="right" bgcolor="#F9F9F9">&nbsp;</td>
    </tr>
    
    <tr>
      <td colspan="3" bgcolor="#5289BA" class="componentheading Style1" style="font-weight: bold">Identité de l'entreprise et de son représentant</td>
      </tr>
    <tr>
      <td bgcolor="#F9F9F9" class="componentheading" style="font-weight: bold">&nbsp;Nom</td>
      <td bgcolor="#F9F9F9" class="componentheading" style="font-weight: bold"><span class="componentheading" style="font-weight: bold">
        <select title="Sélectionner une civilité en déroulant cette liste." name="CIVILITE" id="CIVILITE">
          <option <?php if(empty($id) || $CIVILITE==1){?>selected="selected" <?php }?> value="1">M.</option>
          <option value="2"<?php if($CIVILITE==2){?>selected="selected" <?php }?>>Mme</option>
          <option value="3"<?php if($CIVILITE==3){?>selected="selected" <?php }?>>Melle</option>
          <option value="4"<?php if($CIVILITE==4){?>selected="selected" <?php }?>>M. et Mme</option>
        </select>
        <span class="componentheading" style="font-weight: bold">
        <input title="Saisir votre nom (* cette valeur est obligatoire)." id="NOM" name="NOM" value="<?php echo $NOM; ?>" size="30" type="text" />
        </span></span></td>
      <td  bgcolor="#F9F9F9"><span style="font-weight: bold">Société</span>  <span class="componentheading" style="font-weight: bold">
        <input id="SOCIETE" name="SOCIETE" value="<?php if (isset($val)) {echo $val['NOM'];} else if (!empty($clientProspect->id)) {echo $clientProspect->entreprise;} ?>" size="28" type="text" />
      </span></td>
    </tr>
    <tr>
      <td bgcolor="#F9F9F9" class="componentheading" style="font-weight: bold"><span class="componentheading" style="font-weight: bold">&nbsp;Prénom</span></td>
      <td bgcolor="#F9F9F9" class="componentheading" style="font-weight: bold"><span class="componentheading" style="font-weight: bold">
        <input title="Saisir votre prénom (* cette valeur est obligatoire)." id="PRENOM" name="PRENOM" value="<?php echo $PRENOM; ?>" size="20" type="text" />
      </span></td>
      <td  bgcolor="#F9F9F9"><span style="font-weight: bold">Fonction</span> <span class="componentheading" style="font-weight: bold">
      <input id="FONCTION" name="FONCTION" value="<?php echo $FONCTION; ?>" size="28" type="text" />
      </span></td>
    </tr>
    <tr>
      <td width="9%" valign="top" bgcolor="#F9F9F9" class="componentheading" style="font-weight: bold">&nbsp;Adresse</td>
      <td width="41%" valign="top" bgcolor="#F9F9F9" class="componentheading" style="font-weight: bold">
      	<p>
      	<span class="componentheading" style="font-weight: bold">
        	<input id="ADRESSE1" name="ADRESSE1" value="<?php if (isset($val)) {echo $val['ADRESSE1'];} else if (!empty($clientProspect->id)) {echo $clientProspect->adresse1;} ?>" size="67" type="text" />
      	</span>
      	</p>
        <p>
        <span class="componentheading" style="font-weight: bold">
        	<input id="ADRESSE2" name="ADRESSE2" value="<?php if (isset($val)) {echo $val['ADRESSE2'];} else if (!empty($clientProspect->id)) {echo $clientProspect->adresse2;} ?>" size="67" type="text" />
        </span>
        </p>
        <p>CP <span class="componentheading" style="font-weight: bold">
          <input name="CP" type="text" id="CP" value="<?php if (isset($val)) {echo $val['CODE_POSTAL'];} else if (!empty($clientProspect->id)) {echo $clientProspect->codePostal;} ?>" size="6" maxlength="5" />
        </span>Ville <span class="componentheading" style="font-weight: bold">
        <input id="VILLE" name="VILLE" value="<?php if (isset($val)) {echo $val['VILLE'];} else if (!empty($clientProspect->id)) {echo $clientProspect->ville;} ?>" size="45" type="text" />
        </span></p>
      </td>
      <td valign="top" bgcolor="#F9F9F9"><p><span style="font-weight: bold">Téléphone 1</span> <span class="componentheading" style="font-weight: bold">
        <input id="TEL" name="TEL" value="<?php if (isset($val)) {echo $val['TEL_FIX'];} else if (!empty($clientProspect->id)) {echo $clientProspect->telFix;} ?>" size="17" type="text" />
        Téléphone 2 <span class="componentheading" style="font-weight: bold">
          <input id="MOB" name="MOB" value="<?php if (isset($val)) {echo $val['TEL_MOB'];} else if (!empty($clientProspect->id)) {echo $clientProspect->telMob;} ?>" size="17" type="text" />
        </span></span><br />
      </p>
        <p style="font-weight: bold">&nbsp;</p>
        <p style="font-weight: bold">Fax <span class="componentheading" style="font-weight: bold">
          <input id="FAX" name="FAX" value="<?php if (isset($val)) {echo $val['FAX'];} else if (!empty($clientProspect->id)) {echo $clientProspect->fax;} ?>" size="17" type="text" />
          </span>E-mail <span class="componentheading" style="font-weight: bold">
            <input id="MAIL" name="MAIL" value="<?php if (isset($val)) {echo $val['EMAIL'];} else if (!empty($clientProspect->id)) {echo $clientProspect->email;} ?>" size="46" type="text" />
          </span></p>        </td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#FFFFFF" class="componentheading" style="font-weight: bold">&nbsp;</td>
      <td valign="top" bgcolor="#FFFFFF" class="componentheading" style="font-weight: bold">&nbsp;</td>
      <td valign="top" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
  </tbody>
</table>
<table width="100%" border="0" cellpadding="3" cellspacing="2">
  
  
  <tr>
    <td colspan="4" bgcolor="#5289BA" class="componentheading"><span class="Style1"><strong>Ouverture du compte client</strong></span></td>
    </tr>
  <tr>
    <td valign="top" bgcolor="#EAF0F7" class="Style1"><span class="Style1" style="font-weight: bold; color: #545454">Accès <span style="font-weight: bold">aux fonctionnalités CAP BOX </span></span></td>
    <td valign="top" bgcolor="#F9F9F9"><span style="font-weight: bold">
      <input name="CATALOGUE" type="radio" id="radio" value="0" checked="checked"/>Complet<br />
      <input name="CATALOGUE" type="radio" id="radio" value="1" <?php if(!empty($val['CATALOGUE'])){ ?>checked="checked"<?php } ?>/>Partiel </span>(hors catalgogue CAP ACHAT)<br />
      <input name="CONSULT" type="checkbox" id="checkbox" <?php if(!empty($CONSULT)){ ?>checked="checked"<?php } ?>/><span style="font-weight: bold">Uniquement en consultation</span>
    </td>
    <td width="230" valign="top" bgcolor="#EAF0F7" class="Style1">
      <span style="font-weight: bold; color: #545454">Date ouverture compte</span>
    </td>
    <td width="209" valign="top" bgcolor="#F9F9F9">
      <input name="DATE1" type="text" id="DATE1" value="<?php
	if (!empty($val['DATE_CREATION']) && $val['DATE_CREATION'] != "0000-00-00") {
  		echo date("d/m/Y", strtotime($val['DATE_CREATION']));
  	} else {
  		echo date("d/m/Y");
  	} ?>" size="12" />
  	</td>
  </tr>
  <tr>
    <td width="143" valign="top" bgcolor="#EAF0F7" class="Style1"><span class="Style1" style="font-weight: bold; color: #545454">Envoyer l'e-mail des identifiants au client</span></td>
    <td width="292" valign="top" bgcolor="#F9F9F9"><p style="color: #545454">
<?php if(!empty($id)){?>
      Génère un e-mail automatique contenant :<br />
- Le nom du compte et sa date d'ouverture<br />
- Le login et le mot de passe aléatoire<br /><div align="center" id="ENVOI"><a href="#" class="readon2" style="font-weight: bold" onclick="window.open('envoi_mail.php?id=<?php echo $id;?>','','scrollbars=yes,resizable=yes,width=100,height=100')" >Renvoyer un mail</a></div>
<?php } else { ?> Lors de la création d'un nouveau client, un mail automatique lui est envoyé contenant :<br />
- le nom du compte,<br />
- le login et le mot de passe aléatoire<?php } ?>
        </p>
    </td>
    <td valign="top" bgcolor="#EAF0F7" class="Style1" style="color: #545454"><p><span style="font-weight: bold; color: #545454">Date de fermeture du compte</span></p>
      <p>(attention l'insertion d'une date ferme l'accès au compte par le client sans effacer les données)</p></td>
    <td valign="top" bgcolor="#F9F9F9" class="Style1" style="color: #545454">
    	<input name="DATE2" type="text" id="DATE2" size="12" value="<?php  if( !empty($val['DATE_FERMETURE'])) {if($val['DATE_FERMETURE']!="0000-00-00") {echo date("d/m/Y",strtotime($val['DATE_FERMETURE'])); }}   ?>"/>
    	<input type="hidden" name="hid" value="1" />
    </td>
  </tr>
  <tr>
    <td colspan="4">
    	<span style="font-weight: bold">
    		<img src="images/icones/enregistrer-page-icone-7705-32.png" width="24" height="24" align="absmiddle" />
    		<a href="javascript:;" onclick="document.frm.submit()">Sauvegarder</a>
    	</span>
    </td>
  </tr>
  <tr>
    <td colspan="4" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" bgcolor="#5289BA" class="componentheading"><span class="Style1"><strong>Bloc notes</strong></span></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#EAF0F7" class="Style1"><span style="font-weight: bold; color: #545454">Commentaires sur le suivi de ce compte client<br />
    </span></td>
    <td colspan="3" valign="top" bgcolor="#F9F9F9"><textarea name="BLOC" cols="115" rows="15" id="BLOC"><?php if (isset($val)) {echo $val['BLOC'];} else if (!empty($clientProspect->id)) {echo $clientProspect->commentaire;} ?></textarea></td>
  </tr>
  <tr>
    <td colspan="4" valign="top" bgcolor="#F9F9F9" class="Style1">
    	<span style="font-weight: bold">
	    	<img src="images/icones/enregistrer-page-icone-7705-32.png" width="24" height="24" align="absmiddle" />
	    	<a href="javascript:;" onclick="document.frm.submit()">Sauvegarder</a>
    	</span>
    </td>
    </tr>
</table>                                                      </td>
                                                    </tr><!--endprint-->
                                                    <tr >
                                                      <td colspan="8"><div align="right"></div></td>
                                                    </tr>
                                              </tbody></table></form>
                                                
                                                	
                                                    
                                              <!-- /article-content -->
                                            </div>
                                            <div class="cleared"></div>
                                    </div>
                                  <div class="cleared"></div>
                                           
                            		<div class="cleared"></div>
                          </div></div>
                        </div>
                  </div>
                </div>
                <div class="cleared"></div><div class="art-footer">
                    <div class="art-footer-inner">
                      <div class="art-footer-text">
                            <p><a href="#">Nous contacter</a> | <a href="#">Conditions d'utilisation</a> | <a href="#">Mentions légales</a>
                                | <br />
                                Copyright &copy; 2010 - Tous droits réservés</p>
                      </div>
                  </div>
                    <div class="art-footer-background"></div>
                </div>
        		<div class="cleared"></div>
            </div>
        </div>
        <div class="cleared"></div>
        <p class="art-page-footer"></p>
    </div>
</body>
</html>
