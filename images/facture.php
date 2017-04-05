<? require("inc.php"); 
if(empty($_GET['transforme'])){
$facture="facture";
$ligne_facture="ligne_facture";
}else{
$facture="devis";
$ligne_facture="ligne_devis";
}

$id=$_GET['id'];
$d_hid=$_POST['d_hid'];
$dd_hid=$_POST['dd_hid'];
if(!empty($d_hid)){
	// METTRE A JOUR LE facture
	$REFERENCE=$_POST['reference'];
	$REF_DEVIS=$_POST['REF_DEVIS'];
	$EMETTEUR=$client;
	$DESTINATAIRE=$_POST['DESTINATAIRE'];
	$DATE_EMISSION=$_POST['date_emission'];
	$DATE_EMISSION= implode('/',array_reverse(explode('/',$DATE_EMISSION)));
	$DATE_VALIDITE=$_POST['DVALIDATION'];
	if(!empty($DATE_VALIDITE)){
	$valid="1";
	}
	$DATE_VALIDITE= implode('/',array_reverse(explode('/',$DATE_VALIDITE)));
	$TITRE=$_POST['titre'];
	$INTERLOCUTEUR=$_POST['interlocuteur'];
	$TOTAL_HT=$_POST['Htotalht1'];
	$TOTAL_HT=$TOTAL_HT;
	$TOTALTTC=$_POST['Htotalttc'];
	$TOTALTTC=$TOTALTTC;
	$REMISE=$_POST['Hremise1'];
	$ACOMPTE=$_POST['Hacompte'];
	$COMMENTAIRE=$_POST['commentaire'];
	$htva55=$_POST['Htva55'];
	$htva19=$_POST['Htva19'];
		
		if(empty($id)){
		
		$req ="INSERT INTO facture (REF_DEVIS,DEVIS,REFERENCE,EMETTEUR,DESTINATAIRE,DATE_EMISSION,DATE_VALIDITE,TITRE,INTERLOCUTEUR,TOTAL_HT,TOTALTTC,REMISE,ACOMPTE,COMMENTAIRE,TVA55,TVA19) VALUES('$REFERENCE','$id','$REFERENCE','$EMETTEUR','$DESTINATAIRE','$DATE_EMISSION','$DATE_VALIDITE','$TITRE','$INTERLOCUTEUR','$TOTAL_HT','$TOTALTTC','$REMISE','$ACOMPTE','$COMMENTAIRE','$htva55','$htva19')";
		mysql_query($req);
		$id=mysql_insert_id();		
		}else{
		if(!empty($_GET['transforme'])){
		$req ="INSERT INTO facture (REF_DEVIS,DEVIS,REFERENCE,EMETTEUR,DESTINATAIRE,DATE_EMISSION,DATE_VALIDITE,TITRE,INTERLOCUTEUR,TOTAL_HT,TOTALTTC,REMISE,ACOMPTE,COMMENTAIRE,TVA55,TVA19) VALUES('$REFERENCE','$id','$REFERENCE','$EMETTEUR','$DESTINATAIRE','$DATE_EMISSION','$DATE_VALIDITE','$TITRE','$INTERLOCUTEUR','$TOTAL_HT','$TOTALTTC','$REMISE','$ACOMPTE','$COMMENTAIRE','$htva55','$htva19')";
		mysql_query($req);
		$iid=$id;
		$id=mysql_insert_id();
		mysql_query("update devis set VALIDATION='1' where _ID='$iid'");
			
		}else{		
		$req="UPDATE facture SET REFERENCE='$REFERENCE',EMETTEUR='$EMETTEUR',DESTINATAIRE='$DESTINATAIRE',DATE_EMISSION='$DATE_EMISSION',DATE_VALIDITE='$DATE_VALIDITE',TITRE='$TITRE',INTERLOCUTEUR='$INTERLOCUTEUR',TOTAL_HT='$TOTAL_HT',TOTALTTC='$TOTALTTC',REMISE='$REMISE',REF_DEVIS='$REF_DEVIS',ACOMPTE='$ACOMPTE',COMMENTAIRE='$COMMENTAIRE',TVA55='$htva55',TVA19='$htva19',VALIDATION='$valid' WHERE _ID='$id'";
		mysql_query($req);
		}
		// VIDER LIGNES DE facture LE CAS ECHEANT
		$rere="DELETE FROM ligne_facture WHERE DEVIS='$id'";
		mysql_query($rere);		
}
//REMPLIR LIGNE_FACTURE
$i = 1; 
while($i < $d_hid){
$DESIGNATION=$_POST['designation'.$i];
$TTVA=$_POST['tauxtva'.$i];
$QTE=$_POST['Hquant'.$i];
$UNITE=$_POST['unite'.$i];
$PUHT=$_POST['Hprix'.$i];
$NUMERO=$_POST['numero'.$i];
if(!empty($QTE)){
$req_insert ="INSERT INTO ligne_facture(DEVIS,DESIGNATION,TTVA,QTE,UNITE,PUHT,NUMERO) VALUES('$id','$DESIGNATION','$TTVA','$QTE','$UNITE','$PUHT','$NUMERO')";
mysql_query($req_insert)or die(mysql_error());
}
$i++;
}
$dd_hid=0;

?>
<script language="JavaScript">
window.location='facture_liste.php'
</script>
<?	}?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
<head>
<script language="javascript">
var tvaclient1='<? echo $_SESSION['tva1'];?>';
var tvaclient2='<? echo $_SESSION['tva2'];?>';
var tvaclient11='<? echo $_SESSION['tva11'];?>';
var tvaclient22='<? echo $_SESSION['tva22'];?>';
</script>
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
    <script type="text/javascript" src="script_flo2.js"></script>
    <style type="text/css">
<!--
.Style1 {color: #FFFFFF}
-->
    </style>
</head>
<body >
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
                			<a href="#" class="active"><span class="l"></span><span class="r"></span><span class="t">Accueil</span></a>                		</li>
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
                			<a href="#"><span class="l"></span><span class="r"></span><span class="t">Actualités CAP BOX</span></a>                		</li>
                        <li>
                			<a href="#"><span class="l"></span><span class="r"></span><span class="t">Besoin d'aide ? </span></a>                		</li>
                                                <li>
                			<a href="#"><span class="l"></span><span class="r"></span><span class="t">Contact </span></a>                		</li>
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
                                <div class="art-post-body">
                                  <div class="art-post-inner art-article">
                                    <h2 class="art-postheader"> <img src="images/postheadericon.png" width="26" height="26" alt="postheadericon" /> Edition de votre facture </h2>
                                    <form id="frm" name="frm" action="facture.php?transforme=<? echo $_GET['transforme']; ?>&id=<? echo $id; ?>" method="post">
    <!-- Devis en mode création-->
      <!--facture en mode Edition-->
      <!--div style="float: left; width: 100%"-->
      <table width="100%">
        <tbody>
        </tbody>
      </table>
      <!--/div-->
      <div>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="art-article">
                                                  <tbody>
                                                    <? 
													require("turl.php");
													?>
                                                    <tr>
                                                      <td colspan="8"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td><!-- Periode de recherche -->
            <!-- Periode de recherche -->
            <div>
            
<table width="100%">
  <tbody>
    <tr>
      <td height="32" colspan="2" background="images/fd_nav_ss_menu.png" bgcolor="#F0F0F0" class="componentheading"><span style="font-weight: bold"><a href="#" onClick="document.frm.submit()"><img src="images/icones/enregistrer-page-icone-7705-32.png" width="24" height="24" align="absmiddle" />Sauvegarder </a>
        <input type="hidden" name="d_hid" id="d_hid" value="1"/><input type="hidden" name="dd_hid" id="dd_hid" value="1"/><input type="hidden" name="transforme" id="transforme" value="<? echo $_GET['transforme']; ?>"/>
        <img src="images/menuseparator.png" width="1" height="24" align="absmiddle" />  <? if(!empty($id)){?><a href="facture_pdf.php?client=<? echo $client;?>&id=<? echo $id; ?>" target="_blank"><img src="images/icones/imprimante-icone-5571-32.png" width="24" height="24" align="absmiddle" /> Imprimer</a><img src="images/menuseparator.png" width="1" height="24" align="absmiddle" /><? } ?>  <a href="#" onClick="document.frm.reset();"><img src="images/icones/supprimer-la-page-icone-9859-32.png" width="24" height="24" align="absmiddle" />Effacer la saisie en cours</a><img src="images/menuseparator.png" width="1" height="24" align="absmiddle" />  <a href="facture_liste.php"><a href="facture_liste.php"><img src="images/icones/demande-afficher-la-liste-icone-8709-32.png" width="24" height="24" align="absmiddle" /> Retour à la liste des facture</a></span></td>
      <?
	  $select=mysql_query("select * from $facture where _ID='$id'");
	  $result=mysql_fetch_array($select);	  
	  ?>
      </tr>
    <tr>
      <td bgcolor="#F9F9F9" class="componentheading">&nbsp;</td>
      <td align="right" bgcolor="#F9F9F9">&nbsp;</td>
    </tr>
    <tr>
      <td width="50%" height="32" bgcolor="#F9F9F9" class="componentheading"><strong >        FACTURE N° : </strong>
        <input name="reference" type="text" id="reference" value="
		<? 
		if($facture=="facture"){
		echo $result[REFERENCE];
		}else{
		$ref1=mysql_query("select _ID from facture where EMETTEUR='$client'");
		$ref2= mysql_num_rows($ref1);
		$ref2++;
		echo $ref2;
		} 
		?>" size="10" />
        <strong>Affaire suivie par
            <select name="interlocuteur" id="interlocuteur">
            <?
			$in1=$result[INTERLOCUTEUR];
			if(empty($in1)){
			$in1=$interlocuteur;
			}
			$interl="select * from interlocuteur WHERE EMETTEUR='$client'";
			$inter=mysql_query($interl);
			while($interloc=mysql_fetch_array($inter)){
			$in2=$interloc[_ID];
			if($in1==$in2){
			$selected="selected";
			}
			?>
            <option value="<? echo $in2; ?>" <? echo $selected; ?>><? echo $interloc[NOM]." ".$interloc[PRENOM]; ?></option><?$selected=""; } ?>
          </select>
        </strong></td>
      <td width="50%" height="32" align="right" bgcolor="#F9F9F9"><strong><img src="images/icones/icon-date.gif" width="16" height="16" align="absmiddle" /> Date  facture</strong> : 
        <input name="date_emission" id="date_emission" tabindex="10" title="Saisir une date de document en cliquant sur cette zone." value="<? 
		if(empty($result[DATE_EMISSION])){
		echo date('d/m/Y');		
		}else{
		$date_e=$result[DATE_EMISSION];
		echo date('d/m/Y', strtotime($date_e));  }?>"size="10" alt="date" />  </td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#F9F9F9"><p><strong>Intitulé de la facture :</strong><br />
          <textarea title="Saisir l'objet principal du facture (facultatif)." id="titre" name="titre" cols="70" rows="0" tabindex="11"><? echo $result[TITRE]; ?></textarea>
      </p></td>
      <td bgcolor="#F9F9F9"><table width="100%" cellspacing="0" cellpadding="3">
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td bgcolor="#FFFFFF"><strong><img src="images/icones/icon-author.gif" alt="" width="10" height="10" />  Destinataire :</strong><br />
            <? 
			if(!empty($id)){
			$selectioncontact=$result[DESTINATAIRE];
			}else{
			$selectioncontact=$_GET['contact'];
			}
			$sele=mysql_query("select*from contact WHERE _ID='$selectioncontact'");
			$resul=mysql_fetch_array($sele); ?>
            <div id="c_societe"> <? echo $resul[SOCIETE]; ?></div><div id="c_nom"><? echo "$resul[PRENOM] $resul[NOM]"; ?></div><div id="c_adresse"><? echo"$resul[ADRESSE1] - $resul[ADRESSE2]"; ?></div><div id="c_cp"><? echo "$resul[CP] $resul[VILLE]";?></div>
            <input type="hidden" name="DESTINATAIRE" id="DESTINATAIRE" value="<? echo $selectioncontact; ?>" />            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="right"><a href="#" class="readon2" style="font-weight: bold" onClick="window.open('contact_liste_pop.php','','scrollbars=yes,resizable=yes,width=825,height=600')" >Modifier les coordonnées</a></div></td>
            <td></td>
          </tr>
        </table>        </td>
    </tr>
  </tbody>
</table>
<table width="100%" id="tableArticle" name="tableArticle">
          <tbody>
            <tr>
              <th colspan="2" bgcolor="#5289BA" ><span class="Style1">Description Produits | Prestations </span></th>
              <th width="5%" bgcolor="#5289BA" ><span class="Style1"> Qté </span></th>
              <th width="8%" bgcolor="#5289BA" ><span class="Style1">Unité</span></th>
              <th width="7%" bgcolor="#5289BA" ><span class="Style1"> P.U.  HT </span></th>
              <th width="8%" bgcolor="#5289BA" ><span class="Style1"> TVA % </span></th>
              <th width="8%" bgcolor="#5289BA" ><span class="Style1"> Total HT </span></th>
              <th width="5%" bgcolor="#5289BA" ><span class="Style1">Sup.</span></th>
            </tr>
            
            <!--<tr>
              <td bordercolor="#84F0FF" bgcolor="#EAF0F7"><textarea name="txtDescription2" cols="85" id="txtDescription2">VANNE BOULE MACON FIL-BRIDE 60 316L - Ref 37350600 </textarea>                </td><td bgcolor="#EAF0F7"><div align="center"><a href=""  onclick="MM_openBrWindow('catalogue_liste_pop.php','','scrollbars=yes,resizable=yes,width=825,height=600')" ><img src="images/icones/panier-ajouter-icone-7116-32.png" width="32" height="32" /></a></div></td>
              <td bordercolor="#84F0FF" bgcolor="#EAF0F7"><div align="left">
                <input id="txtQuantite2" name="txtQuantite2" size="5" value="1,00" onfocus="this.select()" alt="quantite" onchange="CalculTotalLigne('txtQuantite2')" />              
              </div></td>
              <td align="right" bordercolor="#84F0FF" bgcolor="#EAF0F7"><div align="left">
                <select name="select7" id="select7">
                  <option value="1">Pièce</option>
                  <option value="2">m²</option>
                  <option value="3">heure</option>
                  <option value="4">jour</option>
                  <option value="5">ml</option>
                  <option value="6">forfait</option>
                  <option value="7">m3</option>
                </select>
              </div></td>
              <td align="right" bordercolor="#84F0FF" bgcolor="#EAF0F7"><div align="left">
                <input id="txtPrixBrut2" name="txtPrixBrut2" size="10" onfocus="this.select()" alt="montant" value="253,72" onchange="CalculTotalLigne('txtPrixBrut2')" />              
              </div></td>
              <td align="right" bordercolor="#84F0FF" bgcolor="#EAF0F7"><div align="left">
                <select name="select3" id="select3">
                  <option value="1">5%</option>
                  <option value="2" selected="selected">19,6%</option>
                                </select>
              </div></td>
              <td align="right" bordercolor="#84F0FF" bgcolor="#EAF0F7"><div id="txtTotalLigne2">303,44</div></td>
              <td bordercolor="#84F0FF" bgcolor="#EAF0F7"><div align="center"><img alt="Supprimer" id="imgSupprimer3" onclick="SupprimeRangee(this);" src="images/icones/supprimer_16.png" title="Supprimer" width="16" height="16" /></div></td>
            </tr>
            <tr>
              <td bordercolor="#84F0FF" bgcolor="#EAF0F7"><textarea name="txtAssisteDesignation" cols="85" id="txtAssisteDesignation" tabindex="12" title="Saisir la désignation." onblur="QuantiteSansAssistance()" autocomplete="off">Saisissez manuellement l'intitulé de votre prestation ou ouvrez le catalogue</textarea>                </td><td bgcolor="#EAF0F7"><div align="center"><a href=""  onclick="MM_openBrWindow('catalogue_liste_pop.php','','scrollbars=yes,resizable=yes,width=825,height=600')" ><img src="images/icones/panier-ajouter-icone-7116-32.png" width="32" height="32" /></a></div></td>
              <td bordercolor="#84F0FF" bgcolor="#EAF0F7"><div align="left">
                <input title=" Saisir la quantité." id="txtAssisteQuantite" name="txtAssisteQuantite" size="5" onchange="LigneSansAssistance(this.value);" alt="quantite" value="" tabindex="13" />              
              </div></td>
              <td align="right" bordercolor="#84F0FF" bgcolor="#EAF0F7"><div align="left">
                <select name="select8" id="select8">
                  <option value="1">Pièce</option>
                  <option value="2">m²</option>
                  <option value="3">heure</option>
                  <option value="4">jour</option>
                  <option value="5">ml</option>
                  <option value="6">forfait</option>
                  <option value="7">m3</option>
                </select>
              </div></td>
              <td align="right" bordercolor="#84F0FF" bgcolor="#EAF0F7"><div align="left">
                <input title="Saisir le prix brut." id="txtAssistePrixBrut" name="txtAssistePrixBrut" alt="montant" size="10" value="" tabindex="14" />              
              </div></td>
              <td align="right" bordercolor="#84F0FF" bgcolor="#EAF0F7"><div align="left">
                <select name="select4" id="select4">
                  <option value="1">5%</option>
                  <option value="2">19,6%</option>
                </select>
              </div></td>
              <td bordercolor="#84F0FF" bgcolor="#EAF0F7"><div id="txtAssisteTotalLigne"> </div></td>
              <td bordercolor="#84F0FF" bgcolor="#EAF0F7">   </td>
            </tr>-->
            </tbody>
        </table><table width="100%"><tbody><tr>
              <td bordercolor="#84F0FF" bgcolor="#EAF0F7"><!--<button style="border: none; width:32px; height:32px; background:url(images/icones/ajouter-crayon-icone-4828-32.png); cursor: pointer; vertical-align: middle;" onclick="ajoutLigne()"></button>--><a href="#" onClick="ajoutLigne()"><img src="images/icones/ajouter-crayon-icone-4828-32.png" width="32" height="32" align="absmiddle" /> Ajouter une nouvelle ligne à la facture</a></td>              
            </tr>
          </tbody>
        </table>
        <table width="100%">
          <tbody>
            <tr>
              <td width="70%" valign="top" bgcolor="#F9F9F9"><!-- Pied gauche document -->
                  
                    <p><strong>Commentaires ajoutés à la facture :<br />
                    Ref Devis </strong><span class="componentheading">
                      <input name="REF_DEVIS" type="text" id="REF_DEVIS" value="<? 
					  if(!empty($_GET['transforme'])){
					  echo $result[REFERENCE];
					  }else{
					  echo $result[REF_DEVIS];
					  } 
					  ?>" />
                    </span></p>
                    
                      <textarea title="Saisir l'objet principal du facture (facultatif)." id="commentaire" name="commentaire" cols="85" rows="5" tabindex="11"><? echo $result[COMMENTAIRE]; ?></textarea>
                      
                        
                  
                  
              <td width="30%" rowspan="2" valign="top" bgcolor="#F9F9F9"><!-- Pied droit document -->
                  <div id="divTotalCumuleE">
                    <table width="100%" cellpadding="3">
                      <tbody>
                        <tr>                        </tr>
                        <tr>
                          <td height="2" bgcolor="#5289BA"></td>
                          <td height="2" align="right" bgcolor="#5289BA"></td>
                        </tr>
                        <tr>
                          <td width="60%" bgcolor="#EAF0F7"><strong> SOUS-TOTAL HT </strong></td>
                          <td align="right" bgcolor="#EAF0F7"><strong><div id="totalht"></div><input id="Htotalht" name="Htotalht" type="hidden" value="0"></strong></td>
                          </tr>
<tr>
                          <td bgcolor="#EAF0F7">Remise Globale
                            <input title="Saisir le taux de la remise globale." id="remise1" name="remise1" alt="montant" size="10" value="<? if(!empty($result[REMISE])){ echo $result[REMISE];}else{ echo "0";} ?>" onChange="calcul('r',0);" tabindex="16" /><input id="Hremise1" name="Hremise1" type="hidden" value="<? if(!empty($result[REMISE])){ echo $result[REMISE];}else{ echo "0";} ?>" />
                            %</td>
                          <td align="right" bgcolor="#EAF0F7"><div id="remise2"></div><input id="Hremise2" name="Hremise2" type="hidden"></td>
                          </tr>
                          <tr>
                          <td bgcolor="#5289BA"> <span class="Style1"><strong>TOTAL HT</strong></span></td>
                          <td align="right" bgcolor="#5289BA"><strong><div class="Style1" id="totalht1">  </div><input id="Htotalht1" name="Htotalht1" type="hidden"></strong></td>
                          </tr>
                        <tr>
                          <td bgcolor="#EAF0F7"><em> TVA à 5,5%</em></td>
                          <td align="right" bgcolor="#EAF0F7"><div id="tva55"></div><input id="Htva55" name="Htva55" type="hidden"></td>
                          </tr>
                        <tr>
                          <td bgcolor="#EAF0F7"><em> TVA à 19,6%</em></td>
                          <td align="right" bgcolor="#EAF0F7"><div id="tva19"></div><input id="Htva19" name="Htva19" type="hidden"></td>
                          </tr>
                        
                        
                        <tr>
                          <td bgcolor="#5289BA"><span class="Style1"><strong>TOTAL Net TTC</strong></span></td>
                          <td align="right" bgcolor="#5289BA"><strong><div class="Style1" id="totalttc"></div><input id="Htotalttc" name="Htotalttc" type="hidden"></strong></td>
                          </tr>
                        <tr>
                          <td bgcolor="#EAF0F7">Acompte perçu (TTC)</td>
                          <td align="right" bgcolor="#EAF0F7"><input title="Saisir le taux de l'acompte." id="acompte" name="acompte" alt="montant" size="10" value="
						  <? 
						  $racompte=$result[TOTALTTC]*($result[ACOMPTE]/100); 
						  echo $racompte; 
						  ?>" onChange="reste();" tabindex="16" />
                    <input type="hidden" name="Hacompte" id="Hacompte" value"<? echo $racompte; ?>" /></td>
                        </tr>
                        <tr>
                          <td bgcolor="#EAF0F7"><strong>Reste à payer (TTC)</strong></td>
                          <td align="right" bgcolor="#EAF0F7"><div id="restettc"></div></td>
                        </tr>
                      </tbody>
                    </table>
                  </div></td>
            </tr>
            <tr>
              <td valign="top" bgcolor="#F9F9F9">
                <p class="componentheading"><strong>Suivi de règlement :</strong><br />
                  <img src="images/icones/argent-icone-6943-32.png" alt="" width="32" height="32" align="absmiddle" /><span style="font-weight: bold"> Facture payée intégralement                    le</span>
                  <input name="DVALIDATION" id="DVALIDATION" tabindex="10" title="Saisir une date de document en cliquant sur cette zone." value="" size="10" alt="date" />
                </p>
                </td>
            </tr>
          </tbody>
        </table>
            </div>
            <!-- /Periode de recherche -->
            <!-- /Periode de recherche -->        </td>
      </tr>
      
      <tr>
        <td><!-- Liste des pieces -->            </td>
      </tr>
      
    </table></td>
                                                    </tr>
                                                    <tr >
                                                      <td colspan="8"><div align="right"></div></td>
                                                    </tr>
                                              </tbody></table>
        </div>
      <div id="tableInitialeE">
        
        <!-- Pied document -->
        
        <!-- /Pied document -->
        <!-- boutons -->
      </div>
      <?
	  if(!empty($_GET['dup'])){
	  $id=$_GET['dup'];
	  }
	  if (!empty($id)){
			$aut="select*from $ligne_facture where DEVIS='$id' order by NUMERO";
$aut2=mysql_query($aut);
$naut2=mysql_num_rows($aut2);
if(empty($naut2)){
?>
<script language="javascript">			
			ajoutLigne();
			
            </script>
<?
}else{
while($aut3=mysql_fetch_array($aut2)){
$anumero=$aut3[NUMERO];
$adesignation=mysql_real_escape_string($aut3[DESIGNATION]);
$aqte=$aut3[QTE];
$aprix=$aut3[PUHT];
$aunite=$aut3[UNITE];
$atva=$aut3[TTVA];

echo"<script language=\"javascript\">
ajoutLigne($anumero);
remplis('$anumero','$adesignation','$aqte','$aunite','$aprix','$atva');
calcul('x',$anumero);
</script>";
}
echo"<script language=\"javascript\">reste();</script>";
}
}else{?>
			<script language="javascript">			
			ajoutLigne();
			
            </script>
		<?	}
			
			?>
    </form>
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
