<?php 
	require("inc.php");

if(!empty($_POST['hid'])){
	$societeContact->societe->nom = $_POST['SOCIETE'];
	$societeContact->societe->adresse1 = $_POST['ADRESSE1'];
	$societeContact->societe->codePostal = $_POST['CP'];
	$societeContact->societe->ville = $_POST['VILLE'];
	$societeContact->societe->telFix = $_POST['TEL'];
	$societeContact->societe->fax = $_POST['FAX'];
	$societeContact->societe->telMob = $_POST['MOB'];
	$societeContact->societe->siteWeb = $_POST['WEB'];
	$societeContact->societe->email = $_POST['MAIL'];
	$societeContact->societe->siret = $_POST['SIRET'];
	$societeContact->societe->ape = $_POST['APE'];
	$societeContact->societe->rcs = $_POST['RCS'];
	$societeContact->societe->forme = $_POST['FORME'];
	$societeContact->societe->tvaIntra = $_POST['TVAINTRA'];
	$societeContact->societe->marge = $_POST['MARGE'];
	$societeContact->societe->refBonPrefix = $_POST['REF_BON_PREFIX'];
	$societeContact->societe->refBonIncre = $_POST['REF_BON_INCRE'];
	$societeContact->societe->refDevisPrefix = $_POST['REF_DEVIS_PREFIX'];
	$societeContact->societe->refDevisIncre = $_POST['REF_DEVIS_INCRE'];
	$societeContact->societe->refFacturePrefix = $_POST['REF_FACTURE_PREFIX'];
	$societeContact->societe->refFactureIncre = $_POST['REF_FACTURE_INCRE'];
	$societeContact->societe->refAvoirPrefix = $_POST['REF_AVOIR_PREFIX'];
	$societeContact->societe->refAvoirIncre = $_POST['REF_AVOIR_INCRE'];
	$societeContact->societe->refAcomptePrefix = $_POST['REF_ACOMPTE_PREFIX'];
	$societeContact->societe->refAcompteIncre = $_POST['REF_ACOMPTE_INCRE'];
	$societeContact->societe->delai1 = $_POST['DELAI'];
	$societeContact->societe->delai2 = $_POST['DELAI2'];
	$societeContact->societe->logo = $_POST['LOGO'];
	$societeContact->societe->piedFacture = $_POST['PIED_FACTURE'];
	$societeContact->societe->piedDevis = $_POST['PIED_DEVIS'];
	$societeContact->societe->piedBonCmd = $_POST['PIED_BON'];

	$societeContact->societe->update();

	$i ="0";
	while($i < $_POST['d_hid']){
		$inter = $_POST['INTER'.$i];
		$inter2 = $_POST['INTER_'.$i];
		
		$aSocContact = new SocieteContact();
		if (!empty($inter)) {
			$aSocContact->findById($inter);
		}
		
		$aSocContact->nom = $_POST['nom'.$i];
		$aSocContact->prenom = $_POST['prenom'.$i];
		$aSocContact->fonction = $_POST['fonction'.$i];
		$aSocContact->initiale = $_POST['initiales'.$i];
		$aSocContact->email = $_POST['mmail'.$i];
		if (empty($mmail)) {
			$aSocContact->email = $_POST['MAIL'];
		}

		if (empty($inter)) {
			$caracteres = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",0,1,2,3,4,5,6,7,8,9);
			$login = $aSocContact->nom . $aSocContact->prenom . $aSocContact->societe->id;
			$passe = "";
			for($j=0; $j<=6; $j++)
			{
				$random = array_rand($caracteres);
				$passe .= $caracteres[$random];
			}
			$message = "Bonjour $aSocContact->prenom $aSocContact->nom,\n

Nous avons le plaisir de vous informer que votre compte utilisateur vient d'être créé.\r
Veuillez trouvez ci-après votre login et mot de passe.\n
Login : $login \r
Mot de passe : $passe \n
Conservez les précieusement.\n
Si vous souhaitez les modifier, il vous suffit de vous rendre la rubrique « mon compte » du site http://www.capbox.fr\r
Pour débuter l'utilisation de l'application, rendez-vous dans la rubrique « Besoin d'aide ? », une démonstration pas à pas y est disponible.\n
Christophe LEPRETRE\r
CAP ACHAT\n
Tel : 06 88 86 13 22\r
E-mail : cap.achat@orange.fr\r
Site : www.cap-achat.com";


			if (!empty($aSocContact->nom) and !empty($aSocContact->prenom)) {
				if(empty($i)){
					$admin="1";
				}
				$aSocContact->insert();
				// $req_insert ="INSERT INTO interlocuteur(NOM,PRENOM,FONCTION,INITIALES,LOGIN,PASSWORD,MAIL,EMETTEUR,ADMIN) VALUES('" . str_replace("'", "''", $nom) . "','" . str_replace("'", "''", $prenom) . "','" . str_replace("'", "''", $fonction) . "','$nitiales','$login','md5($passe)','$mmail','$client','$admin')";
				// $req_insert ="INSERT INTO interlocuteur(NOM,PRENOM,FONCTION,INITIALES,LOGIN,PASSWORD,MAIL,EMETTEUR,ADMIN) VALUES('$nom','$prenom','$fonction','$nitiales','$login','".md5($passe)."','$mmail','$client','$admin')";

				if(!empty($aSocContact->email)){
					mail($aSocContact->email, 'Nouveau compte utilisateur', utf8_decode($message));
				}
			}
		} else {
			$aSocContact->update();
			// $req_insert ="UPDATE interlocuteur SET NOM='" . str_replace("'", "''", $nom) . "',PRENOM='" . str_replace("'", "''", $prenom) . "',FONCTION='" . str_replace("'", "''", $fonction) . "',INITIALES='$nitiales',MAIL='$mmail',EMETTEUR='$client' WHERE _ID='$inter'";
			// $req_insert ="UPDATE interlocuteur SET NOM='$nom',PRENOM='$prenom',FONCTION='$fonction',INITIALES='$nitiales',MAIL='$mmail',EMETTEUR='$client' WHERE _ID='$inter'";
		}
		// mysql_query($req_insert) or die(mysql_error());

		$i++;
	}
	$explode=explode("-",$_POST['INTER_']);
	$count=count($explode);
	for ($i=0; $i<$count; $i++) {
		if (!empty($explode[$i])) {
			$aSocContact = new SocieteContact();
			$aSocContact->findById($explode[$i]);
			$aSocContact->delete();
			//echo $explode[$i];
			//$req_del="DELETE FROM interlocuteur WHERE _ID='".$explode[$i]."'";
			//mysql_query($req_del);
		}
	}
	$dd_hid=0;

	?>
<script language="JavaScript">
 window.location='tableau.php'
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
	<script language="javascript">
	function suppr() {
	    document.getElementById('LOGO').value='';
    	document.getElementById('logo1').innerHTML='';    
	}
	
</script>
    <link rel="stylesheet" href="style.css" type="text/css"  />
    <!--[if IE 6]><link rel="stylesheet" href="style.ie6.css" type="text/css"  /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="style.ie7.css" type="text/css"  /><![endif]-->

    <script type="text/javascript" src="script.js"></script>
    <script type="text/javascript" src="script_flo3.js"></script>
    

    <style type="text/css">
<!--
.Style1 {color: #FFFFFF}
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
				<div class="art-nav">
                	<div class="l"></div>
                	<div class="r"></div>
                	<div class="art-nav-center">
                	<ul class="art-menu">
                		<li>
                			<a href="tableau.php" class="active"><span class="l"></span><span class="r"></span><span class="t">Accueil</span></a>                		</li>
                		<li>
                			<a href="parametres_2.php"><span class="l"></span><span class="r"></span><span class="t">Mon compte</span></a>                		</li>
                            <li>
                			<a href="http://capbox.fr/site/"><span class="l"></span><span class="r"></span><span class="t">Guide Utilisateur</span></a></li>
                            <li>
                			<a href="http://capbox.fr/site/index.php?option=com_content&view=article&id=46&Itemid=5"><span class="l"></span><span class="r"></span><span class="t">Questions / Réponses</span></a></li>
                      <li>
           			  <a href="http://capbox.fr/site/index.php?option=com_content&view=category&layout=blog&id=3&Itemid=50"><span class="l"></span><span class="r"></span><span class="t">Actualités</span></a></li>
                                                <li>
                			<a href="http://capbox.fr/site/index.php?option=com_content&view=article&id=54&Itemid=48"><span class="l"></span><span class="r"></span><span class="t">Contact </span></a>                		</li>
                            <li>
                			<a href="http://www.cap-achat.com" target="_blank"><span class="l"></span><span class="r"></span><span class="t">CAP ACHAT</span></a></li>
                      <li> <a href="#" onClick="doPrint()"><img src="images/icones/imprimante-icone-5571-32.png" width="24" height="24" align="absmiddle" /></a></li>
                	</ul>
                	</div>
                </div>
                                    
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
                              <h2 class="art-postheader"> <img src="images/postheadericon.png" width="26" height="26" alt="postheadericon" /> Edition de votre facture</h2>
                              <form name="frm" action="" method="post">
                          <!-- Devis en mode création-->
                          <!--devis en mode Edition-->
                          <!--div style="float: left; width: 100%"-->
                          <table width="100%">
                            <tbody>
                            </tbody>
                                                        </table>
                          <!--/div-->
                          <div>
                          <table width="100%" border="0" cellpadding="0" cellspacing="0" class="art-article">
                                            <tbody>
													<tr >
                                                      <td align="center"  width="12%" ><?php  $rurl="/capbox_test/tableau.php"; urld($rurl); ?><img src="images/icones/diagramme-a-barres-icone-9116-32.png" align="center"  width="32" height="32" /><br />
                                                      Tableau de Bord <?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center"  width="10%" ><?php $rurl="/capbox_test/contact_liste.php"; urld($rurl); ?><img src="images/icones/satisfaire-vos-icone-4079-32.png" align="center"  width="32" height="32" /><br />
                                                      Contacts<?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center"  width="9%" ><?php $rurl="/capbox_test/devis_liste.php"; urld($rurl); ?><img src="images/icones/calculateur-de-modifier-icone-5292-32.png" align="center"  width="32" height="32" /><br />
													  Devis<?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center"  width="10%" > <?php $rurl="/capbox_test/facture_liste.php"; urld($rurl); ?><img src="images/icones/pieces-de-monnaie-icone-6896-32.png" align="center"  width="32" height="32" /><br />
                                                      Factures<?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center" width="9%" ><?php $rurl="/capbox_test/acompte_liste.php"; urld($rurl); ?><img src="images/icones/police-icone-9426-32.png" align="center" width="32" height="32" /><br />
                                                      Acomptes<?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center" width="9%"> <?php $rurl="/capbox_test/avoir_liste.php"; urld($rurl); ?><img src="images/icones/police-icone-9426-32.png" align="center" width="32" height="32" /><br />
                                                      Avoirs<?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center"  width="9%" ><?php $rurl="/capbox_test/bon_liste.php"; urld($rurl); ?><img src="images/icones/blanc-page-de-pile-icone-6477-32.png" align="center"  width="32" height="32" /><br />
                                                      Bons<?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center"  width="10%" ><?php $rurl="/capbox_test/catalogue_liste.php"; urld($rurl); ?><img src="images/icones/livre-icone-9855-32.png" align="center"  width="32" height="32" /><br />
                                                      Catalogues<?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center"  width="11%" ><?php $rurl="/capbox_test/parametres.php"; urld($rurl); ?><img src="images/icones/script-engins-icone-6029-32.png" align="center"  width="32" height="32" /><br />
                                                      Paramètres<?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center"  width="11%"><?php $rurl="/capbox_test/index.php?action=logout"; urld($rurl); ?><img src="images/icones/porte-en-icone-7778-32.png" align="center"  width="32" height="32" /><br />
                                                      Déconnexion<?php echo $fin_url; ?>
                                                      </td>
                                                    </tr>
                                              <tr>
                                                <td colspan="10"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td><!-- Periode de recherche -->
            <!-- Periode de recherche -->
            <div>
<table width="100%">
  <tbody>
    <tr>
      <td width="100%" height="32" background="images/fd_nav_ss_menu.png" bgcolor="#F0F0F0" class="componentheading"><span style="font-weight: bold"><img src="images/icones/enregistrer-page-icone-7705-32.png" width="24" height="24" align="absmiddle" /><a href="javascript:;" onClick="document.frm.submit()">Sauvegarder </a><img src="images/menuseparator.png" width="1" height="24" align="absmiddle" /> </span></td>
      </tr>
  </tbody>
</table>                                                  
                          
  <table width="100%" border="0" cellpadding="3" cellspacing="2" name="frmm" id="frmm">
    <tr>
      <td colspan="4" bgcolor="#F9F9F9"><p><strong><img src="images/icones/asterisque-orange-icone-5289-32.png" width="32" height="32" align="left" /> Important :</strong><strong> Ceci est l' espace de paramèrage de votre compte.<br />
        </strong><strong>Il est important de bien remplir ce formulaire afin d'avoir des documents établis en bonne et dû forme.</strong> 
        <input type="hidden" name="hid" id="hid" value="1" />
      </p>      </td>
      </tr>
 <?php

// $select=mysql_query("select * from societe_contact where _ID = " . $societeContact->societe->id);
// $val=mysql_fetch_array($select);

 ?>  <!--startprint--> 
    <tr>
      <td colspan="4" bgcolor="#5289BA" class="componentheading"><span class="Style1"><strong>Identité de l'entreprise</strong></span></td>
      </tr>
    <tr>
      <td width="140" valign="top" bgcolor="#EAF0F7" class="Style1"><span style="font-weight: bold; color: #545454">Raison sociale</span></td>
      <td width="282" valign="top" bgcolor="#F9F9F9"><input name="SOCIETE" type="text" id="SOCIETE" value="<?php echo $societeContact->societe->nom; ?>" size="50" /></td>
      <td width="156" valign="top" bgcolor="#EAF0F7" class="Style1"><span style="font-weight: bold; color: #545454">Téléphone principal</span></td>
      <td width="230" valign="top" bgcolor="#F9F9F9"><input name="TEL" type="text" id="TEL" value="<?php echo wordwrap ($societeContact->societe->telFix, 2, ' ', 1); ?>" /></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EAF0F7" class="Style1"><span class="Style1" style="font-weight: bold; color: #545454">Adresse</span></td>
      <td valign="top" bgcolor="#F9F9F9"><textarea name="ADRESSE1" cols="50" rows="3" id="ADRESSE1"><?php echo $societeContact->societe->adresse1; ?></textarea></td>
      <td valign="top" bgcolor="#EAF0F7" class="Style1"><span style="font-weight: bold; color: #545454">Mobile</span></td>
      <td valign="top" bgcolor="#F9F9F9"><input name="MOB" type="text" id="MOB" value="<?php echo wordwrap ($societeContact->societe->telMob, 2, ' ', 1); ?>" /></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EAF0F7" class="Style1"><span class="Style1" style="font-weight: bold; color: #545454">Code postal / Ville</span></td>
      <td valign="top" bgcolor="#F9F9F9"><input name="CP" type="text" id="CP" value="<?php echo $societeContact->societe->codePostal; ?>" size="6" />
        <input name="VILLE" type="text" id="VILLE" value="<?php echo $societeContact->societe->ville; ?>" size="40" /></td>
      <td valign="top" bgcolor="#EAF0F7" class="Style1"><span style="font-weight: bold; color: #545454">Fax</span></td>
      <td valign="top" bgcolor="#F9F9F9"><input name="FAX" type="text" id="FAX" value="<?php echo wordwrap ($societeContact->societe->fax, 2, ' ', 1); ?>" /></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EAF0F7" class="Style1"><span class="Style1" style="font-weight: bold; color: #545454">SIRET</span></td>
      <td valign="top" bgcolor="#F9F9F9"><input name="SIRET" type="text" id="SIRET" value="<?php echo $societeContact->societe->siret; ?>" size="20" /> 
        APE 
        <input name="APE" type="text" id="APE" value="<?php echo $societeContact->societe->ape; ?>" size="6" /></td>
      <td valign="top" bgcolor="#EAF0F7" class="Style1"><span style="font-weight: bold; color: #545454">Site web</span></td>
      <td valign="top" bgcolor="#F9F9F9"><input name="WEB" type="text" id="WEB" value="<?php echo $societeContact->societe->siteWeb; ?>" size="35" /></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EAF0F7" class="Style1"><span class="Style1" style="font-weight: bold; color: #545454">RCS / RM</span></td>
      <td valign="top" bgcolor="#F9F9F9"><p>
        <input name="RCS" type="text" id="RCS" value="<?php echo $societeContact->societe->rcs; ?>" size="20" />
        </p>
        <p><strong>Artisan</strong> : saisir votre n° RM si vous en avez un, précédé des lettres RM. <br />
          <strong>Commerçant</strong> : saisir votre n° RCS si vous en avez un, précédé des lettres                  RCS. </p></td>
      <td valign="top" bgcolor="#EAF0F7" class="Style1"><span style="font-weight: bold; color: #545454">E-mail</span></td>
      <td valign="top" bgcolor="#F9F9F9"><input name="MAIL" type="text" id="MAIL" value="<?php echo $societeContact->societe->email; ?>" size="35" /></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EAF0F7" class="Style1"><span class="Style1" style="font-weight: bold; color: #545454">Forme sociale</span></td>
      <td colspan="3" valign="top" bgcolor="#F9F9F9"><input name="FORME" type="text" id="FORME" value="<?php echo $societeContact->societe->forme; ?>" size="120" /></td>
      </tr>
    <tr>
      <td valign="top" bgcolor="#EAF0F7" class="Style1"><span class="Style1" style="font-weight: bold; color: #545454">TVA </span><span style="font-weight: bold; color: #545454">intra</span></td>
      <td valign="top" bgcolor="#F9F9F9"><input name="TVAINTRA" type="text" id="TVAINTRA" value="<?php echo $societeContact->societe->tvaIntra; ?>" /></td>
      <td valign="top" bgcolor="#EAF0F7" class="Style1"><span class="Style1" style="font-weight: bold; color: #545454"></span></td>
      <td valign="top" bgcolor="#F9F9F9"></td>
    </tr>
    <tr>
      <td colspan="4"><span style="font-weight: bold"><img src="images/icones/enregistrer-page-icone-7705-32.png" width="24" height="24" align="absmiddle" /><a href="javascript:;" onclick="document.frm.submit()">Sauvegarder</a></span></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#5289BA" class="componentheading"><span class="Style1"><strong>Présentation des devis et factures</strong></span></td>
    </tr>
    <?php 
	if(empty($societeContact->societe->catalogue)){
	?>
    <tr>
      <td valign="top" bgcolor="#EAF0F7" class="Style1"><span style="font-weight: bold; color: #545454">Taux de marge<br />
        <span style="color: #FF0000"></span></span></td>
      <td colspan="3" valign="top" bgcolor="#F9F9F9">
        <input name="MARGE" type="text" id="MARGE" value="<?php echo $societeContact->societe->marge; ?>" size="6" />
        % Ce taux s'appliquera automatiquement au prix d'achat de vos catalogues, mais chaque article reste modifiable manuellement au moment de la création du devis.
        <p><strong>Exemple</strong> : un article acheté <strong>15,00 € HT</strong> auquel on applique un taux de marge de<strong> 30 %</strong> aura un prix de vente de : <strong>19,50 € HT</strong></p>
      </td>
    </tr><?php } ?>
    <tr>
      <td valign="top" bgcolor="#EAF0F7" class="Style1"><span style="font-weight: bold; color: #545454">Délai de validité des devis</span></td>
      <td valign="top" bgcolor="#F9F9F9"><input name="DELAI" type="text" id="DELAI" value="<?php echo $societeContact->societe->delai1; ?>" size="30" /></td>
      <td valign="top" bgcolor="#EAF0F7" class="Style1"><span style="font-weight: bold; color: #545454">Délais de paiement des factures</span></td>
      <td valign="top" bgcolor="#F9F9F9"><input name="DELAI2" type="text" id="DELAI2" value="<?php echo $societeContact->societe->delai2; ?>" size="30" /></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EAF0F7" class="Style1" colspan="4"><span style="font-weight: bold; color: #545454">Initilisation des références</span></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EAF0F7" class="Style1">
      	<span style="font-weight: bold; color: #545454">Bon de commande : </span>
      </td>
      <td valign="top" bgcolor="#F9F9F9">
      	<span>Préfix : </span>
      	<input name="REF_BON_PREFIX" type="text" id="REF_BON_PREFIX" value="<?php echo $societeContact->societe->refBonPrefix; ?>" size="7" />
      	<span>Incrément : </span>
      	<input name="REF_BON_INCRE" type="text" id="REF_BON_INCRE" value="<?php echo $societeContact->societe->refBonIncre; ?>" size="7" /><br/>
      	<span>Ex : (BONxxx_1000)</span>
      </td>
      <td valign="top" bgcolor="#EAF0F7" class="Style1">
      	<span style="font-weight: bold; color: #545454">Devis : </span>
      </td>
      <td valign="top" bgcolor="#F9F9F9">
      	<span>Préfix : </span>
      	<input name="REF_DEVIS_PREFIX" type="text" id="REF_DEVIS_PREFIX" value="<?php echo $societeContact->societe->refDevisPrefix; ?>" size="7" />
      	<span>Incrément : </span>
      	<input name="REF_DEVIS_INCRE" type="text" id="REF_DEVIS_INCRE" value="<?php echo $societeContact->societe->refDevisIncre; ?>" size="7" /><br/>
      	<span>Ex : (DEVxxx_1000) </span>
      </td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EAF0F7" class="Style1">
      	<span style="font-weight: bold; color: #545454">Facture : </span>
      </td>
      <td valign="top" bgcolor="#F9F9F9">
      	<span>Préfix : </span>
      	<input name="REF_FACTURE_PREFIX" type="text" id="REF_FACTURE_PREFIX" value="<?php echo $societeContact->societe->refFacturePrefix; ?>" size="7" />
      	<span>Incrément : </span>
      	<input name="REF_FACTURE_INCRE" type="text" id="REF_FACTURE_INCRE" value="<?php echo $societeContact->societe->refFactureIncre; ?>" size="7" /><br/>
      	<span>Ex : (FACxxx_1000)</span>
      </td>
      <td valign="top" bgcolor="#EAF0F7" class="Style1">
      	<span style="font-weight: bold; color: #545454">Avoir : </span>
      </td>
      <td valign="top" bgcolor="#F9F9F9">
      	<span>Préfix : </span>
      	<input name="REF_AVOIR_PREFIX" type="text" id="REF_AVOIR_PREFIX" value="<?php echo $societeContact->societe->refAvoirPrefix; ?>" size="7" />
      	<span>Incrément : </span>
      	<input name="REF_AVOIR_INCRE" type="text" id="REF_AVOIR_INCRE" value="<?php echo $societeContact->societe->refAvoirIncre; ?>" size="7" /><br/>
      	<span>Ex : (AVOxxx_1000) </span>
      </td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EAF0F7" class="Style1">
      	<span style="font-weight: bold; color: #545454">Acompte : </span>
      </td>
      <td valign="top" bgcolor="#F9F9F9">
      	<span>Préfix : </span>
      	<input name="REF_ACOMPTE_PREFIX" type="text" id="REF_ACOMPTE_PREFIX" value="<?php echo $societeContact->societe->refAcomptePrefix; ?>" size="7" />
      	<span>Incrément : </span>
      	<input name="REF_ACOMPTE_INCRE" type="text" id="REF_ACOMPTE_INCRE" value="<?php echo $societeContact->societe->refAcompteIncre; ?>" size="7" /><br/>
      	<span>Ex : (ACOxxx_1000)</span>
      </td>
      <td colspan="2"/>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EAF0F7" class="Style1"><span style="font-weight: bold; color: #545454">Logo</span></td>
      <td valign="top" bgcolor="#F9F9F9"><div id="logo1"><img src="images/logos/<?php echo $societeContact->societe->logo; ?>" align="absmiddle" /></div><input type="hidden" id="LOGO" name="LOGO" value="<?php echo $societeContact->societe->logo; ?>"/><div style="display:inline"><a href="javascript:;" class="readon2" style="font-weight: bold" onClick="window.open('logo.php','','scrollbars=yes,resizable=yes,width=400,height=200')" >Modifier l'image</a></div> 
        | <a href="javascript:;" class="readon2" style="font-weight: bold" onClick="suppr();">supprimer l'image</a>       </td>
      <td colspan="2" valign="top" bgcolor="#F9F9F9"><p><strong>Format JPG</strong></p></td>
    </tr>
     </tr>
     <tr>
      <td valign="top" bgcolor="#EAF0F7" class="Style1"><span style="font-weight: bold; color: #545454">Logos bas de page</span></td>
      <td valign="top" bgcolor="#F9F9F9"><div id="logo1"></div><div style="display:inline"><a href="javascript:;" class="readon2" style="font-weight: bold" onClick="window.open('logo_bas_de_page.php','','scrollbars=yes,resizable=yes,width=400,height=200')" >Gérer les images</a></div> 
      </td>
      <td colspan="2" valign="top" bgcolor="#F9F9F9"><p><strong>Format JPG</strong></p></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EAF0F7" class="Style1"><span style="font-weight: bold; color: #545454">Mentions particulières devant figurer en pied de page de vos devis.</span></td>
      <td colspan="3" valign="top" bgcolor="#F9F9F9"><textarea name="PIED_DEVIS" cols="115" rows="3" id="PIED_DEVIS"><?php echo $societeContact->societe->piedDevis; ?></textarea></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EAF0F7" class="Style1"><span style="font-weight: bold; color: #545454">Mentions particulières devant figurer en pied de page de vos factures.</span></td>
      <td colspan="3" valign="top" bgcolor="#F9F9F9"><textarea name="PIED_FACTURE" cols="115" rows="3" id="PIED_FACTURE"><?php echo $societeContact->societe->piedFacture; ?></textarea></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EAF0F7" class="Style1"><span style="font-weight: bold; color: #545454">Mentions particulières devant figurer en pied de page de vos bons de commande.</span></td>
      <td colspan="3" valign="top" bgcolor="#F9F9F9"><textarea name="PIED_BON" cols="115" rows="3" id="PIED_BON"><?php echo $societeContact->societe->piedBonCmd; ?></textarea></td>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="3" cellspacing="2">
    <tr>
      <td colspan="6"><span style="font-weight: bold"><img src="images/icones/enregistrer-page-icone-7705-32.png" width="24" height="24" align="absmiddle" /><a href="javascript:;" onClick="document.frm.submit()">Sauvegarder</a></span></td>
                </tr>
    <tr>
      <td colspan="6" bgcolor="#5289BA" class="componentheading"><span class="Style1"><strong>Interlocuteurs - Affaire suivie par </strong></span></td>
                </tr>
    
    <tr>
      <td colspan="6" valign="top" bgcolor="#EAF0F7" class="Style1">
      <table name="tableArticle" id="tableArticle" width="100%" cellpadding="0" cellspacing="0">
      		<tr>
                  <td width="89"  bgcolor="#EAF0F7" class="Style1"><span style="font-weight: bold; color: #545454">Prénom / Nom</span></td>
                  <td width="326"  bgcolor="#F9F9F9">
                  <select title="Sélectionner une civilité en déroulant cette liste." name="INTITULE0" id="INTITULE0">
          <option selected="selected" value="1">M.</option>
          <option value="2" >Mme</option>
          <option value="3" >Melle</option>
          <option value="4">M. et Mme</option>
                </select>
                <input name="prenom0" type="text" id="prenom0" value=" " size="15" />
                <input name="nom0" type="text" id="nom0" value="" size="20" />
                  </td>
                  <td width="61" bgcolor="#EAF0F7" class="Style1"><span style="font-weight: bold; color: #545454">Fonction</span></td>
                  <td width="131"  bgcolor="#F9F9F9"><input name="fonction0" type="text" id="fonction0" value="" size="20" /></td>
                  <td width="34"  bgcolor="#EAF0F7"><span style="font-weight: bold; color: #545454"> Mail</span></td>
                  <td width="113"  bgcolor="#F9F9F9"><input name="mmail0" type="text" id="mmail0" value="" size="15" /></td>
                  <td width="107"  bgcolor="#F9F9F9"><span style="font-weight: bold; color: #545454">Initiales</span>
                    <input name="initiales0" type="text" id="initiales0" value="" size="2" />
                    <input type="hidden" id="INTER0" name="INTER0"/>
                    <input type="hidden" id="INTER_0" name="INTER_0"/>
                  </td>
                  <td width="33" bgcolor="#F9F9F9"></td>
                </tr>
      </table></td>
      </tr>
    
    <tr>
      <td width="2730" colspan="5" valign="top" bgcolor="#F9F9F9"><a href="javascript:;" onclick="ajoutLigne()"><img src="images/icones/ajouter-crayon-icone-4828-32.png" width="32" height="32" align="absmiddle" />  Ajouter un nouvel interlocuteur</a></td>
                  <td width="661" valign="top" bgcolor="#F9F9F9">
                  <input type="hidden" id="d_hid" name="d_hid" value="1"/>
                  <input type="hidden" id="INTER_" name="INTER_" />
                  <?php
				  $sel=mysql_query("select soco.* from societe_contact soco, utilisateur util where soco.LOGIN = util.LOGIN and soco.ID_SOCIETE = " . $societeContact->societe->id . " order by util.CODE_ROLE DESC, soco._ID");
				  $i="0";
				  while ($va=mysql_fetch_array($sel)) {
					  $INTER=$va['_ID'];
					  $aprenom=mysql_real_escape_string($va['PRENOM']);
					  $anom=mysql_real_escape_string($va['NOM']);
					  $afonction=mysql_real_escape_string($va['FONCTION']);
					  $ainitiales=$va['INITIALE'];
					  $amail=$va['EMAIL'];
					  $civilite=$va['CIVILITE'];
					  echo "<script language=\"javascript\">";
					  if(!empty($i)){
						  echo"ajoutLigne('$i');";
					  }
					  echo"remplis('$i','$anom','$aprenom','$afonction','$ainitiales','$amail','$civilite','$INTER');</script>";
					  $i++;
				  }
				  ?></td>
                </tr>
    <tr>
      <td colspan="5" valign="top"><span style="font-weight: bold"><img src="images/icones/enregistrer-page-icone-7705-32.png" width="24" height="24" align="absmiddle" /><a href="javascript:;" onClick="document.frm.submit()">Sauvegarder</a></span></td>
                  <td valign="top">&nbsp;</td>
                </tr>
    </table>
              </div><!--endprint-->
                            <!-- /Periode de recherche -->
                            <!-- /Periode de recherche -->        </td>
                            </tr>
                                                    
                            <tr>
                              <td><!-- Liste des pieces -->            </td>
        </tr>
                                                    
                            </table></td>
                                                    </tr>
                                                    <tr >
                                                      <td colspan="8"><div align="right"></div></td>
                                                      </tr>
                                                    </tbody></table>
                                        
                          </div>
                          <div id="tableInitialeE">
                                                    
                            <!-- Pied document -->
                                                    
                            <!-- /Pied document -->
                            <!-- boutons -->
                                                                      </div>
                          </form>
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
