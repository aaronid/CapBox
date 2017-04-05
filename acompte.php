<?php
	require("business/facture.php");
	require("business/utils.php");
	require("business/tva.php");
	require("inc.php");

	$id = "";
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	}

	$idFacture = "";
	if (isset($_GET['idFacture'])) {
		$idFacture = $_GET['idFacture'];
	}

	if (!empty ($_POST)) {
		$currentAcompte = $_SESSION['currentAcompte'];
		// METTRE A JOUR LA FACTURE
		$currentAcompte->reference = $_POST['reference'];
		$currentAcompte->idSociete = $societeContact->societe->id;
		if (!empty($idFacture)) { // Si pas renseigne, alors il garde sa valeur
			$currentAcompte->idFacture = $idFacture;
		}
		$currentAcompte->dateEmission = implode('/', array_reverse(explode('/', $_POST['date_emission'])));
		$currentAcompte->dateValidite = $_POST['dateValidation'];
		$valid="";
		if (!empty($currentAcompte->dateValidite)) {
			$valid="1";
		}
		
		$currentAcompte->titre = $_POST['titre'];
		$currentAcompte->commentaire = $_POST['commentaire'];
		$currentAcompte->pourcent = $_POST['Hpourcent'];
		$currentAcompte->totalTTC = $_POST['Htotalttc'];
		
		$isDuplication = isset($_GET['dup']) && !empty($_GET['dup']);
		if (empty($id) || $isDuplication) {
			$currentAcompte->insert();
			$id = $currentAcompte->id;
		} else {
			$currentAcompte->update();
		}
		
		if (endsWith($currentAcompte->reference, ($societeContact->societe->refAcompteIncre + 1))) {
			$societeContact->societe->refAcompteIncre++;
			$societeContact->societe->update();
		}
		
		header("Location: acompte_liste.php");
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
                                    <h2 class="art-postheader"> <img src="images/postheadericon.png" width="26" height="26" alt="postheadericon" /> Edition de votre acompte </h2>
                                    <form id="frm" name="frm" action="acompte.php?<?php echo "idFacture=" . $idFacture . "&"; ?><?php if (!empty($id)) { echo "id=" . $id; } ?><?php if (isset($_GET['dup']) && !empty($_GET['dup'])) { echo "dup=" . $_GET['dup']; } ?>" method="post">
    <!-- Devis en mode création-->
      <!--acompte en mode Edition-->
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
          $acompte = new Acompte();
          if (!empty($id)) {
          	  $acompte->findById($id);
          }
          $factureRef = new Facture();
          if (empty($idFacture) && !empty($id)) {
          	  $idFacture = $acompte->idFacture;
          }
          if (!empty($idFacture)) {
          	  $factureRef->findById($idFacture);
          	  Facture::calculTvaPrice($factureRef);
          }
          ?>
            
<table width="100%">
  <tbody>
    <tr>
      <td height="32" colspan="2" background="images/fd_nav_ss_menu.png" bgcolor="#F0F0F0" class="componentheading">
          <span style="font-weight: bold">
          <a href="#" onclick="document.frm.submit()"><img src="images/icones/enregistrer-page-icone-7705-32.png" width="24" height="24" />Sauvegarder </a>
          <img src="images/menuseparator.png" width="1" height="24" />
          <a href="acompte.php?<?php echo "idFacture=" . $idFacture . "&"; ?><?php if (!empty($id)) { echo "id=" . $id; } ?><?php if (isset($_GET['dup']) && !empty($_GET['dup'])) { echo "dup=" . $_GET['dup']; } ?>"><img src="images/icones/supprimer-la-page-icone-9859-32.png" width="24" height="24" />Effacer la saisie en cours</a>
          <img src="images/menuseparator.png" width="1" height="24" />
          <a href="acompte_liste.php"><img src="images/icones/demande-afficher-la-liste-icone-8709-32.png" width="24" height="24" />Retour à la liste des acomptes</a>
          <img src="images/menuseparator.png" width="1" height="24" />
          <a href="facture.php?<?php echo "id=" . $idFacture; ?>"><img src="images/icones/pieces-de-monnaie-icone-6896-32.png" width="24" height="24" />Retour à la facture</a>
          </span>
      </td>
	</tr>
    <tr>
      <td bgcolor="#F9F9F9" class="componentheading">&nbsp;</td>
      <td align="right" bgcolor="#F9F9F9">&nbsp;</td>
    </tr>
    <tr>
      <td width="70%" height="32" bgcolor="#F9F9F9" class="componentheading">
        <strong>ACOMPTE N° : </strong>
        <input name="reference" type="text" id="reference" 
		<?php 
			if (!empty($acompte->reference) and (!isset($_GET['dup']) || empty($_GET['dup']))) {
				echo "value=\"" . $acompte->reference . "\"";
			} else {
				if (empty($societeContact->societe->refAcomptePrefix) && $societeContact->societe->refAcompteIncre > 0) {
					$ref1 = mysql_query("select _ID from acompte where ID_SOCIETE = " . $societeContact->societe->id);
					$ref2 = mysql_num_rows($ref1);
					$ref2++;
					echo "value=\"$ref2\"";
				} else {
					echo "value=\"" . $societeContact->societe->refAcomptePrefix . ($societeContact->societe->refAcompteIncre + 1) . "\"";
				}
			} 
		?> size="10" />
      </td>
      <td width="30%" height="32" align="right" style="border-color:#84F0FF; background-color:#EAF0F7; padding-right: 5px;">
        <strong><img src="images/icones/icon-date.gif" width="16" height="16" /> Date acompte :</strong>
        <input name="date_emission" id="date_emission" tabindex="10" title="Saisir une date de document en cliquant sur cette zone." value="<?php 
		if (empty($acompte->dateEmission)) {
			echo date('d/m/Y');		
		} else {
			echo date('d/m/Y', strtotime($acompte->dateEmission));
		} ?>" size="10" alt="date" style="text-align: right;" />
      </td>
    </tr>
    <tr>
      <td colspan="2" width="70%" height="32" bgcolor="#F9F9F9" class="componentheading">
        <strong>FACTURE N° : </strong><?php echo $factureRef->reference; ?>
      </td>
    </tr>
    <?php if (!empty($factureRef->idSocieteClient)) { ?>
    <tr>
      <td colspan="2" width="70%" height="32" bgcolor="#F9F9F9" class="componentheading">
        <strong>Destinataire : </strong>
	    <?php 
			$selClient = new SocieteClient();
			$selClient->findByLogin($factureRef->idSocieteClient);
		?>
        <div id="c_societe"> <?php echo $selClient->entreprise; ?></div>
        <div id="c_nom"><?php echo $selClient->prenom." ".$selClient->nom; ?></div>
        <div id="c_adresse"><?php echo $selClient->adresse1." - ".$selClient->adresse2; ?></div>
        <div id="c_cp"><?php echo $selClient->codePostal." ".$selClient->ville;?></div>
      </td>
    </tr>
    <tr>
      <td bgcolor="#F9F9F9" class="componentheading">&nbsp;</td>
      <td align="right" bgcolor="#F9F9F9">&nbsp;</td>
    </tr>
    <?php } ?>
    <tr>
      <td valign="top" bgcolor="#F9F9F9">
        <p>
          <strong>Intitulé de l'acompte :</strong><br />
        </p>
        <textarea title="Saisir l'objet principal de l'acompte (facultatif)." id="titre" name="titre" cols="85" rows="0" tabindex="11"><?php echo $acompte->titre; ?></textarea>
        
      </td>
      <td bgcolor="#F9F9F9">
        <table width="100%" cellspacing="0" cellpadding="3">
          <tr>
			<td style="border-color:#84F0FF; background-color:#EAF0F7;" align="right" >
                <strong>Pourcentage de l'acompte : </strong>
				<input id="pourcent" name="pourcent" size="10" alt="pourcentage" value="<?php echo $acompte->getPourcentFormat(); ?>" onchange="calculMontantAcompte();" style="text-align: right;" />
				<input id="Hpourcent" name="Hpourcent" type="hidden" value="<?php echo $acompte->pourcent; ?>"/>
			</td>
          </tr>
          <tr>
			<td style="border-color:#84F0FF; background-color:#EAF0F7;" align="right" >
                <strong>Montant de l'acompte : </strong>
				<input id="montant" name="montant" size="10" alt="montant" value="<?php echo $acompte->getMontantFormat(); ?>" onchange="calculPourcentAcompte();" style="text-align: right;" />
				<input id="Hmontant" name="Hmontant" type="hidden" value="<?php echo $acompte->totalTTC; ?>"/>
			</td>
          </tr>
        </table>
      </td>
    </tr>
  </tbody>
</table>
        <table width="100%">
          <tbody>
            <tr>
              <td width="70%" valign="top" bgcolor="#F9F9F9"><!-- Pied gauche document -->
                    <p><strong>Commentaires ajoutés à l'acompte :</strong><br /></p>
                    <textarea title="Saisir l'objet principal du acompte (facultatif)." id="commentaire" name="commentaire" cols="85" rows="5" tabindex="11"><?php echo $acompte->commentaire; ?></textarea>
              </td>  
              <td width="30%" rowspan="2" valign="top" bgcolor="#F9F9F9"><!-- Pied droit document -->
                  <div id="divTotalCumuleE">
                    <table width="100%" cellpadding="3">
                      <tbody>
                        <tr>                        </tr>
                        <tr>
                          <td bgcolor="#5289BA"><span class="Style1"><strong>TOTAL TTC de la facture</strong></span></td>
                          <td align="right" bgcolor="#5289BA"><div class="Style1" id="totalFacture"><strong><?php echo $factureRef->getTTCPriceFormat(); ?></strong></div><input id="HtotalFacture" name="HtotalFacture" type="hidden" value="<?php echo $factureRef->getTTCPrice(); ?>"/></td>
                        </tr>
                        <tr>
                          <td bgcolor="#EAF0F7"><span><strong>TOTAL des autres acomptes</strong></span></td>
                          <td align="right" bgcolor="#EAF0F7"><div id="totalttcOther"><strong><?php echo $factureRef->getTotalAcompteFormatIgnore($id); ?></strong></div></td>
                        </tr>
                        <tr>
                          <td bgcolor="#5289BA"><span class="Style1"><strong>TOTAL de l'acompte</strong></span></td>
                          <td align="right" bgcolor="#5289BA"><div class="Style1" id="totalttc"><strong><?php echo $acompte->getMontantFormat(); ?></strong></div><input id="Htotalttc" name="Htotalttc" type="hidden" value="<?php echo $acompte->totalTTC; ?>"/></td>
                        </tr>
                        <tr>
                          <td bgcolor="#EAF0F7"><strong>Reste de la facture à payer</strong></td>
                          <td align="right" bgcolor="#EAF0F7"><div id="restettc"><strong><?php echo $factureRef->getResteAPayerTTCFormat(); ?></strong></div><input id="Hrestettc" name="Hrestettc" type="hidden" value="<?php echo $factureRef->getResteAPayerTTC(); ?>"/></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
               </td>
            </tr>
            <tr>
              <td valign="top" bgcolor="#F9F9F9">
                <p class="componentheading"><strong>Suivi de règlement :</strong><br />
                  <img src="images/icones/argent-icone-6943-32.png" alt="" width="32" height="32" /><span style="font-weight: bold"> Acompte payée intégralement le</span>
                  <input name="dateValidation" id="dateValidation" tabindex="10" title="Saisir une date de document en cliquant sur cette zone." value="<?php $d = strtotime($acompte->dateValidite); if (empty($d)) { $d = time(); } echo date('d/m/Y', $d);?>" size="10" alt="date" style="text-align: right;" />
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

<?php $_SESSION['currentAcompte'] = $acompte; ?>
