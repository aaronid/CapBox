<?php 
	require("inc.php"); 

	$id = "";
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	}

	if (!empty($_POST)) {
		$FAMILLE=$_POST['FAMILLE'];
		if (!empty($_POST['FAMILLE2'])) {
			$FAMILLE=$_POST['FAMILLE2'];
		}
		$SOUS_FAMILLE=$_POST['SOUS_FAMILLE'];
		if(!empty($_POST['SOUS_FAMILLE2'])){
			$SOUS_FAMILLE=$_POST['SOUS_FAMILLE2'];
		}
		$MARQUE=$_POST['MARQUE'];
		if (!empty($_POST['MARQUE2'])) {
			$MARQUE=$_POST['MARQUE2'];
		}
		$FOURNISSEUR=$_POST['FOURNISSEUR'];
		if (!empty($_POST['FOURNISSEUR2'])) {
			$FOURNISSEUR=$_POST['FOURNISSEUR2'];
		}
		$REF_FABRICANT=$_POST['REF_FABRICANT'];
		$REF_DISTRIBUTEUR=$_POST['REF_DISTRIBUTEUR'];
		$PRIX_AU=$_POST['PRIX_AU'];
		$PRIX_NET=$_POST['PRIX_NET'];
		$PRIX_BASE=$_POST['PRIX_BASE'];
		$DESIGNATION=$_POST['DESIGNATION'];
		if (empty($id)) {
			$req="INSERT INTO cataloguep (FAMILLE,SOUS_FAMILLE,FOURNISSEUR,MARQUE,REF_FABRICANT,REF_DISTRIBUTEUR,PRIX_AU,PRIX_NET,PRIX_BASE,DESIGNATION,ID_SOCIETE) values('" . str_replace("'", "''", $FAMILLE) . "','" . str_replace("'", "''", $SOUS_FAMILLE) . "','" . str_replace("'", "''", $FOURNISSEUR) . "','" . str_replace("'", "''", $MARQUE) . "','$REF_FABRICANT','$REF_DISTRIBUTEUR','" . str_replace("'", "''", $PRIX_AU) . "','$PRIX_NET','$PRIX_BASE','" . str_replace("'", "''", $DESIGNATION) . "'," . $societeContact->societe->id . ")";
		} else {
			$req="update cataloguep set FAMILLE='" . str_replace("'", "''", $FAMILLE) . "',SOUS_FAMILLE='" . str_replace("'", "''", $SOUS_FAMILLE) . "',FOURNISSEUR='" . str_replace("'", "''", $FOURNISSEUR) . "', MARQUE='" . str_replace("'", "''", $MARQUE) . "', REF_FABRICANT='$REF_FABRICANT', REF_DISTRIBUTEUR='$REF_DISTRIBUTEUR', PRIX_AU='" . str_replace("'", "''", $PRIX_AU) . "', PRIX_NET='$PRIX_NET', PRIX_BASE='$PRIX_BASE', DESIGNATION='" . str_replace("'", "''", $DESIGNATION) . "' where _ID='$id'";
		}
		mysql_query($req);
		header("Location: catalogue_liste.php?catalogue=cataloguep");
	}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
    <style type="text/css">
<!--
.Style8 {
	color: #FF0000;
	font-weight: bold;
}
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
                                                Edition de votre article</h2>
                                            <div class="art-postcontent">
                                                <!-- article-content -->
                                               
                                                
                                                
                                                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="art-article">
                                                  <tbody>
                                                    <?php 
													require("turl.php");
													?>
                                                    <tr>
                                                      <td colspan="10"><form name="frm" action="?id=<?php echo $id; ?>" method="post">
                                                      <table width="100%">
  <tbody>
    <tr>
      <td height="32" colspan="4" background="images/fd_nav_ss_menu.png" bgcolor="#F0F0F0" class="componentheading"><span style="font-weight: bold"><img src="images/icones/enregistrer-page-icone-7705-32.png" width="24" height="24" align="absmiddle" /><a href="#" onClick="document.frm.submit()">Sauvegarder
        <input type="hidden" name="hid" id="hid" value="1" />
</a><img src="images/menuseparator.png" width="1" height="24" align="absmiddle" /> <img src="images/menuseparator.png" width="1" height="24" align="absmiddle" />  <a href="#" onClick="document.frm.reset();"><img src="images/icones/supprimer-la-page-icone-9859-32.png" width="24" height="24" align="absmiddle" />Effacer la saisie en cours</a> <img src="images/menuseparator.png" width="1" height="24" align="absmiddle" />  <a href="catalogue_liste.php">
      <img src="images/icones/demande-afficher-la-liste-icone-8709-32.png" width="24" height="24" align="absmiddle" /> Retour à la liste des articles</a></span></td>
      </tr>
      <!--startprint-->
    <tr>
      <td colspan="2" bgcolor="#F9F9F9" class="componentheading">&nbsp;</td>
      <td width="45%" colspan="2" align="right" bgcolor="#F9F9F9">&nbsp;</td>
    </tr>
    <?php 
	if(!empty($id)){
	$select="select * from cataloguep where _ID='$id'";
	$result=mysql_query($select);
	$fetch=mysql_fetch_array($result);
	}
	?>
    <tr>
      <td width="30%" bgcolor="#F9F9F9" class="componentheading" style="font-weight: bold">Famille <strong>
        <select name="FAMILLE" id="FAMILLE"><option ></option>
          <?php 
        if (empty($societeContact->societe->catalogue)) {
            $select="(select distinct FAMILLE from cataloguep where ID_SOCIETE = " . $societeContact->societe->id . ") union (select distinct FAMILLE from catalogue) order by FAMILLE";
        } else {
        	$select="select distinct FAMILLE from cataloguep where ID_SOCIETE = " . $societeContact->societe->id . " order by FAMILLE";
        }
		$result=mysql_query($select);
		while($val=mysql_fetch_array($result)){
		
		?>
          <option value="<?php echo $val['FAMILLE']; ?>" <?php if(isset($fetch['FAMILLE']) and $val['FAMILLE']==$fetch['FAMILLE']){ echo " selected=\"selected\""; } ?>><?php echo $val['FAMILLE']; ?></option>
          <?php } ?>
        </select>
        </strong></td>
      <td width="25%" bgcolor="#F9F9F9" class="componentheading" >Ajouter une famille &nbsp;
         <input name="FAMILLE2" type="text" id="FAMILLE2" size="15" />      </td>
      <td  bgcolor="#F9F9F9"><span style="font-weight: bold">Fournisseur</span><strong>
        <select name="FOURNISSEUR" id="FOURNISSEUR"><option ></option>
          <?php 
        if (empty($societeContact->societe->catalogue)) {
			$select="(select distinct FOURNISSEUR from cataloguep where ID_SOCIETE = " . $societeContact->societe->id . ") union (select distinct FOURNISSEUR from catalogue) order by FOURNISSEUR";
        } else {
        	$select="select distinct FOURNISSEUR from cataloguep where ID_SOCIETE = " . $societeContact->societe->id . " order by FOURNISSEUR";
        }
		$result=mysql_query($select);
		while($val=mysql_fetch_array($result)){
		?>
          <option value="<?php echo $val['FOURNISSEUR']; ?>"<?php if(isset($fetch['FOURNISSEUR']) and $val['FOURNISSEUR']==$fetch['FOURNISSEUR']){ echo " selected=\"selected\""; } ?>><?php echo $val['FOURNISSEUR']; ?></option>
          <?php } ?>
        </select>
         
      </strong></td>
      <td  bgcolor="#F9F9F9">Ajouter un fournisseur
         <input name="FOURNISSEUR2" type="text" id="FOURNISSEUR2" size="15" /></td>
    </tr>
    
    <tr>
      <td width="30%" bgcolor="#F9F9F9" class="componentheading" style="font-weight: bold">Sous famille <strong>
        <select name="SOUS_FAMILLE" id="SOUS_FAMILLE"><option ></option>
          <?php 
        if (empty($societeContact->societe->catalogue)) {
            $select="(select distinct SOUS_FAMILLE from cataloguep where ID_SOCIETE = " . $societeContact->societe->id . ") union (select distinct SOUS_FAMILLE from catalogue) order by SOUS_FAMILLE";
        } else {
        	$select="select distinct SOUS_FAMILLE from cataloguep where ID_SOCIETE = " . $societeContact->societe->id . " order by SOUS_FAMILLE";
        }
		$result=mysql_query($select);
		while($val=mysql_fetch_array($result)){
		
		?>
          <option value="<?php echo $val['SOUS_FAMILLE']; ?>" <?php if(isset($fetch['SOUS_FAMILLE']) and $val['SOUS_FAMILLE']==$fetch['SOUS_FAMILLE']){ echo " selected=\"selected\""; } ?>><?php echo $val['SOUS_FAMILLE']; ?></option>
          <?php } ?>
        </select>
        </strong></td>
      <td width="25%" bgcolor="#F9F9F9" class="componentheading" >Ajouter une sous famille &nbsp;
         <input name="SOUS_FAMILLE2" type="text" id="SOUS_FAMILLE2" size="15" /></td>
      <td bgcolor="#F9F9F9"><span style="font-weight: bold">Ref. Fabricant</span>
        <input name="REF_FABRICANT" type="text" id="REF_FABRICANT" title="Saisir un référence exacte" value="<?php if(isset($fetch['REF_FABRICANT'])) {echo $fetch['REF_FABRICANT'];} ?>" size="20" alt="date" />        </td>
      <td bgcolor="#F9F9F9"><span style="font-weight: bold">Ref. Distributeur</span>
        <input name="REF_DISTRIBUTEUR" type="text" id="REF_DISTRIBUTEUR" title="Saisir un référence exacte" value="<?php if(isset($fetch['REF_DISTRIBUTEUR'])) {echo $fetch['REF_DISTRIBUTEUR'];} ?>" size="20" alt="date" />        </td>
    </tr>
    <tr>
      <td bgcolor="#F9F9F9" class="componentheading" style="font-weight: bold">Marque         <strong>
        <select name="MARQUE" id="MARQUE"><option ></option>
        <?php 
        if (empty($societeContact->societe->catalogue)) {
			$select="(select distinct MARQUE from cataloguep where ID_SOCIETE = " . $societeContact->societe->id . ") union (select distinct MARQUE from catalogue)  order by MARQUE";
        } else {
        	$select="select distinct MARQUE from cataloguep where ID_SOCIETE = " . $societeContact->societe->id . " order by MARQUE";
        }
		$result=mysql_query($select);
		while($val=mysql_fetch_array($result)){
		?>
          <option value="<?php echo $val['MARQUE']; ?>"<?php if(isset($fetch['MARQUE']) and $val['MARQUE']==$fetch['MARQUE']){ echo " selected=\"selected\""; } ?>><?php echo $val['MARQUE']; ?></option>
          <?php } ?>
        </select>
         
      </strong></td>
      <td bgcolor="#F9F9F9" class="componentheading" >Ajouter une marque
        <input name="MARQUE2" type="text" id="MARQUE2" size="15" /></td>
      <td bgcolor="#F9F9F9" class="componentheading" ></td>
      <td bgcolor="#F9F9F9" class="componentheading" ></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F9F9F9" class="componentheading" style="font-weight: bold">Conditionnement <span class="componentheading" style="font-weight: bold">
        <input name="PRIX_AU" type="text" id="PRIX_AU" title="Saisir un référence exacte" value="<?php if(isset($fetch['PRIX_AU'])) {echo $fetch['PRIX_AU'];} ?>" size="15" alt="date" />
      </span></td>
      <td colspan="2" rowspan="2" valign="top"  bgcolor="#F9F9F9"><span style="font-weight: bold">Désignation</span><br />
        (Attention ! Ne pas utiliser le signe <span class="Style8">&quot; </span>)<br /> 
                <textarea name="DESIGNATION" cols="65" id="DESIGNATION"><?php if(isset($fetch['DESIGNATION'])) {echo $fetch['DESIGNATION'];} ?></textarea></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F9F9F9" class="componentheading" style="font-weight: bold">
      	<span class="componentheading" style="font-weight: bold">Prix d'achat HT</span>
        <input name="PRIX_NET" type="text" id="PRIX_NET" title="Saisir un référence exacte" value="<?php if(isset($fetch['PRIX_NET'])) {echo $fetch['PRIX_NET'];} ?>" size="15" alt="date" />
        <br/>
		<span class="componentheading" style="font-weight: bold">Prix de vente HT</span>
		<input name="PRIX_BASE" type="text" id="PRIX_BASE" title="Saisir un référence exacte" value="<?php if(isset($fetch['PRIX_BASE'])) {echo $fetch['PRIX_BASE'];} ?>" size="15" alt="date" />
      	</span>
      </td>
    </tr>
  </tbody>
</table>
                                                      </form>                                                      </td>
                                                    </tr>
                                                    <tr >
                                                      <td colspan="8"><div align="right"></div></td>
                                                    </tr>
                                              </tbody></table><!--endprint-->
                                                
                                                	
                                                    
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
