<? require("inc.php"); 
$pop=$_GET['pop'];
$catalogue=$_GET['catalogue'];
$famille=$_GET['famille'];
$fournisseur=$_GET['fournisseur'];
$marque=$_GET['marque'];
$reference=$_GET['reference'];
$designation=$_GET['designation'];
$hidd=$_GET['hidd'];
$sort=$_GET['sort'];
if(empty($sort)){
$sort="FAMILLE";
}
$page=$_GET['page'];
if(empty($page)){
$page="0";
}
$nombre=$_GET['nombre'];
if(empty($nombre)){
$nombre="100";
}
$url="?pop=$pop&catalogue=$catalogue&famille=$famille&fournisseur=$fournisseur&marque=$marque&reference=$reference&designation=$designation";
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

    <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
    <!--[if IE 6]><link rel="stylesheet" href="style.ie6.css" type="text/css" media="screen" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="style.ie7.css" type="text/css" media="screen" /><![endif]-->

    <script type="text/javascript" src="script.js"></script>
    <style type="text/css">
<!--
.Style1 {color: #FFFFFF}
.Style4 {font-size: 85%}
.Style6 {font-size: 85%; font-weight: bold; }
.Style7 {font-size: 85%; font-weight: bold; color: #FFFFFF; }
-->
    </style>
    <script type="text/javascript"><!--
function go() 
{
window.location=document.getElementById("menu").value;
}

function toggle(id) {
   if (document.getElementById) {
       var cdiv = document.getElementById(id);
	   	  
       if (cdiv) {
           if (cdiv.className != 'minimized') cdiv.className = 'minimized';
		     else    cdiv.className = '';
			 }
   }   
}
//-->
</script>
<style>
.minimized{display:none;}
</style>
</head>
<body>
                                               
                                                
                                                
                                                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="art-article">
                                                  <tbody>                                                    
                                                    <tr>
                                                      <td colspan="8"><table width="100%" cellpadding="0" cellspacing="0">
      
      <tr>
        <td bgcolor="#F9F9F9"><!-- Periode de recherche -->
            <!-- Periode de recherche -->
            <form action="" method="get" name="frm1"><div><input type="hidden" name="pop" value="<? echo $pop; ?>" />
              
                <h2><strong>                  Rechercher et comparer parmi tous les articles du catalogue</strong></h2>
                <p><strong>Catalogue
                  <select name="catalogue" id="select4">
                  <option ></option>
                    <option value="catalogue" <? if($catalogue=='catalogue'){echo"selected"; }?>>CAP ACHAT</option>
                    <option value="cataloguep"<? if($catalogue=='cataloguep'){echo"selected"; }?>>Mon catalogue personnel</option>
                  </select>
                  
Famille
<select name="famille" id="select">
<? 
$tri=mysql_query("(select DISTINCT FAMILLE from catalogue) UNION (select DISTINCT FAMILLE from cataloguep) ORDER BY FAMILLE");
while($tri1=mysql_fetch_array($tri)){ 
?>

  <option value="<? echo $tri1[FAMILLE]; if($famille==$tri1[FAMILLE]){echo"\"selected"; }?>"><? echo $tri1[FAMILLE]; ?></option>
 <? } ?>
</select>
              </strong> <strong>Fournisseur</strong> <strong>
              <select name="fournisseur" id="select2">
              <option ></option>
                <? 
				$tri=mysql_query("(select DISTINCT FOURNISSEUR from catalogue) UNION (select DISTINCT FOURNISSEUR from cataloguep)ORDER BY FOURNISSEUR");
while($tri1=mysql_fetch_array($tri)){ 
?>

  <option value="<? echo $tri1[FOURNISSEUR];  if($fournisseur==$tri1[FOURNISSEUR]){echo"\" selected"; }?>"><? echo $tri1[FOURNISSEUR]; ?></option>
 <? } ?>
              </select>
              </strong></p>
              <p><strong>Marque
                  <select name="marque" id="select3">
                   <? 
				   $tri=mysql_query("(select DISTINCT MARQUE from catalogue) UNION (select DISTINCT MARQUE from cataloguep) ORDER BY MARQUE");
while($tri1=mysql_fetch_array($tri)){ 
?>

  <option value="<? echo $tri1[MARQUE];  if($marque==$tri1[MARQUE]){echo"\"selected"; }?>"><? echo $tri1[MARQUE]; ?></option>
 <? } ?>
                  </select>
                </strong><strong>Ref. Fabricant</strong>
                <input name="reference" type="text" id="reference" title="Saisir un référence exacte" size="15"  />
                <strong>Désignation</strong>
                <input name="designation" type="text" id="DateDebut5" title="Saisir le texte d'une désignation produit" size="35" value="<? echo $designation; ?>" />
                <span style="font-weight: bold"><a href="#" onclick="document.forms['frm1'].submit();"><img src="images/icones/loupe-icone-4171-32.png" width="32" height="32" align="absmiddle"/>Rechercher</a> <a href="catalogue_liste_pop.php?pop=<? echo $pop; ?>"><img src="images/icones/arrow-rotation-anti-horaire-icone-4507-32.png" width="32" height="32" align="absmiddle"/>Réinitialiser</a></span></p>
              </div></form>
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
                      <td width="6%" bgcolor="#5289BA" class="Style7"><div align="center" style="font-size: 11px"><span class="Style7"> </span>                        <span class="Style7">Cocher
                        </span></div>                        </td>
                      <td width="9%" bgcolor="#5289BA" class="Style7"><div align="center" style="font-size: 11px"><span class="Style7">Famille.</span></div></td>
                      <td width="11%" bgcolor="#5289BA" class="Style7"><p align="center" style="font-size: 11px"><span class="Style7">Fournisseur<br />
                        </span></p>                      </td>
                      <td width="14%" bgcolor="#5289BA" class="Style7"><div align="center" style="font-size: 11px"><span class="Style7">Marque</span></div></td>
                      <td width="28%" bgcolor="#5289BA"><div align="center" style="font-size: 11px"><span class="Style7">Désignation</span></div>                      </td>
                      <td width="9%" bgcolor="#5289BA"><div align="center" style="font-size: 11px"><span class="Style7"> Ref</span></div></td>
                      <td width="9%" bgcolor="#5289BA"> <div align="center" style="font-size: 11px"><span class="Style7"> PA HT</span></div>                        </td>
                      <td width="9%" bgcolor="#5289BA"><div align="center" style="font-size: 11px"><span class="Style7"> PV HT</span></div>                        </td>
                      <!--th class="data-table">                    Acompte                </th-->
                    </tr>
                    <!-- /Entete du tableau -->
                    <!-- Corps du tableau -->
                    <tr>
                      <td bgcolor="#CDDDEB"><!--<div align="center" style="font-size: 11px">
                        <input type="checkbox" name="checkbox" id="checkbox" title="Sélectionner tous les articles de la page"/>
                      </div>--></td>
                      <td bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<? echo"$url&page=$pag&nombre=$nombre&sort=FAMILLE"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<? echo"$url&page=$pag&nombre=$nombre&sort=FAMILLE DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<? echo"$url&page=$pag&nombre=$nombre&sort=FOURNISSEUR"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<? echo"$url&page=$pag&nombre=$nombre&sort=FOURNISSEUR DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td align="left" bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<? echo"$url&page=$pag&nombre=$nombre&sort=MARQUE"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<? echo"$url&page=$pag&nombre=$nombre&sort=MARQUE DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td align="left" bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<? echo"$url&page=$pag&nombre=$nombre&sort=DESIGNATION"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<? echo"$url&page=$pag&nombre=$nombre&sort=DESIGNATION DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td align="left" bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<? echo"$url&page=$pag&nombre=$nombre&sort=REFERENCE"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<? echo"$url&page=$pag&nombre=$nombre&sort=REFERENCE DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td align="right" bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<? echo"$url&page=$pag&nombre=$nombre&sort=PRIX_NET"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<? echo"$url&page=$pag&nombre=$nombre&sort=PRIX_NET DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      <td align="left" bgcolor="#CDDDEB"><div align="center" style="font-size: 11px"><a href="<? echo"$url&page=$pag&nombre=$nombre&sort=PRIX_NET"; ?>"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /></a><a href="<? echo"$url&page=$pag&nombre=$nombre&sort=PRIX_NET DESC"; ?>"><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></a></div></td>
                      </tr>
                      <?
					  $toggle="1"; 
					  // requete					  
					  $arr=array();
					  $quete="WHERE ";
					  if(!empty($famille)){
					  $famille="FAMILLE='".$famille."'";
					  array_push ($arr, $famille);
					  }
					  if(!empty($fournisseur)){
					  $fournisseur="FOURNISSEUR='".$fournisseur."'";
					  array_push ($arr, $fournisseur);
					  }
					  if(!empty($marque)){
					  $marque="MARQUE='".$marque."'";
					  array_push ($arr, $marque);
					  }
					  if(!empty($designation)){
					  $designation=str_replace(" ","%' AND DESIGNATION LIKE '%",$designation);
					  $designation="DESIGNATION LIKE '%".$designation."%'";
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
					  $quete=$quete.$arr[$count];
					  }else{
					  $quete="";
					  }
					  
					  
					  
					  
					  
					  $parametre="order by ".$sort. " LIMIT ".$page*$nombre. ",".$nombre;
					  //execution !
					  if(!empty($reference)){
                      $quete="WHERE REFERENCE='".$reference."'";
					  $catalogue="";
					  $parametre="";
					   }
					  if(empty($catalogue)){
					  $selecti=mysql_query("(select * from catalogue $quete) UNION ALL (select * from cataloguep $quete)");					  
					  $select=mysql_query("(select * from catalogue $quete) UNION ALL (select * from cataloguep $quete)  $parametre");
					  }else{
					  $selecti=mysql_query("select * from $catalogue $quete");
					  $select=mysql_query("select * from $catalogue $quete $parametre");
					  
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
                    <tr bgcolor="<? echo $bgcolor; ?>">
                      <td valign="top" bgcolor="<? 
					  $des=addslashes($result[DESIGNATION])." ref : ".addslashes($result[REFERENCE]);
					  if(!empty($marge)){
					  $prixvente=($result[PRIX_NET]*$marge/100)+$result[PRIX_NET];
					  }else{
					  $prixvente=$result[PRIX_NET];
					  } 
					  
					  echo $bgcolor; ?>" ><a href="#"<? echo" onclick=\"opener.document.getElementById('designation$pop').value='$des'; opener.document.getElementById('quant$pop').value='1';opener.document.getElementById('Hquant$pop').value='1';opener.document.getElementById('prix$pop').value='$prixvente';opener.document.getElementById('Hprix$pop').value='$prixvente';opener.window.calcul('t',$pop); window.close()\";" ?> ><img src="images/icones/panier-ajouter-icone-7116-32.png" width="24" height="24" align="absmiddle" title="insérer l'article au document en cours" /></a></td>
                      <td valign="top"><div align="center"><span style="font-size: 11px"><? echo $result[FAMILLE]; ?></span></div></td>
                      <td valign="top"><span class="Style4" style="font-size: 11px"> <? echo $result[FOURNISSEUR]; ?> </span></td>
                      <td valign="top"align="left" ><span class="Style4" style="font-size: 11px"><? echo $result[MARQUE]; ?></span></td>
                      <td valign="top"align="left" ><span class="Style4" style="font-size: 11px"> <? echo $result[DESIGNATION]; ?> <a href="javascript:;" onclick="toggle(<? echo $toggle; ?>);"><img src="images/icones/bullet-fleche-vers-le-bas-icone-5704-16.png" width="16" height="16" align="absmiddle" /></a></span><div id="<? echo $toggle; ?>" class="minimized"><img src="images/blockcontentbullets.png" width="7" height="9" /> <span style="font-weight: bold">Conditionnement</span> : <? echo $result[PRIX_AU]; ?> <br/> <img src="images/blockcontentbullets.png" width="7" height="9" /> <span style="font-weight: bold">Unité</span> :Pièce <br> <img src="images/blockcontentbullets.png" width="7" height="9" />  <span style="font-weight: bold">Prix de vente public</span> : <? echo  number_format($result[PRIX_BASE], 2, ',', ' '); ?> € <br/>  <img src="images/blockcontentbullets.png" width="7" height="9" /> <span style="font-weight: bold">Ref interne</span> : <? echo $result[_ID]; ?>
                        <p align="right"><a href="javascript:;" onclick="toggle(<? echo $toggle; ?>);"><img src="images/icones/bullet-fleche-vers-le-haut-icone-8574-16.png" width="16" height="16" align="absmiddle" /> Fermer</a></p></div></td>
                      <td valign="top"align="left" " class="Style4" style="font-size: 11px"><div align="center"><span class="Style4" style="font-size: 11px"><? echo $result[REFERENCE]; ?></span></div></td>
                      <td valign="top"align="right" ><div align="center" class="Style4" style="font-size: 11px"><? echo number_format($result[PRIX_NET], 2, ',', ' '); ?> </div></td>
                      <td valign="top"align="left" ><div align="center" class="Style4" style="font-size: 11px">	   
					  <?
					  echo  number_format($prixvente, 2, ',', ' ');
					   ?></div></td>
                      </tr>
                    <? $toggle++; } ?>
                    <tr>
                      <td colspan="8" bgcolor="#EAF0F7" >&nbsp;</td>
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
                                                      <td colspan="8"><p align="center">Nombre d'articles par page
                                                        <select name="select5" id="menu" onchange="go()">
                                                              <option value="<? echo"$url&page=$pag&nombre=10&sort=$sort"; ?>"<? if($nombre==10){ echo"selected"; }?>>10</option>
                                                              <option value="<? echo"$url&page=$pag&nombre=50&sort=$sort"; ?>"<? if($nombre==50){ echo"selected"; }?>>50</option>
                                                              <option value="<? echo"$url&page=$pag&nombre=100&sort=$sort"; ?>" <? if($nombre==100){ echo"selected"; }?>>100</option>
                                                        </select>
                                                      </p>
                                                      <p align="center"><? 
													  $pag=$page-1;
													  $pagee=$page+1;
													  $totpages=ceil($totp/$nombre);
													  if($pag>=0){?><a href="<? echo"$url&page=$pag&nombre=$nombre&sort=$sort"; ?>">Précédent</a> |<? } ?> Page <? echo $pagee; ?> sur <? echo $totpages; if($pagee<$totpages){?> | <a href="<? echo"$url&page=$pagee&nombre=$nombre&sort=$sort"; ?>">Suivant</a><? } ?></p></td>
                                                    </tr>
                                              </tbody></table>
</body>
</html>
