<?php
	require("business/societeContact.php");
	
	session_start();
	// mysql_connect("localhost","root","");
	// mysql_select_db("capbox");
	mysql_connect("mysql51-9.business", "capboxtest", "test00test");
	mysql_select_db("capboxtest");
	// mysql_connect("mysql5-23.bdb", "capbox001", "3Ty3FG0O");
	// mysql_select_db("capbox001");
		
	$hid="";
	if (isset($_POST['hid'])) {
		$hid = $_POST['hid'];
	}
	$login="";
	if (isset($_POST['login'])) {
		$login = $_POST['login'];
	}
	$passe="";
	if (isset($_POST['passe'])) {
		$passe = $_POST['passe'];
	}

	if(isset($_GET['action']) && $_GET['action']=="logout"){
		// Destruction de la session : manière simple
		//session_destroy();

		// Destruction de session : ma  manière (utilisez l'une ou l'autre)
		$_SESSION['societeContact'] = null;
		$_SESSION = array(); // on réécrit le tableau
	}

	$incorrect="";
	$isAdmin=false;
	$societeContact = new SocieteContact();

	if (!empty($hid)) {
		$utilisateur = new Utilisateur();
		$utilisateur->findByLogin($login, $passe);
		
//		$interlocQuery=mysql_query("select * from interlocuteur where LOGIN='$login' AND PASSWORD='$passe'");
//		$interlocResult=mysql_fetch_array($interlocQuery);
		if (empty($utilisateur->login)) {
			$incorrect = "Le login ou le mot de passe est incorrect";
			$_SESSION['societeContact'] = null;
		} else {
			$incorrect = "Le login : " . $utilisateur->login;
			$societeContact->findByLogin($utilisateur->login);
			$_SESSION['societeContact'] = $societeContact;
			
			if ($utilisateur->codeRole == Role::$CODE_ADMIN) {
				$incorrect = "Role administrateur";
				$isAdmin=true;
			} else if ($utilisateur->codeRole == Role::$CODE_ENTREPRENEUR) {
				$incorrect = "Role entrepreneur";
			} else {
				$incorrect="Role non conforme";
			}
		}
	} else {
		$_SESSION['societeContact'] = null;
	}

	if ($_SESSION['societeContact'] != null) {
		if ($isAdmin) {
			header("Location: admin_tableau.php");
		} else {
			if (empty($societeContact->societe->consult)) {
				header("Location: tableau.php");
			} else {
				header("Location: catalogue_liste2.php");
			}
		}
	} else {
//		$incorrect = $incorrect . " - client vide";
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
                	<div align="center"><br />Pour en savoir plus, <a href="http://www.cap-achat.com">cliquez-ici</a>.</div>
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
                                                Accédez à votre espace privé</h2>
                                            <div class="art-postcontent">
                                                <!-- article-content -->



                                                  <!--startprint--><table width="100%" border="0" cellpadding="0" cellspacing="0" class="art-article">
                                                  <tbody>
                                                    <tr>
                                                      <td colspan="8">
                                                      <div align="center">
							<form method="post" action="">
							  <table width="300" border="0" cellspacing="0" cellpadding="1">
							    <tr>
							      <td colspan="2">
							        <div align="center"><h2>Identification</h2></div>      </td>
							    </tr>
							    <tr>
							      <td>Login</td>
							      <td>
							        <input type="text" name="login"/>      </td>
							    </tr>
							    <tr>
							      <td>Mot de passe</td>
							      <td>
							        <input type="password" name="passe"/>
							          <input type="hidden" name="hid" value="1"/>        </td>
							    </tr>
							    <tr>
							      <td colspan="2">
							        <div align="center">
							          <input type="submit" name="Submit" value="Envoyer"/>
							        </div><?php echo $incorrect; ?>      </td>
							    </tr>
							    <tr>
							      <td colspan="2"><div align="left"><a href="forget.php">Mot de passe oublié ?</a></div></td>
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
