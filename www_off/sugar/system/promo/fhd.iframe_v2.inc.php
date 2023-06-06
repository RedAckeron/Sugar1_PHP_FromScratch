<?php
$id_item=$_GET['id_item'];

switch ($sub_system)
	{
######################################################################################################################
    case 'edit_item':
		{
		$item=db_single_read("select * from promo_item where id=$id_item;");
		$box->empty_in('80','0','180','120','red','',"",'',100,"","",'');
			echo "Type : ".$item->type;
			echo "<br>Pos x : ".$item->pos_x;
			echo "<br>Pos y : ".$item->pos_y;
			echo "<br>Width : ".$item->width;
			echo "<br>Height : ".$item->height;
			echo "<br>Actif : ".$item->activated;
		$box->empty_out('.');
		switch ($item->type)
				{
			######################################################################################################################
				case 'img':
					{
					$box->empty_in('0','0','80','80','','',"",'',100,"","",'');
					echo "<a href='index.php?system=promo/fhd.iframe_v2&sub_system=edit_fhd_gfx&id_odp=$item->id_odp&id_item=$item->id&no_interface' target=_parent><img src='img/promo/item/$item->valeur' width=80px height=80px></img></a>";
					$box->empty_out('.');
					
					/*
					$box->angle_in('','','150','150','','steelblue',"",'',100,"IMG 0","",'');
						$form->open("index.php?system=promo/fhd.iframe&sub_system=update_loc_xy&format=fhd&id_prm=$id_prm&no_interface","POST");
						$form->hidden('lblx',"img0_fhd_x");
						$form->hidden('lbly',"img0_fhd_y");
						echo "300X300px<br><br>";
						echo"X : ";
						$form->select_in('x',1);
						for($i=1;$i<=1620;$i++)$form->select_option($i,$i,$id_promo->img0_fhd_x);
						$form->select_out();
						echo"<br>Y : ";
						$form->select_in('y',1);
						for($i=1;$i<=780;$i++)$form->select_option($i,$i,$id_promo->img0_fhd_y);
						$form->select_out();
						echo "<br>";
						$form->send("Update");
						$form->close();
					$box->angle_out('');	
					*/
					};break;
				}
			
		//$box->angle_out('');
		
			/*
		//$id_prm=$_GET['id_prm'];
		$id_promo=db_single_read("select * from promo where id_odp=$id_prm");
		//$cmd->load($id_prm);

			//IMG0
			$box->empty_in('20','20','500','150','','steelblue',"",'',100,"","",'');
				
			$box->empty_out('');
		
			$box->angle_in('660','20','320','180','','steelblue',"",'',100,"","index.php?system=promo/fhd.iframe&sub_system=edit_fhd_gfx&id_prm=$id_prm&img=bground&no_interface",'');
			echo "<img src='img/promo/bground_fhd/$id_promo->bground_fhd' width=100% height=100%></img>";
			$box->angle_out('.');
		*/
		};break;
######################################################################################################################
	case 'update_loc_xy':
		{
		$x=$_POST['x'];
		$y=$_POST['y'];
		$labelx=$_POST['lblx'];
		$labely=$_POST['lbly'];
		db_write("update promo set $labelx='$x',$labely='$y' where id_odp = $id_prm;");
		echo"<meta http-equiv='refresh' content='0; url=index.php?system=promo/fhd.iframe&sub_system=edit_fhd_img&id_prm=$id_prm&no_interface'/>";
		};break;

######################################################################################################################
	case 'edit_fhd_gfx':
		{
		$iterator = new DirectoryIterator("img/promo/item/");
		foreach($iterator as $document)
			{
			if(($document->getFilename()!='.')and($document->getFilename()!='..'))
				{
				$box->angle_in('','','150','150','','red',"",'',100,"","index.php?system=promo/fhd.iframe_v2&sub_system=update_fhd_gfx&id_odp=".$_GET['id_odp']."&id_item=$id_item&image=".$document->getFilename()."&no_interface",'');
				echo "<img src='img/promo/item/".$document->getFilename()."' width=100%>";
				$box->angle_out(".");
				}
			}
			
		};break;
######################################################################################################################
	case 'update_fhd_gfx':
		{
		$image=$_GET['image'];
		db_write("update promo_item set valeur ='$image' where id=$id_item;");
		echo"<meta http-equiv='refresh' content='0; url=index.php?system=promo/promo.groupe&sub_system=edit_fhd&tab=edit_fhd&id_prm=".$_GET['id_odp']."'/>";	
		};break;
######################################################################################################################
	}
?>