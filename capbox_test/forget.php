<?php

	mysql_connect("localhost","root","");
	mysql_select_db("capbox");
	// mysql_connect("mysql51-9.business", "capboxtest", "test00test");
	// mysql_select_db("capboxtest");
	// mysql_connect("mysql5-23.bdb", "capbox001", "3Ty3FG0O");
	// mysql_select_db("capbox001");

	if (!empty($_POST['hid'])) {
		$socCont = new SocieteContact();
		$socCont->findByEmail($_POST['mail']);
		
		if (empty($socCont->id)) {
			$incorrect="Cette adresse e-mail n'est pas connue. Veuillez la vérifier, merci. ";
		} else {
			$caracteres = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",0,1,2,3,4,5,6,7,8,9);
			$passeNew = "";
			for($j=0; $j<=6; $j++)
			{
				$random = array_rand($caracteres);
				$passeNew .= $caracteres[$random];
			}

			$utili = $socCont->getUtilisateur();
			$utili->password = $passeNew;
			$utili->update();
			
			$incorrect="Le mail est envoyé. ";
			$message="Bonjour $socCont->prenom $socCont->nom,\n

Veuillez trouvez ci-après vos nouveaux identifiants.\n
Login : $utili->login\r
Mot de passe : $passeNew\n
Conservez les précieusement.\n
Pour débuter l'utilisation de l'application CAP BOX, rendez-vous dans la rubrique « Besoin d'aide ? », une démonstration pas à pas y est disponible.\n
Christophe LEPRETRE\r
CAP ACHAT\n
Tel : 06 88 86 13 22\r
E-mail : cap.achat@orange.fr\r
Site : www.cap-achat.com";
mail($socCont->email, 'Rappel de vos identifiants', utf8_decode($message)); 
		}
	}
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
                <? require("topmenu0.php"); ?>
                                    
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
                                                Vous avez oublié votre mot de passe ?</h2>
                                            <div class="art-postcontent">
                                                <!-- article-content -->
                                               
                                                
                                                
                                                  <!--startprint--><table width="100%" border="0" cellpadding="0" cellspacing="0" class="art-article">
                                                  <tbody>                                                   
                                                    <tr>
                                                      <td colspan="8">
                                                      <div align="center">
														<form method="post" action="">
														  <table width="420" border="0" cellspacing="0" cellpadding="1">
														    <tr> 
														      <td colspan="2">
														        
														          <div align="left">Renseignez l'adresse e-mail sur laquelle a été généré le compte CAP BOX. Puis consultez votre boîte e-mail, un nouveau mot de passe va vous être envoyé.</div></td>
														    </tr>
														    
														    <tr> 
														      <td width="90"><strong>Votre e-mail</strong></td>
														      <td width="206">
														        <input type="text" name="mail"/>
														          <input type="hidden" name="hid" value="1"/></td>
														    </tr>
														    <tr> 
														      <td colspan="2"> 
														        <div align="center">
														          <input type="submit" name="Submit" value="Envoyer"/>
														        </div>
														        <? echo $incorrect; ?><a href="index.php"> retour à l'accueil</a> </td>
														    </tr>
														    <tr>
														      <td colspan="2">Plus d'informations, vous pouvez contacter CAP ACHAT.</td>
														    </tr>    
														  </table>
														
														</form> </div>
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
