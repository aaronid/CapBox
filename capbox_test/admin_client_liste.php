<?php
	require("inc.php"); 
	$nom="";
	if (isset($_GET['NOM'])) {
		$nom=$_GET['NOM'];
	}
	$prenom="";
	if (isset($_GET['PRENOM'])) {
		$prenom=$_GET['PRENOM'];
	}
	$societe="";
	if (isset($_GET['SOCIETE'])) {
		$societe=$_GET['SOCIETE'];
	}
	$statut="";
	if (isset($_GET['STATUT'])) {
		$statut=$_GET['STATUT'];
	}
	$hidd="";
	if (isset($_GET['hidd'])) {
		$hidd=$_GET['hidd'];
	}
	$lettre="";
	if (isset($_GET['lettre'])) {
		$lettre=$_GET['lettre'];
	}
	$sort="";
	if (isset($_GET['sort'])) {
		$sort=$_GET['sort'];
	}
	$catalogue="";
	if (isset($_GET['CATALOGUE'])) {
		$catalogue=$_GET['CATALOGUE'];
	}
	$consult="";
	if (isset($_GET['CONSULT'])) {
		$consult=$_GET['CONSULT'];
	}
	$type="";
	if (isset($_GET['TYPE'])) {
		$type=$_GET['TYPE'];
	}
	
	if (empty($sort)) {
		$sort="soco.NOM";
	}

	// Pagination
	$pag = "";
	$pagee = "";
	$page = "";
	if (isset($_GET['page'])) {
		$page = $_GET['page'];
	}
	if(empty($page)){
		$page = "0";
	}

	$nombre="";
	if (isset($_GET['nombre'])) {
		$nombre = $_GET['nombre'];
	}
	if (empty($nombre)) {
		$nombre="100";
	}
	$url="?nom=$nom&prenom=$prenom&societe=$societe&statut=$statut";
	//suppression cases à cocher

	if(!empty($_GET['FICHIER'])){
		//recupere le nom du fichier indiquÃ© par l'user
		//$fichier=$_FILES["userfile"]["name"];
		$fichier="temporaire/".$_GET['FICHIER'];
		// ouverture du fichier en lecture
		if ($fichier) {
			//ouverture du fichier temporaire
			//$fp = fopen ($_FILES["userfile"]["tmp_name"], "r");
			$fp = fopen ($fichier, "r");
		} else {
			// fichier inconnu
			echo"Importation échouée";
			exit();
		}
		
		// declaration de la variable "cpt" qui permettra de compter le nombre d'enregistrement rÃ©alisÃ©
		$cpt=0;
		
		// importation
		while (!feof($fp)) {
			$ligne = fgets($fp,4096);
			// on crÃ©e un tableau des Ã©lements sÃ©parÃ©s par des points virgule
			$liste = explode(";",$ligne);
			// premier Ã©lÃ©ment
			$liste[0] = ( isset($liste[0]) ) ? $liste[0] : Null;//Nom
			$liste[1] = ( isset($liste[1]) ) ? $liste[1] : Null;//Adress1
			$liste[2] = ( isset($liste[2]) ) ? $liste[2] : Null;//CodePostal
			$liste[3] = ( isset($liste[3]) ) ? $liste[3] : Null;//Ville
			$liste[4] = ( isset($liste[4]) ) ? $liste[4] : Null;//TelFix
			$liste[5] = ( isset($liste[5]) ) ? $liste[5] : Null;//TelMob
			$liste[6] = ( isset($liste[6]) ) ? $liste[6] : Null;//Fax
			$liste[7] = ( isset($liste[7]) ) ? $liste[7] : Null; //Email
			$liste[8] = ( isset($liste[8]) ) ? $liste[8] : Null; //SiteWeb
			$liste[9] = ( isset($liste[9]) ) ? $liste[9] : Null; //NomContact
			$liste[10] = ( isset($liste[10]) ) ? $liste[10] : Null; //PrenomContact
			$liste[11] = ( isset($liste[11]) ) ? $liste[11] : Null; //Fonction
			$liste[12] = ( isset($liste[12]) ) ? $liste[12] : Null; //Commentaire
			
			// pour eviter qu un champs "nom" du fichier soit vide
			if (!empty($liste[0])) {
				// nouvel ajout, compteur incrÃ©mentÃ©
				
				// requete et insertion ligne par ligne
				// champs1 id en general donc on affecte pas de valeur
				if (!empty($cpt)) {
					$newSociete = new Societe();
					$newSociete->dateCreation = "0000-00-00";
					$newSociete->dateFermeture = "0000-00-00";
					$newSociete->nom = $liste[0];
					$newSociete->adresse1 = $liste[1];
					$newSociete->codePostal = $liste[2];
					$newSociete->ville = $liste[3];
					$newSociete->telFix = $liste[4];
					$newSociete->telMob = $liste[5];
					$newSociete->fax = $liste[6];
					$newSociete->email = $liste[7];
					$newSociete->siteWeb = $liste[8];
					$newSociete->bloc = $liste[12];
											
					$newSociete->insert();
					
					$newSocieteCon = new SocieteContact();
					$newSocieteCon->idSociete = $newSociete->id;
					$newSocieteCon->codeProfil = Profil::$CODE_PROSPECT;
					$newSocieteCon->nom = $liste[9];
					$newSocieteCon->prenom = $liste[10];
					$newSocieteCon->fonction = $liste[11];
					$newSocieteCon->telFix = $liste[4];
					$newSocieteCon->telMob = $liste[5];
					$newSocieteCon->email = $liste[7];
					
					$newSocieteCon->insert();
					
				}
				$cpt++;
			}
		}
		
		// fermeture du fichier
		fclose($fp);
		//on supprime la derniere car elle est vide
	?>
	<script language="JavaScript">
		window.location='admin_client_liste.php'
	</script>
<?php
		
		//==================
		// FIN
		//==================
	}

	if (isset($_GET['options'])) {
		$count=count($_GET['options']);
		for ($i=0;$i<$count;$i++) {
			$req_arch = "INSERT INTO societe_archive SELECT * FROM societe WHERE _ID = " . $_GET['options'][$i] . ";";
			mysql_query($req_arch);
			$req_del = "DELETE FROM societe WHERE _ID = " . $_GET['options'][$i] . ";";
			mysql_query($req_del);
		}
	}
	
	if (isset($_GET['print'])) {
		header("Content-type: application/vnd.ms-excel"); 
		$inputFile="clients.csv";
		header("Content-disposition: attachment; filename=$inputFile");
		$csv = "NOM;PRENOM;SOCIETE;FONCTION;ADRESSE;CP;VILLE;TEL1;TEL2;FAX;MAIL;DATE CREATION;DATE FERMETURE;ACCES\n"; 
		$select="select _ID from societe ";									
		$result=mysql_query($select);
		// construction de chaque ligne 					
		while ($val=mysql_fetch_array($result)) { 
			$socContact = new SocieteContact();
			$socContact->findResponsableSociete($val['_ID']);

			// on concatene a $csv 
			if (!empty($socContact->societe->consult)) {
				$acces = "consultation";
			} else {
				if (empty($socContact->societe->catalogue)) {
					$acces = "complet";
				} else {
					$acces = "partiel";
				}
			}
			if ($socContact->societe->dateFermeture != "0000-00-00") {
				$valDATE = $socContact->societe->dateFermeture;
			}
			$csv .=  utf8_decode($socContact->nom).';'. utf8_decode($socContact->prenom).';'. utf8_decode($socContact->societe->nom).';'. utf8_decode($socContact->fonction).';'. utf8_decode($socContact->societe->adresse1).';'.$socContact->societe->codePostal.';'. utf8_decode($socContact->societe->ville).';'.$socContact->societe->telFix.';'.$socContact->societe->telMob.';'.$socContact->societe->fax.';'. utf8_decode($socContact->societe->email).';'. utf8_decode($socContact->societe->dateCreation).';'. utf8_decode($valDATE).';'. utf8_decode($acces)."\n"; // le \n final entre " " 
		} 
		print($csv); 
		exit; 
	}
	$quete="";
	$print="";
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
	function majcheckbox(master, className) { 
		var liste = document.getElementsByTagName('input'); 
		for(var i=0; i<liste.length; i++) { 
			if (liste[i].className == className) { 
				liste[i].checked = master.checked; 
			} 
		} 
	}
    function go() {
		window.location=document.getElementById("menu").value;
	}

	function ex() {
		var x=confirm("Attention ! Vous êtes sur le point de supprimer un compte client.\nLe compte et TOUS LES DOCUMENTS ET INFORMATIONS qui y sont rattachés seront supprimés.\nVoulez-vous supprimer ce compte ? ")
		if (x) {
 			document.forms['form2'].submit();
		}
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
                <span style="font-size: 11px"><?php echo $type;?></span>
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
                                               Administration - Liste de vos contacts</h2>
                                            <div class="art-postcontent">
                                                <!-- article-content -->
                                               
                                                
                                                
                                                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="art-article">
                                                  <tbody>
                                                   <?php
													require("admin_turl.php");
													?>
                                                    <tr>
                                                      <td colspan="8"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td height="32" background="images/fd_nav_ss_menu.png" bgcolor="#F0F0F0"><a href="admin_client.php"><img src="images/icones/vcard-ajouter-icone-9305-32.png" width="24" height="24" align="absmiddle" /> <strong>Nouveau client</strong></a>  <img src="images/menuseparator.png" width="1" height="24" align="absmiddle" /> <img src="images/icones/page-excel-icone-6057-32.png" width="24" height="24" align="absmiddle" /> <a href="?print=1"><strong>Export</strong></a> <img src="images/menuseparator.png" width="1" height="24" align="absmiddle" />  <img src="images/icones/vcard-supprimer-icone-9269-32.png" width="24" height="24" align="absmiddle" /> <a href="#" onclick="ex();"><strong>Supprimer</strong></a></td>
      </tr>
      <form action="" method="get" name="form1"><!--startprint-->
      <tr>
        <td bgcolor="#F9F9F9"><!-- Periode de recherche -->
            <!-- Periode de recherche -->            
              <table width="100%" border="0">
                <tr>
                  <th scope="col"><div align="left"><strong>Rechercher à partir de la première lettre du nom : <a href="<?php echo $url;?>&lettre=" class="Style1">A</a> <a href="<?php echo $url;?>&lettre=B" class="Style1">B</a> <a href="<?php echo $url;?>&lettre=C" class="Style1">C</a> <a href="<?php echo $url;?>&lettre=D" class="Style1">D</a> <a href="<?php echo $url;?>&lettre=E" class="Style1">E</a> <a href="<?php echo $url;?>&lettre=F" class="Style1">F</a> <a href="<?php echo $url;?>&lettre=G" class="Style1">G</a> <a href="<?php echo $url;?>&lettre=H" class="Style1">H</a> <a href="<?php echo $url;?>&lettre=I" class="Style1">I</a> <a href="<?php echo $url;?>&lettre=J" class="Style1">J</a> <a href="<?php echo $url;?>&lettre=K" class="Style1">K</a> <a href="<?php echo $url;?>&lettre=L" class="Style1">L</a> <a href="<?php echo $url;?>&lettre=M" class="Style1">M</a> <a href="<?php echo $url;?>&lettre=N" class="Style1">N</a> <a href="<?php echo $url;?>&lettre=O" class="Style1">O</a> <a href="<?php echo $url;?>&lettre=P" class="Style1">P</a> <a href="<?php echo $url;?>&lettre=Q" class="Style1">Q</a> <a href="<?php echo $url;?>&lettre=R" class="Style1">R</a> <a href="<?php echo $url;?>&lettre=S" class="Style1">S</a> <a href="<?php echo $url;?>&lettre=T" class="Style1">T</a> <a href="<?php echo $url;?>&lettre=U" class="Style1">U</a> <a href="<?php echo $url;?>&lettre=V" class="Style1">V</a> <a href="<?php echo $url;?>&lettre=W" class="Style1">W</a> <a href="<?php echo $url;?>&lettre=X" class="Style1">X</a> <a href="<?php echo $url;?>&lettre=Y" class="Style1">Y</a> <a href="<?php echo $url;?>&lettre=Z" class="Style1">Z</a> </strong>
                      <input type="hidden" name="hidd" value="1" />
                  </div></th>
                  <th width="31%" valign="bottom">&nbsp;</th>
                </tr>
                <tr>
                  <th width="69%" scope="col"><div align="left"><strong>Nom</strong>
                      <input title="le nom du contact recherché" id="NOM" name="NOM" value="<?php echo $nom;?>" type="text" />
                      <strong>Prénom</strong>
                      <input title="le prénom du contact recherché" id="PRENOM" name="PRENOM" value="<?php echo $prenom;?>" type="text" />
                      <strong>Société</strong>
                      <input title="la société recherchée" id="SOCIETE" name="SOCIETE" value="<?php echo $societe;?>" type="text" />
                  </div></th>
                  <th width="31%" rowspan="2" valign="bottom"><span style="font-weight: bold"><a href="#" onclick="document.forms['form1'].submit();"><img src="images/icones/loupe-icone-4171-32.png" width="32" height="32" align="absmiddle"/>Rechercher</a> <a href="admin_client_liste.php"><img src="images/icones/arrow-rotation-anti-horaire-icone-4507-32.png" width="32" height="32" align="absmiddle"/>Réinitialiser</a></span></th>
                </tr>
                <tr>
                  <th scope="col"> <div align="left">Accès :
                    <input type="radio" name="CATALOGUE" value="0" />
						complet
					<input type="radio" name="CATALOGUE" value="1" />
						partiel
					<input type="radio" name="CONSULT" value="1" />
						consultation
					</div>
				  </th>
                </tr>
                <tr>
                	<td scope="col">
				      <span class="componentheading" style="font-weight: bold; padding-bottom: 20px;">
					      <div style="display:inline">
					      	<a href="javascript:;" class="readon2" style="font-weight: bold" onclick="window.open('csv.php','','scrollbars=yes,resizable=yes,width=400,height=200')" >insérer des clients</a>
					      </div>
					      <div id="FICHIER1"></div>
				      </span>
				      <input id="FICHIER" name="FICHIER" value="" size="45" type="hidden" />
				      <span><a href="javascript:;" onclick="document.form1.submit()"><strong>Importer</strong></a></span>
                	</td>
                </tr>
              </table>
            
          <!-- /Periode de recherche -->
            <!-- /Periode de recherche -->        </td>
      </tr></form>
      
      <tr>
        <td><!-- Liste des pieces -->
            <div id="listePiece">
              <!-- Confirmation Piece -->
              
              <!-- /Confirmation Piece -->
              <center id="tableauListe">
                <!-- Pagination --><form action="" method="get" name="form2">
                <table width="100%">
                  <!-- Entete du tableau -->
                  <tbody>
                    <tr>
                      <td width="4%" bgcolor="#5289BA"><div align="center" style="font-size: 11px"></div></td>
                      <td width="4%" bgcolor="#5289BA"><div align="center" style="font-size: 11px"><span class="Style7">Voir</span></div></td>
                      <td width="6%" bgcolor="#5289BA"><div align="center" style="font-size: 11px"><span class="Style7">accès</span></div></td>
                      <td width="10%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Nom</p></td>
                      <td width="11%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Prénom</p></td>
                      <td width="11%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Société</p></td>
                      <td width="5%" bgcolor="#5289BA"> <p align="center" class="Style7" style="font-size: 11px">CP</p></td>
                      <td width="13%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Ville</p></td>
                      <td width="10%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Date création</p></td>
                      <td width="10%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Date fermeture</p></td>
                      <td width="16%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Téléphone 1</p></td>
                      <!--th class="data-table">                    Acompte                </th-->
                    </tr>
                    <!-- /Entete du tableau -->
                    <!-- Corps du tableau -->
                    <tr>
                      <td bgcolor="#CDDDEB"><div align="center" style="font-size: 11px">
                        <input type="checkbox" id="Master" 	onclick="javascript:majcheckbox(this, 'mesCoches');"/>
                      </div></td>
                      <td bgcolor="#CDDDEB"><div align="center"></div></td>
                      <td bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=so.CATALOGUE"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=so.CATALOGUE DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=soco.NOM"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=soco.NOM DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td align="left" bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=soco.PRENOM"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=soco.PRENOM DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td align="left" bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=so.NOM"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=so.NOM DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td align="right" bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=so.CODE_POSTAL"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=so.CODE_POSTAL DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td align="left" bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=so.VILLE"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=so.VILLE DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td align="left" bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=so.DATE_CREATION"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=so.DATE_CREATION DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td align="left" bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=so.DATE_FERMETURE"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=so.DATE_FERMETURE DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td align="left" bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=so.TEL_FIX"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=so.TEL_FIX DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                    </tr>
                    <?php
	                    $toggle="1";
	                    
	                    $arr=array();
	                    $quete=" AND ";

	                    if(!empty($nom)){
	                    	array_push ($arr, "soco.NOM LIKE '%" . $nom . "%'");
	                    }
	                    if(!empty($prenom)){
	                    	array_push ($arr, "soco.PRENOM LIKE '%" . $prenom . "%'");
	                    }
	                    if(!empty($consult)){
	                    	array_push ($arr, "so.CONSULT ='" . $consult. "'");
	                    }
	                    if(!empty($societe)){
	                    	array_push ($arr, "so.NOM LIKE '%" . $societe . "%'");
	                    }
	                    if(!empty($catalogue)){
	                    	array_push ($arr, "so.CATALOGUE ='" + $catalogue . "'");
	                    }
	                    	
	                    $count=count($arr);
	                    if(!empty($count)){
	                    	for($i=0; $i<$count ; $i++){
	                    		if(!empty($i)){
	                    			$quete=$quete." AND ";
	                    		}
	                    		$quete=$quete.$arr[$i];
	                    	}
	                    } else {
	                    	$quete="";
	                    }
	                    if(!empty($lettre)){
	                    	$quete=" AND soco.NOM LIKE '$lettre%'";
	                    }
	                    $parametres="order by ".$sort. " LIMIT ".$page*$nombre. ",".$nombre;
	                    	
	                    $select = "(select distinct so._ID as 'ID_SOCIETE', so.CONSULT, so.CATALOGUE, soco.NOM as 'NOM_C', soco.PRENOM, so.NOM as 'NOM_S', so.CODE_POSTAL, so.VILLE, so.DATE_CREATION, so.DATE_FERMETURE, so.TEL_FIX " . 
	                    "from societe_contact soco, societe so, utilisateur util WHERE util.CODE_ROLE = '" . Role::$CODE_ENTREPRENEUR . "' AND util.LOGIN = soco.LOGIN AND so._ID = soco.ID_SOCIETE $quete $parametres)";
	                    $select .= " UNION (select distinct so._ID as 'ID_SOCIETE', so.CONSULT, so.CATALOGUE, soco.NOM as 'NOM_C', soco.PRENOM, so.NOM as 'NOM_S', so.CODE_POSTAL, so.VILLE, so.DATE_CREATION, so.DATE_FERMETURE, so.TEL_FIX " . 
	                    "from societe_contact soco, societe so WHERE so._ID = soco.ID_SOCIETE AND soco.CODE_PROFIL = '" . Profil::$CODE_PROSPECT . "' $quete $parametres)";
	                    
	                    $result = mysql_query($select) or die(mysql_error());
	                    $totp = mysql_num_rows($result);

	                    while ($res = mysql_fetch_array($result)) {
	                    	if ($toggle&1) {
	                    		$bgcolor="#EAF0F7";
	                    	} else {
	                    		$bgcolor="#F4F8FB";
	                    	}
	                  ?>
                    <tr bgcolor="<?php echo $bgcolor; ?>">
                      <td ><div align="center" class="Style4" style="font-size: 11px">
                          <input type="checkbox" name="options[]" id="options[]" class="mesCoches" value="<?php echo $res['ID_SOCIETE'];?>" />
                      </div></td>
                      <td ><p align="center" class="Style6 Style4" style="font-size: 11px"><a href="admin_client.php?id=<?php echo $res['ID_SOCIETE'];?>"><img src="images/icones/editer_16.png" alt="Modifier" name="imgModifier2" width="16" height="16" id="imgModifier20" title="Modifier" /></a></p></td>
                      <td class="Style4"><div align="center" style="font-size: 11px"><?php if(empty($res['CONSULT'])){if($res['CATALOGUE']=='1'){ echo"Partiel"; }else{echo"Complet"; }}else{ echo"Consult.";} ?></div></td>
                      <td class="Style4"><span class="Style4" style="font-size: 11px">  <span class="Style4" style="font-size: 11px"><?php echo mb_strtoupper($res['NOM_C'],'UTF-8');?></span></span></td>
                      <td align="left"  class="Style4"><span class="Style4" style="font-size: 11px"> <?php echo $res['PRENOM'];?> </span></td>
                      <td align="left"  class="Style4"><span class="Style4" style="font-size: 11px"><?php echo mb_strtoupper($res['NOM_S'],'UTF-8');?>  </span></td>
                      <td align="right"  class="Style4"><div align="center" class="Style4" style="font-size: 11px"><?php echo $res['CODE_POSTAL'];?> </div></td>
                      <td align="left"  class="Style4"><div align="center" class="Style4" style="font-size: 11px"><?php echo mb_strtoupper($res['VILLE'],'UTF-8');?></div></td>
                      <td align="left"  class="Style4"><div align="center" class="Style4" style="font-size: 11px"><?php if($res['DATE_CREATION']!="0000-00-00"){echo date("d/m/Y",strtotime($res['DATE_CREATION']));}?></div></td>
                      <td align="left"  class="Style4"><div align="center" class="Style4" style="font-size: 11px"><?php if($res['DATE_FERMETURE']!="0000-00-00"){echo date("d/m/Y",strtotime($res['DATE_FERMETURE']));}?></div></td>
                      <td align="left"  class="Style4"><div align="center" class="Style4" style="font-size: 11px"><?php echo wordwrap ($res['TEL_FIX'], 2, ' ', 1); ?></div></td>
                    </tr>
                     <?php
							$toggle++;
					 	} ?>
                    <tr>
                      <td bgcolor="#EAF0F7">&nbsp;</td>
                      <td bgcolor="#EAF0F7">&nbsp;</td>
                      <td bgcolor="#EAF0F7">&nbsp;</td>
                      <td bgcolor="#EAF0F7">&nbsp;</td>
                      <td align="left" bgcolor="#EAF0F7">&nbsp;</td>
                      <td align="left" bgcolor="#EAF0F7">&nbsp;</td>
                      <td align="right" bgcolor="#EAF0F7">&nbsp;</td>
                      <td align="left" bgcolor="#EAF0F7">&nbsp;</td>
                      <td align="left" bgcolor="#EAF0F7">&nbsp;</td>
                      <td align="left" bgcolor="#EAF0F7">&nbsp;</td>
                      <td align="left" bgcolor="#EAF0F7">&nbsp;</td>
                    </tr>

                    <!-- total general du mois -->
                    <!-- total general de la periode -->
                  </tbody>
                </table>
                </form>
              </center>
            </div></td>
      </tr>
      
    </table></td>
                                                    </tr>
                                                    <tr >
                                                      <td colspan="8"><div align="right"></div></td>
                                                    </tr>
                                                    <tr >
                                                      <td colspan="8"><p align="center">
                                                      <select name="select5" id="menu" onchange="go()">
                                                              <option value="<?php echo"$url&page=$pag&nombre=10&sort=$sort"; ?>"<?php if($nombre==10){ echo"selected"; }?>>10</option>
                                                              <option value="<?php echo"$url&page=$pag&nombre=50&sort=$sort"; ?>"<?php if($nombre==50){ echo"selected"; }?>>50</option>
                                                              <option value="<?php echo"$url&page=$pag&nombre=100&sort=$sort"; ?>" <?php if($nombre==100){ echo"selected"; }?>>100</option>
                                                        </select>
                                                      </p>
                                                      <p align="center"><?php 
													  $pag=$page-1;
													  $pagee=$page+1;
													  $totpages=ceil($totp/$nombre);
													  
													  if($pag>=0){?><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=$sort"; ?>">Précédent</a> |<?php } ?> Page <?php echo $pagee; ?> sur <?php echo $totpages; if($pagee<$totpages){?> | <a href="<?php echo"$url&page=$pagee&nombre=$nombre&sort=$sort"; ?>">Suivant</a><?php } ?></p></td>
                                                    </tr>
                                              </tbody></table>
                                                
                                                	<!--endprint-->
                                                    
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
