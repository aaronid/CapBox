<?php
	require("business/bon.php");
	require("business/filter.php");
	require("business/tva.php");
	require("business/utils.php");
	require("inc.php"); 

	$id = "";
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	}

	if (!empty ($_POST)) {
		$currentBon = $_SESSION['currentBon'];
		// METTRE A JOUR LE BON
		$currentBon->reference = $_POST['reference'];
		$currentBon->idSociete = $societeContact->societe->id;
		$currentBon->idSocieteClient = $_POST['destinataire'];
		$currentBon->dateEmission = implode('/', array_reverse(explode('/', $_POST['date_emission'])));
		$currentBon->dateValidite = $_POST['dateValidation'];
		$valid="";
		if (!empty($currentBon->dateValidite)) {
			$valid="1";
		}
		
		$currentBon->titre = $_POST['titre'];
		$currentBon->idSocieteContact = $_POST['interlocuteur'];
		$currentBon->remise = $_POST['Hremise1'];
		$currentBon->acompte = $_POST['Hacompte'];
		$currentBon->commentaire = $_POST['commentaire'];

		$newLines = array_filter($_POST, "isNewIdLineWithoutGrp");
		
		$isDuplication = isset($_GET['dup']) && !empty($_GET['dup']);
		if (empty($id) || $isDuplication || (isset($_GET['transforme']) && !empty($_GET['transforme']))) {
			if (isset($_GET['transforme']) && !empty($_GET['transforme'])) {
				$currentBon->idDevis = $id;
				$devis = new Devis();
				$devis->findById($id);
				$devis->validate();
			}
			$currentBon->insert();
			$id = $currentBon->id;
		} else {
			$currentBon->update();
		}
		
		if (endsWith($currentBon->reference, ($societeContact->societe->refBonIncre + 1))) {
			$societeContact->societe->refBonIncre++;
			$societeContact->societe->update();
		}
		
		foreach ($currentBon->lignes as $ligne) {
			$idHtml = $ligne->id;
			if (isset($_POST['idLine' . $idHtml])) {
				$ligne->designation = $_POST['designation' . $idHtml];
				$ligne->tauxTva = $_POST['tauxtva' . $idHtml];
				$ligne->quantite = $_POST['Hquant' . $idHtml];
				$ligne->unite = $_POST['unite' . $idHtml];
				$ligne->prixUnitaireHT = $_POST['Hprix' . $idHtml];
				$ligne->numero = 0;
				$ligne->rang = "";
				if ($isDuplication) {
					$dupLigne = $ligne->duplicate($currentBon->id);
					$currentBon->lignes[$dupLigne->id] = $dupLigne;
				}
				else {
					$ligne->update();
				}
			}
			else {
				if (!$isDuplication) {
					$ligne->delete();
				}
			}
		}
		foreach ($newLines as $newIdLine) {
			if (isset($_POST['idLine' . $newIdLine])) {
				$newLine = $currentBon->addLigne();
				$newLine->designation = $_POST['designation' . $newIdLine];
				$newLine->tauxTva = $_POST['tauxtva' . $newIdLine];
				$newLine->quantite = $_POST['Hquant' . $newIdLine];
				$newLine->unite = $_POST['unite' . $newIdLine];
				$newLine->prixUnitaireHT = $_POST['Hprix' . $newIdLine];
				$newLine->numero = 0;
				$newLine->rang = "";
				$newLine->insert();
				$currentBon->lignes[$newLine->id] = $newLine;
			}
		}
		header("Location: bon_liste.php");
	}
	
	$allTva = Tva::findAll();
	$usedTva = array();
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
<head>
	<script type="text/javascript">
		var tvaOptionSelect = "<?php
				$options = "";
				foreach ($allTva as $tva) {
					if ($tva->isActif) {
						$options = $options . "<option value=\\\"" . $tva->id . "\\\">" . $tva->libelle . "</option>";
					}
				}
				echo $options;
			?>";
	</script>

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
    <script type="text/javascript" src="script_flo.js"></script>
    <style type="text/css">
		<!--
		.Style1 {color: #FFFFFF}
		.Style4 {font-size: 85%}
		.Style6 {font-size: 85%; font-weight: bold; }
		.Style7 {font-size: 85%; font-weight: bold; color: #FFFFFF; }
		-->
    </style>
</head>
<body >
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
                                    <h2 class="art-postheader"> <img src="images/postheadericon.png" width="26" height="26" alt="postheadericon" /> Edition de votre bon de commande</h2>
                                    <form id="frm" name="frm" action="bon.php?<?php if (!empty($id)) { echo "id=" . $id; } ?><?php if (isset($_GET['dup']) && !empty($_GET['dup'])) { echo "dup=" . $_GET['dup']; } ?>" method="post">
    <!-- Devis en mode création-->
      <!--bon en mode Edition-->
      <!--div style="float: left; width: 100%"-->
      <table width="100%">
        <tbody>
        </tbody>
      </table>
      <!--/div-->
      <div>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="art-article">
                                                  <tbody>
                                                    <?php 
													require("turl.php");
													?>
                                                    <tr>
                                                      <td colspan="10"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td><!-- Periode de recherche -->
            <!-- Periode de recherche -->
            <div>
            
<table width="100%">
  <tbody>
    <tr>
      <td height="32" colspan="2" background="images/fd_nav_ss_menu.png" bgcolor="#F0F0F0" class="componentheading"><span style="font-weight: bold"><a href="#" onClick="document.frm.submit()"><img src="images/icones/enregistrer-page-icone-7705-32.png" width="24" height="24" align="absmiddle" />Sauvegarder </a>
        <img src="images/menuseparator.png" width="1" height="24" align="absmiddle" />  <?php if(!empty($id)){?><a href="bon_pdf.php?id=<?php echo $id; ?>" target="_blank"><img src="images/icones/imprimante-icone-5571-32.png" width="24" height="24" align="absmiddle" /> Imprimer</a><img src="images/menuseparator.png" width="1" height="24" align="absmiddle" /><?php } ?>  <a href="bon.php?<?php if (!empty($id)) { echo "id=" . $id; } ?><?php if (isset($_GET['dup']) && !empty($_GET['dup'])) { echo "dup=" . $_GET['dup']; } ?>"><img src="images/icones/supprimer-la-page-icone-9859-32.png" width="24" height="24" align="absmiddle" />Effacer la saisie en cours</a><img src="images/menuseparator.png" width="1" height="24" align="absmiddle" />  <a href="bon_liste.php"><img src="images/icones/demande-afficher-la-liste-icone-8709-32.png" width="24" height="24" align="absmiddle" /> Retour à la liste des bon</a></span></td>
		<?php
			if (!empty($_GET['dup'])) {
				$id = $_GET['dup'];
			}
			$bon = new Bon();
			$_SESSION['currentBon'] = $bon;
			if (empty($id)) {
				$newLig = $bon->addLigne();
				$newLig->id = "New0";
				$bon->lignes[$newLig->id] = $newLig;
			}
			else {
				$bon->findById($id);
			}
		?>
      </tr>
      <!--startprint-->
    <tr>
      <td bgcolor="#F9F9F9" class="componentheading">&nbsp;</td>
      <td align="right" bgcolor="#F9F9F9">&nbsp;</td>
    </tr>
    <tr>
      <td width="50%" height="32" bgcolor="#F9F9F9" class="componentheading"><strong >        BON DE COMMANDE N° : </strong>
        <input name="reference" type="text" id="reference" 
		<?php
			if (!empty($bon->reference) and empty($_GET['dup'])) {
				echo "value=\"".$bon->reference."\"";
			}
			else{
				if (empty($societeContact->societe->refBonPrefix) && $societeContact->societe->refBonIncre > 0) {
					$ref1 = mysql_query("select _ID from bon where ID_SOCIETE = " . $societeContact->societe->id);
					$ref2 = mysql_num_rows($ref1);
					$ref2++;
					echo "value=\"".$ref2."\"";
				} else {
					echo "value=\"" . $societeContact->societe->refBonPrefix . ($societeContact->societe->refBonIncre + 1) . "\"";
				}
			}
		?> size="10" />
        <strong>Affaire suivie par
            <select name="interlocuteur" id="interlocuteur">
			<?php
				$selected="";
				$in1=$bon->idSocieteContact;
				if (empty($in1)) {
					$in1 = $societeContact->id;
				}
				$interl="select * from societe_contact WHERE ID_SOCIETE = " . $societeContact->societe->id;
				$inter=mysql_query($interl);
				while ($interloc=mysql_fetch_array($inter)) {
					$in2=$interloc['_ID'];
					$selected="";
					if ($in1==$in2) {
						$selected="selected=\"selected\"";
					}
			?>
            <option value="<?php echo $in2; ?>" <?php echo $selected; ?>><?php echo $interloc['PRENOM']." ".$interloc['NOM']; ?></option>
			<?php
				}
			?>
          </select>
        </strong></td>
      <td width="50%" height="32" align="right" bgcolor="#F9F9F9"><strong><img src="images/icones/icon-date.gif" width="16" height="16" align="absmiddle" /> Date de création du bon de commande</strong> : 
        <input name="date_emission" id="date_emission" tabindex="10" title="Saisir une date de document en cliquant sur cette zone." value="<?php 
			if(empty($bon->dateEmission)){
				echo date('d/m/Y');
			}
			else{
				echo date('d/m/Y', strtotime($bon->dateEmission));
			}
        ?>"size="10" alt="date" />  </td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#F9F9F9"><p><strong>Intitulé du bon de commande:</strong><br />
          <textarea title="Saisir l'objet principal du bon (facultatif)." id="titre" name="titre" cols="70" rows="0" tabindex="11"><?php echo $bon->titre; ?></textarea>
      </p></td>
      <td bgcolor="#F9F9F9"><table width="100%" cellspacing="0" cellpadding="3">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td bgcolor="#FFFFFF"><strong><img src="images/icones/icon-author.gif" alt="" width="10" height="10" />  Destinataire :</strong><br />
      		<?php
				$selectioncontact = "";
				if (!empty($id)) {
					$selectioncontact = $bon->idSocieteClient;
				} else if (isset($_GET['contact'])) {
					$selectioncontact = $_GET['contact'];
				}
				if (!empty($id)) {
					$selClient = new SocieteClient();
					$selClient->findByLogin($selectioncontact);
					// $sele = mysql_query("select * from contact WHERE _ID='$selectioncontact'");
					// $resul = mysql_fetch_array($sele); ?>
	            	<div id="c_societe"> <?php echo $selClient->entreprise; ?></div>
	            	<div id="c_nom"><?php echo $selClient->prenom." ".$selClient->nom; ?></div>
	            	<div id="c_adresse"><?php echo $selClient->adresse1." - ".$selClient->adresse2; ?></div>
	            	<div id="c_cp"><?php echo $selClient->codePostal." ".$selClient->ville;?></div>
		            <input type="hidden" name="destinataire" id="destinataire" value="<?php echo $selectioncontact; ?>" />
 	    <?php  } else { ?>
		            <div id="c_societe"></div>
		            <div id="c_nom"></div>
		            <div id="c_adresse"></div>
		            <div id="c_cp"></div>
		            <input type="hidden" name="destinataire" id="destinataire" value="" />
	     <?php  } ?>
			</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right"><a href="#" class="readon2" style="font-weight: bold" onclick="window.open('contact_liste_pop.php?STATUT=2','','scrollbars=yes,resizable=yes,width=1000,height=600')" >Modifier les coordonnées</a></div></td>
            <td></td>
          </tr>
        </table>        </td>
    </tr>
  </tbody>
</table>
<table width="100%" id="tableArticle" name="tableArticle">
          <tbody>
            <tr>
              <th colspan="2" bgcolor="#5289BA" ><span class="Style1">Description Produits | Prestations </span></th>
              <th width="5%" bgcolor="#5289BA" ><span class="Style1"> Qté </span></th>
              <th width="8%" bgcolor="#5289BA" ><span class="Style1">Unité</span></th>
              <th width="7%" bgcolor="#5289BA" ><span class="Style1"> P.A.  HT </span></th>
              <th width="8%" bgcolor="#5289BA" ><span class="Style1"> TVA % </span></th>
              <th width="8%" bgcolor="#5289BA" ><span class="Style1"> Total HT </span></th>
              <th width="5%" bgcolor="#5289BA" ><span class="Style1">Sup.</span></th>
            </tr>
            
	<?php
				foreach ($bon->lignes as $ligne) {
	?>
			<tr>
				<td style="border-color:#84F0FF; background-color:#EAF0F7;">
					<textarea name="designation<?php echo $ligne->getHtmlId(); ?>" id="designation<?php echo $ligne->getHtmlId(); ?>" cols="85"><?php echo $ligne->designation; ?></textarea>
					<input type="hidden" name="idLine<?php echo $ligne->getHtmlId(); ?>" id="idLine<?php echo $ligne->getHtmlId(); ?>" value="<?php echo $ligne->getHtmlId(); ?>"/>
				</td>
				<td style="background-color:#EAF0F7;">
					<div align="center">
						<a href="#" onclick="window.open('catalogue_liste_pop.php?pop=<?php echo $ligne->getHtmlId(); ?>','','scrollbars=yes,resizable=yes,width=825,height=600')" >
							<img src="images/icones/panier-ajouter-icone-7116-32.png" width="32" height="32" />
						</a>
					</div>
				</td>
				<td style="border-color:#84F0FF; background-color:#EAF0F7;">
					<div align="left">
						<input id="quant<?php echo $ligne->getHtmlId(); ?>" name="quant<?php echo $ligne->getHtmlId(); ?>" size="5" alt="quantite" value="<?php echo $ligne->getQuantiteFormat(); ?>" onchange="calcul('q', '<?php echo $ligne->getHtmlId(); ?>')"/>
						<input id="Hquant<?php echo $ligne->getHtmlId(); ?>" name="Hquant<?php echo $ligne->getHtmlId(); ?>" type="hidden" value="<?php echo $ligne->quantite; ?>"/>
					</div>
				</td>
				<td style="border-color:#84F0FF; background-color:#EAF0F7; text-align:right;">
					<div align="left">
						<select name="unite<?php echo $ligne->getHtmlId(); ?>" id="unite<?php echo $ligne->getHtmlId(); ?>">
							<option value="Pièce"<?php if ($ligne->unite == "Pièce") echo " selected=\"selected\""; ?>>Pièce</option>
							<option value="m²"<?php if ($ligne->unite == "m²") echo" selected=\"selected\""; ?>>m²</option>
							<option value="heure"<?php if ($ligne->unite == "heure") echo" selected=\"selected\""; ?>>heure</option>
							<option value="jour"<?php if ($ligne->unite == "jour") echo" selected=\"selected\""; ?>>jour</option>
							<option value="ml"<?php if ($ligne->unite == "ml") echo" selected=\"selected\""; ?>>ml</option>
							<option value="forfait"<?php if ($ligne->unite == "forfait") echo" selected=\"selected\""; ?>>forfait</option>
							<option value="m3"<?php if ($ligne->unite == "m3") echo" selected=\"selected\""; ?>>m3</option>
						</select>
					</div>
				</td>
				<td style="border-color:#84F0FF; background-color:#EAF0F7; text-align:right;">
					<div align="left">
						<input id="prix<?php echo $ligne->getHtmlId(); ?>" name="prix<?php echo $ligne->getHtmlId(); ?>" size="10" alt="montant" value="<?php echo $ligne->getUnitHTPriceFormat(); ?>" onchange="calcul('p', '<?php echo $ligne->getHtmlId(); ?>')"/>
						<input id="Hprix<?php echo $ligne->getHtmlId(); ?>" name="Hprix<?php echo $ligne->getHtmlId(); ?>" type="hidden" value="<?php echo $ligne->prixUnitaireHT; ?>"/>
					</div>
				</td>
				<td style="border-color:#84F0FF; background-color:#EAF0F7; text-align:right;">
					<div align="left">
						<select name="tauxtva<?php echo $ligne->getHtmlId() ?>" id="tauxtva<?php echo $ligne->getHtmlId(); ?>" onchange="calcul('0', '<?php echo $ligne->getHtmlId(); ?>')";>
	<?php
				foreach ($allTva as $tva) {
					if ($tva->isActif || floatval($ligne->tauxTva) == $tva-> id) {
						$option = "<option value=\"" . $tva->id . "\"";
						if (floatval($ligne->tauxTva) == $tva->id) {
							$usedTva[$tva->id] = $tva->id;
							$option = $option . " selected=\"selected\"";
						}
						$option = $option . ">" . $tva->libelle . "</option>";
						echo $option;
					}
				}
	?>
						</select>
						<input id="Htauxtva<?php echo $ligne->getHtmlId(); ?>" name="Htauxtva<?php echo $ligne->getHtmlId(); ?>" type="hidden" value="<?php echo $ligne->tauxTva; ?>"/>
					</div>
				</td>
				<td style="border-color:#84F0FF; background-color:#EAF0F7; text-align:right;">
					<div id="total<?php echo $ligne->getHtmlId(); ?>"><?php echo $ligne->getHTPriceFormat(); ?></div>
				</td>
				<td style="border-color:#84F0FF; background-color:#EAF0F7; text-align:right;">
					<input type="button" title="Supprimer cette ligne" onclick="suppressionLigne('<?php echo $ligne->getHtmlId(); ?>');" style="border:none; width:32px; height:32px; background:url(images/icones/supprimer_16.png) no-repeat; cursor:pointer; vertical-align:middle;"/>
				</td>
			</tr>
	<?php
				}
	?>
            </tbody>
        </table><table width="100%"><tbody><tr>
              <td bordercolor="#84F0FF" bgcolor="#EAF0F7"><a href="#" onclick="ajoutLigne('0')"><img src="images/icones/ajouter-crayon-icone-4828-32.png" width="32" height="32" align="absmiddle" /> Ajouter une nouvelle ligne au bon de commande</a></td>              
            </tr>
          </tbody>
        </table>
        <table width="100%">
          <tbody>
            <tr>
              <td width="70%" valign="top" bgcolor="#F9F9F9"><!-- Pied gauche document -->
                  
                    <p><strong>Commentaires ajoutés au bon de commande:</strong></p>
                    
                      <textarea title="Saisir l'objet principal du bon (facultatif)." id="commentaire" name="commentaire" cols="85" rows="5" tabindex="11"><?php echo $bon->commentaire; ?></textarea>
                      
                        
                  
                  
              <td width="30%" rowspan="2" valign="top" bgcolor="#F9F9F9"><!-- Pied droit document -->
                  <div id="divTotalCumuleE">
                    <table width="100%" cellpadding="3">
                      <tbody>
                        <tr>                        </tr>
                        <tr>
                          <td height="2" bgcolor="#5289BA"></td>
                          <td height="2" align="right" bgcolor="#5289BA"></td>
                        </tr>
                        <tr>
                          <td width="60%" bgcolor="#EAF0F7"><strong> SOUS-TOTAL HT </strong></td>
                          <td align="right" bgcolor="#EAF0F7"><strong><div id="totalht"><?php echo $bon->getHTPriceFormat(); ?></div><input id="Htotalht" name="Htotalht" type="hidden" value="<?php echo $bon->getHTPrice() ?>"/></strong></td>
                        </tr>
						<tr>
                          <td bgcolor="#EAF0F7">Remise Globale
                            <input title="Saisir le taux de la remise globale." id="remise1" name="remise1" alt="montant" size="10" value="<?php if(!empty($bon->remise)){ echo $bon->getRemiseFormat();}else{ echo '0,00';} ?>" onchange="calcul('r',0);" tabindex="16" /><input id="Hremise1" name="Hremise1" type="hidden" value="<?php if(!empty($bon->remise)){ echo $bon->remise;}else{ echo '0';} ?>" />
                            %</td>
                          <td align="right" bgcolor="#EAF0F7"><div id="remise2"></div><input id="Hremise2" name="Hremise2" type="hidden"/></td>
                        </tr>
                        <tr>
                          <td bgcolor="#5289BA"> <span class="Style1"><strong>TOTAL HT</strong></span></td>
                          <td align="right" bgcolor="#5289BA"><strong><div class="Style1" id="totalht1"><?php echo $bon->getHTPriceRemiseFormat(); ?></div><input id="Htotalht1" name="Htotalht1" type="hidden" value="<?php echo $bon->getHTPriceRemise(); ?>"/></strong></td>
                        </tr>
	<?php
				foreach ($allTva as $tva) {
					if ($tva->isActif || (isset($usedTva[$tva->id]) && $usedTva[$tva->id] == $tva->id)) {
	?>
						<tr>
						  <td bgcolor="#EAF0F7">
						  	<em> TVA à <?php echo $tva->libelle; ?></em>
						  </td>
						  <td align="right" bgcolor="#EAF0F7">
						  	<div id="tva<?php echo $tva->id; ?>"><?php echo $bon->getTvaPriceFormat($tva->id); ?></div>
						  	<input id="Htva<?php echo $tva->id; ?>" name="Htva<?php echo $tva->id; ?>" type="hidden" value="<?php echo $bon->getTvaPrice($tva->id); ?>"/>
						  </td>
						</tr>
	<?php
					}
				}
	?>
                        <tr>
                          <td bgcolor="#5289BA"><span class="Style1"><strong>TOTAL Net TTC</strong></span></td>
                          <td align="right" bgcolor="#5289BA"><strong><div class="Style1" id="totalttc"><?php echo $bon->getTTCPriceFormat(); ?></div><input id="Htotalttc" name="Htotalttc" type="hidden" value="<?php echo $bon->getTTCPrice(); ?>"/></strong></td>
                        </tr>
                      </tbody>
                    </table>
                  </div></td>
            </tr>
            <tr>
              <td valign="top" bgcolor="#F9F9F9">
                <p class="componentheading"><strong>Suivi de règlement :</strong><br />
                  <img src="images/icones/camion-icone-4478-32.png" alt="" width="32" height="32" align="absmiddle" /><span style="font-weight: bold"> Bon de commande livré                     le</span>
                  <input name="dateValidation" id="dateValidation" tabindex="10" title="Saisir une date de document en cliquant sur cette zone." value="<?php $d=$bon->dateValidite; if($bon->dateValidite!="0000-00-00" and !empty($bon->dateValidite)){echo date("d/m/Y",strtotime($d)); }?>" size="10" alt="date" />
                </p>
                </td>
            </tr>
          </tbody>
        </table>
            </div>
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
                                Copyright &copy; 2010 - Tous droits réservés</p><!--endprint-->
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
