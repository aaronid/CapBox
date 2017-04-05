<?php
	require("inc.php");
	 
	if (isset($_GET['idSociete'])) {
		$idSociete=$_GET['idSociete'];
	}
	$pop="";
	if (isset($_GET['pop'])) {
		$pop=$_GET['pop'];
	}
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
	$lettre="";
	if (isset($_GET['lettre'])) {
		$lettre=$_GET['lettre'];
	}
	$sort="NOM";
	if (isset($_GET['sort'])) {
		$sort=$_GET['sort'];
	}
	$pag="";
	$pagee="";
	$page="0";
	if (isset($_GET['nombre'])) {
		$page=$_GET['page'];
	}
	$nombre="100";
	if (isset($_GET['nombre'])) {
		$nombre=$_GET['nombre'];
	}
	$url="?idSociete=$idSociete&nom=$nom&prenom=$prenom&societe=$societe&statut=$statut";
	
//	$strDebug = "DEBUT</br>";
	if(!empty($_GET['FICHIER'])){
		//recupere le nom du fichier indique par l'user
		$fichier="temporaire/".$_GET['FICHIER'];
		// ouverture du fichier en lecture
		if ($fichier) {
			//ouverture du fichier temporaire
			ini_set('auto_detect_line_endings', true);
			$fp = fopen ($fichier, "r");
		} else {
			// fichier inconnu
			echo"Importation échouée";
			exit();
		}
		
		// declaration de la variable "cpt" qui permettra de compter le nombre d'enregistrement realise
		$cpt=0;
		
		// importation
		while (!feof($fp)) {
			$ligne = fgets($fp);
			// on crÃ©e un tableau des Ã©lements sÃ©parÃ©s par des points virgule
			$liste = explode(";", $ligne);
			// premier Ã©lÃ©ment
			$liste[0] = ( isset($liste[0]) ) ? $liste[0] : Null; //Ref Client
			$liste[1] = ( isset($liste[1]) ) ? $liste[1] : Null; //Entreprise
			$liste[2] = ( isset($liste[2]) ) ? $liste[2] : Null; //Adress1
			$liste[3] = ( isset($liste[3]) ) ? $liste[3] : Null; //Code Postal
			$liste[4] = ( isset($liste[4]) ) ? $liste[4] : Null; //Ville
			$liste[5] = ( isset($liste[5]) ) ? $liste[5] : Null; //Tel Fix
			$liste[6] = ( isset($liste[6]) ) ? $liste[6] : Null; //Tel Mob
			$liste[7] = ( isset($liste[7]) ) ? $liste[7] : Null; //Fax
			$liste[8] = ( isset($liste[8]) ) ? $liste[8] : Null; //Email
			$liste[9] = ( isset($liste[9]) ) ? $liste[9] : Null; //Site Web
			$liste[10] = ( isset($liste[10]) ) ? $liste[10] : Null; //Nom Contact
			$liste[11] = ( isset($liste[11]) ) ? $liste[11] : Null; //Prenom Contact
			$liste[12] = ( isset($liste[12]) ) ? $liste[12] : Null; //Fonction
			$liste[13] = ( isset($liste[13]) ) ? $liste[13] : Null; //Commentaire Client
			$liste[14] = ( isset($liste[14]) ) ? $liste[14] : Null; //Appel
			$liste[15] = ( isset($liste[15]) ) ? $liste[15] : Null; //Rendez vous
			$liste[16] = ( isset($liste[16]) ) ? $liste[16] : Null; //Relance
			$liste[17] = ( isset($liste[17]) ) ? $liste[17] : Null; //Commentaire Prospection

			/*$strDebug .= "nb element : " . count($liste);
			for ($i=0; $i<18; $i++) {
				$strDebug .= "--" . $liste[$i];
			}
			$strDebug .= "<br/>";
			*/
			// pour eviter qu un champs "nom" du fichier soit vide
			//if (!empty($liste[0])) {
				// nouvel ajout, compteur incrÃ©mentÃ©
				
				// requete et insertion ligne par ligne
				// champs1 id en general donc on affecte pas de valeur
				if (!empty($cpt)) {
					$newSocieteClient = new SocieteClient();
					if (!empty($liste[0])) {
						$newSocieteClient->findByRefClientIdSociete($liste[0], $idSociete);
					}
					if (empty($newSocieteClient->id)) {
						$newSocieteClient->idSociete = $idSociete;
						$newSocieteClient->refClient = $liste[0];
						$newSocieteClient->entreprise = $liste[1];
						$newSocieteClient->adresse1 = $liste[2];
						$newSocieteClient->codePostal = $liste[3];
						$newSocieteClient->ville = $liste[4];
						$newSocieteClient->telFix = $liste[5];
						$newSocieteClient->telMob = $liste[6];
						$newSocieteClient->fax = $liste[7];
						$newSocieteClient->email = $liste[8];
						$newSocieteClient->siteWeb = $liste[9];
						$newSocieteClient->nom = $liste[10];
						$newSocieteClient->prenom = $liste[11];
						$newSocieteClient->fonction = $liste[12];
						$newSocieteClient->commentaire = $liste[13];
						$newSocieteClient->type = "3"; // Type prospect
						
						$newSocieteClient->insert();
//						$strDebug .= "Add client" . $newSocieteClient->id . "</br>";
					} else {
//						$strDebug .= "Find client" . $newSocieteClient->id . "</br>";
					}
					
					$newSocClientProspect = new SocieteClientProspect();
					$newSocClientProspect->idSocieteClient = $newSocieteClient->id;
					$newSocClientProspect->appel = $liste[14];
					$newSocClientProspect->rdv = $liste[15];
					$newSocClientProspect->relance = $liste[16];
					$newSocClientProspect->commentaire = $liste[17];
					
					$newSocClientProspect->insert();
				}
				$cpt++;
			//}
		}
		
	    if (!feof($fp)) {
	        echo "Error: unexpected fgets() fail\n";
	    }
		fclose($fp);
	}
//	$strDebug .= "FIN";
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
<?php // echo $strDebug;?>
 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="art-article">
                                                  <tbody>
                                                   <form action="" method="get" name="f1">
                                                    <tr>
                                                      <td colspan="8"><table width="100%" cellpadding="0" cellspacing="0">
      
      <tr>
        <td bgcolor="#F9F9F9">
            <div>
              <strong><br />
              Rechercher à partir de la première lettre du nom : <a href="<?php echo $url;?>&lettre=A" class="Style1">A</a> <a href="<?php echo $url;?>&lettre=B" class="Style1">B</a> <a href="<?php echo $url;?>&lettre=C" class="Style1">C</a> <a href="<?php echo $url;?>&lettre=D" class="Style1">D</a> <a href="<?php echo $url;?>&lettre=E" class="Style1">E</a> <a href="<?php echo $url;?>&lettre=F" class="Style1">F</a> <a href="<?php echo $url;?>&lettre=G" class="Style1">G</a> <a href="<?php echo $url;?>&lettre=H" class="Style1">H</a> <a href="<?php echo $url;?>&lettre=I" class="Style1">I</a> <a href="<?php echo $url;?>&lettre=J" class="Style1">J</a> <a href="<?php echo $url;?>&lettre=K" class="Style1">K</a> <a href="<?php echo $url;?>&lettre=L" class="Style1">L</a> <a href="<?php echo $url;?>&lettre=M" class="Style1">M</a> <a href="<?php echo $url;?>&lettre=N" class="Style1">N</a> <a href="<?php echo $url;?>&lettre=O" class="Style1">O</a> <a href="<?php echo $url;?>&lettre=P" class="Style1">P</a> <a href="<?php echo $url;?>&lettre=Q" class="Style1">Q</a> <a href="<?php echo $url;?>&lettre=R" class="Style1">R</a> <a href="<?php echo $url;?>&lettre=S" class="Style1">S</a> <a href="<?php echo $url;?>&lettre=T" class="Style1">T</a> <a href="<?php echo $url;?>&lettre=U" class="Style1">U</a> <a href="<?php echo $url;?>&lettre=V" class="Style1">V</a> <a href="<?php echo $url;?>&lettre=W" class="Style1">W</a> <a href="<?php echo $url;?>&lettre=X" class="Style1">X</a> <a href="<?php echo $url;?>&lettre=Y" class="Style1">Y</a> <a href="<?php echo $url;?>&lettre=Z" class="Style1">Z</a> </strong>
              <input type="hidden" name="idSociete" value="<?php echo $idSociete; ?>" />
              <p><strong>Nom</strong>
                <input title="le nom du contact recherché" id="NOM" name="NOM" value="<?php if (isset($res['NOM'])) { echo $res['NOM']; }?>" type="text" /> 
                <strong>Prénom</strong>
                <input title="le prénom du contact recherché" id="PRENOM" name="PRENOM" value="<?php if (isset($res['PRENOM'])) { echo $res['PRENOM']; }?>" type="text" />
                <strong>Société</strong>
                <input title="la société recherchée" id="SOCIETE" name="SOCIETE" value="<?php if (isset($res['ENTREPRISE'])) { echo $res['ENTREPRISE']; }?>" type="text" />
                <br />
                <br />
                <input type="radio" name="STATUT" value="1" /> 
                 Client 
                <input type="radio" name="STATUT" value="2" />
                 Fournisseur 
                <input type="radio" name="STATUT" value="3" />
                 Prospect 
<span style="font-weight: bold"><a href="#" onclick="document.forms['f1'].submit();"><img src="images/icones/loupe-icone-4171-32.png" width="32" height="32" align="absmiddle"/>Rechercher</a> <a href="contact_liste_pop.php?pop=<?php echo $pop; ?>"><img src="images/icones/arrow-rotation-anti-horaire-icone-4507-32.png" width="32" height="32" align="absmiddle"/>Réinitialiser</a></span>
            </div>
        </td>
      </tr>
      <tr>
       	<td bgcolor="#F9F9F9" scope="col" colspan="8">
	      <span class="componentheading" style="font-weight: bold; padding-bottom: 20px;">
	      <div style="display:inline">
	      	<a href="javascript:;" class="readon2" style="font-weight: bold" onclick="window.open('csv.php','','scrollbars=yes,resizable=yes,width=400,height=200')" >insérer des clients</a>
	      </div>
	      <div id="FICHIER1"></div>
	      <a href="javascript:;" onclick="document.f1.submit()">
	      	<strong>Importer</strong>
	      </a>
	      </span>
	      <input id="FICHIER" name="FICHIER" value="" size="45" type="hidden" />
       	</td>
      </tr>
      
      <tr>
        <td><!-- Liste des pieces -->
            <div id="listePiece">
              <!-- Confirmation Piece -->
              
              <!-- /Confirmation Piece -->
              <center id="tableauListe">
                <!-- Pagination -->
                <table width="100%">
                  <!-- Entete du tableau -->
                  <tbody>
                    <tr>
                      <td width="5%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Action</p></td>
                      <td width="3%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Statut</p></td>
                      <td width="5%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Référence</p></td>
                      <td width="8%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Nom</p></td>
                      <td width="8%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Prénom</p></td>
                      <td width="8%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Société</p></td>
                      <td width="20%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Prospection</p></td>
                      <td width="13%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Adresse</p></td>
                      <td width="6%" bgcolor="#5289BA"> <p align="center" class="Style7" style="font-size: 11px">CP</p></td>
                      <td width="8%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Ville</p></td>
                      <td width="6%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Téléphone 1</p></td>
                      <!--th class="data-table">                    Acompte                </th-->
                    </tr>
                    <!-- /Entete du tableau -->
                    <!-- Corps du tableau -->
                    <tr>
                      <td align="left" bgcolor="#CDDDEB"></td>
                      <td bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=TYPE"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=TYPE DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=REF_CLIENT"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=REF_CLIENT DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=NOM"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=NOM DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td align="left" bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=PRENOM"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=PRENOM DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td align="left" bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=ENTREPRISE"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=ENTREPRISE DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td align="left" bgcolor="#CDDDEB"></td>
                      <td align="right" bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=ADRESSE1"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=ADRESSE1 DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td align="right" bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=CODE_POSTAL"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=CODE_POSTAL DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td align="left" bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=VILLE"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=VILLE DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td align="left" bgcolor="#CDDDEB">&nbsp;</td>
                    </tr>
			<?php 
				$toggle="1";
				//tri
				$arr=array();
				$quete=" AND INACTIF='' AND ";
				//$quete="WHERE ";
				if(!empty($nom)){
					$nom="NOM LIKE '%".$nom."%'";
					array_push ($arr, $nom);
				}
				if(!empty($prenom)){
					$prenom="PRENOM LIKE '%".$prenom."%'";
					array_push ($arr, $prenom);
				}
				if(!empty($societe)){
					$societe="ENTREPRISE LIKE '%".$societe."%'";
					array_push ($arr, $societe);
				}
				if(!empty($statut)){
					$statut="TYPE='".$statut."'";
					array_push ($arr, $statut);
				}
				$count=count($arr);
				if(!empty($count)){
					for($i=0; $i<$count; $i++){
						if(!empty($i)){
							$quete=$quete." AND ";
						}
						$quete=$quete.$arr[$i];
					}
					//$quete=$quete.$arr[$count];
				}
				else{
					$quete=" AND INACTIF='' ";
				}
				if(!empty($lettre)){
					$quete=$quete." AND ENTREPRISE LIKE '$lettre%' ";
				}
				$parametres="order by ".$sort. " LIMIT ".$page*$nombre. ",".$nombre;

				$select="select _ID from societe_client WHERE ID_SOCIETE = " . $idSociete . " $quete $parametres";
				$selecti="select _ID from societe_client WHERE ID_SOCIETE = " . $idSociete . " $quete";
				$result=mysql_query($select);
				$resulti=mysql_query($selecti);
				$totp=mysql_num_rows($resulti);
				//echo $select;
				while($res = mysql_fetch_array($result)){
					if($toggle&1){
						$bgcolor="#EAF0F7";
					}
					else{
						$bgcolor="#F4F8FB";
					}
					$societeClient = new SocieteClient();
					$societeClient->findByLogin($res["_ID"]);
					
					$popsociete = addslashes($societeClient->entreprise);
					$popprenom = addslashes($societeClient->prenom);
					$popnom = addslashes($societeClient->nom);
					$popadresse = addslashes($societeClient->adresse1) . " " . addslashes($societeClient->adresse2);
					$popville = addslashes($societeClient->ville);
					$popcp = addslashes($societeClient->codePostal);
					$popid = $societeClient->id;
					?>
                    <tr bgcolor="<?php echo $bgcolor; ?>">
                      <td class="Style4"><div align="center" style="font-size: 11px"><?php if($societeClient->type == '3') { ?><a href="" onclick="opener.location = 'admin_client.php?idClientProspect=<?php echo $societeClient->id; ?>'; window.close();"><img src="images/icones/editer_16.png" alt="Ouvrir un compte client" width="16" height="16" title="Ouvrir un compte client" /></a><?php } ?></div></td>
                      <td class="Style4"><div align="center" style="font-size: 11px"><?php if($societeClient->type == '1'){ echo "C"; } else if($societeClient->type == '2'){ echo "F"; } else if($societeClient->type == '3'){ echo "P"; } ?></div></td>
                      <td align="left" class="Style4"><span class="Style4" style="font-size: 11px"><?php echo $societeClient->refClient;?></span></td>
                      <td align="left" class="Style4"><span class="Style4" style="font-size: 11px"><?php echo mb_strtoupper($societeClient->nom,'UTF-8');?></span></td>
                      <td align="left" class="Style4"><span class="Style4" style="font-size: 11px"><?php echo $societeClient->prenom;?></span></td>
                      <td align="left" class="Style4"><span class="Style4" style="font-size: 11px"><?php echo mb_strtoupper($societeClient->entreprise,'UTF-8');?></span></td>
                      <td valign="top"align="left" >
                      <?php if (empty($societeClient->clientsProspect)) { ?>
                      	<span class="Style4" style="font-size: 11px">Aucune prospection réalisée</span>
                      <?php } else { ?>
                      	<span class="Style4" style="font-size: 11px">Détail...
                      		<a href="javascript:;" onclick="toggle(<?php echo $toggle; ?>);">
                      			<img src="images/icones/bullet-fleche-vers-le-bas-icone-5704-16.png" width="16" height="16" align="absmiddle" />
                      		</a>
                      	</span>
                      	<div id="<?php echo $toggle; ?>" class="minimized">
						<?php foreach ($societeClient->clientsProspect as $prospect) { ?>
	                      	<span style="font-weight: bold">Prospection :</span><br/>
	                      	<span>
	                      		<img src="images/blockcontentbullets.png" width="7" height="9" />
	                      		Appel : <?php echo $prospect->appel; ?><br/>
	                      		<img src="images/blockcontentbullets.png" width="7" height="9" />
	                      		RDV : <?php echo $prospect->rdv; ?><br/>
	                      		<img src="images/blockcontentbullets.png" width="7" height="9" />
	                      		Relance : <?php echo $prospect->relance; ?><br/>
	                      		<img src="images/blockcontentbullets.png" width="7" height="9" />
	                      		Commentaire : <?php echo $prospect->commentaire; ?><br/>
	                      	</span>
	                    <?php } ?>
	                        <p align="right">
	                        	<a href="javascript:;" onclick="toggle(<?php echo $toggle; ?>);">
	                        		<img src="images/icones/bullet-fleche-vers-le-haut-icone-8574-16.png" width="16" height="16" align="absmiddle" /> Fermer
	                        	</a>
	                        </p>
	                     </div>
                      <?php } ?>
                      </td>
                      <td align="left"  class="Style4" style="font-size: 11px"><?php echo $societeClient->adresse1;?> </td>
                      <td align="right"  class="Style4"><div align="center" class="Style4" style="font-size: 11px"><?php echo $societeClient->codePostal;?> </div></td>
                      <td align="left"  class="Style4"><div align="center" class="Style4" style="font-size: 11px"><?php echo mb_strtoupper($societeClient->ville,'UTF-8');?></div></td>
                      <td align="left"  class="Style4"><div align="center" class="Style4" style="font-size: 11px"><?php echo wordwrap ($societeClient->telFix, 2, ' ', 1); ?></div></td>
                    </tr>
			<?php
					$toggle++;
				}
			?>
                    <tr>
                      <td bgcolor="#EAF0F7">&nbsp;</td>
                      <td bgcolor="#EAF0F7">&nbsp;</td>
                      <td bgcolor="#EAF0F7">&nbsp;</td>
                      <td bgcolor="#EAF0F7">&nbsp;</td>
                      <td align="left" bgcolor="#EAF0F7">&nbsp;</td>
                      <td align="left" bgcolor="#EAF0F7">&nbsp;</td>
                      <td align="left" bgcolor="#EAF0F7">&nbsp;</td>
                      <td align="left" bgcolor="#EAF0F7">&nbsp;</td>
                      <td align="left" bgcolor="#EAF0F7">&nbsp;</td>
                      <td align="left" bgcolor="#EAF0F7">&nbsp;</td>
                      <td align="left" bgcolor="#EAF0F7">&nbsp;</td>
                    </tr>
                  </tbody>
                </table>
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
                                                      <p align="center">
                                                      <?php 
									  $pag=$page-1;
									  $pagee=$page+1;
									  $totpages=ceil($totp/$nombre);
									  if($pag>=0){?><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=$sort"; ?>">Précédent</a> |<?php } ?> Page <?php echo $pagee; ?> sur <?php echo $totpages; if($pagee<$totpages){?> | <a href="<?php echo"$url&page=$pagee&nombre=$nombre&sort=$sort"; ?>">Suivant</a><?php } ?></p></td>
                                                    </tr></form>
                                              </tbody></table>
</body>
</html>
