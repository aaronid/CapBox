<?php require("inc.php"); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
                <?php require("topmenu.php"); ?>
                                    
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
                                                Administration - Consultation de votre tableau de bord</h2>
                                            <div class="art-postcontent">
                                                <!-- article-content -->
                                               
                                                
                                                
                                                  <!--startprint--><table width="100%" border="0" cellpadding="0" cellspacing="0" class="art-article">
                                                  <tbody>
                                                    <?php require("admin_turl.php"); ?>
                                                    <tr>
                                                      <td colspan="8"><table width="100%" cellpadding="0" cellspacing="0">
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
          <p><strong><img src="images/icones/satisfaire-vos-icone-4079-32.png" alt="" width="32" height="32" />Les 5 derniers comptes client activés</strong></p>
        </div></td>
        <td valign="top" bgcolor="#F9F9F9"><div align="center">
          <p><strong><img src="images/icones/livre-icone-9855-32.png" width="32" height="32" /> Vos 5 derniers catalogues mis à jour</strong></p>
        </div></td>
        <td valign="top" bgcolor="#F9F9F9">&nbsp;</td>
      </tr>
      <tr>
        <td height="2" valign="top" bgcolor="#4B85B8"></td>
        <td height="2" valign="top" bgcolor="#4B85B8"></td>
        <td height="2" valign="top" bgcolor="#4B85B8"></td>
      </tr>
      <tr>
        <td width="33%" valign="top" bgcolor="#F9F9F9">
            <ul>
			<?php $select=mysql_query("select _ID from societe WHERE INACTIF = '' ORDER BY DATE_CREATION DESC LIMIT 0,5");
			while($result=mysql_fetch_array($select)){
				$socContact = new SocieteContact();
				$socContact->findResponsableSociete($result['_ID']);

				echo"<li><a href=\"admin_client.php?id=" . $socContact->idSociete . "\">" . $socContact->prenom . " " . mb_strtoupper($socContact->nom, 'UTF-8') . " - " . $socContact->societe->nom . "</a></li>";
			}
			?></ul>
        </td>
        <td width="33%" valign="top" bgcolor="#F9F9F9">
            <ul>
            <?php $select=mysql_query("select * from catalogues ORDER BY DATE2 DESC LIMIT 0,5");
			while($result=mysql_fetch_array($select)){
				echo"<li><a href=\"admin_catalogues.php?id=".$result['_ID']."\">".$result['NOM']."</a></li>";
			}
			?></ul>
		</td>
        <td width="33%" valign="top" bgcolor="#F9F9F9">&nbsp;</td>
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
