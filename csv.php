<?php 
	require("inc.php");
	if( isset($_POST['upload']) ) // si formulaire soumis
	{
	    $content_dir = 'temporaire/'; // dossier où sera déplacé le fichier
	    $tmp_file = $_FILES['fichier']['tmp_name'];
	    if( !is_uploaded_file($tmp_file) )
	    {
	        exit("Le fichier est introuvable");
	    }
	    // on vérifie maintenant l'extension
	    //$type_file = $_FILES['fichier']['type'];
	    //if( !strstr($type_file, 'csv') )
	    //{
	      //  exit("Le fichier n'est pas csv");
	    //}else{
		
	    // on copie le fichier dans le dossier de destination
	    $name_file = $_FILES['fichier']['name'];
	    if( !move_uploaded_file($tmp_file, $content_dir .$name_file) )
	    {
	        exit("Impossible de copier le fichier dans $content_dir");
	    }
			//}
	
	    echo "En cours de transfert, veuillez patienter";
		
		?>
	    <script language="javascript">
		    opener.document.getElementById('FICHIER').value='<?php echo $name_file; ?>';
		    opener.document.getElementById('FICHIER1').innerHTML='<?php echo $name_file; ?>';
		    window.close();
		</script>
	    <?php 
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Document sans nom</title>
</head>
<body>
	Transfert de votre catalogue
	<form method="post" enctype="multipart/form-data" action="">
		<p>
		<input type="file" name="fichier" size="30"/>
		<input type="submit" name="upload" value="Uploader"/>
		</p>
	</form>
</body>
</html>
