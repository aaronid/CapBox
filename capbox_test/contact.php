<?php 
	require("business/bon.php");
	require("business/devis.php");
	require("business/facture.php");
	require("inc.php"); 
	
	$id = "";
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	}

	if (!empty($_POST)) {
		$societeClient = new SocieteClient();
		$societeClient->idSociete = $societeContact->societe->id;
		$societeClient->refClient = $_POST['REF_CLIENT'];
		$societeClient->civilite = $_POST['INTITULE'];
		$societeClient->nom = $_POST['NOM'];
		$societeClient->prenom = $_POST['PRENOM'];
		$societeClient->entreprise = $_POST['SOCIETE'];
		$societeClient->adresse1 = $_POST['ADRESSE1'];
		$societeClient->adresse2 = $_POST['ADRESSE2'];
		$societeClient->codePostal = $_POST['CP'];
		$societeClient->ville = $_POST['VILLE'];
		$societeClient->telFix = $_POST['TEL'];
		$societeClient->telMob = $_POST['MOB'];
		$societeClient->fax = $_POST['FAX'];
		$societeClient->email = $_POST['MAIL'];
		$societeClient->type = $_POST['TYPE'];
		$societeClient->fonction = $_POST['FONCTION'];
		$societeClient->commentaire = $_POST['commentaire'];
		
		if (!empty($id)) {
			$societeClient->id = $id;
			$societeClient->update();
		} else {
			$societeClient->insert();
		}
		header("Location: contact_liste.php");
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

    <link rel="stylesheet" href="style.css" type="text/css" />
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
                                                Edition de votre contact</h2>
                                            <div class="art-postcontent">
                                                <!-- article-content -->
                                               
                                                
                                                
                                                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="art-article">
                                                  <tbody>
                                                    <?php 
													require("turl.php");
													?>
                                                    <tr>
                                                      <td colspan="10">
                                                      <?php 
                	                                      $theSocCli = new SocieteClient();
                	                                      if (!empty($id)) {
            	                                          	$theSocCli->findByLogin($id);
                	                                      }
													  ?>
                                                      
                                                      <form action="?id=<?php echo $theSocCli->id; ?>" method="post" name="frm" id="frm"><table width="100%">
  <tbody>
    <tr>
      <td height="32" colspan="3" background="images/fd_nav_ss_menu.png" bgcolor="#F0F0F0" class="componentheading"><span style="font-weight: bold"><a href="#" onClick="document.frm.submit()"><img src="images/icones/enregistrer-page-icone-7705-32.png" width="24" height="24" align="absmiddle" />Sauvegarder </a><img src="images/menuseparator.png" width="1" height="24" align="absmiddle" />  <?php if(!empty($id)){ ?><a href="devis.php?contact=<?php echo $id;?>"><img src="images/icones/ajouter-une-page-blanche-icone-9840-32.png" alt="" width="24" height="24" align="absmiddle" />Créer un nouveau devis </a><img src="images/menuseparator.png" width="1" height="24" align="absmiddle" /><?php } ?>  <a href="#" onClick="document.frm.reset();"><img src="images/icones/supprimer-la-page-icone-9859-32.png" width="24" height="24" align="absmiddle" />Effacer la saisie en cours</a> <img src="images/menuseparator.png" width="1" height="24" align="absmiddle" />  <a href="contact_liste.php">
      <img src="images/icones/demande-afficher-la-liste-icone-8709-32.png" width="24" height="24" align="absmiddle" /> Retour à la liste des contacts</a></span></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F9F9F9" class="componentheading">&nbsp;</td>
      <td width="50%" align="right" bgcolor="#F9F9F9">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F9F9F9" class="componentheading" style="font-weight: bold">
        <p><span style="font-weight: bold">Référence</span>
        <span class="componentheading" style="font-weight: bold">
        <input name="REF_CLIENT" value="<?php echo $theSocCli->refClient;?>" size="28" type="text" />
        </span></p>
      	<p><span>Nom / Prénom</span> 
        <select title="Sélectionner une civilité en déroulant cette liste." name="INTITULE">
          <option <?php if($theSocCli->civilite == 'M.'){ echo"selected=\"selected\""; } ?> value="M.">M.</option>
          <option <?php if($theSocCli->civilite == 'Mme'){ echo"selected=\"selected\""; }?>value="Mme">Mme</option>
          <option <?php if($theSocCli->civilite == 'Melle'){ echo"selected=\"selected\""; }?>value="Melle">Melle</option>
          <option <?php if($theSocCli->civilite == 'M. et Mme'){ echo"selected=\"selected\""; }?>value="M. et Mme">M. et Mme</option>
                </select>
        <input title="Saisir votre nom (* cette valeur est obligatoire)."  name="NOM" value="<?php echo $theSocCli->nom;?>" size="25" maxlength="35" type="text" />
        <input title="Saisir votre prénom (* cette valeur est obligatoire)."  name="PRENOM" value="<?php echo $theSocCli->prenom;?>" size="20" type="text" /></p>
      </td>
      <td bgcolor="#F9F9F9">
        <p><span style="font-weight: bold">Société</span>
        <span class="componentheading" style="font-weight: bold">
        <input title="Saisir votre nom d'entreprise (* cette valeur est obligatoire)."  name="SOCIETE" value="<?php echo $theSocCli->entreprise;?>" size="28" type="text" />
        </span></p>
        <p><span style="font-weight: bold">Fonction</span>
        <span class="componentheading" style="font-weight: bold">
        <input title="Saisir votre fonction (* cette valeur est obligatoire)."  name="FONCTION" value="<?php echo $theSocCli->fonction;?>" size="28" type="text" />
        </span></p>
      </td>
    </tr>
    <tr>
      <td width="9%" valign="top" bgcolor="#F9F9F9" class="componentheading" style="font-weight: bold">
      	<p>Adresse</p>
        <p>&nbsp;</p>
      </td>
      <td width="41%" valign="top" bgcolor="#F9F9F9" class="componentheading" style="font-weight: bold">
      	<p><span class="componentheading" style="font-weight: bold">
        <input name="ADRESSE1" value="<?php echo $theSocCli->adresse1;?>" size="67" type="text" />
      	</span></p>
        <p><span class="componentheading" style="font-weight: bold">
        <input  name="ADRESSE2" value="<?php echo $theSocCli->adresse2;?>" size="67" type="text" />
        </span></p>
        <p>CP <span class="componentheading" style="font-weight: bold">
        <input name="CP" type="text" title="Saisir le code postal." value="<?php echo $theSocCli->codePostal;?>" size="6" maxlength="5" />
        </span>Ville <span class="componentheading" style="font-weight: bold">
        <input title="Saisir la ville." name="VILLE" value="<?php echo $theSocCli->ville;?>" size="45" type="text" />
        </span></p></td>
      <td valign="top" bgcolor="#F9F9F9">
      	<p><span style="font-weight: bold">Téléphone 1</span>
      	<span class="componentheading" style="font-weight: bold">
        <input title="Saisir le téléphone (* cette valeur est obligatoire)."  name="TEL" value="<?php echo $theSocCli->telFix;?>" size="17" type="text" />
        </span></p>
        <p><span style="font-weight: bold">Téléphone 2</span>
        <span class="componentheading" style="font-weight: bold">
        <input name="MOB" value="<?php echo $theSocCli->telMob;?>" size="17" type="text" />
        </span></p>
        <p style="font-weight: bold">
        <span style="font-weight: bold">Fax</span>
        <span class="componentheading" style="font-weight: bold">
        <input name="FAX" value="<?php echo $theSocCli->fax;?>" size="17" type="text" />
        </span></p>
        <p><span style="font-weight: bold">E-mail</span>
        <span class="componentheading" style="font-weight: bold">
        <input name="MAIL" value="<?php echo $theSocCli->email;?>" size="46" type="text" />
        </span></p>
        <p style="font-weight: bold">Statut de ce contact 
          <input type="radio" name="TYPE" value="1" <?php if($theSocCli->type == 1){ echo"checked "; }?>/>
        Client 
        <input type="radio" name="TYPE" value="2" <?php if($theSocCli->type == 2){ echo"checked "; } ?>/>
		Fournisseur
        <input type="radio" name="TYPE" value="3" <?php if($theSocCli->type == 3){ echo"checked "; } ?>/>
		Prospect
		</p></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#F9F9F9" class="componentheading" style="font-weight: bold">Commentaires</td>
      <td colspan="2" valign="top" bgcolor="#F9F9F9" class="componentheading" style="font-weight: bold"><textarea title="Saisir un commentaire)." id="commentaire" name="commentaire" cols="85" rows="5" tabindex="11"><?php echo $theSocCli->commentaire; ?></textarea></td>
      </tr>
  </tbody>
</table>
    <input type="hidden" name="hid" value="1" />
</form>


<?php
	if (!empty($id)) {
?>
	<table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td>
            <div id="listePiece">
              <center id="tableauListe">
				<h2>Historique des prospections</h2>
				<a href="" onclick="window.open('contact_prospect_pop.php?id=&idSocClient=<?php echo $id; ?>','','scrollbars=yes,resizable=yes,width=800,height=500')"><span>Ajouter une prospection</span></a>
                <table width="100%">
                  <!-- Entete du tableau -->
                  <tbody>
                    <tr style="background-color:#5289BA">
                      <td width="5%" bgcolor="#5289BA"><p align="left" class="Style7" style="font-size: 11px"></p></td>
                      <td width="15%" bgcolor="#5289BA"><p align="left" class="Style7" style="font-size: 11px">Appel</p></td>
                      <td width="15%" bgcolor="#5289BA"><p align="left" class="Style7" style="font-size: 11px">Rendez-vous</p></td>
                      <td width="15%" bgcolor="#5289BA"><p align="left" class="Style7" style="font-size: 11px">Relance</p></td>
                      <td width="50%" bgcolor="#5289BA"><p align="left" class="Style7" style="font-size: 11px">Commentaire</p></td>
                      <!--th class="data-table">                    Acompte                </th-->
                    </tr>
<?php
	if (!empty($theSocCli->clientsProspect)) {
		foreach ($theSocCli->clientsProspect as $theSocCliPros) {
?>
                    <tr>
                      <td bgcolor="#EAF0F7"><div align="left"><a href="" onclick="window.open('contact_prospect_pop.php?id=<?php echo $theSocCliPros->id; ?>&idSocClient=<?php echo $id; ?>','','scrollbars=yes,resizable=yes,width=800,height=500')"><img src="images/icones/editer_16.png" alt="Modifier" width="16" height="16" title="Modifier" /></a></div></td>
                      <td align="left" bgcolor="#EAF0F7"><div align="left" class="Style4" style="font-size: 11px"><?php echo $theSocCliPros->appel; ?></div></td>
                      <td align="left" bgcolor="#EAF0F7"><div align="left" class="Style4" style="font-size: 11px"><?php echo $theSocCliPros->rdv; ?></div></td>
                      <td align="left" bgcolor="#EAF0F7"><div align="left" class="Style4" style="font-size: 11px"><?php echo $theSocCliPros->relance; ?></div></td>
                      <td align="left" bgcolor="#EAF0F7"><div align="left" class="Style4" style="font-size: 11px"><?php echo $theSocCliPros->commentaire; ?></div></td>
                    </tr>
<?php
		}
	}
?>
                    <tr>
                      <td height="2" colspan="5" bgcolor="#5289BA"></td>
                    </tr>
                  </tbody>
                </table>
<?php
	if($theSocCli->type != 3){
?>
				<h2><img src="images/icones/calculator-icone-9138-32.png" width="32" height="32" align="absmiddle" />Historique des devis en cours</h2>
                <table width="100%">
                  <!-- Entete du tableau -->
                  <tbody>
                    <tr style="background-color:#5289BA">
                      <td width="15%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Ref</p> </td>
                      <td width="47%" bgcolor="#5289BA"> <p align="center" class="Style7" style="font-size: 11px">Intitulé du devis</p>                      </td>
                      <td width="13%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Date de création</p>                      </td>
                      <td width="16%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Montant HT</p> </td>
                      <td width="9%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Consulter</p>                      </td>
                      <!--th class="data-table">                    Acompte                </th-->
                    </tr>
                    <!-- /Entete du tableau -->
                    <!-- Corps du tableau -->
                    <?php 
					$totalHT = 0.0; 
					$nbElements = 0; 
                    $devisTab = Devis::findByDestinataireEmetteur($id, $theSocCli->idSociete);					
					foreach ($devisTab as $devis) {
						$nbElements += 1;
					?>
                    <tr>
                      <td bgcolor="#EAF0F7"><div align="center"><?php echo $devis->reference; ?></div></td>
                      <td align="right" bgcolor="#EAF0F7"><div align="center" class="Style4" style="font-size: 11px">
                        <div align="left"><?php echo $devis->titre; ?></div>
                      </div></td>
                      <td align="left" bgcolor="#EAF0F7"><div align="center" class="Style4" style="font-size: 11px"><?php $d=$devis->dateEmission; echo date("d/m/Y",strtotime($d)); ?></div></td>
                      <td align="left" bgcolor="#EAF0F7"><div align="right"><?php echo $devis->getHTPriceRemiseFormat(); ?></div></td>
                      <td align="left" bgcolor="#EAF0F7"><div align="center" class="Style4" style="font-size: 11px"><?php if(empty($devis->validation)){?><a href="devis.php?id=<?php echo $devis->id; ?>"><img src="images/icones/editer_16.png" alt="Modifier" name="imgModifier2" width="16" height="16" id="imgModifier2" title="Modifier" /></a><?php }else{ ?><a href="devis_pdf.php?id=<?php echo $devis->id; ?>" target="_blank"><img alt="Imprimer" id="imgPDF3" src="images/icones/imprimante-icone-5571-16.png" title="Imprimer" width="16" height="16" /></a> <?php }?></div></td>
                    </tr>
                    <?php 
						$totalHT += $devis->getHTPriceRemise();
					}
					?>                   
                    <tr>
                      <td height="2" colspan="5" bgcolor="#5289BA"></td>
                      </tr>
                    <tr>
                      <td bgcolor="#EAF0F7">&nbsp;</td>
                      <td align="right" bgcolor="#EAF0F7"><span style="font-weight: bold">Total devis réalisés</span></td>
                      <td align="left" bgcolor="#EAF0F7"><div align="center" style="font-weight: bold"><?php echo $nbElements; ?></div></td>
                      <td align="left" bgcolor="#EAF0F7"><div align="right" style="font-weight: bold"><?php echo number_format($totalHT, 2, ',', ' '); ?></div></td>
                      <td align="left" bgcolor="#EAF0F7">&nbsp;</td>
                    </tr>
                  </tbody>
                </table>
                <h2><img src="images/icones/pieces-de-monnaie-icone-6896-32.png" width="32" height="32" align="absmiddle" /> Historique des factures</h2>
                <table width="100%">
                  <!-- Entete du tableau -->
                  <tbody>
                    <tr>
                      <td width="15%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Ref</p></td>
                      <td width="47%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Intitulé de la facture</p></td>
                      <td width="13%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Date de création</p></td>
                      <td width="16%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Montant HT</p></td>
                      <td width="9%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Consulter</p></td>
                      <!--th class="data-table">                    Acompte                </th-->
                    </tr>
                    <!-- /Entete du tableau -->
                    <!-- Corps du tableau -->                    
                    <?php 
					$totalHT = 0.0; 
					$nbElements = 0; 
                    $factureTab = Facture::findByDestinataireEmetteur($id, $theSocCli->idSociete);					
					foreach ($factureTab as $facture) {
						$nbElements += 1;
					?>
                    <tr>
                      <td bgcolor="#EAF0F7"><div align="center"><?php echo $facture->reference; ?></div></td>
                      <td align="right" bgcolor="#EAF0F7"><div align="center" class="Style4" style="font-size: 11px">
                        <div align="left"><?php echo $facture->titre; ?></div>
                      </div></td>
                      <td align="left" bgcolor="#EAF0F7"><div align="center" class="Style4" style="font-size: 11px"><?php $d=$facture->dateEmission; echo date("d/m/Y",strtotime($d)); ?></div></td>
                      <td align="left" bgcolor="#EAF0F7"><div align="right"><?php echo $facture->getHTPriceRemiseFormat(); ?></div></td>
                      <td align="left" bgcolor="#EAF0F7"><div align="center" class="Style4" style="font-size: 11px"><?php if(empty($facture->validation)){?><a href="facture.php?id=<?php echo $facture->id; ?>"><img src="images/icones/editer_16.png" alt="Modifier" name="imgModifier2" width="16" height="16" id="imgModifier2" title="Modifier" /></a><?php }else{ ?><a href="facture_pdf.php?id=<?php echo $facture->id; ?>" target="_blank"><img alt="Imprimer" id="imgPDF3" src="images/icones/imprimante-icone-5571-16.png" title="Imprimer" width="16" height="16" /></a> <?php }?></div></td>
                    </tr> <?php 
					$totalHT += $facture->getHTPriceRemise(); }?>                   
                    <tr>
                      <td height="2" colspan="5" bgcolor="#5289BA"></td>
                      </tr>
                    <tr>
                      <td bgcolor="#EAF0F7">&nbsp;</td>
                      <td align="right" bgcolor="#EAF0F7"><span style="font-weight: bold">Total factures réalisées</span></td>
                      <td align="left" bgcolor="#EAF0F7"><div align="center" style="font-weight: bold"><?php echo $nbElements; ?></div></td>
                      <td align="left" bgcolor="#EAF0F7"><div align="right" style="font-weight: bold"><?php echo number_format($totalHT, 2, ',', ' '); ?></div></td>
                      <td align="left" bgcolor="#EAF0F7">&nbsp;</td>
                    </tr>
                  </tbody>
                </table>
                <h2><img src="images/icones/blanc-page-de-pile-icone-6477-32.png" width="32" height="32" align="absmiddle" /> Historique des bons de commande</h2>
                <table width="100%">
                  <!-- Entete du tableau -->
                  <tbody>
                    <tr>
                      <td width="15%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Ref</p></td>
                      <td width="47%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Intitulé de la facture</p></td>
                      <td width="13%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Date de création</p></td>
                      <td width="16%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Montant HT</p></td>
                      <td width="9%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Consulter</p></td>
                      <!--th class="data-table">                    Acompte                </th-->
                    </tr>
                    <!-- /Entete du tableau -->
                    <!-- Corps du tableau -->                    
                    <?php 
					$totalHT = 0.0; 
					$nbElements = 0; 
                    $bonTab = Bon::findByDestinataireEmetteur($id, $theSocCli->idSociete);					
					foreach ($bonTab as $bon) {
						$nbElements += 1;
					?>
                    <tr>
                      <td bgcolor="#EAF0F7"><div align="center"><?php echo $bon->reference; ?></div></td>
                      <td align="right" bgcolor="#EAF0F7"><div align="center" class="Style4" style="font-size: 11px">
                        <div align="left"><?php echo $bon->titre; ?></div>
                      </div></td>
                      <td align="left" bgcolor="#EAF0F7"><div align="center" class="Style4" style="font-size: 11px"><?php $d=$bon->dateEmission; echo date("d/m/Y",strtotime($d)); ?></div></td>
                      <td align="left" bgcolor="#EAF0F7"><div align="right"><?php echo $bon->getHTPriceRemiseFormat(); ?></div></td>
                      <td align="left" bgcolor="#EAF0F7"><div align="center" class="Style4" style="font-size: 11px"><?php if(empty($bon->validation)){?><a href="bon.php?id=<?php echo $bon->id; ?>"><img src="images/icones/editer_16.png" alt="Modifier" name="imgModifier2" width="16" height="16" id="imgModifier2" title="Modifier" /></a><?php }else{ ?><a href="bon_pdf.php?id=<?php echo $bon->id; ?>" target="_blank"><img alt="Imprimer" id="imgPDF3" src="images/icones/imprimante-icone-5571-16.png" title="Imprimer" width="16" height="16" /></a> <?php }?></div></td>
                    </tr> <?php 
					$totalHT += $bon->getHTPriceRemise(); }?>                   
                    <tr>
                      <td height="2" colspan="5" bgcolor="#5289BA"></td>
                      </tr>
                    <tr>
                      <td bgcolor="#EAF0F7">&nbsp;</td>
                      <td align="right" bgcolor="#EAF0F7"><span style="font-weight: bold">Total bons de commande réalisés</span></td>
                      <td align="left" bgcolor="#EAF0F7"><div align="center" style="font-weight: bold"><?php echo $nbElements; ?></div></td>
                      <td align="left" bgcolor="#EAF0F7"><div align="right" style="font-weight: bold"><?php echo number_format($totalHT, 2, ',', ' '); ?></div></td>
                      <td align="left" bgcolor="#EAF0F7">&nbsp;</td>
                    </tr>
                  </tbody>
                </table>
                <p>&nbsp;</p>
<?php
	}
?>
              </center>
            </div></td>
      </tr>
    </table>
<?php
	}
?>
    </td>
                                                    </tr>
                                                    <tr >
                                                      <td colspan="8"><div align="right"></div></td>
                                                    </tr>
                                              </tbody></table>
                                                
                                                	
                                                    
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
