<? require("inc.php"); 
//suppression cases à cocher



/////
if(empty($catalogue)){
$catalogue=$_GET['catalogue'];
}
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
$nombre="50";
}
$url="?catalogue=$catalogue&famille=$famille&fournisseur=$fournisseur&marque=$marque&reference=$reference&designation=$designation";
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
    <script type="text/javascript" src="script.js"></script> 
   <script type="text/javascript">

var famille = new Array();
var famill = new Array();
famill.push('');
var marque= new Array();

<?

	$marquetri=mysql_query("select DISTINCT(FAMILLE), MARQUE  from catalogue ORDER BY FAMILLE");

while($m1=mysql_fetch_assoc($marquetri)){
$mar1=$m1[MARQUE];
$fam1=$m1[FAMILLE];
if(!empty($m1[FAMILLE])){
if($fam1==$fam0){
echo "famille['$fam1'].push('$mar1'); ";
}else{
echo"famille['$fam1']= new Array();";
echo "famille['$fam1'].push('');";
echo "famille['$fam1'].push('$mar1');";
echo "famill.push('$fam1');";
}
$fam0=$fam1;
}
}

	$marquetri=mysql_query("select DISTINCT MARQUE from catalogue ORDER BY MARQUE");

$i="1";
while($m1=mysql_fetch_array($marquetri)){
$mark=$m1[MARQUE];
echo "marque.push('$mark');";
}
?>
function remplirSelect()
  {
  var code=document.getElementById('famille').value;
  if(code){
     var lesMarques = famille[code];
  lesMarques.sort();
  
    document.frm1.marque.options.length = lesMarques.length;
	document.frm1.marque.options[0].value = '';
      document.frm1.marque.options[0].text = '';
    for (i=1; i<lesMarques.length; i++)
      {
      document.frm1.marque.options[i].value = lesMarques[i];
      document.frm1.marque.options[i].text = lesMarques[i];
      }
    document.frm1.marque.options.selectedIndex = 0;
	}else{
	marque.sort();
   var lesMarques = marque;
   document.frm1.marque.options.length = lesMarques.length;
   for (i=0; i<lesMarques.length; i++)
      {
      document.frm1.marque.options[i].value = lesMarques[i];
      document.frm1.marque.options[i].text = lesMarques[i];
      }
    document.frm1.marque.options.selectedIndex = 0;
  }	
	}
	
function go() 
{
window.location=document.getElementById("menu").value;
}
function majcheckbox(master, className) { 
	var liste = document.getElementsByTagName('input'); 
	for(var i=0; i<liste.length; i++) { 
		if (liste[i].className == className) { 
			liste[i].checked = master.checked; 
		} 
	} 
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
</script>
    <link rel="stylesheet" href="style.css" type="text/css"  />
    <!--[if IE 6]><link rel="stylesheet" href="style.ie6.css" type="text/css"  /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="style.ie7.css" type="text/css"  /><![endif]-->
    <style type="text/css">
<!--
.Style1 {color: #FFFFFF}
.Style4 {font-size: 85%}
.Style6 {font-size: 85%; font-weight: bold; }
.Style7 {font-size: 85%; font-weight: bold; color: #FFFFFF; }
.minimized{display:none;}
-->
    </style>
 <script language="javascript">
    	function ex()
{
var x=confirm("Etes-vous sûr de supprimer ces articles ?")
if (x)
 document.forms['frmm'].submit();
}
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
                <? require("topmenu.php"); ?>
                                    
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
                                                Consulter et gérer les articles de votre catalogue</h2>
                                            <div class="art-postcontent">
                                                <!-- article-content -->
                                               
                                                
                                                
                                                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="art-article">
                                                  <tbody>
                                                    <? 													
													require("turl2.php");													
													?>
                                                    <tr>
                                                      <td colspan="8"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td height="32" background="images/fd_nav_ss_menu.png" bgcolor="#F0F0F0"><img src="images/icones/imprimante-icone-5571-32.png" width="24" height="24" align="absmiddle" /> <a href="#"><strong>Imprimer</strong></a> <img src="images/menuseparator.png" width="1" height="24" align="absmiddle" />  </td>
      </tr>
      <tr>
        <td bgcolor="#F9F9F9"><!-- Periode de recherche -->
            <!-- Periode de recherche --><!--startprint-->
            <form action="" method="get" name="frm1" id="frm1"><div>
              
                <h2><strong>                  Rechercher et comparer parmi tous les articles du catalogue</strong></h2>
                <p><strong><? if(empty($_SESSION['catalogue'])){ ?>Catalogue
                  <select name="catalogue" id="select4">
                  <option ></option>
                    <option value="catalogue" <? if($catalogue=='catalogue'){echo"selected"; }?>>CAP ACHAT</option>
                    <option value="cataloguep"<? if($catalogue=='cataloguep'){echo"selected"; }?>>Mon catalogue personnel</option>
                  </select> <? } ?>
                  
Famille<select name="famille" id="famille" onChange="remplirSelect();">
              <script>			  
   var lesFamilles = famill;  
    for (i=0; i<lesFamilles.length; i++)
      {
     var nwChild = document.createElement( "option" );
	nwChild.setAttribute( "value", lesFamilles[i] );
	if(lesFamilles[i]=='<? echo $famille; ?>'){
	nwChild.setAttribute( "selected", "selected");
	}	
	nwChild.appendChild( document.createTextNode(lesFamilles[i]));
document.getElementById( "famille" ).appendChild( nwChild );
       }
    
			  </script>
              </select>
<!--<select name="famille" id="famille" onChange="remplirSelect();">

<? 
//$tri=mysql_query("(select DISTINCT FAMILLE from catalogue) UNION (select DISTINCT FAMILLE from cataloguep) ORDER BY FAMILLE");
//while($tri1=mysql_fetch_array($tri)){ 
//$ffamille=$tri1[FAMILLE];
?>
  <option value="<? //echo $ffamille; if($famille==$ffamille){echo"\"selected"; }?>"><? //echo $ffamille; ?></option>
  <? //} ?>
</select>-->
              <strong>Marque </strong><select name="marque" id="marque">
              <script>
			  var code=document.getElementById('famille').value;
  if(code){
     var lesMarques = famille[code];
  lesMarques.sort();
  }else{
   var lesMarques = marque;
  }
    for (i=0; i<lesMarques.length; i++)
      {
     var newChild = document.createElement( "option" );
	newChild.setAttribute( "value", lesMarques[i] );
	if(lesMarques[i]=='<? echo $marque; ?>'){
	newChild.setAttribute( "selected", "selected");
	}	
	newChild.appendChild( document.createTextNode(lesMarques[i]));
document.getElementById( "marque" ).appendChild( newChild );
       }
    
			  </script>
              </select> </p><p><strong>Fournisseur</strong> 
              <select name="fournisseur" id="select2">
              <option ></option>
                <? 
				$tri=mysql_query("select DISTINCT FOURNISSEUR from catalogue ORDER BY FOURNISSEUR");
while($tri1=mysql_fetch_array($tri)){ 
?>

  <option value="<? echo $tri1[FOURNISSEUR];  if($fournisseur==$tri1[FOURNISSEUR]){echo"\" selected"; }?>"><? echo $tri1[FOURNISSEUR]; ?></option>
 <? } ?>
              </select>
              
              <strong>Ref. Fabricant</strong>
                <input name="reference" type="text" id="reference" title="Saisir un référence exacte" size="15"  />
                <strong>Désignation</strong>
                <input name="designation" type="text" id="DateDebut5" title="Saisir le texte d'une désignation produit" size="35" value="<? echo $designation; ?>" />
                <span style="font-weight: bold"><a href="#" onclick="document.forms['frm1'].submit();"><img src="images/icones/loupe-icone-4171-32.png" width="32" height="32" align="absmiddle"/>Rechercher</a> <a href="catalogue_liste.php"><img src="images/icones/arrow-rotation-anti-horaire-icone-4507-32.png" width="32" height="32" align="absmiddle"/>Réinitialiser</a></span></p>
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
                <form action="<? echo "$url&page=$pag&nombre=$nombre&sort=$sort"; ?>" method="post" name="frmm">
                <table width="100%">
                  <!-- Entete du tableau -->
                  <tbody>
                    <tr>                      
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
					  $quete=$quete.$arr[$count];
					  $quete2=" AND CLIENT='$client'";
					  }else{
					  $quete="";
					  $quete2="WHERE CLIENT='$client'";
					  }
					  
					  
					  
					  
					  
					  $parametre="order by ".$sort. " LIMIT ".$page*$nombre. ",".$nombre;
					  //execution !
					  if(!empty($reference)){
                      $quete="WHERE REFERENCE='".$reference."'";
					  $catalogue="";
					  $parametre="";
					  $quete2="";
					   }					  
					  $selecti=mysql_query("select * from catalogue $quete ");
					  $select=mysql_query("select * from catalogue $quete $parametre");
					  
					  
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
                      <td valign="top"><div align="center"><span style="font-size: 11px"><? echo $result[FAMILLE]; ?></span></div></td>
                      <td valign="top"><div align="center"><span class="Style4" style="font-size: 11px"> <? echo $result[FOURNISSEUR]; ?> </span></div></td>
                      <td valign="top"align="center" ><span class="Style4" style="font-size: 11px"><? echo $result[MARQUE]; ?></span></div></td>
                      <td valign="top"align="left" ><span class="Style4" style="font-size: 11px"> <? echo $result[DESIGNATION]; ?> <a href="javascript:;" onclick="toggle(<? echo $toggle; ?>);"><img src="images/icones/bullet-fleche-vers-le-bas-icone-5704-16.png" width="16" height="16" align="absmiddle" /></a></span><div id="<? echo $toggle; ?>" class="minimized"><img src="images/blockcontentbullets.png" width="7" height="9" /> <span style="font-weight: bold">Conditionnement</span> : <? echo $result[PRIX_AU]; ?> <br/><img src="images/blockcontentbullets.png" width="7" height="9" />  <span style="font-weight: bold">Prix de vente public</span> : <? echo  number_format($result[PRIX_BASE], 2, ',', ' '); ?> € <br/>  <img src="images/blockcontentbullets.png" width="7" height="9" /> <span style="font-weight: bold">Ref interne</span> : <? echo $result[_ID]; ?>
                        <p align="right"><a href="javascript:;" onclick="toggle(<? echo $toggle; ?>);"><img src="images/icones/bullet-fleche-vers-le-haut-icone-8574-16.png" width="16" height="16" align="absmiddle" /> Fermer</a></p></div></td>
                      <td valign="top"align="left" " class="Style4" style="font-size: 11px"><div align="center"><span class="Style4" style="font-size: 11px"><? echo $result[REFERENCE]; ?></span></div></td>
                      <td valign="top"align="right" ><div align="center" class="Style4" style="font-size: 11px">
					  <? 
					  if (empty($result[CLIENT])){
					  echo number_format($result[PRIX_NET], 2, ',', ' '); 
					  }else{
					  echo number_format($result[PRIX_BASE], 2, ',', ' '); 
					  }
					  
					  ?> </div></td>
                      <td valign="top"align="left" ><div align="center" class="Style4" style="font-size: 11px">
					  <? if(!empty($marge) and empty($result[CLIENT])){ 
					  $prixvente=($result[PRIX_NET]*$marge/100)+$result[PRIX_NET]; 
					  echo  number_format($prixvente, 2, ',', ' ');
					  }else{
					  echo  number_format($result[PRIX_BASE], 2, ',', ' ');
					  } ?></div></td>
                      </tr>
                    <? $toggle++; } ?>
                    <tr>
                      <td colspan="9" bgcolor="#EAF0F7" >&nbsp;</td>
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
