<?php 
	require("inc.php");

	$id = "";
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	}

	if (!empty($_POST)) {
		$NOM=$_POST['NOM'];
		//mise à jour du catalogue....///////////////////////////////////////////////////////////////////////
		if(!empty($_POST['FICHIER'])){
			//recupere le nom du fichier indiqué par l'user
			//$fichier=$_FILES["userfile"]["name"];
			$fichier="temporaire/".$_POST['FICHIER'];
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
			//mise à jour du fournisseur
			
			$DATE1=$_POST['DATE1'];
			$DATE1=implode('/',array_reverse(explode('/',$DATE1)));
			$DATE2=$_POST['DATE2'];
			$DATE2=implode('/',array_reverse(explode('/',$DATE2)));
			$BLOC=$_POST['BLOC'];
			if (empty($id)) {
				//insert
				mysql_query("INSERT INTO catalogues(NOM,DATE1,DATE2,BLOC) VALUES('$NOM','$DATE1','$DATE2','$BLOC')");
			} else {
				//update
				mysql_query("UPDATE catalogues SET NOM='$NOM' , DATE1='$DATE1' ,DATE2='$DATE2', BLOC='$BLOC' WHERE _ID='$id'");
			}
			
			// declaration de la variable "cpt" qui permettra de compter le nombre d'enregistrement réalisé
			$cpt=0;
			
			//echo "importation réussie !";
			mysql_query("DELETE FROM catalogue WHERE FOURNISSEUR='$NOM'"); 	
			// importation
			while (!feof($fp)) {
				$ligne = fgets($fp,4096);
				// on crée un tableau des élements séparés par des points virgule
				$liste = explode(";",$ligne);
				// premier élément
				$liste[0] = ( isset($liste[0]) ) ? $liste[0] : Null;// REF_INTERNE
				$liste[1] = ( isset($liste[1]) ) ? $liste[1] : Null;// fournisseur
				$liste[2] = ( isset($liste[2]) ) ? $liste[2] : Null;// famille
				$liste[3] = ( isset($liste[3]) ) ? $liste[3] : Null;// sous famille
				$liste[4] = ( isset($liste[4]) ) ? $liste[4] : Null;// ref_fabricant
				$liste[5] = ( isset($liste[5]) ) ? $liste[5] : Null;// ref_distributeur
				$liste[6] = ( isset($liste[6]) ) ? $liste[6] : Null;// designation
				$liste[7] = ( isset($liste[7]) ) ? $liste[7] : Null; // marque
				$liste[8] = ( isset($liste[8]) ) ? $liste[8] : Null; // prix_au
				$liste[9] = ( isset($liste[9]) ) ? $liste[9] : "0.0"; // prix_base
				$liste[10] = ( isset($liste[10]) ) ? $liste[10] : "0.0"; // prix_net
				
				
				$champs1=addslashes(utf8_encode($liste[0])); //REF_INTERNE
				$champs2=addslashes(utf8_encode($liste[1])); // fournisseur
				$champs2=str_replace("'","",$champs2); // ;
				$famille=addslashes(utf8_encode($liste[2])); // Famille
				$famille=str_replace("'","",$famille); // ;
				$sousFam=addslashes(utf8_encode($liste[3])); // Sous Famille
				$sousFam=str_replace("'","",$sousFam); // ;
				$champs4=addslashes(utf8_encode($liste[4])); // ref_fabricant
				$champs5=addslashes(utf8_encode($liste[5])); // ref_distributeur
				$champs6=addslashes(utf8_encode($liste[6])); // designation
				$champs7=utf8_encode($liste[7]); // marque
				$champs7=str_replace("'","''",$champs7); // ;
				$champs8=addslashes(utf8_encode($liste[8])); // prix_au
				$champs8=str_replace("'","''",$champs8); // ;
				$champs9=str_replace(",",".",$liste[9]); // prix_base
				$champs10=str_replace(",",".",$liste[10]); // prix_net

				// pour eviter qu un champs "nom" du fichier soit vide
				if ($champs1!='') {
					// nouvel ajout, compteur incrémenté
					
					// requete et insertion ligne par ligne
					if (!empty($cpt)) {
						$sql= "INSERT INTO catalogue (REF_INTERNE,FOURNISSEUR,FAMILLE,SOUS_FAMILLE,REF_FABRICANT,REF_DISTRIBUTEUR,DESIGNATION,MARQUE,PRIX_AU,PRIX_BASE,PRIX_NET)
								VALUES('$champs1','$NOM','$famille','$sousFam','$champs4','$champs5','$champs6','$champs7','$champs8',$champs9,$champs10) ";
						printf("sql : " . $sql . "\n");
						$requete = mysql_query($sql) or die( mysql_error() ) ;
					}
					$cpt++;
				}
			}
			
			// fermeture du fichier
			fclose($fp);
			//on supprime la derniere car elle est vide
			
			//==================
			// FIN
			//==================
		}
		header("Location: admin_catalogues_liste.php");
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en"><!-- InstanceBegin template="/capbox/maquette1/modele_maquette1.dwt" codeOutsideHTMLIsLocked="false" -->
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
    <style type="text/css">
<!--
.Style1 {color: #FFFFFF}
.Style4 {font-size: 85%}
.Style6 {font-size: 85%; font-weight: bold; }
.Style7 {font-size: 85%; font-weight: bold; color: #FFFFFF; }
-->
    </style>
    <script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
    </script>
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
                			<a href="#" class="active"><span class="l"></span><span class="r"></span><span class="t">Accueil</span></a>
                		</li>
                		<li>
                			<a href="#"><span class="l"></span><span class="r"></span><span class="t">Paramètrer mon compte</span></a>
                			<ul>
                				<li><a href="#">Menu Subitem 1</a>
                					<ul>
                						<li><a href="#">Menu Subitem 1.1</a></li>
                						<li><a href="#">Menu Subitem 1.2</a></li>
                						<li><a href="#">Menu Subitem 1.3</a></li>
                					</ul>
                				</li>
                				<li><a href="#">Menu Subitem 2</a></li>
                				<li><a href="#">Menu Subitem 3</a></li>
                			</ul>
                		</li>		
                		<li>
                			<a href="#"><span class="l"></span><span class="r"></span><span class="t">Actualités CAP BOX</span></a>
                		</li>
                        <li>
                			<a href="#"><span class="l"></span><span class="r"></span><span class="t">Besoin d'aide ? </span></a>
                		</li>
                                                <li>
                			<a href="#"><span class="l"></span><span class="r"></span><span class="t">Contact </span></a>
                		</li>
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
                                <div class="art-post-body"><!-- InstanceBeginEditable name="EditRegion1" -->
                                    <div class="art-post-inner art-article">
                                            <h2 class="art-postheader">
                                                <img src="images/postheadericon.png" width="26" height="26" alt="postheadericon" />
                                                Administration - Edition du catalogue fournisseur CAP BOX</h2>
                                            <div class="art-postcontent">
                                                <!-- article-content -->
                                               
                                                
                                                
                                                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="art-article">
                                                  <tbody>
                                                    <?php require("admin_turl.php"); ?>
                                                    <tr>
                                                      <td colspan="8">
                                                      <table width="100%">
  <tbody>
    <tr>
      <td height="32" colspan="2" background="images/fd_nav_ss_menu.png" bgcolor="#F0F0F0" class="componentheading"><span style="font-weight: bold"><a href="#" onClick="document.forms['frm'].submit();"><img src="images/icones/enregistrer-page-icone-7705-32.png" width="24" height="24" align="absmiddle" />Sauvegarder </a><img src="images/menuseparator.png" width="1" height="24" align="absmiddle" /><img src="images/icones/demande-afficher-la-liste-icone-8709-32.png" width="24" height="24" align="absmiddle" /> <a href="admin_catalogues_liste.php">Retour à la liste des catalogues</a></span></td>
      </tr>
      <!--startprint-->
    <tr>
      <td width="50%" bgcolor="#F9F9F9" class="componentheading">&nbsp;</td>
      <td width="50%" align="right" bgcolor="#F9F9F9">&nbsp;</td>
    </tr>
  </tbody>
</table><form action="?id=<?php echo $id; ?>" method="post" name="frm">
<table width="100%" border="0" cellpadding="3" cellspacing="2">
  <?php 
  $references=0;
  if(!empty($id)){
  $select=mysql_query("select * from catalogues where _ID='$id'");
  $val=mysql_fetch_array($select);
  $num_select=mysql_query("select * from catalogue where FOURNISSEUR='".$val['NOM']."'");
  $references=mysql_num_rows($num_select);
  $d1=$val['DATE1'];
  $d2=$val['DATE2'];
  
  }
  ?>
  
  <tr>
    <td colspan="4" bgcolor="#5289BA" class="componentheading"><span class="Style1"><strong>Le catalogue</strong></span></td>
    </tr>
  <tr>
    <td valign="top" bgcolor="#EAF0F7" class="Style1"><span class="Style1" style="font-weight: bold; color: #545454">Nom du catalogue </span></td>
    <td valign="top" bgcolor="#F9F9F9"><span class="componentheading" style="font-weight: bold">
      <input title="Saisir votre nom (* cette valeur est obligatoire)." id="NOM" name="NOM" value="<?php if (isset($val['NOM'])) {echo $val['NOM'];} ?>" size="45" type="text" /><input type="hidden" name="hid" value="1" />
    </span></td>
    <td width="191" valign="top" bgcolor="#EAF0F7" class="Style1"><span style="font-weight: bold; color: #545454">Date du catalogue fournisseur</span></td>
    <td width="209" valign="top" bgcolor="#F9F9F9"><input name="DATE1" type="text" id="DATE1" value="<?php 
	if(!empty($d1)){
  echo date("d/m/Y",strtotime($d1));
  }else{echo date("d/m/Y");
  } ?>" size="12" /></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#EAF0F7" class="Style1" style="font-weight: bold; color: #545454">Nombre de références</td>
    <td valign="top" bgcolor="#F9F9F9"> Ce catalogue contient actuellement : <span style="font-weight: bold"><?php echo $references; ?> articles</span></td>
    <td valign="top" bgcolor="#EAF0F7" class="Style1"><span style="font-weight: bold; color: #545454">Date de mise à jour CAP BOX</span></td>
    <td valign="top" bgcolor="#F9F9F9"><span class="Style1" style="color: #545454">
      <input name="DATE2" type="text" id="DATE2" value="<?php if(empty($d2)){
  echo date("d/m/Y");
  }else{
  echo date("d/m/Y",strtotime($d2));
  } ?>" size="12" />
    </span></td>
  </tr>
  <tr>
    <td width="143" valign="top" bgcolor="#EAF0F7" class="Style1"><span class="Style1" style="font-weight: bold; color: #545454">Télécharger </span></td>
    <td width="331" valign="top" bgcolor="#F9F9F9"><p style="color: #545454">
      <span class="componentheading" style="font-weight: bold"><div id="FICHIER1"></div>
      <input id="FICHIER" name="FICHIER" value="" size="45" type="hidden" />
      </span>
      <div style="display:inline"><a href="javascript:;" class="readon2" style="font-weight: bold" onclick="window.open('csv.php','','scrollbars=yes,resizable=yes,width=400,height=200')" >insérer catalogue</a></div>
        </p>
      </td>
    <td valign="top" bgcolor="#EAF0F7" class="Style1" style="color: #545454"><p>&nbsp;</p>      </td>
    <td valign="top" bgcolor="#F9F9F9" class="Style1" style="color: #545454">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><span style="font-weight: bold"><a href="#" onclick="document.forms['frm'].submit();"><img src="images/icones/enregistrer-page-icone-7705-32.png" width="24" height="24" align="absmiddle" />Sauvegarder</a></span></td>
  </tr>
  <tr>
    <td colspan="4" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" bgcolor="#5289BA" class="componentheading"><span class="Style1"><strong>Bloc notes</strong></span></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#EAF0F7" class="Style1"><span style="font-weight: bold; color: #545454">Commentaires sur le suivi de ce catalogue<br />
    </span></td>
    <td colspan="3" valign="top" bgcolor="#F9F9F9"><textarea name="BLOC" cols="115" rows="4" id="BLOC"><?php if (isset($val['NOM'])) { echo $val['BLOC']; } ?></textarea></td>
  </tr>
  <tr>
    <td colspan="4" valign="top" bgcolor="#F9F9F9" class="Style1"><span style="font-weight: bold"><a href="#" onClick="document.forms['frm'].submit();"><img src="images/icones/enregistrer-page-icone-7705-32.png" width="24" height="24" align="absmiddle" />Sauvegarder</a></span></td>
    </tr>
</table></form>                                                  </td>
                                                    </tr>
                                                    <tr >
                                                      <td colspan="8"><div align="right"></div></td>
                                                    </tr>
                                              </tbody></table>
                                                
                                                	
                                                    <!--endprint-->
                                              <!-- /article-content -->
                                            </div>
                                            <div class="cleared"></div>
                            </div>
                                  <!-- InstanceEndEditable -->
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
<!-- InstanceEnd --></html>
