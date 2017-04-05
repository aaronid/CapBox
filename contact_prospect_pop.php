<?php 
	require("inc.php"); 
	
	$idSocClient = $_GET['idSocClient'];
	$id = "";
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	}

	if (!empty($_POST)) {
		$societeClientP = new SocieteClientProspect();
		$societeClientP->idSocieteClient = $idSocClient;
		$societeClientP->appel = $_POST['APPEL'];
		$societeClientP->relance = $_POST['RELANCE'];
		$societeClientP->rdv = $_POST['RDV'];
		$societeClientP->commentaire = $_POST['COMMENTAIRE'];
		
		if (!empty($id)) {
			$societeClientP->id = $id;
			$societeClientP->update();
		} else {
			$societeClientP->insert();
		}
?>
<script language="javascript">
opener.location.reload(true);
window.close();
</script>
<?php 
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

    <link rel="stylesheet" href="style.css" type="text/css" />
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
                                                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="art-article">
                                                  <tbody>
                                                    <tr>
                                                      <td colspan="9">
                                                      <?php 
                	                                      $theSocCliP = new SocieteClientProspect();
                	                                      if (!empty($id)) {
            	                                          	$theSocCliP->findByLogin($id);
                	                                      }
													  ?>
                                                      
  <form action="?id=<?php echo $id; ?>&idSocClient=<?php echo $idSocClient;?>" method="post" name="frm" id="frm">
  <table width="100%">
  <tbody>
    <tr>
      <td height="32" colspan="3" background="images/fd_nav_ss_menu.png" bgcolor="#F0F0F0" class="componentheading">
      	<span style="font-weight: bold">
	      	<a href="#" onclick="document.frm.submit();">
	      		<img src="images/icones/enregistrer-page-icone-7705-32.png" width="24" height="24" align="absmiddle" />Sauvegarder 
	      	</a>
	    </span>
      </td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F9F9F9" class="componentheading">&nbsp;</td>
      <td width="50%" align="right" bgcolor="#F9F9F9">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F9F9F9" class="componentheading" style="font-weight: bold">
        <p>
          <span style="font-weight: bold">Appel : </span>
          <span class="componentheading" style="font-weight: bold">
            <input name="APPEL" value="<?php echo $theSocCliP->appel;?>" size="25" maxlength="35" type="text" />
          </span>
        </p>
      </td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F9F9F9" class="componentheading" style="font-weight: bold">
        <p>
          <span style="font-weight: bold">Rendez-vous : </span>
          <span class="componentheading" style="font-weight: bold">
            <input name="RDV" value="<?php echo $theSocCliP->rdv;?>" size="25" maxlength="35" type="text" />
          </span>
        </p>
      </td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#F9F9F9" class="componentheading" style="font-weight: bold">
        <p>
          <span style="font-weight: bold">Relance : </span>
          <span class="componentheading" style="font-weight: bold">
            <input name="RELANCE" value="<?php echo $theSocCliP->relance;?>" size="25" maxlength="35" type="text" />
          </span>
        </p>
      </td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#F9F9F9" class="componentheading" style="font-weight: bold">Commentaires</td>
      <td colspan="2" valign="top" bgcolor="#F9F9F9" class="componentheading" style="font-weight: bold">
        <textarea id="COMMENTAIRE" name="COMMENTAIRE" cols="85" rows="5" ><?php echo $theSocCliP->commentaire; ?></textarea>
      </td>
    </tr>
  </tbody>
</table>
</form>
    </td>
   </tr>
   <tr>
    <td colspan="8"><div align="right"></div></td>
   </tr>
  </tbody>
 </table>
</body>
</html>
