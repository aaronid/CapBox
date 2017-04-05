<?php
	require("inc.php");
	
	$errorMessage = "";
	if (!empty($_POST['hid'])) {
		$login = $_POST['LOGIN'];
		$passeOld = $_POST['PASSE_OLD'];
		$passeNew = $_POST['PASSE_NEW'];
		$passeConf = $_POST['PASSE_CONF'];
		
		$currentUtili = $societeContact->getUtilisateur();

		if (md5($passeOld) != $currentUtili->password) {
			$errorMessage = "La saisie de votre ancien mot de passe est erroné.";
		} else if (empty($passeNew)) {
			$errorMessage = "La saisie de votre nouveau mot de passe est obligatoire.";
		} else if ($passeNew != $passeConf) {
			$errorMessage = "Votre nouveau mot de passe n'est pas confirmé, veuillez le saisir à nouveau.";
		} else {
			$message = "Bonjour $societeContact->prenom $societeContact->nom,\n
			
			Nous avons le plaisir de vous confirmer la modification de votre compte utilisateur.\r
			Veuillez trouvez ci-après vos nouveaux identifiants.\n
			Login : $currentUtili->login\r
			Mot de passe : $passeNew\n
			Conservez les précieusement.\n
			Pour débuter l'utilisation de l'application, rendez-vous dans la rubrique « Besoin d'aide ? », une démonstration pas à pas y est disponible.\n
			Christophe LEPRETRE\r
			CAP ACHAT\n
			Tel : 06 88 86 13 22\r
			E-mail : cap.achat@orange.fr\r
			Site : www.cap-achat.com";
			
			$currentUtili->password = $passeNew;
			$currentUtili->update();

			mail($societeContact->email, 'Modification de vos identifiants', utf8_decode($message)); 

?>
<script language="JavaScript">
window.location='tableau.php'
</script>
<?php
		}
	}
	$passeOld = "";
	$passeNew = "";
	$passeConf = "";
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
                		<li><a href="tableau.php"><span class="l"></span><span class="r"></span><span class="t">Accueil</span></a>                		</li>
                		<li><a href="parametres_2.php" class="active"><span class="l"></span><span class="r"></span><span class="t">Mon compte</span></a>                		</li>
                		<li><a href="http://capbox.fr/site/"><span class="l"></span><span class="r"></span><span class="t">Guide Utilisateur</span></a></li>
                		<li><a href="http://capbox.fr/site/index.php?option=com_content&view=article&id=46&Itemid=5"><span class="l"></span><span class="r"></span><span class="t">Questions / R�ponses</span></a></li>
                		<li><a href="http://capbox.fr/site/index.php?option=com_content&view=category&layout=blog&id=3&Itemid=50"><span class="l"></span><span class="r"></span><span class="t">Actualit�s</span></a></li>
                		<li><a href="http://capbox.fr/site/index.php?option=com_content&view=article&id=54&Itemid=48"><span class="l"></span><span class="r"></span><span class="t">Contact </span></a>                		</li>
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
                              <h2 class="art-postheader"> <img src="images/postheadericon.png" width="26" height="26" alt="postheadericon" /> Edition de votre facture</h2>
                              <form name="frm" action="" method="post">
                          <!-- Devis en mode création-->
                          <!--devis en mode Edition-->
                          <!--div style="float: left; width: 100%"-->
                          <table width="100%">
                            <tbody>
                            </tbody>
                                                        </table>
                          <!--/div-->
                          <div>
                          <table width="100%" border="0" cellpadding="0" cellspacing="0" class="art-article">
                                            <tbody>
													<tr >
                                                      <td align="center"  width="12%" ><?php  $rurl="/tableau.php"; urld($rurl); ?><img src="images/icones/diagramme-a-barres-icone-9116-32.png" align="center"  width="32" height="32" /><br />

                                                      Tableau de Bord <?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center"  width="12%" ><?php $rurl="/contact_liste.php"; urld($rurl); ?><img src="images/icones/satisfaire-vos-icone-4079-32.png" align="center"  width="32" height="32" /><br />
                                                        Contacts<?php echo $fin_url; ?>
                                                        </td>
                                                      <td align="center"  width="9%" ><?php $rurl="/devis_liste.php"; urld($rurl); ?><img src="images/icones/calculateur-de-modifier-icone-5292-32.png" align="center"  width="32" height="32" /><br />

													  Devis<?php echo $fin_url; ?>

                                                      </td>
                                                      <td align="center"  width="11%" > <?php $rurl="/facture_liste.php"; urld($rurl); ?><img src="images/icones/pieces-de-monnaie-icone-6896-32.png" align="center"  width="32" height="32" /><br />
                                                       Factures<?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center"  width="16%" ><?php $rurl="/bon_liste.php"; urld($rurl); ?><img src="images/icones/blanc-page-de-pile-icone-6477-32.png" align="center"  width="32" height="32" /><br />
                                                       Bons de commande<?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center"  width="10%" ><?php $rurl="/catalogue_liste.php"; urld($rurl); ?><img src="images/icones/livre-icone-9855-32.png" align="center"  width="32" height="32" /><br />
                                                       Catalogues<?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center"  width="15%" ><?php $rurl="/parametres.php"; urld($rurl); ?><img src="images/icones/script-engins-icone-6029-32.png" align="center"  width="32" height="32" /><br />
                                                         Paramètres<?php echo $fin_url; ?>
                                                        </td>
                                                      <td align="center"  width="15%"><?php $rurl="/index.php?action=logout"; urld($rurl); ?><img src="images/icones/porte-en-icone-7778-32.png" align="center"  width="32" height="32" /><br />
														 Déconnexion<?php echo $fin_url; ?></td>
                                                    </tr>
                                              <tr>
                                                <td colspan="8"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td><!-- Periode de recherche -->
            <!-- Periode de recherche -->
            <div>
<table width="100%">
  <tbody>
    <tr>
      <td width="100%" height="32" background="images/fd_nav_ss_menu.png" bgcolor="#F0F0F0" class="componentheading"><span style="font-weight: bold"><img src="images/icones/enregistrer-page-icone-7705-32.png" width="24" height="24" align="absmiddle" /><a href="javascript:;" onClick="document.frm.submit()">Sauvegarder </a><img src="images/menuseparator.png" width="1" height="24" align="absmiddle" /> </span></td>
      </tr>
  </tbody>
</table>                                                  
                          
  <table width="100%" border="0" cellpadding="3" cellspacing="2" name="frmm" id="frmm">
    <tr>
      <td colspan="4" bgcolor="#F9F9F9"><p><strong><img src="images/icones/asterisque-orange-icone-5289-32.png" width="32" height="32" align="left" /> Important :</strong><strong> Ceci est l' espace de paramèrage de votre compte.<br />
        </strong><strong>Il est important de bien remplir ce formulaire afin d'avoir des documents établis en bonne et dû forme.</strong> 
        <input type="hidden" name="hid" id="hid" value="1" />
      </p>      </td>
      </tr>
    <tr>
      <td colspan="2" bgcolor="#5289BA" class="componentheading"><span class="Style1"><strong>Identité de l'entreprise</strong></span></td>
    </tr>
    <tr>
      <td colspan="2" ><span style="color: red" class="Style1"><?php echo $errorMessage; ?></span></td>
    </tr>
    <tr>
      <td width="156" valign="top" bgcolor="#EAF0F7" class="Style1"><span style="font-weight: bold; color: #545454">identifiant</span></td>
      <td width="282" valign="top" bgcolor="#F9F9F9"><input name="LOGIN" type="text" id="LOGIN" value="<?php echo $societeContact->login; ?>" size="50" /></td>
    </tr>
    <tr>
      <td width="156" valign="top" bgcolor="#EAF0F7" class="Style1"><span class="Style1" style="font-weight: bold; color: #545454">ancien mot de passe</span></td>
      <td width="282" valign="top" bgcolor="#F9F9F9"><input name="PASSE_OLD" type="password" id="PASSE_OLD" value="<?php echo $passeOld; ?>" /></td>
    </tr>
    <tr>
      <td width="156" valign="top" bgcolor="#EAF0F7" class="Style1"><span class="Style1" style="font-weight: bold; color: #545454">nouveau mot de passe</span></td>
      <td width="282" valign="top" bgcolor="#F9F9F9"><input name="PASSE_NEW" type="password" id="PASSE_NEW" value="<?php echo $passeNew; ?>" /></td>
    </tr>
    <tr>
      <td width="156" valign="top" bgcolor="#EAF0F7" class="Style1"><span class="Style1" style="font-weight: bold; color: #545454">confirmation mot de passe</span></td>
      <td width="282" valign="top" bgcolor="#F9F9F9"><input name="PASSE_CONF" type="password" id="PASSE_CONF" value="<?php echo $passeConf; ?>" /></td>
    </tr>
   
    <tr>
      <td colspan="4"><span style="font-weight: bold"><img src="images/icones/enregistrer-page-icone-7705-32.png" width="24" height="24" align="absmiddle" /><a href="javascript:;" onClick="document.frm.submit()">Sauvegarder</a></span></td>
    </tr>  
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
