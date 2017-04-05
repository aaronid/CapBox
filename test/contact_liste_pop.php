<?php require("inc.php"); 
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
	if (isset($_GET['nombre'])) {
		$page=$_GET['page'];
	}
	$nombre="100";
	if (isset($_GET['nombre'])) {
		$nombre=$_GET['nombre'];
	}
	$url="?nom=$nom&prenom=$prenom&societe=$societe&statut=$statut";
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
 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="art-article">
                                                  <tbody>
                                                  	<tr>
                                                  		<td height="32" background="images/fd_nav_ss_menu.png" bgcolor="#F0F0F0">
															<a href="contact_pop.php">
	      														<img src="images/icones/vcard-ajouter-icone-9305-32.png" width="24" height="24" align="absmiddle" />
	      														<strong>Nouveau contact</strong>
	      													</a>
      													</td>
      												</tr>
                                                   <form action="" method="get" name="f1">
                                                    <tr>
                                                      <td colspan="8"><table width="100%" cellpadding="0" cellspacing="0">
      
      <tr>
        <td bgcolor="#F9F9F9"><!-- Periode de recherche -->
            <!-- Periode de recherche -->
            <div>
              
              <strong><br />
              Rechercher à partir de la première lettre du nom : <a href="<?php echo $url;?>&lettre=A" class="Style1">A</a> <a href="<?php echo $url;?>&lettre=B" class="Style1">B</a> <a href="<?php echo $url;?>&lettre=C" class="Style1">C</a> <a href="<?php echo $url;?>&lettre=D" class="Style1">D</a> <a href="<?php echo $url;?>&lettre=E" class="Style1">E</a> <a href="<?php echo $url;?>&lettre=F" class="Style1">F</a> <a href="<?php echo $url;?>&lettre=G" class="Style1">G</a> <a href="<?php echo $url;?>&lettre=H" class="Style1">H</a> <a href="<?php echo $url;?>&lettre=I" class="Style1">I</a> <a href="<?php echo $url;?>&lettre=J" class="Style1">J</a> <a href="<?php echo $url;?>&lettre=K" class="Style1">K</a> <a href="<?php echo $url;?>&lettre=L" class="Style1">L</a> <a href="<?php echo $url;?>&lettre=M" class="Style1">M</a> <a href="<?php echo $url;?>&lettre=N" class="Style1">N</a> <a href="<?php echo $url;?>&lettre=O" class="Style1">O</a> <a href="<?php echo $url;?>&lettre=P" class="Style1">P</a> <a href="<?php echo $url;?>&lettre=Q" class="Style1">Q</a> <a href="<?php echo $url;?>&lettre=R" class="Style1">R</a> <a href="<?php echo $url;?>&lettre=S" class="Style1">S</a> <a href="<?php echo $url;?>&lettre=T" class="Style1">T</a> <a href="<?php echo $url;?>&lettre=U" class="Style1">U</a> <a href="<?php echo $url;?>&lettre=V" class="Style1">V</a> <a href="<?php echo $url;?>&lettre=W" class="Style1">W</a> <a href="<?php echo $url;?>&lettre=X" class="Style1">X</a> <a href="<?php echo $url;?>&lettre=Y" class="Style1">Y</a> <a href="<?php echo $url;?>&lettre=Z" class="Style1">Z</a> </strong>
              <input type="hidden" name="hidd" value="1" />
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
          <!-- /Periode de recherche -->
            <!-- /Periode de recherche -->        </td>
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
                      <td width="5%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Sélect.
                        </p>                        </td>
                      <td width="4%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Statut.</p></td>
                      <td width="14%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Nom</p>                      </td>
                      <td width="13%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Prénom</p></td>
                      <td width="13%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Société</p></td>
                      <td width="14%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px"> Adresse</p></td>
                      <td width="6%" bgcolor="#5289BA"> <p align="center" class="Style7" style="font-size: 11px">CP</p>                      </td>
                      <td width="14%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Ville</p>                      </td>
                      <td width="12%" bgcolor="#5289BA"><p align="center" class="Style7" style="font-size: 11px">Téléphone 1</p>                      </td>
                      <!--th class="data-table">                    Acompte                </th-->
                    </tr>
                    <!-- /Entete du tableau -->
                    <!-- Corps du tableau -->
                    <tr>
                      <td bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"></div></td>
                      <td bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=TYPE"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=TYPE DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=NOM"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=NOM DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td align="left" bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=PRENOM"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=PRENOM DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td align="left" bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=ENTREPRISE"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<?php echo"$url&page=$pag&nombre=$nombre&sort=ENTREPRISE DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td align="left" bgcolor="#CDDDEB"></td>
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

				$select="select ENTREPRISE, PRENOM, NOM, ADRESSE1, ADRESSE2, VILLE, CODE_POSTAL, TYPE, TEL_FIX, _ID from societe_client WHERE ID_SOCIETE = " . $societeContact->societe->id . " $quete $parametres";
				$selecti="select ENTREPRISE, PRENOM, NOM, ADRESSE1, ADRESSE2, VILLE, CODE_POSTAL, TYPE, TEL_FIX, _ID from societe_client WHERE ID_SOCIETE = " . $societeContact->societe->id . " $quete";
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
					$popsociete = addslashes($res["ENTREPRISE"]);
					$popprenom = addslashes($res["PRENOM"]);
					$popnom = addslashes($res["NOM"]);
					$popadresse = addslashes($res["ADRESSE1"])." ".addslashes($res["ADRESSE2"]);
					$popville = addslashes($res["VILLE"]);
					$popcp = addslashes($res["CODE_POSTAL"]);
					$popid = $res["_ID"];
					?>
                    <tr bgcolor="<?php echo $bgcolor; ?>">
                      <td ><div align="center" class="Style4"><a href="#" onclick="opener.document.getElementById('c_societe').innerHTML='<?php echo $popsociete;?>'; opener.document.getElementById('c_nom').innerHTML='<?php echo $popprenom . " " . $popnom;?>';opener.document.getElementById('c_adresse').innerHTML='<?php echo $popadresse;?>';opener.document.getElementById('c_cp').innerHTML='<?php echo $popcp . " " . $popville;?>';opener.document.getElementById('destinataire').value='<?php echo $popid;?>'; window.close();">
                      <img src="images/icones/panier-ajouter-icone-7116-32.png" width="24" height="24" align="absmiddle" title="insérer l'article au document en cours" /></a></div></td>
                      <td  class="Style4"><div align="center" style="font-size: 11px"><?php if($res['TYPE']=='1'){ echo "C"; } else if($res['TYPE']=='2'){ echo "F"; } else if($res['TYPE']=='3'){ echo "P"; } ?></div></td>
                      <td  class="Style4"><span class="Style4" style="font-size: 11px"><span class="Style4" style="font-size: 11px"><?php echo mb_strtoupper($res['NOM'],'UTF-8');?></span>  </span></td>
                      <td align="left"  class="Style4"><span class="Style4" style="font-size: 11px"> <?php echo $res['PRENOM'];?> </span></td>
                      <td align="left"  class="Style4"><span class="Style4" style="font-size: 11px"><?php echo mb_strtoupper($res['ENTREPRISE'],'UTF-8');?>  </span></td>
                      <td align="left"  class="Style4" style="font-size: 11px"><?php echo $res['ADRESSE1'];?> </td>
                      <td align="right"  class="Style4"><div align="center" class="Style4" style="font-size: 11px"><?php echo $res['CODE_POSTAL'];?> </div></td>
                      <td align="left"  class="Style4"><div align="center" class="Style4" style="font-size: 11px"><?php echo mb_strtoupper($res['VILLE'],'UTF-8');?></div></td>
                      <td align="left"  class="Style4"><div align="center" class="Style4" style="font-size: 11px"><?php echo wordwrap ($res['TEL_FIX'], 2, ' ', 1); ?></div></td>
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
                      <td align="left" bgcolor="#EAF0F7">&nbsp;</td>
                      <td align="left" bgcolor="#EAF0F7">&nbsp;</td>
                    </tr>

                    <!-- total general du mois -->
                    <!-- total general de la periode -->
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
