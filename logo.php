<?
require("inc.php");
///////////////////
if( isset($_POST['upload']) ) // si formulaire soumis
{
    $content_dir = 'images/logos/'; // dossier où sera déplacé le fichier
    $tmp_file = $_FILES['fichier']['tmp_name'];
    if( !is_uploaded_file($tmp_file) )
    {
        exit("Le fichier est introuvable");
    }
    // on vérifie maintenant l'extension
    $type_file = $_FILES['fichier']['type'];
    if( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'gif')&& !strstr($type_file, 'png') )
    {
        exit("Le fichier n'est pas une image");
    }
	//dimensions image
	$img_size = getimagesize($tmp_file);
	$W_Src = $img_size[0]; // largeur
	$H_Src = $img_size[1]; // hauteur
	$W_max=280;
	$H_max=60;      
	$ratiox = $W_Src / $W_max; // ratio en largeur
	$ratioy = $H_Src / $H_max; // ratio en hauteur
	$ratio = max($ratiox,$ratioy); // le plus grand
	$W = $W_Src/$ratio;
	$H = $H_Src/$ratio;   
	$condition = ($W_Src>$W) || ($H_Src>$H); // 1 si vrai (true)
      	  
	if (strstr($type_file, 'png')) {
		$tmp_fil = substr($_FILES['fichier']['name'], 0, -3);
		$name_file = $content_dir . $societeContact->societe->id . "_" . $tmp_fil . "jpg";
		$nam_file = $societeContact->societe->id . "_" . $tmp_fil . "jpg";
		$image = imagecreatefrompng($tmp_file);
		if ($condition == 1) {
			$Ress_Ds = imagecreatetruecolor($W, $H); 
			$Ress_Dst = imagecolorallocate($Ress_Ds, 255, 255, 255); 
			imagecopyresampled($Ress_Dst, $image, 0, 0, 0, 0, $W, $H, $W_Src, $H_Src);
			imagejpeg($Ress_Dst, $name_file, 100);
		} else {
			imagejpeg($image, $name_file, 100);
		} 	
		echo "<img src=\"$name_file\">";	
		imagedestroy($image);
	
	} else if(strstr($type_file, 'gif')) {
		$tmp_fil = substr($_FILES['fichier']['name'], 0, -3);
		$name_file = $content_dir . $societeContact->societe->id . "_" . $tmp_fil . ".jpg";
		$nam_file = $societeContact->societe->id . "_" . $tmp_fil . "jpg";
		$image = imagecreatefromgif($tmp_file);
		if ($condition==1) {
			$Ress_Dst = imagecreatetruecolor($W,$H); 
			imagecopyresampled($Ress_Dst, $image, 0, 0, 0, 0, $W, $H, $W_Src, $H_Src);
			imagejpeg($Ress_Dst, $name_file, 100);
		} else {
			imagejpeg($image, $name_file, 100);
		} 	
		echo "<img src=\"$name_file\">";	
		imagedestroy($image);
	
	} else {
		$name_file = $content_dir . $societeContact->societe->id . "_" . $_FILES['fichier']['name'];
		$image = imagecreatefromjpeg($tmp_file);
		if ($condition == 1) {	
			$Ress_Dst = imagecreatetruecolor($W,$H); 
			imagecopyresampled($Ress_Dst, $image, 0, 0, 0, 0, $W, $H, $W_Src, $H_Src);
			imagejpeg($Ress_Dst, $name_file, 100);
		} else {	       
			imagejpeg($image, $name_file, 100);
		}
		$nam_file = $societeContact->societe->id . "_" . $_FILES['fichier']['name'];
		echo "<img src=\"$name_file\">";
	}

    echo "En cours de transfert, veuillez patienter";
	?>
    <script language="javascript">
	    opener.document.getElementById('LOGO').value='<? echo $nam_file; ?>';
	    opener.document.getElementById('logo1').innerHTML='<img src=\"<? echo $name_file; ?>\" />';
	    window.close();
	</script>
    <?
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Document sans nom</title>
	</head>
	<body>
		<h2>Transfert de votre logo</h2>
		<form method="post" enctype="multipart/form-data" action="">
			<p>
				<input type="file" name="fichier" size="30"/>
				<input type="submit" name="upload" value="T�l�charger"/>
			</p>
		</form>
	</body>
</html>
