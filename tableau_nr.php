<?php 
	require("inc.php");
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
                		<li><a href="tableau.php" class="active"><span class="l"></span><span class="r"></span><span class="t">Accueil</span></a></li>
                		<li><a href="parametres_2.php"><span class="l"></span><span class="r"></span><span class="t">Mon compte</span></a></li>
                		<li><a href="http://capbox.fr/site/"><span class="l"></span><span class="r"></span><span class="t">Guide Utilisateur</span></a></li>
                		<li><a href="http://capbox.fr/site/index.php?option=com_content&view=article&id=46&Itemid=5"><span class="l"></span><span class="r"></span><span class="t">Questions / Réponses</span></a></li>
                		<li><a href="http://capbox.fr/site/index.php?option=com_content&view=category&layout=blog&id=3&Itemid=50"><span class="l"></span><span class="r"></span><span class="t">Actualités</span></a></li>
                 		<li><a href="http://capbox.fr/site/index.php?option=com_content&view=article&id=54&Itemid=48"><span class="l"></span><span class="r"></span><span class="t">Contact</span></a></li>
                		<li><a href="http://www.cap-achat.com" target="_blank"><span class="l"></span><span class="r"></span><span class="t">CAP ACHAT</span></a></li>
                		<li><a href="#" onClick="doPrint()"><img src="images/icones/imprimante-icone-5571-32.png" width="24" height="24" align="absmiddle" /></a></li>
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
                                            <h2 class="art-postheader">
                                                <img src="images/postheadericon.png" width="26" height="26" alt="postheadericon" />
                                                Consultation de votre tableau de bord</h2>
                                            <div class="art-postcontent">
                                                <!-- article-content -->



                                                  <!--startprint--><table width="100%" border="0" cellpadding="0" cellspacing="0" class="art-article">
                                                  <tbody>
													<tr >
                                                      <td align="center"  width="12%" ><?php  $rurl="/tableau.php"; urld($rurl); ?><img src="images/icones/diagramme-a-barres-icone-9116-32.png" align="center"  width="32" height="32" /><br />
                                                      Tableau de Bord <?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center"  width="10%" ><?php $rurl="/contact_liste.php"; urld($rurl); ?><img src="images/icones/satisfaire-vos-icone-4079-32.png" align="center"  width="32" height="32" /><br />
                                                      Contacts<?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center"  width="9%" ><?php $rurl="/devis_liste.php"; urld($rurl); ?><img src="images/icones/calculateur-de-modifier-icone-5292-32.png" align="center"  width="32" height="32" /><br />
													  Devis<?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center"  width="10%" > <?php $rurl="/facture_liste.php"; urld($rurl); ?><img src="images/icones/pieces-de-monnaie-icone-6896-32.png" align="center"  width="32" height="32" /><br />
                                                      Factures<?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center" width="10%"> <?php $rurl="/avoir_liste.php"; urld($rurl); ?><img src="images/icones/police-icone-9426-32.png" align="center" width="32" height="32" /><br />
                                                      Avoirs<?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center"  width="16%" ><?php $rurl="/bon_liste.php"; urld($rurl); ?><img src="images/icones/blanc-page-de-pile-icone-6477-32.png" align="center"  width="32" height="32" /><br />
                                                      Bons de commande<?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center"  width="10%" ><?php $rurl="/catalogue_liste.php"; urld($rurl); ?><img src="images/icones/livre-icone-9855-32.png" align="center"  width="32" height="32" /><br />
                                                      Catalogues<?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center"  width="11%" ><?php $rurl="/parametres.php"; urld($rurl); ?><img src="images/icones/script-engins-icone-6029-32.png" align="center"  width="32" height="32" /><br />
                                                      Paramètres<?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center"  width="11%"><?php $rurl="/index.php?action=logout"; urld($rurl); ?><img src="images/icones/porte-en-icone-7778-32.png" align="center"  width="32" height="32" /><br />
													  Déconnexion<?php echo $fin_url; ?>
													  </td>
                                                    </tr>
                                                    <tr>
                                                      <td colspan="10"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td height="32" colspan="3" background="images/fd_nav_ss_menu.png" bgcolor="#F0F0F0"></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#F9F9F9">&nbsp;</td>
        <td valign="top" bgcolor="#F9F9F9">&nbsp;</td>
        <td valign="top" bgcolor="#F9F9F9">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#F9F9F9"><div align="center">
          <p><strong><img src="images/icones/calculateur-de-modifier-icone-5292-32.png" width="32" height="32" align="absmiddle" /> Vos 5 derniers devis</strong></p>
        </div>
        </td>
        <td valign="top" bgcolor="#F9F9F9"><div align="center">
          <p><strong><img src="images/icones/pieces-de-monnaie-icone-6896-32.png" width="32" height="32" align="absmiddle" /> Vos 5 dernières factures</strong></p>
        </div>
        </td>
        <td valign="top" bgcolor="#F9F9F9"><div align="center">
          <p><strong><img src="images/icones/blanc-page-de-pile-icone-6477-32.png" width="32" height="32" align="absmiddle" /> Vos 5 derniers bons de commande</strong></p>
        </div>
        </td>
      </tr>
      <tr>
        <td height="2" valign="top" bgcolor="#4B85B8"></td>
        <td height="2" valign="top" bgcolor="#4B85B8"></td>
        <td height="2" valign="top" bgcolor="#4B85B8"></td>
        </tr>
      <tr>
        <td width="20%" valign="top" bgcolor="#F9F9F9">
            <ul>
			<?php
			$devisQ = mysql_query("select * from devis where ID_SOCIETE = " . $societeContact->societe->id . " and VALIDATION !=1 ORDER BY DATE_EMISSION DESC LIMIT 0,5");
			while ($devis = mysql_fetch_array($devisQ)) {
				echo "<li><a href=\"devis.php?id=" . $devis['_ID'] . "\">" . $devis['TITRE'] . "</a></li>";
			}
			?>
			</ul>
        </td>
        <td width="20%" valign="top" bgcolor="#F9F9F9">
        	<ul>
        	<?php 
        	$select = mysql_query("select * from facture where ID_SOCIETE = " . $societeContact->societe->id . " and VALIDATION !=1 ORDER BY DATE_EMISSION DESC LIMIT 0,5");
			while ($result = mysql_fetch_array($select)) {
				echo "<li><a href=\"facture.php?id=" . $result['_ID'] . "\">" . $result['TITRE'] . "</a></li>";
			}
			?>
			</ul>
		</td>
        <td width="20%" valign="top" bgcolor="#F9F9F9">
        	<ul>
        	<?php 
        	$select = mysql_query("select * from bon where ID_SOCIETE = " . $societeContact->societe->id . " and VALIDATION !=1 ORDER BY DATE_EMISSION DESC LIMIT 0,5");
			while ($result = mysql_fetch_array($select)) {
				echo "<li><a href=\"bon.php?id=" . $result['_ID'] . "\">" . $result['TITRE'] . "</a></li>";
			}
			?>
			</ul>
		</td>
      </tr>
      <tr bgcolor="#EFEFEF">
        <td valign="top" ><div align="center"><span style="font-weight: bold"><a href="devis.php">Créer un nouveau devis</a></span></div></td>
        <td valign="top"><div align="center"><span style="font-weight: bold"><a href="facture.php">Créer une nouvelle facture</a></span></div></td>
        <td valign="top"><div align="center"><span style="font-weight: bold"><a href="bon.php">Créer un nouveau bon de commande</a></span></div></td>
        </tr>
      <tr>
        <td valign="top" >&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#F9F9F9"><div align="center">
          <p><strong><img src="images/icones/satisfaire-vos-icone-4079-32.png" width="32" height="32" align="absmiddle" /> Vos 5 derniers contacts</strong></p>
        </div></td>
        <td valign="top" bgcolor="#F9F9F9"><div align="center">
          <p><strong><img src="images/icones/panier-ajouter-icone-7116-32.png" width="32" height="32" align="absmiddle" /> Vos 5 derniers articles</strong></p>
        </div></td>
        <td valign="top" bgcolor="#F9F9F9"><p align="center" style="display: none;"><strong><img src="images/icones/journal-icone-6872-32.png" width="32" height="32" align="absmiddle"/> Actualités</strong></p></td>
      </tr>
      <tr>
        <td height="2" valign="top" bgcolor="#4B85B8"></td>
        <td height="2" valign="top" bgcolor="#4B85B8"></td>
        <td height="2" valign="top" bgcolor="#4B85B8"></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#F9F9F9">
        	<ul>
        	<?php 
        	$select=mysql_query("select * from societe_client where ID_SOCIETE = " . $societeContact->societe->id . " and INACTIF !=1 ORDER BY _ID DESC LIMIT 0,5");
			while($result=mysql_fetch_array($select)){
				echo"<li><a href=\"contact.php?id=".$result['_ID']."\">".$result['PRENOM']." ".$result['NOM']." - ".$result['ENTREPRISE']."</a></li>";
			}
			?>
			</ul>
		</td>
        <td valign="top" bgcolor="#F9F9F9">
        	<ul>
        	<?php 
        	$select=mysql_query("select * from cataloguep where CLIENT=" . $societeContact->societe->id . " ORDER BY _ID DESC LIMIT 0,5");
			while($result=mysql_fetch_array($select)){
				echo"<li><a href=\"catalogue.php?id=".$result['_ID']."\">".$result['DESIGNATION']."</a></li>";
			}
			?>
			</ul>
		</td>
        <td valign="top" bgcolor="#F9F9F9">
        	<ul style="display: none;">
        	<?php
			require_once("feedparser.php");
			echo FeedParser("http://www.capbox.fr/site/index.php?option=com_content&view=category&layout=blog&id=3&Itemid=50&format=feed&type=rss", 3);
			?>
            </ul>
        </td>
      </tr>
      <tr bgcolor="#EFEFEF">
        <td valign="top" ><div align="center"><span style="font-weight: bold"><a href="contact.php">Créer un nouveau contact</a></span></div></td>
        <td valign="top"><div align="center"><span style="font-weight: bold"><a href="catalogue.php">Créer un nouvel article</a></span></div></td>
        <td valign="top"><div align="center" style="display: none;"><span style="font-weight: bold"><a href="http://www.capbox.fr/site/index.php?option=com_content&view=category&layout=blog&id=3&Itemid=50">Lire toute l'actualité</a></span></div></td>
      </tr>
      <tr>
        <td colspan="3"><!-- Liste des pieces -->
            <div id="listePiece">
              <!-- Confirmation Piece -->

              <!-- /Confirmation Piece -->
              <center id="tableauListe">
                <!-- Pagination -->
              </center>
            </div></td>
      </tr>

    </table><!--endprint--></td>
                                                    </tr>
                                                    <tr >
                                                      <td colspan="8"><div align="right"></div></td>
                                                    </tr>
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
