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
	$sort="NOM";
	if (isset($_GET['sort'])) {
		$sort=$_GET['sort'];
	}
	$pag="";
	$pagee="";
	$page="0";
	if (isset($_GET['page'])) {
		$page=$_GET['page'];
	}
	$nombre="100";
	if (isset($_GET['nombre'])) {
		$nombre=$_GET['nombre'];
	}
	$url="?nom=$nom&prenom=$prenom&societe=$societe&statut=$statut";
	//suppression cases à cocher

	if(isset($_GET['options'])){
		$count=count($_GET['options']);
		for($i=0;$i<$count;$i++){
			$req_del="SELECT NOM FROM catalogues WHERE _ID='".$_GET['options'][$i]."';";
			$resul_del=mysql_query($req_del);
			$nom_del=mysql_fetch_array($resul_del);
			$req_del="DELETE FROM catalogues WHERE _ID='".$_GET['options'][$i]."';";
			mysql_query($req_del);
			$req_del="DELETE FROM catalogue WHERE FOURNISSEUR='".$nom_del['NOM']."';";
			mysql_query($req_del);
		}
	
	}
	
	if(isset($_GET['print'])){
		header("Content-type: application/vnd.ms-excel"); 
		$inputFile="catalogues.csv";
		header("Content-disposition: attachment; filename=$inputFile");
		$csv = "NOM;DATE 1;DATE 2;NB references;BLOC;\n"; 
		$select="select * from catalogues";					
		$result=mysql_query($select);
		$totp=mysql_num_rows($result);
		//echo $select;
		while($res=mysql_fetch_array($result)){
			$num_select=mysql_query("select * from catalogue where FOURNISSEUR='" . $res['NOM'] . "'");
			$references=mysql_num_rows($num_select);
		  
			$csv .=  utf8_decode($res['NOM']).';'. utf8_decode($res['DATE1']).';'. utf8_decode($res['DATE2']).';'. utf8_decode($references).';'. utf8_decode($res['BLOC'])."\n"; // le \n final entre " " 
		} 
		print($csv); 
		exit; 
	}
    $res = array("TYPE" => "", "NOM" => "", "PRENOM" => "", "SOCIETE" => "", "STATUT" => "");
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
	
	    function ex()
		{
			var x=confirm("Etes-vous sûr de supprimer ces catalogues ?")
			if (x) {
				document.forms['form2'].submit();
			}
		}
	
	    function majcheckbox(master, className)
	    { 
			var liste = document.getElementsByTagName('input'); 
			for(var i=0; i<liste.length; i++) { 
				if (liste[i].className == className) { 
					liste[i].checked = master.checked; 
				} 
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
                <span style="font-size: 11px"><? echo $res['TYPE'];?></span>
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
                                                Administration - Liste des catalogues fournisseurs CAP ACHAT</h2>
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
        <td height="32" background="images/fd_nav_ss_menu.png" bgcolor="#F0F0F0"><a href="admin_catalogues.php"><img src="images/icones/vcard-ajouter-icone-9305-32.png" width="24" height="24" align="absmiddle" /> <strong>Nouveau catalogue</strong></a>  <img src="images/menuseparator.png" width="1" height="24" align="absmiddle" /> <img src="images/icones/page-excel-icone-6057-32.png" width="24" height="24" align="absmiddle" /> <a href="?print=1"><strong>Export</strong></a> <img src="images/menuseparator.png" width="1" height="24" align="absmiddle" />  <img src="images/icones/vcard-supprimer-icone-9269-32.png" width="24" height="24" align="absmiddle" /> <a href="#" onclick="ex();"><strong>Supprimer</strong></a></td>
      </tr>
      <form action="" method="get" name="form1"><!--startprint-->
      <tr>
        <td bgcolor="#F9F9F9"><!-- Periode de recherche -->
            <!-- Periode de recherche -->
            <div>
              
              <strong><br />
              Rechercher à partir de la première lettre du nom : <a href="<?php echo $url;?>&lettre=A" class="Style1">A</a> <a href="<?php echo $url;?>&lettre=B" class="Style1">B</a> <a href="<?php echo $url;?>&lettre=C" class="Style1">C</a> <a href="<?php echo $url;?>&lettre=D" class="Style1">D</a> <a href="<?php echo $url;?>&lettre=E" class="Style1">E</a> <a href="<?php echo $url;?>&lettre=F" class="Style1">F</a> <a href="<?php echo $url;?>&lettre=G" class="Style1">G</a> <a href="<?php echo $url;?>&lettre=H" class="Style1">H</a> <a href="<?php echo $url;?>&lettre=I" class="Style1">I</a> <a href="<?php echo $url;?>&lettre=J" class="Style1">J</a> <a href="<?php echo $url;?>&lettre=K" class="Style1">K</a> <a href="<?php echo $url;?>&lettre=L" class="Style1">L</a> <a href="<?php echo $url;?>&lettre=M" class="Style1">M</a> <a href="<?php echo $url;?>&lettre=N" class="Style1">N</a> <a href="<?php echo $url;?>&lettre=O" class="Style1">O</a> <a href="<?php echo $url;?>&lettre=P" class="Style1">P</a> <a href="<?php echo $url;?>&lettre=Q" class="Style1">Q</a> <a href="<?php echo $url;?>&lettre=R" class="Style1">R</a> <a href="<?php echo $url;?>&lettre=S" class="Style1">S</a> <a href="<?php echo $url;?>&lettre=T" class="Style1">T</a> <a href="<?php echo $url;?>&lettre=U" class="Style1">U</a> <a href="<?php echo $url;?>&lettre=V" class="Style1">V</a> <a href="<?php echo $url;?>&lettre=W" class="Style1">W</a> <a href="<?php echo $url;?>&lettre=X" class="Style1">X</a> <a href="<?php echo $url;?>&lettre=Y" class="Style1">Y</a> <a href="<?php echo $url;?>&lettre=Z" class="Style1">Z</a> </strong>
              <input type="hidden" name="hidd" value="1" />
              <p><strong>Nom</strong>
                <input title="le nom du contact recherché" id="NOM" name="NOM" value="<?php echo $res['NOM'];?>" type="text" />
                <span style="font-weight: bold"><a href="#" onclick="document.forms['form1'].submit();"><img src="images/icones/loupe-icone-4171-32.png" width="32" height="32" align="absmiddle"/>Rechercher</a> <a href="admin_catalogues_liste.php"><img src="images/icones/arrow-rotation-anti-horaire-icone-4507-32.png" width="32" height="32" align="absmiddle"/>Réinitialiser</a></span></p>
            </div>
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
                      <td width="8%" bgcolor="#5289BA"><div align="center" style="font-size: 11px"><!--<span class="Style7"> </span>                        <span class="Style7"><a href="#" onclick="ex();">Cocher</a>
                        </span>--></div>                        </td>
                      <td width="4%" bgcolor="#5289BA"><div align="center" style="font-size: 11px"><span class="Style7">Voir</span>  </div></td>
                      <td width="22%" bgcolor="#5289BA"><p align="center" style="font-size: 11px"><span class="Style7">Nom du catalogue<br />
                        </span></p>                      </td>
                      <td width="10%" bgcolor="#5289BA"><div align="center" style="font-size: 11px"><span class="Style7">date du catalogue fournisseur</span></div></td>
                      <td width="10%" bgcolor="#5289BA"><div align="center" class="Style7" style="font-size: 11px"><span class="Style7">Date de mise à jour</span></div></td>
                      <td width="10%" bgcolor="#5289BA"><div align="center" style="font-size: 11px"><span class="Style7"> nombre de références</span></div></td>
                      <td width="36%" bgcolor="#5289BA"> <p align="center" class="Style7" style="font-size: 11px">bloc note</p>                      </td>
                      <!--th class="data-table">                    Acompte                </th-->
                    </tr>
                    <!-- /Entete du tableau -->
                    <!-- Corps du tableau -->
                    <tr>
                      <td bgcolor="#CDDDEB"><div align="center" style="font-size: 11px">
                        <input type="checkbox" id="Master" 	onclick="javascript:majcheckbox(this, 'mesCoches');"/>
                      </div></td>
                      <td bgcolor="#CDDDEB"><div align="center"></div></td>
                      <td bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=NOM"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=NOM DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td align="left" bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=DATE1"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=DATE1 DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td align="left" bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=DATE2"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=DATE2 DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td align="left" bgcolor="#CDDDEB"></td>
                      <td align="right" bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=BLOC"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=BLOC DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      </tr>
                    <?php 
					$toggle="1";
					//tri
					
					$quete="";
					if(!empty($nom)){
						$quete="WHERE NOM LIKE '%".$nom."%'";
					}
					if(!empty($lettre)){
						$quete=" WHERE NOM LIKE '$lettre%'";
					}  
					$parametres="order by ".$sort. " LIMIT ".$page*$nombre. ",".$nombre;
					
					$select="select * from catalogues $quete $parametres";
					$selecti="select * from catalogues $quete";					
					$result=mysql_query($select);
					$totp=mysql_num_rows($result);
					//echo $select;
					while($res=mysql_fetch_array($result)){
						$num_select=mysql_query("select * from catalogue where FOURNISSEUR='" . $res['NOM'] . "'");
	  					$references=mysql_num_rows($num_select);
						if($toggle&1){
							$bgcolor="#EAF0F7";
						}else{
							$bgcolor="#F4F8FB";
						}
					?>
                    <tr bgcolor="<?php echo $bgcolor; ?>">
                      <td ><div align="center" class="Style4" style="font-size: 11px">
                          <input type="checkbox" name="options[]" id="options[]" class="mesCoches" value="<?php echo $res['_ID'];?>" />
                      </div></td>
                      <td ><p align="center" class="Style6 Style4" style="font-size: 11px"><a href="admin_catalogues.php?id=<?php echo $res['_ID'];?>"><img src="images/icones/editer_16.png" alt="Modifier" name="imgModifier2" width="16" height="16" id="imgModifier20" title="Modifier" /></a></p></td>
                      <td  class="Style4"><span class="Style4" style="font-size: 11px">  <span class="Style4" style="font-size: 11px"><?php echo $res['NOM'];?></span></span></td>
                      <td align="left"  class="Style4"><span class="Style4" style="font-size: 11px"><span class="Style4" style="font-size: 11px"><?php echo date("d/m/Y",strtotime($res['DATE1']));?></span></span></td>
                      <td align="left"  class="Style4"><span class="Style4" style="font-size: 11px"> <span class="Style4" style="font-size: 11px"><?php echo date("d/m/Y",strtotime($res['DATE2']));?></span> </span></td>
                      <td align="left"  class="Style4" style="font-size: 11px"><?php echo $references;?> </td>
                      <td align="right"  class="Style4"><div align="center" class="Style4" style="font-size: 11px"><?php echo $res['BLOC'];?> </div></td>
                      </tr>
                    <?php 
							$toggle++;
						}
					?>
                    <tr>
                      <td bgcolor="#EAF0F7">&nbsp;</td>
                      <td bgcolor="#EAF0F7">&nbsp;</td>
                      <td bgcolor="#EAF0F7">&nbsp;</td>
                      <td align="left" bgcolor="#EAF0F7">&nbsp;</td>
                      <td align="left" bgcolor="#EAF0F7">&nbsp;</td>
                      <td align="left" bgcolor="#EAF0F7">&nbsp;</td>
                      <td align="right" bgcolor="#EAF0F7">&nbsp;</td>
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
                                                    </tr><!--endprint-->
                                              </tbody></table>
                                                
                                                	
                                                    
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
