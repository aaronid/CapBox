<?php
	require("inc.php");
	require("business/tva.php");
	require("business/bon.php");
	require("business/devis.php");
	require("business/facture.php");
	
	$dateDebPeriode = getCurrentYearDateMinStrToDisplay();
	if (isset($_GET['dateDebPeriode'])) {
		$dateDebPeriode = $_GET['dateDebPeriode'];
	}
	$dateDebPeriodeSql = implode('-', array_reverse(explode('/', $dateDebPeriode)));
	
	$dateFinPeriode = getCurrentYearDateMaxStrToDisplay();
	if (isset($_GET['dateFinPeriode'])) {
		$dateFinPeriode = $_GET['dateFinPeriode'];
	}
	$dateFinPeriodeSql = implode('-', array_reverse(explode('/', $dateFinPeriode)));
	
	$typeMontant = Profil::$TYPE_MONTANT_HT;
	if (isset($_GET['typeMontant'])) {
		$typeMontant = $_GET['typeMontant'];
	} else if (isset($_SESSION['typeMontant'])) {
		$typeMontant = $_SESSION['typeMontant'];
	}
	$_SESSION['typeMontant'] = $typeMontant;
?>
<!DOCTYPE html>
<html>
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
    <script type="text/javascript" src="Chart.bundle.js"></script>
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
                                                      <td align="center" width="12%" ><?php $rurl="/capbox_test/tableau.php"; urld($rurl); ?><img src="images/icones/diagramme-a-barres-icone-9116-32.png" align="center"  width="32" height="32" /><br />
                                                      Tableau de Bord <?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center" width="10%" ><?php $rurl="/capbox_test/contact_liste.php"; urld($rurl); ?><img src="images/icones/satisfaire-vos-icone-4079-32.png" align="center"  width="32" height="32" /><br />
                                                      Contacts<?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center" width="9%"  ><?php $rurl="/capbox_test/devis_liste.php"; urld($rurl); ?><img src="images/icones/calculateur-de-modifier-icone-5292-32.png" align="center"  width="32" height="32" /><br />
                                                      Devis<?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center" width="10%" ><?php $rurl="/capbox_test/facture_liste.php"; urld($rurl); ?><img src="images/icones/pieces-de-monnaie-icone-6896-32.png" align="center"  width="32" height="32" /><br />
                                                      Factures<?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center" width="9%" ><?php $rurl="/capbox_test/acompte_liste.php"; urld($rurl); ?><img src="images/icones/police-icone-9426-32.png" align="center" width="32" height="32" /><br />
                                                      Acomptes<?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center" width="9%" ><?php $rurl="/capbox_test/avoir_liste.php"; urld($rurl); ?><img src="images/icones/police-icone-9426-32.png" align="center" width="32" height="32" /><br />
                                                      Avoirs<?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center" width="9%" ><?php $rurl="/capbox_test/bon_liste.php"; urld($rurl); ?><img src="images/icones/blanc-page-de-pile-icone-6477-32.png" align="center"  width="32" height="32" /><br />
                                                      Bons<?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center" width="10%" ><?php $rurl="/capbox_test/catalogue_liste.php"; urld($rurl); ?><img src="images/icones/livre-icone-9855-32.png" align="center"  width="32" height="32" /><br />
                                                      Catalogues<?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center" width="11%" ><?php $rurl="/capbox_test/parametres.php"; urld($rurl); ?><img src="images/icones/script-engins-icone-6029-32.png" align="center"  width="32" height="32" /><br />
                                                      Paramètres<?php echo $fin_url; ?>
                                                      </td>
                                                      <td align="center" width="11%" ><?php $rurl="/capbox_test/index.php?action=logout"; urld($rurl); ?><img src="images/icones/porte-en-icone-7778-32.png" align="center"  width="32" height="32" /><br />
                                                      Déconnexion<?php echo $fin_url; ?>
                                                      </td>
                                                    </tr>
                                                    <tr>
                                                      <td colspan="10">
	<form action="" method="get" name="formTab">
    <table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td height="32" colspan="3" background="images/fd_nav_ss_menu.png" bgcolor="#F0F0F0"></td>
      </tr>
      <tr>
      	<td>
      		<div>
      			<br/>
				<strong>Date de début</strong>:
				<input name="dateDebPeriode" type="text" id="dateDebPeriode" title="Date de début de période" value="<?php echo $dateDebPeriode; ?>" size="10" alt="date" style="margin: 0, 10px, 0, 10px;" />
				<strong>Date de fin</strong>:
				<input name="dateFinPeriode" type="text" id="dateFinPeriode" title="Date de fin de période" value="<?php echo $dateFinPeriode; ?>" size="10" alt="date" style="margin: 0, 10px, 0, 10px;" />
      			<br/>
      			<br/>
				<strong><i>Choisir votre type de montant :</i></strong>
				<input type="radio" name="typeMontant" value="<?php echo Profil::$TYPE_MONTANT_HT; ?>" <?php if ($typeMontant == Profil::$TYPE_MONTANT_HT) echo "checked"; ?> >HT
				<input type="radio" name="typeMontant" value="<?php echo Profil::$TYPE_MONTANT_TTC; ?>" <?php if ($typeMontant == Profil::$TYPE_MONTANT_TTC) echo "checked"; ?> >TTC
      			<br/>
      			<br/>
				<a href="#" onclick="document.forms['formTab'].submit();"><img src="images/icones/arrow-rotation-anti-horaire-icone-4507-32.png" width="32" height="32" /><span style="font-weight: bold">Recharger les graphiques</span></a>
      		</div>
      		<div>
      			<br/>
      			<h1><b><?php echo "Le CA de " . Facture::getCACurrentYear($societeContact->societe->id, $typeMontant) . "€ en cours est de " . Facture::calculFormule($societeContact->societe->id, $typeMontant) . "% par rapport à l'exercice précédent à période équivalente."; ?></b></h1>
      		</div>
      		<div>
			    <div id="canvas-holder-ca" class="graphique" >
		      		<h1><b><?php echo "CA par année : "; ?></b></h1>
		      		<p><?php echo "<i>Année " . getCurrentYear() . " : </i>" . Facture::getCACurrentYear($societeContact->societe->id, $typeMontant); ?></p>
		      		<p><?php echo "<i>Année " . getLastYear() . " : </i>" . Facture::getCALastYear($societeContact->societe->id, $typeMontant); ?></p>
			        <canvas id="bar-chart-ca-month" width="100%" height="100%"></canvas>
		      		<div id="js-legend" class="chart-legend"></div>
			    </div>
			    <div id="canvas-holder-devis" class="graphique" >
		      		<h1><b>&nbsp;</b></h1>
		      		<p><?php echo Devis::getNbDevisValidate($societeContact->societe->id, $dateDebPeriodeSql, $dateFinPeriodeSql) . " devis validés sur un total de " . Devis::getNbDevis($societeContact->societe->id, $dateDebPeriodeSql, $dateFinPeriodeSql); ?></p>
		      		<p><?php echo "Taux de réussite : " . Devis::getTauxReussite($societeContact->societe->id, $dateDebPeriodeSql, $dateFinPeriodeSql) . "%"; ?></p>
			        <canvas id="pie-chart-devis" width="100%" height="100%"></canvas>
	      			<br/>
	      			<br/>
	      			<br/>
	      			<br/>
	      			<br/>
	      			<br/>
			    </div>
			    <div id="canvas-holder-facture" class="graphique" >
		      		<h1><b>&nbsp;</b></h1>
		      		<p><?php echo Facture::getNbFactureValidate($societeContact->societe->id, $dateDebPeriodeSql, $dateFinPeriodeSql) . " factures encaissées sur un total de " . Facture::getNbFacture($societeContact->societe->id, $dateDebPeriodeSql, $dateFinPeriodeSql); ?></p>
		      		<p><?php echo "Taux de facture closes : " . Facture::getFactureClose($societeContact->societe->id, $dateDebPeriodeSql, $dateFinPeriodeSql) . "%"; ?></p>
			        <canvas id="pie-chart-facture" width="100%" height="100%"></canvas>
	      			<br/>
	      			<br/>
	      			<br/>
	      			<br/>
	      			<br/>
	      			<br/>
			    </div>
			    <div id="canvas-holder-client" class="graphique" >
		      		<h1><b>&nbsp;</b></h1>
		      		<p>Vos contacts</p>
		      		<p>&nbsp;</p>
			        <canvas id="pie-chart-client" width="100%" height="100%"></canvas>
			    </div>
			    <div id="canvas-holder-bon" class="graphique" >
		      		<h1><b>&nbsp;</b></h1>
		      		<p><?php echo Bon::getNbBonValidate($societeContact->societe->id, $dateDebPeriodeSql, $dateFinPeriodeSql) . " bons de commande en cours sur un total de " . Bon::getNbBon($societeContact->societe->id, $dateDebPeriodeSql, $dateFinPeriodeSql); ?></p>
		      		<p><?php echo "Taux de bons clos : " . Bon::getBonClos($societeContact->societe->id, $dateDebPeriodeSql, $dateFinPeriodeSql) . "%"; ?></p>
			        <canvas id="pie-chart-bon" width="100%" height="100%"></canvas>
			    </div>
			    <div id="canvas-holder-avoir" class="graphique" >
		      		<h1><b>&nbsp;</b></h1>
		      		<p><?php echo Avoir::getNbAvoirValidate($societeContact->societe->id, $dateDebPeriodeSql, $dateFinPeriodeSql) . " avoirs clôturés sur un total de " . Avoir::getNbAvoir($societeContact->societe->id, $dateDebPeriodeSql, $dateFinPeriodeSql); ?></p>
		      		<p><?php echo "Taux d'avoirs clos : " . Avoir::getAvoirClos($societeContact->societe->id, $dateDebPeriodeSql, $dateFinPeriodeSql) . "%"; ?></p>
			        <canvas id="pie-chart-avoir" width="100%" height="100%"></canvas>
			    </div>
		        <script type="text/javascript">
					<?php echo getCALastMonthHistoChart($societeContact, $typeMontant); ?>
	  				<?php echo getDevisCamenbertChart($societeContact, $dateDebPeriodeSql, $dateFinPeriodeSql, $typeMontant); ?>
	   				<?php echo getFactureCamenbertChart($societeContact, $dateDebPeriodeSql, $dateFinPeriodeSql, $typeMontant); ?>
	   				<?php echo getBonCamenbertChart($societeContact, $dateDebPeriodeSql, $dateFinPeriodeSql, $typeMontant); ?>
	   				<?php echo getAvoirCamenbertChart($societeContact, $dateDebPeriodeSql, $dateFinPeriodeSql, $typeMontant); ?>
	   				<?php echo getClientCamenbertChart($societeContact); ?>

	      		    // Creation des graphiques
	      		    window.onload = function() {
	   		    	    var ctxCaHisto = document.getElementById("bar-chart-ca-month").getContext("2d");
	   			        var myBarCA = Chart.Bar(ctxCaHisto, configCAMonthHisto);
	   			     	document.getElementById('js-legend').innerHTML = myBarCA.generateLegend();
	   		    	    var ctxDevis   = document.getElementById("pie-chart-devis").getContext("2d");
	   			        window.myPie = new Chart(ctxDevis, configDevis);
	   			        var ctxFacture = document.getElementById("pie-chart-facture").getContext("2d");
		  		        window.myPie = new Chart(ctxFacture, configFacture);
	   			        var ctxBon     = document.getElementById("pie-chart-bon").getContext("2d");
		  		        window.myPie = new Chart(ctxBon, configBon);
	   			        var ctxAvoir   = document.getElementById("pie-chart-avoir").getContext("2d");
		  		        window.myPie = new Chart(ctxAvoir, configAvoir);
	   			        var ctxClient  = document.getElementById("pie-chart-client").getContext("2d");
		  		        window.myPie = new Chart(ctxClient, configClient);
	      		    };
	   			</script>
		    </div>
<!-- 		    <br/>
      		<div>
	      		<h1><b><?php echo "Calcul période : "; ?></b></h1>
	      		<p><?php echo "<i>Année N   : </i>" . getCurrentYearDateMinStr() . " - " . getCurrentYearDateMaxStr(); ?></p>
	      		<p><?php echo "<i>Année N-1 : </i>" . getLastYearDateMinStr() . " - " . getLastYearDateMaxStr(); ?></p>
	      		<p><?php echo "<i>Année N Mois N     : </i>" . getCurrentYearCurrentMonthMinStr() . " - " . getCurrentYearCurrentMonthMaxStr(); ?></p>
	      		<p><?php echo "<i>Année N Mois N-1   : </i>" . getCurrentYearLastMonthMinStr() . " - " . getCurrentYearLastMonthMaxStr(); ?></p>
	      		<p><?php echo "<i>Année N Mois N-2   : </i>" . getCurrentYearLast2MonthMinStr() . " - " . getCurrentYearLast2MonthMaxStr(); ?></p>
	      		<p><?php echo "<i>Année N-1 Mois N   : </i>" . getLastYearCurrentMonthMinStr() . " - " . getLastYearCurrentMonthMaxStr(); ?></p>
	      		<p><?php echo "<i>Année N-1 Mois N-1 : </i>" . getLastYearLastMonthMinStr() . " - " . getLastYearLastMonthMaxStr(); ?></p>
	      		<p><?php echo "<i>Année N-1 Mois N-2 : </i>" . getLastYearLast2MonthMinStr() . " - " . getLastYearLast2MonthMaxStr(); ?></p>
	
	      		<h1><b><?php echo "Calcul CA : "; ?></b></h1>
	      		<p><?php echo "<i>Année N   : </i>" . Facture::getCACurrentYear($societeContact->societe->id); ?></p>
	      		<p><?php echo "<i>Année N-1 : </i>" . Facture::getCALastYear($societeContact->societe->id); ?></p>
	      		<p><?php echo "<i>Année N Mois N     : </i>" . Facture::getCACurrentYearCurrentMonth($societeContact->societe->id); ?></p>
	      		<p><?php echo "<i>Année N Mois N-1   : </i>" . Facture::getCACurrentYearLastMonth($societeContact->societe->id); ?></p>
	      		<p><?php echo "<i>Année N Mois N-2   : </i>" . Facture::getCACurrentYearLast2Month($societeContact->societe->id); ?></p>
	      		<p><?php echo "<i>Année N-1 Mois N   : </i>" . Facture::getCALastYearCurrentMonth($societeContact->societe->id); ?></p>
	      		<p><?php echo "<i>Année N-1 Mois N-1 : </i>" . Facture::getCALastYearLastMonth($societeContact->societe->id); ?></p>
	      		<p><?php echo "<i>Année N-1 Mois N-2 : </i>" . Facture::getCALastYearLast2Month($societeContact->societe->id); ?></p>
	      		<p><?php echo "<b>(CA Annee N - CA Annee N-1) = valeur / CA Annee N * 100 : </b>" . Facture::calculFormule($societeContact->societe->id) . "%"; ?></p>
	
	      		<h1><b><?php echo "Facture : "; ?></b></h1>
	      		<p><?php echo "Nombres de factures validées : " . Facture::getNbFactureValidate($societeContact->societe->id); ?></p>
	      		<p><?php echo "Nombres de factures  : " . Facture::getNbFacture($societeContact->societe->id); ?></p>
	      		<p><?php echo "Montant total des factures validées : " . Facture::getMontantTotalFactureValidee($societeContact->societe->id); ?></p>
	      		<p><?php echo "Montant total des factures : " . Facture::getMontantTotalFacture($societeContact->societe->id); ?></p>
	      		<p><?php echo "Taux de facture closes : " . Facture::getFactureClose($societeContact->societe->id); ?></p>
	
	      		<h1><b><?php echo "Devis : "; ?></b></h1>
	      		<p><?php echo "Nombres de devis validés : " . Devis::getNbDevisValidate($societeContact->societe->id); ?></p>
	      		<p><?php echo "Nombres de devis  : " . Devis::getNbDevis($societeContact->societe->id); ?></p>
	      		<p><?php echo "Montant total des devis validés : " . Devis::getMontantTotalDevisValidee($societeContact->societe->id); ?></p>
	      		<p><?php echo "Montant total des devis : " . Devis::getMontantTotalDevis($societeContact->societe->id); ?></p>
	      		<p><?php echo "Taux de réussite : " . Devis::getTauxReussite($societeContact->societe->id); ?></p>
		    </div>
 -->
<div>
</div>
      	</td>
      	<td>
      	</td>
      	<td>
      	</td>
      </tr>
    </table>
    </form>
														</td>
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
