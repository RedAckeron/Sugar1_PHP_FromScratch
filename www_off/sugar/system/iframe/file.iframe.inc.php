<?php
switch ($sub_system)
	{
######################################################################################################################
	case 'select_file':
		{
		$box->empty_in('0','0','320','25','','','','',100,"",'',"");

		$size_file=($_GET['size_file']);
		$dir=$_GET['dir'];
		echo "<form enctype='multipart/form-data' action='index.php?system=iframe/file.iframe&sub_system=upload_file&dir=$dir&no_interface' method='post'>
				<input type='hidden' name='MAX_FILE_SIZE' value='$size_file' />
				<input name='userfile' type='file' />
				 <input type='submit' value='Upload' />
			</form>";
		};break;
######################################################################################################################
	case 'upload_file':
		{
		//$name=$_GET['name'];
		$msg="";
		//$size_file=$_POST['MAX_FILE_SIZE'];
		$size_file=$_POST['size_file'];
		
		$dir=$_GET['dir'];

		$uploaddir = "$dir";
		$url_out="index.php?system=iframe/file.iframe&sub_system=select_file&size_file=$size_file&dir=$dir&no_interface";
		//$uploaddir = 'img/dlc/';
		
		$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
		
		if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
			{
			$msg="Le fichier est valide, et a ete uploader.";
			}
		else 
			{
			//traitement des code d erreur
			switch ($_FILES['userfile']['error'])
				{
				case '1':$msg="Le fichier est trop gros : taille maximum : ".($size_file/1000000)."Mo.";break;
				case '2':$msg="Le fichier est trop gros : taille maximum : ".($size_file/1000000)."Mo.";break;
				case '3':$msg="Le fichier n a ete que partiellement telecharge.";break;
				case '4':$msg="Le fichier n a pas ete choisis.";break;
				case '6':$msg="Dossier temporaire manquant.";break;
				case '7':$msg="Echec d ecriture du fichier sur le disque dur.";break;
				case '8':$msg="Extention PHP a arreter l envoi du fichier.";break;
				}
			}
		$js->alert_redirect($msg,"$url_out",0);
		};break;
	}
?>