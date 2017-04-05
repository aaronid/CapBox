<?php
	require("business/devis.php");
	require("business/facture.php");
	require("business/filter.php");
	require("business/tva.php");
	require("business/utils.php");
	require("inc.php");

	$id = "";
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	}

	if (!empty ($_POST)) {
		$currentFacture = $_SESSION['currentFacture'];
		// METTRE A JOUR LA FACTURE
		$currentFacture->reference = $_POST['reference'];
		$currentFacture->refDevis = $_POST['refDevis'];
		$currentFacture->idSociete = $societeContact->societe->id;
		$currentFacture->idSocieteClient = $_POST['destinataire'];
		$currentFacture->dateEmission = implode('/', array_reverse(explode('/', $_POST['date_emission'])));
		$currentFacture->dateValidite = $_POST['dateValidation'];
		$valid="";
		if (!empty($currentFacture->dateValidite)) {
			$valid="1";
		}
		
		$currentFacture->titre = $_POST['titre'];
		$currentFacture->idSocieteContact = $_POST['interlocuteur'];
		$currentFacture->remise = $_POST['Hremise1'];
		$currentFacture->acompte = $_POST['Hacompte'];
		$currentFacture->commentaire = $_POST['commentaire'];

		$newGroupes = array_filter($_POST, "isNewIdGrp");
		$newLines = array_filter($_POST, "isNewIdLine");
		
		$isDuplication = isset($_GET['dup']) && !empty($_GET['dup']);
		if (empty($id) || $isDuplication || (isset($_GET['transforme']) && !empty($_GET['transforme']))) {
			if (isset($_GET['transforme']) && !empty($_GET['transforme'])) {
				$currentFacture->idDevis = $id;
				$currentFacture->insert();
				
				$devis = new Devis();
				$devis->findById($id);
				$devis->validate();
				if (!empty($devis->acompte)) {
					if (empty($societeContact->societe->refAcomptePrefix) && $societeContact->societe->refAcompteIncre > 0) {
						$ref1 = mysql_query("select _ID from acompte where ID_SOCIETE = " . $societeContact->societe->id);
						$ref2 = mysql_num_rows($ref1);
						$ref2++;
						$refAcompte = $ref2;
					} else {
						$refAcompte = $societeContact->societe->refAcomptePrefix . ($societeContact->societe->refAcompteIncre + 1);
						$societeContact->societe->refAcompteIncre++;
					}
					$currentFacture->addAcompte($refAcompte, $devis->acompte, $_POST['Htotalttc']);
				}
			} else {
				$currentFacture->insert();
			}
			$id = $currentFacture->id;
		} else {
			$currentFacture->update();
		}

		if (endsWith($currentFacture->reference, ($societeContact->societe->refFactureIncre + 1))) {
			$societeContact->societe->refFactureIncre++;
			$societeContact->societe->update();
		}
		
		foreach ($currentFacture->groupes as $groupe) {
			if (isset($_POST['idGrp' . $groupe->id])) {
				$groupe->designation = $_POST['designationGrp' . $groupe->id];
				if ($isDuplication) {
					$dupGroupe = $groupe->duplicate($currentFacture->id);
					$currentFacture->groupes[$dupGroupe->id] = $dupGroupe;
				}
				else {
					$groupe->update();
				}
				foreach ($groupe->lignes as $ligne) {
					$idHtml = $groupe->id . "_" . $ligne->id;
					if (isset($_POST['idLine' . $idHtml])) {
						$ligne->designation = $_POST['designation' . $idHtml];
						$ligne->tauxTva = $_POST['tauxtva' . $idHtml];
						$ligne->quantite = $_POST['Hquant' . $idHtml];
						$ligne->unite = $_POST['unite' . $idHtml];
						$ligne->prixUnitaireHT = $_POST['Hprix' . $idHtml];
						$ligne->numero = 0;
						$ligne->rang = "";
						if ($isDuplication) {
							$dupLigne = $ligne->duplicate($dupGroupe->id);
							$dupGroupe->lignes[$dupLigne->id] = $dupLigne;
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
					if (isset($_POST['idLine' . $newIdLine]) && 
							startswith($_POST['idLine' . $newIdLine], $groupe->id . '_')) {
						$newLine = $groupe->addLigne();
						$newLine->designation = $_POST['designation' . $newIdLine];
						$newLine->tauxTva = $_POST['tauxtva' . $newIdLine];
						$newLine->quantite = $_POST['Hquant' . $newIdLine];
						$newLine->unite = $_POST['unite' . $newIdLine];
						$newLine->prixUnitaireHT = $_POST['Hprix' . $newIdLine];
						$newLine->numero = 0;
						$newLine->rang = "";
						$newLine->insert();
						$groupe->lignes[$newLine->id] = $newLine;
					}
				}
			}
			else {
				if (!$isDuplication) {
					$groupe->delete();
				}
			}
		}
		foreach ($newGroupes as $newIdGroupe) {
			if (isset($_POST['idGrp' . $newIdGroupe])) {
				$newGroupe = $currentFacture->addGroupe();
				$newGroupe->designation = $_POST['designationGrp' . $newIdGroupe];
				$newGroupe->insert();
				$currentFacture->groupes[$newGroupe->id] = $newGroupe;
				foreach ($newLines as $newIdLine) {
					if (isset($_POST['idLine' . $newIdLine]) && 
							startswith($_POST['idLine' . $newIdLine], $newIdGroupe . '_')) {
						$newLine = $newGroupe->addLigne();
						$newLine->designation = $_POST['designation' . $newIdLine];
						$newLine->tauxTva = $_POST['tauxtva' . $newIdLine];
						$newLine->quantite = $_POST['Hquant' . $newIdLine];
						$newLine->unite = $_POST['unite' . $newIdLine];
						$newLine->prixUnitaireHT = $_POST['Hprix' . $newIdLine];
						$newLine->numero = 0;
						$newLine->rang = "";
						$newLine->insert();
						$newGroupe->lignes[$newLine->id] = $newLine;
					}
				}
			}
		}
		
		header("Location: facture_liste.php");
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
                                    <h2 class="art-postheader"> <img src="images/postheadericon.png" width="26" height="26" alt="postheadericon" /> Edition de votre facture </h2>
                                    <form id="frm" name="frm" action="facture.php?<?php if (isset($_GET['transforme'])) { echo "transforme=" . $_GET['transforme'] . "&"; } ?><?php if (!empty($id)) { echo "id=" . $id; } ?><?php if (isset($_GET['dup']) && !empty($_GET['dup'])) { echo "dup=" . $_GET['dup']; } ?>" method="post">
    <!-- Devis en mode création-->
      <!--facture en mode Edition-->
      <!--div style="float: left; width: 100%"-->
      <table width="100%">
        <tbody>
        </tbody>
      </table>
      <!--/div-->
      <div>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="art-article">
                                                  <tbody>
                                                  <?php require("turl.php");?>
                                                      <tr>
                                                      <td colspan="10"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td><!-- Periode de recherche -->
            <!-- Periode de recherche -->
            <div>

          <?php
          if (!empty($_GET['dup'])) {
          	$id = $_GET['dup'];
          }
          if (!isset($_GET['transforme']) || empty($_GET['transforme'])) {
          	$facture = new Facture();
          	if (empty($id)) {
          		$newGrp = $facture->addGroupe();
          		$newGrp->id = "New0";
          		$facture->groupes[$newGrp->id] = $newGrp;
          		$newLig = $newGrp->addLigne();
          		$newLig->id = "New0";
          		$newGrp->lignes[$newLig->id] = $newLig;
          	}
          	else {
          		$facture->findById($id);
          	}
          }
          else {
          	$devis = new Devis();
          	$devis->findById($id);
          	$facture = $devis->transformToFacture();
          }
          ?>
            
<table width="100%">
  <tbody>
    <tr>
      <td height="32" colspan="2" background="images/fd_nav_ss_menu.png" bgcolor="#F0F0F0" class="componentheading">
          <span style="font-weight: bold">
          <a href="#" onclick="document.frm.submit()"><img src="images/icones/enregistrer-page-icone-7705-32.png" width="24" height="24" />Sauvegarder </a>
          <input type="hidden" name="transforme" id="transforme" value="<?php if (isset($_GET['transforme'])) { echo $_GET['transforme']; } ?>"/>
          <img src="images/menuseparator.png" width="1" height="24" align="middle" />
          <a href="facture.php?<?php if (isset($_GET['transforme'])) { echo "transforme=" . $_GET['transforme'] . "&"; } ?><?php if (!empty($id)) { echo "id=" . $id; } ?><?php if (isset($_GET['dup']) && !empty($_GET['dup'])) { echo "dup=" . $_GET['dup']; } ?>"><img src="images/icones/supprimer-la-page-icone-9859-32.png" width="24" height="24" />Effacer la saisie</a>
          <?php
          if (empty($_GET['dup']) && !empty($id) && (!isset($_GET['transforme']) || empty($_GET['transforme']))) {
          ?>
          <img src="images/menuseparator.png" width="1" height="24" align="middle" />
          <a href="acompte.php?idFacture=<?php echo $facture->id; ?>"><img src="images/icones/police-icone-9426-32.png" width="24" height="24" />Créer un acompte</a>
          <img src="images/menuseparator.png" width="1" height="24" align="middle" />
          <a href="acompte_liste.php?idFacture=<?php echo $facture->id; ?>"><img src="images/icones/police-icone-9426-32.png" width="24" height="24" />Voir les acomptes</a>
          <img src="images/menuseparator.png" width="1" height="24" align="middle" />
          <a href="avoir.php?idFacture=<?php echo $facture->id; ?>"><img src="images/icones/police-icone-9426-32.png" width="24" height="24" />Créer un avoir</a>
          <img src="images/menuseparator.png" width="1" height="24" align="middle" />
          <a href="avoir_liste.php?idFacture=<?php echo $facture->id; ?>"><img src="images/icones/police-icone-9426-32.png" width="24" height="24" />Voir les avoirs</a>
          <?php
          }
          ?>
          <img src="images/menuseparator.png" width="1" height="24" align="middle" />
          <a href="facture_liste.php"><img src="images/icones/demande-afficher-la-liste-icone-8709-32.png" width="24" height="24" />Retour aux factures</a>
          </span>
      </td>
	</tr>
    <tr>
      <td bgcolor="#F9F9F9" class="componentheading">&nbsp;</td>
      <td align="right" bgcolor="#F9F9F9">&nbsp;</td>
    </tr>
    <tr>
      <td width="50%" height="32" bgcolor="#F9F9F9" class="componentheading"><strong >        FACTURE N° : </strong>
        <input name="reference" type="text" id="reference" 
		<?php 
			if ((!isset($_GET['transforme']) || empty($_GET['transforme'])) and !empty($facture->reference) and (!isset($_GET['dup']) || empty($_GET['dup']))) {
				echo "value=\"" . $facture->reference . "\"";
			}
			else {
				if (empty($societeContact->societe->refFacturePrefix) && $societeContact->societe->refFactureIncre > 0) {
					$ref1 = mysql_query("select _ID from facture where ID_SOCIETE = " . $societeContact->societe->id);
					$ref2 = mysql_num_rows($ref1);
					$ref2++;
					echo "value=\"".$ref2."\"";
				} else {
					echo "value=\"" . $societeContact->societe->refFacturePrefix . ($societeContact->societe->refFactureIncre + 1) . "\"";
				}
			} 
		?> size="10" />
        <strong>Affaire suivie par
            <select name="interlocuteur" id="interlocuteur">
            <?php
				$in1 = $facture->idSocieteContact;
				if (empty($in1)) {
					$in1 = $societeContact->id;
				}
				$interl = "select * from societe_contact WHERE ID_SOCIETE = " . $societeContact->societe->id;
				$inter = mysql_query($interl);
				while ($interloc=mysql_fetch_array($inter)) {
					$in2 = $interloc['_ID'];
            		$selected=""; 
					if ($in1 == $in2) {
						$selected = "selected=\"selected\"";
					}
			?>
            <option value="<?php echo $in2; ?>" <?php echo $selected; ?>><?php echo $interloc['PRENOM']." ".$interloc['NOM']; ?></option>
            <?php 
				}
			?>
          </select>
        </strong></td>
      <td width="50%" height="32" align="right" bgcolor="#F9F9F9"><strong><img src="images/icones/icon-date.gif" width="16" height="16" align="absmiddle" /> Date  facture</strong> : 
        <input name="date_emission" id="date_emission" tabindex="10" title="Saisir une date de document en cliquant sur cette zone." value="<?php 
		if (empty($facture->dateEmission)) {
			echo date('d/m/Y');		
		} else {
			if (isset($_GET['transforme']) && !empty($_GET['transforme'])) {
				echo date('d/m/Y');
			} else {
				echo date('d/m/Y', strtotime($facture->dateEmission));
			}
		}
	?>" size="10" alt="date" />  </td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#F9F9F9"><p><strong>Intitulé de la facture :</strong><br />
          <textarea title="Saisir l'objet principal du facture (facultatif)." id="titre" name="titre" cols="70" rows="0" tabindex="11"><?php echo $facture->titre; ?></textarea>
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
			if (!empty($id)) {
				$selectioncontact = $facture->idSocieteClient;
			} else if (isset($_GET['contact'])) {
				$selectioncontact = $_GET['contact'];
			}
			if (!empty($id)) {
				$selClient = new SocieteClient();
				$selClient->findByLogin($selectioncontact);
			?>
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
            <td><div align="right"><a href="#" class="readon2" style="font-weight: bold" onclick="window.open('contact_liste_pop.php','','scrollbars=yes,resizable=yes,width=1000,height=600')" >Modifier les coordonnées</a></div></td>
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
              <th width="7%" bgcolor="#5289BA" ><span class="Style1"> P.U.  HT </span></th>
              <th width="8%" bgcolor="#5289BA" ><span class="Style1"> TVA % </span></th>
              <th width="8%" bgcolor="#5289BA" ><span class="Style1"> Total HT </span></th>
              <th width="5%" bgcolor="#5289BA" ><span class="Style1">Sup.</span></th>
            </tr>
            
	<?php
			foreach ($facture->groupes as $groupe) {
	?>
			<tr>
				<td style="border-color:#84F0FF; background-color:#EAF0F7;">
					<textarea name="designationGrp<?php echo $groupe->id; ?>" id="designationGrp<?php echo $groupe->id; ?>" cols="70"><?php echo $groupe->designation; ?></textarea>
					<input type="hidden" name="idGrp<?php echo $groupe->id; ?>" id="idGrp<?php echo $groupe->id; ?>" value="<?php echo $groupe->id; ?>"/>
				</td>
				<td style="background-color:#EAF0F7;">
					<div align="center">
						<a href="#" onclick="ajoutLigne('<?php echo $groupe->id; ?>')" title="Ajouter une ligne">
							<img src="images/icones/ajouter-crayon-icone-4828-32.png" width="32" height="32" />
						</a>
					</div>
				</td>
				<td colspan="5" style="border-color:#84F0FF; background-color:#EAF0F7;"></td>
				<td style="border-color:#84F0FF; background-color:#EAF0F7; text-align:right;">
					<input type="button" title="Supprimer cet ensemble de ligne" onclick="suppressionGroupe('<?php echo $groupe->id; ?>');" style="border:none; width:32px; height:32px; background:url(images/icones/supprimer_16.png) no-repeat; cursor:pointer; vertical-align:middle;"/>
				</td>
			</tr>
	<?php
				foreach ($groupe->lignes as $ligne) {
	?>
			<tr>
				<td style="border-color:#84F0FF; background-color:#EAF0F7;">
					<textarea name="designation<?php echo $ligne->getHtmlId(); ?>" id="designation<?php echo $ligne->getHtmlId(); ?>" cols="70"><?php echo $ligne->designation; ?></textarea>
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
					if ($tva->isActif || floatval($ligne->tauxTva) == $tva->id) {
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
			<tr>
				<td id="sep<?php echo $groupe->id ?>" colspan="8" height="1" style="background-color:#5289BA;"></td>
			</tr>
			<tr>
				<td style="border-color:#84F0FF; background-color:#EAF0F7;" colspan="6"></td>
				<td style="border-color:#84F0FF; background-color:#EAF0F7; text-align:right;">
					<div id="total<?php echo $groupe->id ?>"><?php echo $groupe->getHTPriceFormat(); ?></div>
				</td>
				<td style="border-color:#84F0FF; background-color:#EAF0F7;"></td>
			</tr>
	<?php
			}
	?>

        </tbody>
        </table><table width="100%"><tbody><tr>
			  <td style="border-color:#84F0FF; background-color:#EAF0F7;"><a href="#" onclick="ajoutGroupe()"><img src="images/icones/ajouter-crayon-icone-4828-32.png" width="32" height="32" /> Ajouter un nouvel ensemble de lignes au devis</a></td>
            </tr>
          </tbody>
        </table>
        <table width="100%">
          <tbody>
            <tr>
              <td width="70%" valign="top" bgcolor="#F9F9F9"><!-- Pied gauche document -->
                  
                    <p><strong>Commentaires ajoutés à la facture :<br />
                    Ref Devis </strong><span class="componentheading">
                      <input name="refDevis" type="text" id="refDevis" value="<?php 
					if (isset($_GET['transforme']) && !empty($_GET['transforme'])) {
						echo $devis->reference;
					}
					else {
						echo $facture->refDevis;
					} 
				?>" />
                    </span></p>
                    
                      <textarea title="Saisir l'objet principal du facture (facultatif)." id="commentaire" name="commentaire" cols="85" rows="5" tabindex="11"><?php echo $facture->commentaire; ?></textarea>
                  
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
                          <td align="right" bgcolor="#EAF0F7"><strong><div id="totalht"><?php echo $facture->getHTPriceFormat(); ?></div><input id="Htotalht" name="Htotalht" type="hidden" value="<?php echo $facture->getHTPrice() ?>"/></strong></td>
                        </tr>
						<tr>
                          <td bgcolor="#EAF0F7">Remise Globale
                            <input title="Saisir le taux de la remise globale." id="remise1" name="remise1" alt="montant" size="10" value="<?php if(!empty($facture->remise)){ echo $facture->remise;} else { echo '0,00';} ?>" onchange="calcul('r',0);" tabindex="16" />
                            <input id="Hremise1" name="Hremise1" type="hidden" value="<?php if (!empty($facture->remise)) { echo $facture->remise;} else { echo '0.00';} ?>" />
                            %</td>
                          <td align="right" bgcolor="#EAF0F7">
                          	<div id="remise2"><?php echo $facture->getTotalRemiseFormat(); ?></div>
                          	<input id="Hremise2" name="Hremise2" type="hidden" value="<?php echo $facture->getTotalRemise(); ?>"/>
                          </td>
                        </tr>
                        <tr>
                          <td bgcolor="#5289BA"> <span class="Style1"><strong>TOTAL HT</strong></span></td>
                          <td align="right" bgcolor="#5289BA"><strong><div class="Style1" id="totalht1"><?php echo $facture->getHTPriceRemiseFormat(); ?></div><input id="Htotalht1" name="Htotalht1" type="hidden" value="<?php echo $facture->getHTPriceRemise(); ?>"/></strong></td>
                        </tr>
	<?php
				foreach ($allTva as $tva) {
					if ($tva->id != 0.0 && ($tva->isActif || (isset($usedTva[$tva->id]) && $usedTva[$tva->id] == $tva->id))) {
						?>
						<tr>
						  <td bgcolor="#EAF0F7">
						  	<em> TVA à <?php echo $tva->libelle; ?></em>
						  </td>
						  <td align="right" bgcolor="#EAF0F7">
						  	<div id="tva<?php echo $tva->id; ?>"><?php echo $facture->getTvaPriceFormat($tva->id); ?></div>
						  	<input id="Htva<?php echo $tva->id; ?>" name="Htva<?php echo $tva->id; ?>" type="hidden" value="<?php echo $facture->getTvaPrice($tva->id); ?>"/>
						  </td>
						</tr>
	<?php
					}
				}
	?>
                        <tr>
                          <td bgcolor="#5289BA"><span class="Style1"><strong>TOTAL Net TTC</strong></span></td>
                          <td align="right" bgcolor="#5289BA">
                          	<div class="Style1" id="totalttc"><strong><?php echo $facture->getTTCPriceFormat(); ?></strong></div>
                          	<input id="Htotalttc" name="Htotalttc" type="hidden" value="<?php echo $facture->getTTCPrice(); ?>"/>
                          </td>
                        </tr>
                        <tr>
                          <td bgcolor="#EAF0F7"><strong>Total des acomptes (TTC)</strong></td>
                          <td align="right" bgcolor="#EAF0F7">
	<?php
if (isset($_GET['transforme']) && !empty($_GET['transforme'])) {
	$montantAcompte = $facture->getTTCPrice() * $devis->acompte / 100;
	$resteTTC = $facture->getTTCPrice() - $montantAcompte;
	?>
							<div id="acompte"><strong><?php echo number_format($montantAcompte, 2, ",", " "); ?></strong></div>
                    	  	<input type="hidden" name="Hacompte" id="Hacompte" value="<?php echo $montantAcompte; ?>" />
	<?php
} else {
	?>
							<div id="acompte"><strong><?php echo $facture->getTotalAcompteFormat(); ?></strong></div>
                    	  	<input type="hidden" name="Hacompte" id="Hacompte" value="<?php echo $facture->getTotalAcompte(); ?>" />
	<?php
}
	?>
						  </td>
                        </tr>
                        <tr>
                          <td bgcolor="#EAF0F7"><strong>Total des avoirs (TTC)</strong></td>
                          <td align="right" bgcolor="#EAF0F7">
                          	<div id="avoirttc"><strong><?php echo $facture->getTotalAvoirFormat(); ?></strong></div>
                          </td>
                        </tr>
                        <tr>
                          <td bgcolor="#EAF0F7"><strong>Reste à payer (TTC)</strong></td>
                          <td align="right" bgcolor="#EAF0F7">
	<?php
if (isset($_GET['transforme']) && !empty($_GET['transforme'])) {
	?>
                          	<div id="restettc"><strong><?php echo number_format($resteTTC, 2, ",", " "); ?></strong></div>
	<?php
} else {
	?>
                          	<div id="restettc"><strong><?php echo $facture->getResteAPayerTTCFormat(); ?></strong></div>
	<?php
}
	?>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div></td>
            </tr>
            <tr>
              <td valign="top" bgcolor="#F9F9F9">
                <p class="componentheading"><strong>Suivi de règlement :</strong><br />
                  <img src="images/icones/argent-icone-6943-32.png" alt="" width="32" height="32" align="absmiddle" /><span style="font-weight: bold"> Facture payée intégralement le</span>
                  <input name="dateValidation" id="dateValidation" tabindex="10" title="Saisir une date de document en cliquant sur cette zone." value="<?php $d = strtotime($facture->dateValidite); if (empty($d)) { $d = time(); } echo date('d/m/Y', $d);?>" size="10" alt="date" />
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
          <?php
          if (isset($_GET['transforme']) && !empty($_GET['transforme'])) {
          	$facture = new Facture();
          }
          $_SESSION['currentFacture'] = $facture;
          ?>
