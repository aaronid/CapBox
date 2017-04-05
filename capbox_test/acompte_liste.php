<?php
	require("business/facture.php");
	require("business/tva.php");
	require("inc.php"); 

	// Suppression acompte
	if (isset($_GET['acompte_sup'])) {
		$acompte = new Acompte();
		$acompte->findById($_GET['acompte_sup']);
		$acompte->delete();
	}
	
	// Validation acompte
	if (isset($_GET['acompte_val'])) {
		$acompte = new Acompte();
		$acompte->findById($_GET['acompte_val']);
		$acompte->validate();
	}
	
	// Analyse parametre
	$societe = "";
	if (isset($_GET['societe'])) {
		$societe = $_GET['societe'];
	}
	$hidd = "";
	if (isset($_GET['hidd'])) {
		$hidd=$_GET['hidd'];
	}
	$interlocuteur = "";
	if (isset($_GET['interlocuteur'])) {
		$interlocuteur = $_GET['interlocuteur'];
	}
	$idFacture = "ALL";
	if (isset($_GET['idFacture'])) {
		$idFacture = $_GET['idFacture'];
	}
	$date1 = "";
	if (isset($_GET['date1'])) {
		$date1 = $_GET['date1'];
	}
	$date11 = implode('-',array_reverse(explode('/',$date1)));
	$date2 = "";
	if (isset($_GET['date2'])) {
		$date2 = $_GET['date2'];
	}
	$date22 = implode('-',array_reverse(explode('/',$date2)));
	$sort = "";
	if (isset($_GET['sort'])) {
		$sort = $_GET['sort'];
	}
	if (empty($sort)) {
		$sort = "ac.DATE_EMISSION DESC, ac._ID DESC";
	}
	
	// Pagination
	$pag = "";
	$pagee = "";
	$page = "0";
	if (isset($_GET['page'])) {
		$page = $_GET['page'];
	}
	$nombre = "100";
	if (isset($_GET['nombre'])) {
		$nombre = $_GET['nombre'];
	}
	$url = "?interlocuteur=$interlocuteur&date1=$date1&date2=$date2&societe=$societe&idFacture=$idFacture";

	// Edition CSV de l'acompte
	if (isset($_GET['print'])) {
		header("Content-type: application/vnd.ms-excel"); 
		$inputFile = $societeContact->societe->id . "_acomptes.csv";
		header("Content-disposition: attachment; filename=$inputFile");
		$allTva = Tva::findAll();
				
		$csv = "SUIVI PAR;REFERENCE;DESTINATAIRE;DATE EMISSION; OBJET;MONTANT TTC;PAYE;PAYE LE;COMMENTAIRES\n";
		
		$arr = array();
		$quete = " AND ";
		//$quete="WHERE ";
		if (!empty($interlocuteur)) {
			$nom = "ID_SOCIETE_CONTACT = $interlocuteur";
			array_push ($arr, $nom);
		}
		if (!empty($societe)) {
			$nom2 = "ID_SOCIETE_CLIENT = $societe";
			array_push ($arr, $nom2);
		}
		if (!empty($_GET['validation'])) {
			$nom = "VALIDATION= 0";
			array_push ($arr, $nom);
		}
		if (!empty($date1)) {
			$prenom = "DATE_EMISSION >= '$date11'";
			array_push ($arr, $prenom);
		}
		if (!empty($date2)) {
			$societe = "DATE_EMISSION <= '$date22'";
			array_push ($arr, $societe);
		}
		$count = count($arr);
		if (!empty($count)) {
			for ($i=0; $i<$count ; $i++) {
				if (!empty($i)) {
					$quete = $quete." AND ";
				}
				$quete = $quete.$arr[$i];
			}
			// $quete = $quete.$arr[$count];
		} else {
			$quete = "";
		}

		$select = "select * from acompte WHERE ID_SOCIETE = " . $societeContact->societe->id . " " . $quete;
		$result = mysql_query($select);
		while ($val=mysql_fetch_array($result)) {
			if (empty($val["VALIDATION"])) {
				$valVALIDATION = "NON";
				$val["DATE_VALIDITE"] = "";
			} else {
				$valVALIDATION = "OUI";
			}
			$interloc="select INITIALE from societe_contact where _ID='" . $val['ID_SOCIETE_CONTACT'] . "'";
			$interloc1=mysql_query($interloc);
			$interloc2=mysql_fetch_array($interloc1);
			$destinat1=mysql_query("select ENTREPRISE, NOM from societe_client where _ID='" . $val['ID_SOCIETE_CLIENT'] . "'");
			$destinat2=mysql_fetch_array($destinat1);
			$destinat=$destinat2['ENTREPRISE']." - ".$destinat2['NOM'];

			$str = str_replace(CHR(10)," ",$val["COMMENTAIRE"]);
			$str = str_replace(CHR(13)," ",$str);

			$titre = str_replace(CHR(10)," ",$val["TITRE"]);
			$titre = str_replace(CHR(13)," ",$titre);
			
			$acompteEdit = new Acompte();
			$acompteEdit->findById($val['_ID']);

			$csv .= utf8_decode($interloc2["INITIALE"]).';'. utf8_decode($val["REFERENCE"]).';'. utf8_decode($destinat).';'. utf8_decode($val["DATE_EMISSION"]).';'. utf8_decode($titre); 
			$csv .= ';'.$acompteEdit->getMontantFormat().';'. utf8_decode($val["VALIDATION"]).';'. utf8_decode($val["DATE_VALIDITE"]).';'. utf8_decode($str)."\n";
		} 
		print($csv); 
		exit; 
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
    <script type="text/javascript">
	function ex(acompte)
	{
		var x=confirm("Etes-vous sûr de supprimer cet acompte ?")
		if (x)
			window.location = "acompte_liste.php?acompte_sup=" + acompte;
	}
	function fex(acompte)
	{
		var x=confirm("Etes-vous sûr de valider cet acompte ?")
		if (x)
			window.location = "acompte_liste.php?acompte_val=" + acompte;
	}
	function zex(acompte)
	{
		var x=confirm("Etes-vous sûr de valider cet acompte ?")
		if (x)
			window.location = "acompte.php?id=" + acompte;
	}
	function go() 
	{
		window.location=document.getElementById("menu").value;
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
											<img src="images/postheadericon.png" width="26" height="26" alt="postheadericon" /> Liste de vos acomptes
										</h2>
										<div class="art-postcontent">
											<!-- article-content -->

											<form action="" method="get" name="form1">
												<table width="100%" border="0" cellpadding="0" cellspacing="0" class="art-article">
													<tbody>
													<?php require("turl.php");?>
														<tr>
															<td colspan="10">
															<table width="100%" cellpadding="0" cellspacing="0">
																<tr>
																	<td height="32" background="images/fd_nav_ss_menu.png" bgcolor="#F0F0F0" colspan="3">
																		<span style="font-weight: bold">
<!-- 																			<a href="acompte.php">
																				<img src="images/icones/ajouter-une-page-blanche-icone-9840-32.png" alt="" width="24" height="24" align="middle" />
																				<span>Créer un nouvel acompte</span>
																			</a>
																			<img src="images/menuseparator.png" width="1" height="24" align="middle" />
 -->																			<a href="<?php echo"$url&print=1"; ?>">
																				<img src="images/icones/page-excel-icone-6057-32.png" width="24" height="24" align="middle" />
																				<span>Export</span>
																			</a>
																			<img src="images/menuseparator.png" width="1" height="24" align="middle" />
																			<?php if (empty($_GET['validation'])) { ?>
																			<a href="<?php echo"$url&page=$pag&nombre=$nombre&validation=VALIDATION"; ?>">
																				<img src="images/icones/temps-qui-passe-icone-6367-32.png" width="24" height="24" align="middle" />
																				<span>Voir les acomptes en attente de paiement</span>
																			</a>
																			<?php } else { ?>
																			<a href="<?php echo"$url&page=$pag&nombre=$nombre&validation="; ?>">
																				<img src="images/icones/temps-qui-passe-icone-6367-32.png" width="24" height="24" align="middle" />
																				<span>Voir tous les acomptes</span>
																			</a>
																			<?php } ?>
																		</span>
																	</td>
																</tr>
																<!--startprint-->
																<tr>
													                <td class="searchTD">
													                  <span>Suivi par </span>
													                  <select name="interlocuteur" id="interlocuteur" class="searchSelect">
																	    <option value=""></option>
		<?php
			$iselect = mysql_query("select DISTINCT soco.INITIALE, soco._ID FROM acompte JOIN societe_contact soco WHERE acompte.ID_SOCIETE = " . $societeContact->societe->id . " AND soco.ID_SOCIETE = " . $societeContact->societe->id . " ");
			while ($iresul = mysql_fetch_array($iselect)) {
				if($interlocuteur==$iresul['_ID']){
					$selected = " selected=\"selected\"";
				} else {
					$selected = "";
				}
				echo "<option value=\"" . $iresul['_ID'] . "\" $selected>" . $iresul['INITIALE'] . "</option>";
			}
		?>
																	  </select>
													                </td>
																	<td class="searchTD">
													                  <span>Client </span>
													                  <select name="societe" id="societe" class="searchSelect">
																	    <option value=""></option>
		<?php
			$sselect = mysql_query("select * FROM societe_client WHERE ID_SOCIETE = " . $societeContact->societe->id . " ");
			while ($sresul = mysql_fetch_array($sselect)) {
				if ($societe == $sresul['_ID']) {
					$selected = " selected=\"selected\"";
				} else {
					$selected = "";
				}
				echo "<option value=\"" . $sresul['_ID'] . "\" $selected>" . $sresul['NOM'] . " - " . $sresul['ENTREPRISE'] . "</option>";
			}
		?>
																	  </select>
													                </td>
																	<td class="searchTD">
													                  <span>Facture </span>
													                  <select name="idFacture" id="idFacture" class="searchSelect">
		<?php
			if ($idFacture == "ALL") {
				$selected = " selected=\"selected\"";
			} else {
				$selected = "";
			}
			echo "<option value=\"ALL\" $selected>toutes</option>";

			$fselect = mysql_query("select DISTINCT a.FACTURE, f.REFERENCE from acompte a, facture f where a.ID_SOCIETE = " . $societeContact->societe->id . " AND a.FACTURE IS NOT NULL AND f._ID = a.FACTURE");
			while ($fresul = mysql_fetch_array($fselect)) {
				if ($idFacture == $fresul['FACTURE']) {
					$selected = " selected=\"selected\"";
				} else {
					$selected = "";
				}
				echo "<option value=\"" . $fresul['FACTURE'] . "\" $selected>" . $fresul['REFERENCE'] . "</option>";
			}
		?>
																	  </select>
													                </td>
													              </tr>
													              <tr>
													                <td class="searchTD">
													                  <span>Date de début </span>
													                  <input name="date1" class="searchInput" type="text" id="date1" title="Sélectionner une date de début de période en cliquant sur cette zone" value="<?php echo $date1; ?>" alt="date" />
													                </td>
													                <td class="searchTD">
													                  <span>Date de fin </span>
													                  <input name="date2" class="searchInput" type="text" id="date2" title="Sélectionner une date de fin de période en cliquant sur cette zone" value="<?php echo $date2; ?>" alt="date" />
													                </td>
													                <td class="searchTD">
													                </td>
													              </tr>
													              <tr>
													                <td colspan="3">
													                    <span style="font-weight: bold">
													                        <a href="#" onclick="document.forms['form1'].submit();">
													                            <img src="images/icones/loupe-icone-4171-32.png" width="32" height="32" align="middle"/>Rechercher
													                        </a>
													                        <a href="acompte_liste.php">
																		        <img src="images/icones/arrow-rotation-anti-horaire-icone-4507-32.png" width="32" height="32" align="middle"/>Réinitialiser
																		    </a>
																	    </span>
													                </td>
													              </tr>
												            </table>
															<table width="100%" cellpadding="0" cellspacing="0">
												      
																	<tr>
																		<td>
																			<!-- Liste des pieces -->
																			<div id="listePiece">
																				<!-- Confirmation Piece -->

																				<!-- /Confirmation Piece -->
																				<center id="tableauListe">
																					<!-- Pagination -->
																					<table width="100%">
																						<!-- Entete du tableau -->

																						<tbody>

																							<tr>
																								<th width="38" align="center" bgcolor="#5289BA"><span
																									class="Style1" style="font-size: 11px"> Suivi </span>
																								</th>
																								<th width="56" align="center" bgcolor="#5289BA"><span
																									class="Style1" style="font-size: 11px"> Date </span>
																								</th>
																								<th width="96" bgcolor="#5289BA"><span
																									class="Style1" style="font-size: 11px"> Réf. </span>
																								</th>
																								<th width="96" bgcolor="#5289BA"><span
																									class="Style1" style="font-size: 11px"> Réf. facture </span>
																								</th>
																								<th width="132" bgcolor="#5289BA"><span
																									class="Style1" style="font-size: 11px"> Client
																								</span></th>
																								<th width="210" bgcolor="#5289BA"><span
																									class="Style1" style="font-size: 11px"> Objet </span>
																								</th>
																								<th width="150" bgcolor="#5289BA"><span
																									class="Style1" style="font-size: 11px"> Montant HT</span></th>
																								<th width="75" bgcolor="#5289BA"><span
																									class="Style1" style="font-size: 11px"> Payée </span>
																								</th>
																								<!--th class="data-table">                    Acompte                </th-->
																								<th width="113" bgcolor="#5289BA"><span
																									class="Style1" style="font-size: 11px"> Actions</span>
																								</th>
																							</tr>
																							<!-- /Entete du tableau -->
																							<!-- Corps du tableau -->
																							<tr>
																								<td bgcolor="#CDDDEB">
																									<!-- <div align="center">
																										<a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=ID_SOCIETE_CONTACT "; ?>">
																											<img src="images/icones/icon-max.gif" width="17" height="16" />
																										</a>
																										<a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=ID_SOCIETE_CONTACT DESC"; ?>">
																											<img src="images/icones/icon-min.gif" width="17" height="16" />
																										</a>
																									</div> -->
																								</td>
																								<td bgcolor="#CDDDEB">
																									<div align="center">
																										<a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=ac.DATE_EMISSION "; ?>">
																											<img src="images/icones/icon-max.gif" width="17" height="16" />
																										</a>
																										<a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=ac.DATE_EMISSION DESC"; ?>">
																											<img src="images/icones/icon-min.gif" width="17" height="16" />
																										</a>
																									</div>
																								</td>
																								<td bgcolor="#CDDDEB">
																									<div align="center">
																										<a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=ac.REFERENCE"; ?>">
																											<img src="images/icones/icon-max.gif" width="17" height="16" />
																										</a>
																										<a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=ac.REFERENCE DESC"; ?>">
																											<img src="images/icones/icon-min.gif" width="17" height="16" />
																										</a>
																									</div>
																								</td>
																								<td bgcolor="#CDDDEB">&nbsp;</td>
																								<td bgcolor="#CDDDEB">
																									<!--<div align="center"><a href="<?php //echo"$url&page=$pag&nombre=$nombre&sort=DESTINATAIRE"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<?php //echo"$url&page=$pag&nombre=$nombre&sort=DESTINATAIRE DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div>-->
																								</td>
																								<td bgcolor="#CDDDEB">
																									<div align="center">
																										<a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=ac.TITRE"; ?>">
																											<img src="images/icones/icon-max.gif" width="17" height="16" />
																										</a>
																										<a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=ac.TITRE DESC"; ?>">
																											<img src="images/icones/icon-min.gif" width="17" height="16" />
																										</a>
																									</div>
																								</td>
																								<td bgcolor="#CDDDEB">
																									<div align="center">
																										<a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=ac.TOTAL_TTC"; ?>">
																											<img src="images/icones/icon-max.gif" width="17" height="16" />
																										</a>
																										<a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=ac.TOTAL_TTC DESC"; ?>">
																											<img src="images/icones/icon-min.gif" width="17" height="16" />
																										</a>
																									</div>
																								</td>
																								<td align="left" bgcolor="#CDDDEB">&nbsp;</td>
																								<td align="left" bgcolor="#CDDDEB">&nbsp;</td>
																							</tr>

			<?php
				//tri
				$arr=array();
				$quete=" AND ";
				//$quete="WHERE ";
				if(!empty($interlocuteur)){
					$nom="fa.ID_SOCIETE_CONTACT = $interlocuteur";
					array_push ($arr, $nom);
				}
				if(!empty($societe)){
					$nom2="fa.ID_SOCIETE_CLIENT = $societe";
					array_push ($arr, $nom2);
				}
				if(!empty($_GET['validation'])){
					$nom="ac.VALIDATION = 0";
					array_push ($arr, $nom);
				}
				if(!empty($date1)){
					$prenom="ac.DATE_EMISSION >= '$date11'";
					array_push ($arr, $prenom);
				}
				if(!empty($date2)){
					$societe="ac.DATE_EMISSION <= '$date22'";
					array_push ($arr, $societe);
				}
				if($idFacture != "ALL"){
					$facture="ac.FACTURE = '$idFacture'";
					array_push ($arr, $facture);
				}
				$count=count($arr);
				if(!empty($count)){
					for($i=0; $i<$count ; $i++){
						if(!empty($i)){
							$quete=$quete." AND ";
						}
						$quete=$quete.$arr[$i];
					}
					//$quete=$quete.$arr[$count];
				}
				else{
					$quete="";
				}
					
				$parametres="order by ".$sort. " LIMIT ".$page*$nombre. ",".$nombre;
					
				$select=mysql_query("select ac._ID from acompte ac, facture fa WHERE ac.FACTURE = fa._ID AND ac.ID_SOCIETE = " . $societeContact->societe->id . " " . $quete . " " . $parametres) or die(mysql_error());
				$selecti=mysql_query("select * from acompte ac, facture fa WHERE ac.FACTURE = fa._ID AND ac.ID_SOCIETE = " . $societeContact->societe->id . " " . $quete);
				$totp=mysql_num_rows($selecti);
				$toggle="";
				$totalpage=0.0;
				while($fetch=mysql_fetch_array($select)){
					$acompte = new Acompte();
					$acompte->findById($fetch['_ID']);
					$factAcompte = new Facture();
					$factAcompte->findById($acompte->idFacture);
					if($toggle&1){
						$bgcolor="#EAF0F7";
					}
					else{
						$bgcolor="#F4F8FB";
					}
			?>
																							<tr bgcolor="<?php echo $bgcolor; ?>">
																								<td><span style="font-size: 11px"> 
			<?php 
				$interloc="select INITIALE from societe_contact where _ID=" . $factAcompte->idSocieteContact;
				$interloc1=mysql_query($interloc);
				$interloc2=mysql_fetch_array($interloc1);
				echo $interloc2['INITIALE'];
			?> </span></td>
																								<td><span style="font-size: 11px"> <?php $d = $acompte->dateEmission; echo date("d/m/Y", strtotime($d)); ?>
																								</span></td>
																								<td><span style="font-size: 11px"> <?php echo $acompte->reference; ?> 
																								</span></td>
																								<td><span style="font-size: 11px"> <?php echo $factAcompte->reference; ?> 
																								</span></td>
																								<!-- Tier  -->
																								<td align="left"><span style="font-size: 11px">
																										<?php
						  $requet="select * from societe_client where _ID='" . $factAcompte->idSocieteClient . "'";
						  $resul=mysql_query($requet);
						  $contact=mysql_fetch_array($resul);
						  echo $contact['CIVILITE']." ".mb_strtoupper($contact['NOM'],'UTF-8')." - ".mb_strtoupper($contact['ENTREPRISE'],'UTF-8');
						  ?> </span></td>
																								<td align="left"><?php echo $acompte->titre; ?>
																								</td>
																								<td align="right"><span style="font-size: 11px">
																										<?php echo $acompte->getMontantFormat();
						  ?> </span></td>
																								<td align="left">
																									<div align="center">
																										<?php if(empty($acompte->validation)){ ?>
																										<a href="#" onclick="fex(<?php echo $acompte->id; ?>);">
																											<img alt="Payée aujourd'hui ?" id="imgTransferer3" src="images/icones/date-de-modifier-icone-6352-16.png" title="Payée aujourd'hui ?" width="16" height="16" />
																										</a>
																										<?php }else{  $d=$acompte->dateValidite; echo date("d/m/Y",strtotime($d));  } ?>
																									</div>
																								</td>
																								<td align="left">
																									<div align="center" style="font-size: 11px">
																										<?php if(empty($acompte->validation)){ ?>
																										<a
																											href="acompte.php?id=<?php echo $acompte->id; ?>"><img
																											src="images/icones/transp-16.png"
																											title="déjà payée" width="16" height="16" /><img
																											src="images/icones/editer_16.png"
																											alt="Modifier" name="imgModifier2" width="16"
																											height="16" id="imgModifier3"
																											title="Modifier" />
																										</a>
																										<?php }else{ ?>
																											<img alt="déjà payée" i
																												src="images/icones/tick-icone-8838-32.png"
																												title="déjà payée" width="16" height="16" /><a
																												href="#"
																												onclick="zex(<?php echo $acompte->id; ?>);"><img
																												src="images/icones/cadenas-ouvert-icone-4601-16.png"
																												title="déjà payée" width="16" height="16" />
																										</a>
																										<?php } ?>
																										<a
																											href="acompte.php?dup=<?php echo $acompte->id; ?>"><img
																											alt="Recopier" id="imgRecopie3"
																											src="images/icones/copie_16.png"
																											title="Recopier" width="16" height="16" /> </a>&nbsp;&nbsp;<a
																											href="acompte_pdf.php?id=<?php echo $acompte->id; ?>"
																											target="_blank"><img alt="Imprimer"
																											id="imgPDF3"
																											src="images/icones/imprimante-icone-5571-16.png"
																											title="Imprimer" width="16" height="16" />
																										</a>
																										<?php if(empty($acompte->validation)){ ?>
																										<a href="#"
																											onclick="ex(<?php echo $acompte->id; ?>);"><img
																											alt="Supprimer" id="imgSupprimer3"*
																											src="images/icones/supprimer_16.png"
																											title="Supprimer" width="16" height="16" />
																										</a>
																										<?php
																											}
																										?>
																									</div>
																								</td>
																							</tr>
																							<?php
						$toggle++;
					 	$totalpage = $totalpage + $acompte->getMontantFormat();
						 } ?>
																							<!-- total general du mois -->
																							<!-- total general de la periode -->
																							<tr>
																								<td height="2" colspan="9" bgcolor="#5289BA"></td>
																							</tr>
																							<tr>
																								<td colspan="5"> </td>
																								<td align="right">TOTAL PAGE</td>
																								<td align="right" bgcolor="#5289BA"><span
																									class="Style1"><strong><?php echo number_format($totalpage, 2, ',', ' '); ?>
																									</strong> </span>
																								</td>
																								<td colspan="2"> </td>
																							</tr>
																						</tbody>
																					</table>
																				</center>
																			</div></td>
																	</tr>

																</table></td>
														</tr>
														<tr>
															<td colspan="8"><div align="right"></div></td>
														</tr>
														<tr>
															<td colspan="8"><p align="center">
																	Nombre d'articles par page <select name="select5"
																		id="menu" onchange="go()">
																		<option
																			value="<?php echo"$url&page=$pag&nombre=10&sort=$sort"; ?>"
																			<?php if($nombre==10){ echo "selected=\"selected\""; }?>>10</option>
																		<option
																			value="<?php echo"$url&page=$pag&nombre=50&sort=$sort"; ?>"
																			<?php if($nombre==50){ echo "selected=\"selected\""; }?>>50</option>
																		<option
																			value="<?php echo"$url&page=$pag&nombre=100&sort=$sort"; ?>"
																			<?php if($nombre==100){ echo "selected=\"selected\""; }?>>100</option>
																	</select>
																</p>
																<p align="center">
																	<?php 
																	  $pag=$page-1;
																	  $pagee=$page+1;
																	  $totpages=ceil($totp/$nombre);
																	  
																	  if($pag>=0){?>
																	<a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=$sort"; ?>">Précédent</a>
																	|
																	<?php } ?>
																	Page
																	<?php echo $pagee; ?>
																	sur
																	<?php echo $totpages; if($pagee<$totpages){?>
																	| <a href="<?php echo"$url&page=$pagee&nombre=$nombre&sort=$sort"; ?>">Suivant</a>
																	<?php } ?>
																</p>
															</td>
														</tr>
													</tbody>
												</table>
												<!--endprint-->
											</form>

											<!-- /article-content -->
										</div>
										<div class="cleared"></div>
									</div>
									<div class="cleared"></div>

									<div class="cleared"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="cleared"></div>
				<div class="art-footer">
					<div class="art-footer-inner">
						<div class="art-footer-text">
							<p>
								<a href="#">Nous contacter</a> | <a href="#">Conditions
									d'utilisation</a> | <a href="#">Mentions légales</a> | <br />
								Copyright &copy; 2010 - Tous droits réservés
							</p>
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
