<?php
switch ($sub_system)
	{
######################################################################################################################
	case 'show_img':
		{
		$id=$_GET['id_dlc'];
		$dlc=db_single_read("select * from customer_dlc where id = $id");
		echo "<a href='index.php?system=dlc/dlc.iframe&sub_system=select_img&id=$id&no_interface'><img src='img/dlc/$dlc->img' width=100% height=100%></img></a>";
		};break;
######################################################################################################################
	case 'select_img':
		{
		$id=$_GET['id'];
		$iterator = new DirectoryIterator("img/dlc/");
		foreach($iterator as $document)
			{
			if(($document->getFilename()!='.')and($document->getFilename()!='..'))
				{
				echo "<a href='index.php?system=dlc/dlc.iframe&sub_system=update_img&id=$id&img=".$document->getFilename()."&no_interface'><img src='img/dlc/".$document->getFilename()."'width=170px></img></a>";
				}
			}
		};break;
######################################################################################################################
	case 'update_img':
		{
		$id=$_GET['id'];
		$img=$_GET['img'];
		db_write ("update customer_dlc set img='$img' where id = $id");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=dlc/dlc.iframe&sub_system=show_img&id_dlc=$id&no_interface'/>";
		};break;
	}
?>