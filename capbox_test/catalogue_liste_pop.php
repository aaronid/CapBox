<?php
	require("inc.php");
	$pop="";
	if (isset($_GET['pop'])) {
		$pop=$_GET['pop'];
	}
	
	$catalogue = "";
	if (!empty($societeContact->societe->catalogue)) {
		$catalogue = "cataloguep";
	}
	if (isset($_GET['catalogue'])) {
		$catalogue=$_GET['catalogue'];
	}
	$quete22 = "";
	if ($catalogue == "cataloguep"){
		$quete22=" WHERE ID_SOCIETE = " . $societeContact->societe->id . " ";
	}
	$famille="";
	if (isset($_GET['famille'])) {
		$famille=$_GET['famille'];
	}
	$sousFamille="";
	if (isset($_GET['sousFamille'])) {
		$sousFamille=$_GET['sousFamille'];
	}
	$marque="";
	if (isset($_GET['marque'])) {
		$marque=$_GET['marque'];
	}
	$fournisseur="";
	if (isset($_GET['fournisseur'])) {
		$fournisseur=$_GET['fournisseur'];
	}
	$refFabricant="";
	if (isset($_GET['refFabricant'])) {
		$refFabricant=$_GET['refFabricant'];
	}
	$refDistributeur="";
	if (isset($_GET['refDistributeur'])) {
		$refDistributeur=$_GET['refDistributeur'];
	}
	$designation="";
	if (isset($_GET['designation'])) {
		$designation=$_GET['designation'];
	}
	$hidd="";
	if (isset($_GET['hidd'])) {
		$hidd=$_GET['hidd'];
	}
	$sort="FAMILLE,SOUS_FAMILLE,MARQUE";
	if (isset($_GET['sort'])) {
		$sort=$_GET['sort'];
	}
	$pag="";
	$pagee="";
	$page="0";
	if (isset($_GET['page'])) {
		$page=$_GET['page'];
	}
	$nombre="50";
	if (isset($_GET['nombre'])) {
		$nombre=$_GET['nombre'];
	}
	$url="?pop=$pop&catalogue=$catalogue&famille=$famille&fournisseur=$fournisseur&marque=$marque&refFabricant=$refFabricant&refDistributeur=$refDistributeur&designation=$designation";
	if ($catalogue=="cataloguep"){
		$quete22="WHERE ID_SOCIETE = " . $societeContact->societe->id;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US"
	xml:lang="en">
<head>
<!--
    Created by Artisteer v2.4.0.25435
    Base template (without user's data) checked by http://validator.w3.org : "This page is valid XHTML 1.0 Transitional"
    -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>CAP BOX</title>
<script type="text/javascript" src="script.js"></script>
<script type="text/javascript">

// Listes completes
var famille = new Array();
famille.push('');
var sousFamille = new Array();
sousFamille.push('');
var marque = new Array();
marque.push('');

// Tableaux correspondances
var famille_sousFamille = new Array();
var famille_marque = new Array();
var sousFamille_marque = new Array();

<?php 
	if (empty($catalogue)) { 
		$familleSousFamMarqueTri = mysql_query("(select DISTINCT FAMILLE, SOUS_FAMILLE, MARQUE from catalogue) UNION (select DISTINCT FAMILLE, SOUS_FAMILLE, MARQUE from cataloguep WHERE ID_SOCIETE = " . $societeContact->societe->id . ") ORDER BY FAMILLE, SOUS_FAMILLE, MARQUE");
		// $marquetri = mysql_query("(select DISTINCT FAMILLE, MARQUE from catalogue) UNION (select DISTINCT FAMILLE, MARQUE from cataloguep WHERE ID_SOCIETE = " . $societeContact->societe->id . ") ORDER BY FAMILLE");
	} else {
		$familleSousFamMarqueTri = mysql_query("select DISTINCT FAMILLE, SOUS_FAMILLE, MARQUE from $catalogue $quete22 ORDER BY FAMILLE, SOUS_FAMILLE, MARQUE");
		// $marquetri = mysql_query("select DISTINCT FAMILLE, MARQUE from $catalogue  $quete22 ORDER BY FAMILLE");
	}
	$familleRef = "";
	$sousFamRef = "";
	$marqueRef = "";

	while ($aResult = mysql_fetch_assoc($familleSousFamMarqueTri)) {
		$familleRes = $aResult['FAMILLE'];
		$sousFamRes = $aResult['SOUS_FAMILLE'];
		$marqueRes = $aResult['MARQUE'];

		if (empty($familleRes)) {
			$familleRes = "Non renseigné";
		}
		if (empty($sousFamRes)) {
			$sousFamRes = "Non renseigné";
		}
		if (empty($marqueRes)) {
			$marqueRes = "Non renseigné";
		}
		
		if ($familleRes != $familleRef) {
			echo "famille.push(\"$familleRes\");\n";
			echo "famille_sousFamille[\"$familleRes\"]= new Array();\n";
			echo "famille_sousFamille[\"$familleRes\"].push(\"\");\n";
			echo "famille_marque[\"$familleRes\"]= new Array();\n";
			echo "famille_marque[\"$familleRes\"].push(\"\");\n";

			$familleRef = $familleRes;
		}

		if ($sousFamRes != $sousFamRef) {
			echo "sousFamille.push(\"$sousFamRes\");\n";
			echo "sousFamille_marque[\"$sousFamRes\"]= new Array();\n";
			echo "sousFamille_marque[\"$sousFamRes\"].push(\"\");\n";

			echo "famille_sousFamille[\"$familleRes\"].push(\"$sousFamRes\");\n";
			$sousFamRef = $sousFamRes;
		}
		
		echo "marque.push(\"$marqueRes\");\n";
		echo "famille_marque[\"$familleRes\"].push(\"$marqueRes\");\n";
		echo "sousFamille_marque[\"$sousFamRes\"].push(\"$marqueRes\");\n";
	}

?>

function reloadSsFamilleSelect() {
	var famSelect = document.getElementById('famille').value;

	var listeSsFam = sousFamille;
	if (famSelect) {
		listeSsFam = famille_sousFamille[famSelect];
	}

	document.frm1.sousFamille.options.length = listeSsFam.length;
	for (i = 0; i < listeSsFam.length; i++) {
		document.frm1.sousFamille.options[i].value = listeSsFam[i];
		document.frm1.sousFamille.options[i].text = listeSsFam[i];
	}
	document.frm1.sousFamille.options.selectedIndex = 0;

	reloadMarqueSelect();
}

function reloadMarqueSelect() {
	var sousFamSelect = document.getElementById('sousFamille').value;
	var famSelect = document.getElementById('famille').value;

	var listeMarque = marque;
	if (sousFamSelect) {
		listeMarque = sousFamille_marque[sousFamSelect];
	} else if (famSelect) {
		listeMarque = famille_marque[famSelect];
	}

	document.frm1.marque.options.length = listeMarque.length;
	for (i = 0; i < listeMarque.length; i++) {
		document.frm1.marque.options[i].value = listeMarque[i];
		document.frm1.marque.options[i].text = listeMarque[i];
	}
	document.frm1.marque.options.selectedIndex = 0;
}

function go() 
{
	window.location=document.getElementById("menu").value;
}

function toggle(id) {
	if (document.getElementById) {
		var cdiv = document.getElementById(id);
			   	  
		if (cdiv) {
			if (cdiv.className != 'minimized')
				cdiv.className = 'minimized';
			else
				cdiv.className = '';
		}
	}   
}
</script>
<link rel="stylesheet" href="style.css" type="text/css" />
<!--[if IE 6]><link rel="stylesheet" href="style.ie6.css" type="text/css"  /><![endif]-->
<!--[if IE 7]><link rel="stylesheet" href="style.ie7.css" type="text/css"  /><![endif]-->
<style type="text/css">
	<!--
	.Style1 {
		color: #FFFFFF
	}
	
	.Style4 {
		font-size: 85%
	}
	
	.Style6 {
		font-size: 85%;
		font-weight: bold;
	}
	
	.Style7 {
		font-size: 85%;
		font-weight: bold;
		color: #FFFFFF;
	}
	
	.minimized {
		display: none;
	}
	-->
</style>
</head>
<body>
	<table width="100%" border="0" cellpadding="0" cellspacing="0"
		class="art-article">
		<tbody>
			<tr>
				<td bgcolor="#F9F9F9">
					<!-- Periode de recherche --> <!-- Periode de recherche -->
					<form action="" method="get" name="frm1" id="frm1">
						<div>
							<h2>
								<strong> Rechercher et comparer parmi tous les articles du catalogue</strong>
								<input type="hidden" name="pop" value="<?php echo $pop; ?>" />
							</h2>
			                <table class="searchTable">
			                	<tbody></tbody>
			                <?php if(empty($societeContact->societe->catalogue)){ ?>
			               	<tr>
			                <td class="searchTD">
								<span>Catalogue </span>
								<select name="catalogue" id="select4" class="searchSelect">
									<option></option>
									<option value="catalogue" <?php if($catalogue=='catalogue'){echo"selected"; }?>>CAP ACHAT</option>
									<option value="cataloguep" <?php if($catalogue=='cataloguep'){echo"selected"; }?>>Mon catalogue personnel</option>
								</select>
			                </td>
			               	</tr>
							<?php } ?>
			                <tr>
			                <td class="searchTD">
								<span>Famille </span>
								<select name="famille" id="famille" class="searchSelect" onchange="reloadSsFamilleSelect();">
								<script>
									var lesFamilles = famille;  
									for (i=0; i<lesFamilles.length; i++) {
										var nwChild = document.createElement("option");
										nwChild.setAttribute( "value", lesFamilles[i] );
										if (lesFamilles[i] == '<?php echo $famille; ?>') {
											nwChild.setAttribute("selected", "selected");
										}
										nwChild.appendChild( document.createTextNode(lesFamilles[i]));
										document.getElementById("famille").appendChild( nwChild );
									}
								</script>
								</select>
			                </td>
			                <td class="searchTD">
			                  <span>Sous famille </span>
							  <select name="sousFamille" id="sousFamille" class="searchSelect" onchange="reloadMarqueSelect();">
					              <script>			  
									var famSelect = document.getElementById('famille').value;
									var lesSousFamilles = sousFamille;
									if (famSelect) {
										lesSousFamilles = famille_sousFamille[famSelect];
									}
									for (i=0; i<lesSousFamilles.length; i++) {
										var nwChild = document.createElement( "option" );
										nwChild.setAttribute( "value", lesSousFamilles[i] );
										if (lesSousFamilles[i]=='<?php echo $sousFamille; ?>') {
											nwChild.setAttribute( "selected", "selected");
										}	
										nwChild.appendChild( document.createTextNode(lesSousFamilles[i]));
										document.getElementById( "sousFamille" ).appendChild( nwChild );
									}
					    
								  </script>
				              </select>
			                </td>
			                <td class="searchTD">
			                	<span>Marque </span>
								<select name="marque" id="marque" class="searchSelect">
								<script>
										var famSelect = document.getElementById('famille').value;
										var sousFamSelect = document.getElementById('sousFamille').value;
										var lesMarques = marque;
										if (sousFamSelect) {
											lesMarques = sousFamille_marque[sousFamSelect];
										} else if (famSelect) {
											lesMarques = famille_marque[famSelect];
										}
										for (i=0; i<lesMarques.length; i++) {
											var newChild = document.createElement("option");
											newChild.setAttribute( "value", lesMarques[i]);
											if (lesMarques[i] == '<?php echo $marque; ?>') {
												newChild.setAttribute("selected", "selected");
											}
											newChild.appendChild( document.createTextNode(lesMarques[i]));
											document.getElementById("marque").appendChild( newChild );
										}
	
								</script>
								</select>
			                </td>
			                </tr>
			                <tr>
			                <td class="searchTD">
			                	<span>Fournisseur </span> 
								<select name="fournisseur" id="select2" class="searchSelect">
									<option></option>
									<?php
										if(empty($catalogue)){ 
											$tri=mysql_query("(select DISTINCT FOURNISSEUR from catalogue) UNION (select DISTINCT FOURNISSEUR from cataloguep WHERE ID_SOCIETE = " . $societeContact->societe->id . ") ORDER BY FOURNISSEUR");
										}else{
											$tri=mysql_query("select DISTINCT FOURNISSEUR from $catalogue $quete22 ORDER BY FOURNISSEUR");
										}
										while($tri1=mysql_fetch_array($tri)) {
									?>
											<option value=<?php echo "\"".$tri1['FOURNISSEUR']."\"";  if($fournisseur==$tri1['FOURNISSEUR']){echo " selected=\"selected\""; }?>><?php echo $tri1['FOURNISSEUR']; ?></option>
									<?php 
										}
									?>
								</select>
			                </td>
			                <td class="searchTD">
			                	<span>Ref. Fabricant </span>
								<input name="refFabricant" class="searchInput" type="text" id="refFabricant" title="Saisir une référence exacte" size="15" value="<?php echo $refFabricant; ?>" /> 
			                </td>
			                <td class="searchTD">
			                	<span>Ref. Distributeur </span>
								<input name="refDistributeur" class="searchInput" type="text" id="refDistributeur" title="Saisir une référence exacte" size="15" value="<?php echo $refDistributeur; ?>" /> 
			                </td>
			                </tr>
			                <tr>
			                <td class="searchTD">
			                	<span>Désignation </span>
								<input name="designation" class="searchInput" type="text" id="DateDebut5" title="Saisir le texte d'une désignation produit" size="20" value="<?php echo $designation; ?>" />
			                </td>
			                <td></td>
			                <td></td>
			                </tr>
			                <tr>
			                <td>
			                	<span style="font-weight: bold">
									<a href="#" onclick="document.forms['frm1'].submit();">
										<img src="images/icones/loupe-icone-4171-32.png" width="32" height="32" align="absmiddle" />Rechercher
									</a>
									<a href="catalogue_liste_pop.php?pop=<?php echo $pop; ?>">
										<img src="images/icones/arrow-rotation-anti-horaire-icone-4507-32.png" width="32" height="32" align="absmiddle" />Réinitialiser
									</a>
								</span>
			                </td>
			                </tr>
			                </table>
						</div>
					</form> <!-- /Periode de recherche --> <!-- /Periode de recherche -->
				</td>
			</tr>

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
										<td width="2%" bgcolor="#5289BA" class="Style7">
											<div align="center" style="font-size: 11px">
												<span class="Style7"></span><span class="Style7">Cocher </span>
											</div>
										</td>
										<td width="7%" bgcolor="#5289BA" class="Style7">
											<div align="center" style="font-size: 11px">
												<span class="Style7">Famille</span>
											</div>
										</td>
										<td width="7%" bgcolor="#5289BA" class="Style7">
											<div align="center" style="font-size: 11px">
												<span class="Style7">Sous famille</span>
											</div>
										</td>
										<td width="12%" bgcolor="#5289BA" class="Style7">
											<div align="center" style="font-size: 11px">
												<span class="Style7">Marque</span>
											</div>
										</td>
										<td width="10%" bgcolor="#5289BA" class="Style7">
											<p align="center" style="font-size: 11px">
												<span class="Style7">Fournisseur<br /> </span>
											</p>
										</td>
										<td width="24%" bgcolor="#5289BA">
											<div align="center" style="font-size: 11px">
												<span class="Style7">Désignation</span>
											</div>
										</td>
										<td width="8%" bgcolor="#5289BA">
											<div align="center" style="font-size: 11px">
												<span class="Style7"> Ref Fab</span>
											</div>
										</td>
										<td width="8%" bgcolor="#5289BA">
											<div align="center" style="font-size: 11px">
												<span class="Style7"> Ref Dist</span>
											</div>
										</td>
										<td width="8%" bgcolor="#5289BA">
											<div align="center" style="font-size: 11px">
												<span class="Style7"> PA HT</span>
											</div>
										</td>
										<td width="8%" bgcolor="#5289BA">
											<div align="center" style="font-size: 11px">
												<span class="Style7"> PV HT</span>
											</div>
										</td>
										<!--th class="data-table">                    Acompte                </th-->
									</tr>
									<!-- /Entete du tableau -->
									<!-- Corps du tableau -->
									<tr>
										<td bgcolor="#CDDDEB"></td>
										<td bgcolor="#CDDDEB"><div align="center"
												style="font-size: 11px">
												<a
													href="<?php echo"$url&page=$pag&nombre=$nombre&sort=FAMILLE"; ?>"><img
													src="images/icones/icon-max.gif" width="17" height="16"
													align="absmiddle" /> </a><a
													href="<?php echo"$url&page=$pag&nombre=$nombre&sort=FAMILLE DESC"; ?>"><img
													src="images/icones/icon-min.gif" width="17" height="16"
													align="absmiddle" /> </a>
											</div></td>
										<td bgcolor="#CDDDEB"><div align="center"
												style="font-size: 11px">
												<a
													href="<?php echo"$url&page=$pag&nombre=$nombre&sort=SOUS_FAMILLE"; ?>"><img
													src="images/icones/icon-max.gif" width="17" height="16"
													align="absmiddle" /> </a><a
													href="<?php echo"$url&page=$pag&nombre=$nombre&sort=SOUS_FAMILLE DESC"; ?>"><img
													src="images/icones/icon-min.gif" width="17" height="16"
													align="absmiddle" /> </a>
											</div></td>
										<td align="left" bgcolor="#CDDDEB"><div align="center"
												style="font-size: 11px">
												<a
													href="<?php echo"$url&page=$pag&nombre=$nombre&sort=MARQUE"; ?>"><img
													src="images/icones/icon-max.gif" width="17" height="16"
													align="absmiddle" /> </a><a
													href="<?php echo"$url&page=$pag&nombre=$nombre&sort=MARQUE DESC"; ?>"><img
													src="images/icones/icon-min.gif" width="17" height="16"
													align="absmiddle" /> </a>
											</div></td>
										<td bgcolor="#CDDDEB"><div align="center"
												style="font-size: 11px">
												<a
													href="<?php echo"$url&page=$pag&nombre=$nombre&sort=FOURNISSEUR"; ?>"><img
													src="images/icones/icon-max.gif" width="17" height="16"
													align="absmiddle" /> </a><a
													href="<?php echo"$url&page=$pag&nombre=$nombre&sort=FOURNISSEUR DESC"; ?>"><img
													src="images/icones/icon-min.gif" width="17" height="16"
													align="absmiddle" /> </a>
											</div></td>
										<td align="left" bgcolor="#CDDDEB"><div align="center"
												style="font-size: 11px">
												<a
													href="<?php echo"$url&page=$pag&nombre=$nombre&sort=DESIGNATION"; ?>"><img
													src="images/icones/icon-max.gif" width="17" height="16"
													align="absmiddle" /> </a><a
													href="<?php echo"$url&page=$pag&nombre=$nombre&sort=DESIGNATION DESC"; ?>"><img
													src="images/icones/icon-min.gif" width="17" height="16"
													align="absmiddle" /> </a>
											</div></td>
										<td align="left" bgcolor="#CDDDEB"><div align="center"
												style="font-size: 11px">
												<a
													href="<?php echo"$url&page=$pag&nombre=$nombre&sort=REF_FABRICANT"; ?>"><img
													src="images/icones/icon-max.gif" width="17" height="16"
													align="absmiddle" /> </a><a
													href="<?php echo"$url&page=$pag&nombre=$nombre&sort=REF_FABRICANT DESC"; ?>"><img
													src="images/icones/icon-min.gif" width="17" height="16"
													align="absmiddle" /> </a>
											</div></td>
										<td align="left" bgcolor="#CDDDEB"><div align="center"
												style="font-size: 11px">
												<a
													href="<?php echo"$url&page=$pag&nombre=$nombre&sort=REF_DISTRIBUTEUR"; ?>"><img
													src="images/icones/icon-max.gif" width="17" height="16"
													align="absmiddle" /> </a><a
													href="<?php echo"$url&page=$pag&nombre=$nombre&sort=REF_DISTRIBUTEUR DESC"; ?>"><img
													src="images/icones/icon-min.gif" width="17" height="16"
													align="absmiddle" /> </a>
											</div></td>
										<td align="right" bgcolor="#CDDDEB"><div align="center"
												style="font-size: 11px">
												<a
													href="<?php echo"$url&page=$pag&nombre=$nombre&sort=PRIX_NET"; ?>"><img
													src="images/icones/icon-max.gif" width="17" height="16"
													align="absmiddle" /> </a><a
													href="<?php echo"$url&page=$pag&nombre=$nombre&sort=PRIX_NET DESC"; ?>"><img
													src="images/icones/icon-min.gif" width="17" height="16"
													align="absmiddle" /> </a>
											</div></td>
										<td align="left" bgcolor="#CDDDEB"><div align="center"
												style="font-size: 11px">
												<a
													href="<?php echo"$url&page=$pag&nombre=$nombre&sort=PRIX_NET"; ?>"><img
													src="images/icones/icon-max.gif" width="17" height="16"
													align="absmiddle" /> </a><a
													href="<?php echo"$url&page=$pag&nombre=$nombre&sort=PRIX_NET DESC"; ?>"><img
													src="images/icones/icon-min.gif" width="17" height="16"
													align="absmiddle" /> </a>
											</div></td>
									</tr>
									<?php
									$toggle="1";
									// requete
									$arr=array();
									$quete="WHERE ";
									
									  if(!empty($famille) && $famille == "Non renseigné") {
										  array_push ($arr, "FAMILLE=''");
									  } else if(!empty($famille)) {
										  array_push ($arr, "FAMILLE='".$famille."'");
									  }
									  if(!empty($sousFamille) && $sousFamille == "Non renseigné") {
										  array_push ($arr, "SOUS_FAMILLE=''");
									  } else if(!empty($sousFamille)) {
										  array_push ($arr, "SOUS_FAMILLE='".$sousFamille."'");
									  }
									  if(!empty($marque) && $marque == "Non renseigné") {
										  array_push ($arr, "MARQUE=''");
									  } else if(!empty($marque)) {
										  array_push ($arr, "MARQUE='".$marque."'");
									  }
									  if(!empty($fournisseur)){
										  array_push ($arr, "FOURNISSEUR='".$fournisseur."'");
									  }
									if(!empty($designation)){
										$designation=str_replace(" ","%' AND DESIGNATION LIKE '%",$designation);
										$designation="DESIGNATION LIKE '%".$designation."%'";
										//echo $designation;
										array_push ($arr, $designation);
									}
									$count=count($arr);
									if(!empty($count)){
										for($i=0; $i<$count ; $i++){
											if(!empty($i)){
												$quete=$quete." AND ";
											}
											$quete=$quete.$arr[$i];
										}
										// $quete=$quete.$arr[$count];
										$quete2=" AND ID_SOCIETE = " . $societeContact->societe->id;
									}else{
										$quete="";
										$quete2="WHERE ID_SOCIETE = " . $societeContact->societe->id;
									}

									$parametre="order by ".$sort. " LIMIT ".$page*$nombre. ",".$nombre;
									//execution !
									if(!empty($refFabricant)){
										$quete="WHERE REF_FABRICANT='".$refFabricant."'";
										$catalogue="";
										$parametre="";
										$quete2="";
									}
									if(!empty($refDistributeur)){
										$quete="WHERE REF_DISTRIBUTEUR='".$refDistributeur."'";
										$catalogue="";
										$parametre="";
										$quete2="";
									}
									if(empty($catalogue)){
										$selecti=mysql_query("(select *, 0 from catalogue $quete) UNION ALL (select * from cataloguep $quete $quete2)");
										$select=mysql_query("(select *, 0 from catalogue $quete) UNION ALL (select * from cataloguep $quete $quete2)  $parametre");
									}else{
										if($catalogue !="cataloguep"){
											$quete2="";
										}
										$selecti=mysql_query("select * from $catalogue $quete $quete2");
										$select=mysql_query("select * from $catalogue $quete $quete2 $parametre");
											
									}
									$totp=mysql_num_rows($selecti);
									if(!empty($totp)){
										echo" il y a $totp résultats";
									}
									while($result=mysql_fetch_array($select)){
										if($toggle&1){
											$bgcolor="#EAF0F7";
										}else{
											$bgcolor="#F4F8FB";
										}
										?>
									<tr bgcolor="<?php echo $bgcolor; ?>">
										<td valign="top"
											bgcolor="<?php 
					  $des=addslashes(str_replace("\r\n", "",$result['DESIGNATION']))." ref : ".addslashes($result['REF_FABRICANT']);					 
					  if(!empty($societeContact->societe->marge) and (!isset($result['ID_SOCIETE']) || empty($result['ID_SOCIETE']))){
					  	$prixvente=($result['PRIX_NET']*$societeContact->societe->marge/100)+$result['PRIX_NET'];
					  }else{
					  	$prixvente=$result['PRIX_BASE'];
					  } 
					  $prixventeFormat = number_format($prixvente, 2, ",", " ");
					  echo $bgcolor; ?>"><div align="center">
												<a href="#"
												<?php echo " onclick=\"opener.document.getElementById('designation$pop').value='$des'; opener.document.getElementById('quant$pop').value='1,00'; opener.document.getElementById('prix$pop').value='$prixventeFormat'; opener.window.calcul('t', '$pop'); window.close();\" " ?>><img
													src="images/icones/panier-ajouter-icone-7116-32.png"
													width="24" height="24" align="absmiddle"
													title="insérer l'article au document en cours" /> </a>
											</div></td>
										<td valign="top">
											<div align="center">
												<span style="font-size: 11px"><?php echo $result['FAMILLE']; ?></span>
											</div>
										</td>
										<td valign="top">
											<div align="center">
												<span style="font-size: 11px"><?php echo $result['SOUS_FAMILLE']; ?></span>
											</div>
										</td>
										<td valign="top" align="left">
											<span class="Style4" style="font-size: 11px"><?php echo $result['MARQUE']; ?> </span>
										</td>
										<td valign="top">
											<span class="Style4" style="font-size: 11px"><?php echo $result['FOURNISSEUR']; ?></span>
										</td>
										<td valign="top" align="left"><span class="Style4"
											style="font-size: 11px"> <?php echo $result['DESIGNATION']; ?>
												<a href="javascript:;"
												onclick="toggle(<?php echo $toggle; ?>);"><img
													src="images/icones/bullet-fleche-vers-le-bas-icone-5704-16.png"
													width="16" height="16" align="absmiddle" /> </a> </span>
											<div id="<?php echo $toggle; ?>" class="minimized">
												<img src="images/blockcontentbullets.png" width="7"
													height="9" /> <span style="font-weight: bold">Conditionnement</span>
												:
												<?php echo $result['PRIX_AU']; ?>
												<br /> <img src="images/blockcontentbullets.png" width="7"
													height="9" /> <span style="font-weight: bold">Prix de vente
													public</span> :
													<?php echo  number_format($result['PRIX_BASE'], 2, ',', ' '); ?>
												€ <br /> <img src="images/blockcontentbullets.png"
													width="7" height="9" /> <span style="font-weight: bold">Ref
													interne</span> :
													<?php echo $result['_ID']; ?>
												<p align="right">
													<a href="javascript:;"
														onclick="toggle(<?php echo $toggle; ?>);"><img
														src="images/icones/bullet-fleche-vers-le-haut-icone-8574-16.png"
														width="16" height="16" align="absmiddle" /> Fermer</a>
												</p>
											</div></td>
										<td valign="top" align="left" class="Style4"
											style="font-size: 11px"><div align="center">
												<span class="Style4" style="font-size: 11px"><?php echo $result['REF_FABRICANT']; ?>
												</span>
											</div></td>
										<td valign="top" align="left" class="Style4"
											style="font-size: 11px"><div align="center">
												<span class="Style4" style="font-size: 11px"><?php echo $result['REF_DISTRIBUTEUR']; ?>
												</span>
											</div></td>
										<td valign="top" align="right"><div align="center"
												class="Style4" style="font-size: 11px">
												<?php
													
												echo number_format($result['PRIX_NET'], 2, ',', ' ');
													
												?>
											</div></td>
										<td valign="top" align="left"><div align="center"
												class="Style4" style="font-size: 11px">
												<?php
												echo  number_format($prixvente, 2, ',', ' ');
												?>
											</div></td>
									</tr>
									<?php $toggle++; } ?>
									<tr>
										<td colspan="10" bgcolor="#EAF0F7">&nbsp;</td>
									</tr>

									<!-- total general du mois -->
									<!-- total general de la periode -->
								</tbody>
							</table>
						</center>
					</div></td>
			</tr>
		</tbody>
	</table>
	<table>
		<tbody>
			<tr>
				<td colspan="8"><div align="right"></div></td>
			</tr>
			<tr>
				<td colspan="8"><p align="center">
						Nombre d'articles par page <select name="select5" id="menu"
							onchange="go()">
							<option value="<?php echo"$url&page=$pag&nombre=10&sort=$sort"; ?>"
							<?php if($nombre==10){ echo "selected=\"selected\""; }?>>10</option>
							<option value="<?php echo"$url&page=$pag&nombre=50&sort=$sort"; ?>"
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
						| <a
							href="<?php echo"$url&page=$pagee&nombre=$nombre&sort=$sort"; ?>">Suivant</a>
						<?php } ?>
					</p></td>
			</tr>
		</tbody>
	</table>
</body>
</html>
