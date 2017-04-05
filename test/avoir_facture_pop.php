<?php
	require("inc.php");
	require("business/avoirFacture.php");
	
	$idFacture = "";
	if (isset($_GET['idFacture'])) {
		$idFacture = $_GET['idFacture'];
	}

	$action = "load";
	if (isset($_POST['ACTION'])) {
		$action = $_POST['ACTION'];
	}
	
	$avoirMod = new AvoirFacture();
	if ($action == "add") {
		$avoirMod->idFacture = $idFacture;
	} elseif ($action == "load") {
		if (isset($_POST['ID_AVOIR']) && !empty($_POST['ID_AVOIR'])) {
			$avoirMod->findById($_POST['ID_AVOIR']);
		} else {
			$avoirMod->idFacture = $idFacture;
		}
	} elseif ($action == "save") {
		if (isset($_POST['ID_AVOIR']) && !empty($_POST['ID_AVOIR'])) {
			$avoirMod->findById($_POST['ID_AVOIR']);
		} else {
			$avoirMod->idFacture = $idFacture;
		}
		$avoirMod->montant = str_replace(',', '.', $_POST['MONTANT']);
		$avoirMod->dateEmission = date_create_from_format('d/m/Y', $_POST['DATE_AVOIR']);
		$avoirMod->commentaire = $_POST['COMMENTAIRE'];

		if (isset($_POST['ID_AVOIR']) && !empty($_POST['ID_AVOIR'])) {
			$avoirMod->id = $_POST['ID_AVOIR'];
			$avoirMod->update();
		} else {
			$avoirMod->insert();
		}
	}

	$avoirTab = AvoirFacture::findByIdFacture($idFacture);
	$urlBase = "avoir_facture_pop.php?idFacture=" . $idFacture;
	
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
    <script type="text/javascript">
        function selectAvoir(line, idAvoir) 
        {
            var allLines = line.parentElement.children;
            for (i = 0; i < allLines.length; i++) {
				if (i % 2 == 0) {
					allLines[i].style.backgroundColor = "#EAF0F7";
				} else {
					allLines[i].style.backgroundColor = "#F4F8FB";
				}
            }
        	line.style.backgroundColor = "#BBBBBB";
            document.getElementById("ID_AVOIR").value = idAvoir;
        }

        function changeAction(action) 
        {
            document.getElementById("ACTION").value = action;
        }

        function isValidateData() {
        	var validate = true;
        	var dateAvoir = document.getElementById("DATE_AVOIR").value;
        	var montantAvoir = document.getElementById("MONTANT").value;

        	if (!isValidDate(dateAvoir)) {
        		validate = false;
        		document.getElementById("ERROR_MESSAGE").innerHTML = "La date saisie doit être sous la forme 'JJ/MM/AAAA'";
        	} else if (!isValidMontant(montantAvoir)) {
        		validate = false;
        		document.getElementById("ERROR_MESSAGE").innerHTML = "Le montant saisi doit être sous la forme '-000.00'";
        	} else {
        		document.getElementById("ERROR_MESSAGE").innerHTML = "";
        	}
        	
        	return validate;
        }
        
    </script>
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
	<form action="<?php echo $urlBase; ?>" method="post" name="formAvFacture">
		<div>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="art-article">
			<tbody>
			<?php
				if (empty($avoirTab)) {
			?>
				<tr>
					<td align="center"><h2 style="margin-left: 10px;">Aucun avoir déclaré pour cette facture.</h2></td>
				</tr>
			<?php
				} else {
			?>
				<tr>
					<td>
						<table width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td>
									<!-- Liste des pieces -->
									<div id="listeAvoir">
										<center id="tableauListe">
											<table width="100%">
												<!-- Entete du tableau -->
												<thead>
													<tr>
														<td width="20%" bgcolor="#5289BA">
															<p align="center" class="Style7" style="font-size: 11px">Date</p>
														</td>
														<td width="20%" bgcolor="#5289BA">
															<p align="center" class="Style7" style="font-size: 11px">Montant</p>
														</td>
														<td width="60%" bgcolor="#5289BA">
															<p align="center" class="Style7" style="font-size: 11px">Commentaire</p>
														</td>
													</tr>
												</thead>
												<tbody>
													<!-- /Entete du tableau -->
			<?php 
				$toggle = 1;
				foreach ($avoirTab as $avoirSel) {
					if ($avoirSel->id == $avoirMod->id) {
						$bgcolor="#BBBBBB";
					} elseif ($toggle&1) {
						$bgcolor="#EAF0F7";
					} else {
						$bgcolor="#F4F8FB";
					}
			?>
													<tr bgcolor="<?php echo $bgcolor; ?>" onclick="selectAvoir(this, <?php echo $avoirSel->id; ?>); return false;">
														<td align="center" class="Style4" style="padding: 0 10px;">
															<span class="Style4" style="font-size: 11px"><?php echo date_format($avoirSel->dateEmission, 'd/m/Y');?></span>
														</td>
														<td align="right" class="Style4" style="padding: 0 10px;">
															<span class="Style4" style="font-size: 11px"> <?php echo $avoirSel->getMontantFormat();?></span>
														</td>
														<td align="left" class="Style4" style="padding: 0 10px;">
															<span class="Style4" style="font-size: 11px"><?php echo $avoirSel->commentaire;?></span>
														</td>
													</tr>
			<?php
					$toggle++;
				}
			?>
												</tbody>
												<tfoot>
													<tr>
														<td height="2" colspan="9" bgcolor="#5289BA"></td>
													</tr>

													<!-- total general du mois -->
													<!-- total general de la periode -->
												</tfoot>
											</table>
										</center>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			<?php
				}
			?>
				<tr>
					<td height="10" ><div align="right"></div></td>
				</tr>
			<?php
				if (!empty($avoirTab)) {
			?>
                <tr>
	                <td>
	                	<span style="font-weight: bold; margin-left: 10px;">
							<a href="#" onclick="changeAction('load'); document.formAvFacture.submit();">
								<img src="images/icones/modifier-la-page-blanche-icone-8253-32.png" width="32" height="32" align="middle" />Modifier l'avoir sélectionné
							</a>
							<a href="#" onclick="changeAction('add'); document.formAvFacture.submit();">
								<img src="images/icones/ajouter-une-page-blanche-icone-9840-32.png" width="32" height="32" align="middle" />Créer un nouvel avoir
							</a>
						</span>
	                </td>
                </tr>
			<?php
				}
			?>
			</tbody>
		</table>
		</div>
		<div>
		<table>
			<tbody>
                <tr>
	                <td class="errorMessage" colspan="2">
						<label id="ERROR_MESSAGE" />
	                </td>
                </tr>
                <tr>
	                <td class="searchTD">
	                	<span>Date</span>
						<input id="DATE_AVOIR" name="DATE_AVOIR" class="searchInput" type="text" title="Date" size="15" value="<?php echo date_format($avoirMod->dateEmission, 'd/m/Y'); ?>" /> 
	                </td>
	                <td class="searchTD">
	                	<span>Montant</span>
						<input id="MONTANT" name="MONTANT" class="searchInput" type="text" title="Montant" size="15" value="<?php echo $avoirMod->getMontantFormat(); ?>" /> 
	                </td>
                </tr>
                <tr>
	                <td class="searchTD" colspan="2">
	                	<span>Commentaire</span>
						<input id="COMMENTAIRE" name="COMMENTAIRE" class="searchInput" style="width: 435px;" type="text" title="Commentaire" size="50" value="<?php echo $avoirMod->commentaire; ?>" />
	                </td>
                </tr>
                <tr>
	                <td>
						<input id="ID_AVOIR" name="ID_AVOIR" type="hidden" value="<?php echo $avoirMod->id; ?>" />
						<input id="ACTION" name="ACTION" type="hidden" value="<?php echo $action; ?>" />
	                	<span style="font-weight: bold; margin-left: 10px;">
							<a href="#" onclick="if (isValidateData()) {changeAction('save'); document.formAvFacture.submit();}">
								<img src="images/icones/enregistrer-page-icone-7705-32.png" width="32" height="32" align="middle" />Sauvegarder
							</a>
						</span>
	                </td>
                </tr>
			</tbody>
		</table>
		</div>
	</form>
</body>
</html>
