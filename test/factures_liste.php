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
                                                Liste de vos factures</h2>
                                            <div class="art-postcontent">
                                                <!-- article-content -->
                                               
                                                
                                                
                                                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="art-article">
                                                  <tbody>
                                                   <? 
													require("turl.php");
													?>
                                                    <tr>
                                                      <td colspan="8"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td height="32" background="images/fd_nav_ss_menu.png" bgcolor="#F0F0F0"><span style="font-weight: bold"><a href="#"><a href="devis.html"><img src="images/icones/ajouter-une-page-blanche-icone-9840-32.png" alt="" width="24" height="24" align="absmiddle" />Créer une nouvelle facture</a><img src="images/menuseparator.png" width="1" height="24" align="absmiddle" />  <a href="#"><img src="images/icones/imprimante-icone-5571-32.png" width="24" height="24" align="absmiddle" /> Imprimer</a>  <img src="images/menuseparator.png" width="1" height="24" align="absmiddle" />  <a href="#"><img src="images/icones/sablier-icone-8810-32.png" width="24" height="24" align="absmiddle" /> Voir les factures en attente de règlement</a></span></td>
      </tr>
      <tr>
        <td bgcolor="#F9F9F9"><!-- Periode de recherche -->
            <!-- Periode de recherche -->
            <div>
              <p><strong>Suivi par
                  <select name="select" id="select">
                    <option value="1">NCT</option>
                    <option value="2">FDS</option>
                  </select>
Date de début</strong>:
<input title="Sélectionner une date de début de période en cliquant sur cette zone" alt="date" id="DateDebut" name="DateDebut" value="01/01/2010" onchange="verifDateRechercher('DateDebut')" type="text" />
     <strong>Date de fin</strong>:
<input title="Sélectionner une date de fin de période en cliquant sur cette zone" alt="date" id="DateFin" name="DateFin" value="28/09/2010" onchange="verifDateRechercher('DateFin')" type="text" />
 <a href="#"><img src="images/icones/loupe-icone-4171-32.png" width="32" height="32" align="absmiddle" /> <span style="font-weight: bold">Lancer la recherche</span></a></p>
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
                          <th width="60" align="center" bgcolor="#5289BA"><span class="Style1" style="font-size: 11px">Suivi</span></th>
                          <th width="64" align="center" bgcolor="#5289BA"><span class="Style1" style="font-size: 11px"> Emission </span></th>
                          <th width="36" bgcolor="#5289BA"><span class="Style1" style="font-size: 11px"> Réf. </span></th>
                          <th width="178" bgcolor="#5289BA"><span class="Style1" style="font-size: 11px"> Client </span></th>
                          <th width="302" bgcolor="#5289BA"><span class="Style1" style="font-size: 11px"> Intitulé </span></th>
                          <th width="82" bgcolor="#5289BA"><span class="Style1" style="font-size: 11px"> Montant HT</span></th>
                          <th width="152" bgcolor="#5289BA"><span class="Style1" style="font-size: 11px">Payé</span></th>
                          <!--th class="data-table">                    Acompte                </th-->
                          <th width="152" bgcolor="#5289BA"><span class="Style1" style="font-size: 11px"> Actions</span></th>
                        </tr>
                        <!-- /Entete du tableau -->
                        <!-- Corps du tableau -->
                        <tr>
                          <td bgcolor="#CDDDEB"><div align="center"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></div></td>
                          <td bgcolor="#CDDDEB"><div align="center"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></div></td>
                          <td bgcolor="#CDDDEB"><div align="center"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></div></td>
                          <td bgcolor="#CDDDEB"><div align="center"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></div></td>
                          <td bgcolor="#CDDDEB"><div align="center"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></div></td>
                          <td bgcolor="#CDDDEB"><div align="center"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></div></td>
                          <td align="left" bgcolor="#CDDDEB"><div align="center"><img src="images/icones/icon-max.gif" width="17" height="16" align="absmiddle" /><img src="images/icones/icon-min.gif" width="17" height="16" align="absmiddle" /></div></td>
                          <td align="left" bgcolor="#CDDDEB">&nbsp;</td>
                        </tr>
                        <tr id="rangeeSurvol">
                          <td bgcolor="#EAF0F7"><span style="font-size: 11px">NCT</span></td>
                          <td bgcolor="#EAF0F7"><span style="font-size: 11px"> 30/08/2010  </span></td>
                          <td bgcolor="#EAF0F7"><span style="font-size: 11px"> 11  </span></td>
                          <!-- Tier  -->
                          <td align="left" bgcolor="#EAF0F7"><span style="font-size: 11px"> Prénom NOM - Société</span></td>
                          <td align="left" bgcolor="#EAF0F7"> <a href="devis.php" style="font-size: 11px">Réfection terrasse </a> </td>
                          <td align="right" bgcolor="#EAF0F7"><span style="font-size: 11px"> 661,98 </span></td>
                          <td align="left" bgcolor="#EAF0F7"><div align="center"><img src="images/icones/sablier-icone-8810-16.png" width="16" height="16" /></div></td>
                          <td align="left" bgcolor="#EAF0F7"><div align="center" style="font-size: 11px"><a href="devis.php"><img src="images/icones/editer_16.png" alt="Modifier" name="imgModifier2" width="16" height="16" id="imgModifier2" title="Modifier" /> </a> &nbsp;&nbsp; <a href="facture.html"><img alt="Transférer en facturation" id="imgTransferer2" onclick="TransfererPiece(event);" onmouseover="InitialiseCodeDescriptionPiece('51', '10', '', ' erezr');" src="images/icones/facturer_16.png" title="Transférer en facturation" width="16" height="16" /></a> &nbsp;&nbsp;<img alt="Recopier" id="imgRecopie" src="images/icones/copie_16.png" title="Recopier" width="16" height="16" /><a href="Devis.pdf" target="_blank">&nbsp; &nbsp;<img alt="Imprimer" id="imgPDF" src="images/icones/imprimante-icone-5571-16.png" title="Imprimer" width="16" height="16" /> </a>&nbsp;&nbsp;<img alt="Supprimer" id="imgSupprimer2" onclick="SupprimerPiece(event);" onmouseover="InitialiseCodeDescriptionPiece('52', '11', '');" src="images/icones/supprimer_16.png" title="Supprimer" width="16" height="16" />&nbsp;</div></td>
                        </tr>
                        <tr id="rangeeSurvol">
                          <td bgcolor="#FFFFFF"><span style="font-size: 11px">NCT</span></td>
                          <td bgcolor="#FFFFFF"><span style="font-size: 11px"> 30/08/2010  </span></td>
                          <td bgcolor="#FFFFFF"><span style="font-size: 11px"> 10  </span></td>
                          <!-- Tier  -->
                          <td align="left" bgcolor="#FFFFFF"><span style="font-size: 11px"> erezr  </span></td>
                          <td align="left" bgcolor="#FFFFFF"><span style="font-size: 11px">   </span></td>
                          <td align="right" bgcolor="#FFFFFF"><span style="font-size: 11px"> 190,00 </span></td>
                          <td align="left" bgcolor="#FFFFFF"><div align="center"><img src="images/icones/tick-icone-8838-16.png" width="16" height="16" /></div></td>
                          <td align="left" bgcolor="#FFFFFF"><div align="center" style="font-size: 11px"><a href="devis.php"><img src="images/icones/editer_16.png" alt="Modifier" name="imgModifier2" width="16" height="16" id="imgModifier" title="Modifier" /> </a> &nbsp;&nbsp; <a href="facture.html"><img alt="Transférer en facturation" id="imgTransferer" onclick="TransfererPiece(event);" onmouseover="InitialiseCodeDescriptionPiece('51', '10', '', ' erezr');" src="images/icones/facturer_16.png" title="Transférer en facturation" width="16" height="16" /></a> &nbsp;&nbsp;<img alt="Recopier" id="imgRecopie2" src="images/icones/copie_16.png" title="Recopier" width="16" height="16" /><a href="Devis.pdf" target="_blank">&nbsp; &nbsp;<img alt="Imprimer" id="imgPDF2" src="images/icones/imprimante-icone-5571-16.png" title="Imprimer" width="16" height="16" /> </a>&nbsp;&nbsp;<img alt="Supprimer" id="imgSupprimer" onclick="SupprimerPiece(event);" onmouseover="InitialiseCodeDescriptionPiece('52', '11', '');" src="images/icones/supprimer_16.png" title="Supprimer" width="16" height="16" /></div></td>
                        </tr>
                        <tr id="rangeeSurvol">
                          <td bgcolor="#EAF0F7"><span style="font-size: 11px">FDS</span></td>
                          <td bgcolor="#EAF0F7"><span style="font-size: 11px"> 11/02/2010  </span></td>
                          <td bgcolor="#EAF0F7"><span style="font-size: 11px"> 9  </span></td>
                          <!-- Tier  -->
                          <td align="left" bgcolor="#EAF0F7"><span style="font-size: 11px"> Melle CALVEZ  </span></td>
                          <td align="left" bgcolor="#EAF0F7"> <a href="#" style="font-size: 11px">Réparation ordinateur portable                    </a></td>
                          <td align="right" bgcolor="#EAF0F7"><span style="font-size: 11px"> 290,94 </span></td>
                          <td align="left" bgcolor="#EAF0F7"><div align="center"><img src="images/icones/sablier-icone-8810-16.png" alt="" width="16" height="16" /></div></td>
                          <td align="left" bgcolor="#EAF0F7"><div align="center" style="font-size: 11px"><a href="devis.php"><img src="images/icones/editer_16.png" alt="Modifier" name="imgModifier2" width="16" height="16" id="imgModifier3" title="Modifier" /> </a> &nbsp;&nbsp; <a href="facture.html"><img alt="Transférer en facturation" id="imgTransferer3" onclick="TransfererPiece(event);" onmouseover="InitialiseCodeDescriptionPiece('51', '10', '', ' erezr');" src="images/icones/facturer_16.png" title="Transférer en facturation" width="16" height="16" /></a> &nbsp;&nbsp;<img alt="Recopier" id="imgRecopie3" src="images/icones/copie_16.png" title="Recopier" width="16" height="16" /><a href="Devis.pdf" target="_blank">&nbsp; &nbsp;<img alt="Imprimer" id="imgPDF3" src="images/icones/imprimante-icone-5571-16.png" title="Imprimer" width="16" height="16" /> </a>&nbsp;&nbsp;<img alt="Supprimer" id="imgSupprimer3" onclick="SupprimerPiece(event);" onmouseover="InitialiseCodeDescriptionPiece('52', '11', '');" src="images/icones/supprimer_16.png" title="Supprimer" width="16" height="16" /></div></td>
                        </tr>
                        <tr id="rangeeSurvol">
                          <td bgcolor="#FFFFFF"><span style="font-size: 11px">FDS</span></td>
                          <td bgcolor="#FFFFFF"><span style="font-size: 11px"> 28/09/2010  </span></td>
                          <td bgcolor="#FFFFFF"><span style="font-size: 11px"> 6  </span></td>
                          <!-- Tier  -->
                          <td align="left" bgcolor="#FFFFFF"><span style="font-size: 11px"> Mme RICHARD  </span></td>
                          <td align="left" bgcolor="#FFFFFF"> <a href="#" style="font-size: 11px">Ajout disque dur                    </a></td>
                          <td align="right" bgcolor="#FFFFFF"><span style="font-size: 11px"> 118,04 </span></td>
                          <td align="left" bgcolor="#FFFFFF"><div align="center"><img src="images/icones/sablier-icone-8810-16.png" alt="" width="16" height="16" /></div></td>
                          <td align="left" bgcolor="#FFFFFF"><div align="center" style="font-size: 11px"><a href="devis.php"><img src="images/icones/editer_16.png" alt="Modifier" name="imgModifier2" width="16" height="16" id="imgModifier4" title="Modifier" /> </a> &nbsp;&nbsp; <a href="facture.html"><img alt="Transférer en facturation" id="imgTransferer4" onclick="TransfererPiece(event);" onmouseover="InitialiseCodeDescriptionPiece('51', '10', '', ' erezr');" src="images/icones/facturer_16.png" title="Transférer en facturation" width="16" height="16" /></a> &nbsp;&nbsp;<img alt="Recopier" id="imgRecopie4" src="images/icones/copie_16.png" title="Recopier" width="16" height="16" /><a href="Devis.pdf" target="_blank">&nbsp; &nbsp;<img alt="Imprimer" id="imgPDF4" src="images/icones/imprimante-icone-5571-16.png" title="Imprimer" width="16" height="16" /> </a>&nbsp;&nbsp;<img alt="Supprimer" id="imgSupprimer4" onclick="SupprimerPiece(event);" onmouseover="InitialiseCodeDescriptionPiece('52', '11', '');" src="images/icones/supprimer_16.png" title="Supprimer" width="16" height="16" /></div></td>
                        </tr>
                        <!-- total general du mois -->
                        <!-- total general de la periode -->
                        <tr>
                          <td height="2" colspan="10" bgcolor="#5289BA"></td>
                          </tr>
                        <tr>
                          <td colspan="4">   </td>
                          <td align="right"> TOTAL PAGE </td>
                          <td align="right" bgcolor="#5289BA"><span class="Style1"><strong> 788,98</strong></span> </td>
                          <td colspan="3">   </td>
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
                                                      <td colspan="8"><p align="center">Nombre de lignes par page
                                                          <select name="select5" id="select5">
                                                              <option value="1">10</option>
                                                              <option value="2">50</option>
                                                              <option value="3">100</option>
                                                            </select>
                                                      </p>
                                                      <p align="center"><a href="#">Précédent</a> | Page 1 sur 10 | <a href="#">Suivant</a></p></td>
                                                    </tr>
                                              </tbody></table>
                                                
                                                	
                                                    
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
