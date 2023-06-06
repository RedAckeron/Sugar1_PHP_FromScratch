<?php
$id_prm=$_GET['id_prm'];
switch ($sub_system)
	{
######################################################################################################################
    case 'edit_fhd_img':
		{
		//$id_prm=$_GET['id_prm'];
		$id_promo=db_single_read("select * from promo where id_odp=$id_prm");
		//$cmd->load($id_prm);

			//IMG0
			$box->empty_in('20','20','500','150','','steelblue',"",'',100,"","",'');
				$box->angle_in('','','150','150','','steelblue',"",'',100,"","index.php?system=promo/fhd.iframe&sub_system=edit_fhd_gfx&id_prm=$id_prm&img=img0&no_interface",'');
				echo "<img src='img/promo/img0/$id_promo->img0_fhd' width=100% height=100%></img>";
				$box->angle_out('.');
				
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
			$box->empty_out('');
			//IMG1
			$box->empty_in('340','20','500','150','','steelblue',"",'',100,"","",'');
				$box->angle_in('','','150','150','','steelblue',"",'',100,"","index.php?system=promo/fhd.iframe&sub_system=edit_fhd_gfx&id_prm=$id_prm&img=img1&no_interface",'');
				echo "<img src='img/promo/img1/$id_promo->img1_fhd' width=100% height=100%></img>";
				$box->angle_out('.');
				
				$box->angle_in('','','150','150','','steelblue',"",'',100,"IMG 1","",'');
					$form->open("index.php?system=promo/fhd.iframe&sub_system=update_loc_xy&format=fhd&id_prm=$id_prm&no_interface","POST");
					$form->hidden('lblx',"img1_fhd_x");
					$form->hidden('lbly',"img1_fhd_y");
					echo "150X150px<br><br>";
					echo"X : ";
					$form->select_in('x',1);
					for($i=1;$i<=1770;$i++)$form->select_option($i,$i,$id_promo->img1_fhd_x);
					$form->select_out();
					echo"<br>Y : ";
					$form->select_in('y',1);
					for($i=1;$i<=930;$i++)$form->select_option($i,$i,$id_promo->img1_fhd_y);
					$form->select_out();
					echo "<br>";
					$form->send("Update");
					$form->close();
				$box->angle_out('');
			$box->empty_out('');
			//IMG2
			$box->empty_in('20','190','500','150','','steelblue',"",'',100,"","",'');
				$box->angle_in('','','150','150','','steelblue',"",'',100,"","index.php?system=promo/fhd.iframe&sub_system=edit_fhd_gfx&id_prm=$id_prm&img=img2&no_interface",'');
				echo "<img src='img/promo/img2/$id_promo->img2_fhd' width=100% height=100%></img>";
				$box->angle_out('.');
				$box->angle_in('','','150','150','','steelblue',"",'',100,"IMG 2","",'');
					$form->open("index.php?system=promo/fhd.iframe&sub_system=update_loc_xy&format=fhd&id_prm=$id_prm&no_interface","POST");
					$form->hidden('lblx',"img2_fhd_x");
					$form->hidden('lbly',"img2_fhd_y");
					echo "150X150px<br><br>";
					echo"X : ";
					$form->select_in('x',1);
					for($i=1;$i<=1770;$i++)$form->select_option($i,$i,$id_promo->img2_fhd_x);
					$form->select_out();
					echo"<br>Y : ";
					$form->select_in('y',1);
					for($i=1;$i<=930;$i++)$form->select_option($i,$i,$id_promo->img2_fhd_y);
					$form->select_out();
					echo "<br>";
					$form->send("Update");
					$form->close();
				$box->angle_out('');
			$box->empty_out('');
			//IMG3
			$box->empty_in('340','190','500','150','','steelblue',"",'',100,"","",'');
				$box->angle_in('','','150','150','','steelblue',"",'',100,"","index.php?system=promo/fhd.iframe&sub_system=edit_fhd_gfx&id_prm=$id_prm&img=img3&no_interface",'');
				echo "<img src='img/promo/img3/$id_promo->img3_fhd' width=100% height=100%></img>";
				$box->angle_out('.');
				$box->angle_in('','','150','150','','steelblue',"",'',100,"IMG 3","",'');
					$form->open("index.php?system=promo/fhd.iframe&sub_system=update_loc_xy&format=fhd&id_prm=$id_prm&no_interface","POST");
					$form->hidden('lblx',"img3_fhd_x");
					$form->hidden('lbly',"img3_fhd_y");
					echo "150X150px<br><br>";
					echo"X : ";
					$form->select_in('x',1);
					for($i=1;$i<=1770;$i++)$form->select_option($i,$i,$id_promo->img3_fhd_x);
					$form->select_out();
					echo"<br>Y : ";
					$form->select_in('y',1);
					for($i=1;$i<=930;$i++)$form->select_option($i,$i,$id_promo->img3_fhd_y);
					$form->select_out();
					echo "<br>";
					$form->send("Update");
					$form->close();
				$box->angle_out('');
			$box->empty_out('');
			//IMG4
			$box->empty_in('20','360','500','150','','steelblue',"",'',100,"","",'');
				$box->angle_in('','','150','150','','steelblue',"",'',100,"","index.php?system=promo/fhd.iframe&sub_system=edit_fhd_gfx&id_prm=$id_prm&img=img4&no_interface",'');
				echo "<img src='img/promo/img4/$id_promo->img4_fhd' width=100% height=100%></img>";
				$box->angle_out('.');
				$box->angle_in('','','150','150','','steelblue',"",'',100,"IMG 4","",'');
					$form->open("index.php?system=promo/fhd.iframe&sub_system=update_loc_xy&format=fhd&id_prm=$id_prm&no_interface","POST");
					$form->hidden('lblx',"img4_fhd_x");
					$form->hidden('lbly',"img4_fhd_y");
					echo "150X150px<br><br>";
					echo"X : ";
					$form->select_in('x',1);
					for($i=1;$i<=1770;$i++)$form->select_option($i,$i,$id_promo->img4_fhd_x);
					$form->select_out();
					echo"<br>Y : ";
					$form->select_in('y',1);
					for($i=1;$i<=930;$i++)$form->select_option($i,$i,$id_promo->img4_fhd_y);
					$form->select_out();
					echo "<br>";
					$form->send("Update");
					$form->close();
				$box->angle_out('');
			$box->empty_out('');
			//IMG5
			$box->empty_in('340','360','500','150','','steelblue',"",'',100,"","",'');
				$box->angle_in('','','150','150','','steelblue',"",'',100,"","index.php?system=promo/fhd.iframe&sub_system=edit_fhd_gfx&id_prm=$id_prm&img=img5&no_interface",'');
				echo "<img src='img/promo/img5/$id_promo->img5_fhd' width=100% height=100%></img>";
				$box->angle_out('.');
				$box->angle_in('','','150','150','','steelblue',"",'',100,"IMG 5","",'');
					$form->open("index.php?system=promo/fhd.iframe&sub_system=update_loc_xy&format=fhd&id_prm=$id_prm&no_interface","POST");
					$form->hidden('lblx',"img5_fhd_x");
					$form->hidden('lbly',"img5_fhd_y");
					echo "150X150px<br><br>";
					echo"X : ";
					$form->select_in('x',1);
					for($i=1;$i<=1770;$i++)$form->select_option($i,$i,$id_promo->img5_fhd_x);
					$form->select_out();
					echo"<br>Y : ";
					$form->select_in('y',1);
					for($i=1;$i<=930;$i++)$form->select_option($i,$i,$id_promo->img5_fhd_y);
					$form->select_out();
					echo "<br>";
					$form->send("Update");
					$form->close();
				$box->angle_out('');
			$box->empty_out('');
			//IMG6
			$box->empty_in('20','530','500','150','','steelblue',"",'',100,"","",'');
				$box->angle_in('','','150','150','','steelblue',"",'',100,"","index.php?system=promo/fhd.iframe&sub_system=edit_fhd_gfx&id_prm=$id_prm&img=img6&no_interface",'');
				echo "<img src='img/promo/img6/$id_promo->img6_fhd' width=100% height=100%></img>";
				$box->angle_out('.');
				$box->angle_in('','','150','150','','steelblue',"",'',100,"IMG 6","",'');
					$form->open("index.php?system=promo/fhd.iframe&sub_system=update_loc_xy&format=fhd&id_prm=$id_prm&no_interface","POST");
					$form->hidden('lblx',"img6_fhd_x");
					$form->hidden('lbly',"img6_fhd_y");
					echo "150X150px<br><br>";
					echo"X : ";
					$form->select_in('x',1);
					for($i=1;$i<=1620;$i++)$form->select_option($i,$i,$id_promo->img6_fhd_x);
					$form->select_out();
					echo"<br>Y : ";
					$form->select_in('y',1);
					for($i=1;$i<=780;$i++)$form->select_option($i,$i,$id_promo->img6_fhd_y);
					$form->select_out();
					echo "<br>";
					$form->send("Update");
					$form->close();
				$box->angle_out('');
			$box->empty_out('');
			//TITRE 800 60
			$box->angle_in('660','220','300','80','lightblue','steelblue',"",'',100,"Titre (800 X 60px)","",'');
				$form->open("index.php?system=promo/fhd.iframe&sub_system=update_loc_xy&format=fhd&id_prm=$id_prm&no_interface","POST");
					$form->hidden('lblx',"titre_fhd_x");
					$form->hidden('lbly',"titre_fhd_y");
					echo"X : ";
					$form->select_in('x',1);
					for($i=1;$i<=1118;$i++)$form->select_option($i,$i,$id_promo->titre_fhd_x);
					$form->select_out();
					echo"Y : ";
					$form->select_in('y',1);
					for($i=1;$i<=1018;$i++)$form->select_option($i,$i,$id_promo->titre_fhd_y);
					$form->select_out();
					echo "<br>";
					$form->send("Update");
				$form->close();
			$box->angle_out('.');
			//FICHE TECHNIQUE 600 400
			$box->angle_in('1100','20','300','120','lightblue','steelblue',"",'',100,"Fiche technique (600 X 400px)","",'');
				$form->open("index.php?system=promo/fhd.iframe&sub_system=update_loc_xy&format=fhd&id_prm=$id_prm&no_interface","POST");
					$form->hidden('lblx',"fiche_fhd_x");
					$form->hidden('lbly',"fiche_fhd_y");
					echo"X : ";
					$form->select_in('x',1);
					for($i=1;$i<=1318;$i++)$form->select_option($i,$i,$id_promo->fiche_fhd_x);
					$form->select_out();
					echo"Y : ";
					$form->select_in('y',1);
					for($i=1;$i<=678;$i++)$form->select_option($i,$i,$id_promo->fiche_fhd_y);
					$form->select_out();
					echo "<br>";
					$form->send("Update");
				$form->close();
			$box->angle_out('.');
			//PRIX
			$box->angle_in('1100','180','300','120','lightblue','steelblue',"",'',100,"Prix (150 X 150px)","",'');
				$form->open("index.php?system=promo/fhd.iframe&sub_system=update_loc_xy&format=fhd&id_prm=$id_prm&no_interface","POST");
					$form->hidden('lblx',"prix_fhd_x");
					$form->hidden('lbly',"prix_fhd_y");
					echo"X : ";
					$form->select_in('x',1);//200 120
					for($i=1;$i<=1720;$i++)$form->select_option($i,$i,$id_promo->prix_fhd_x);
					$form->select_out();
					echo"Y : ";
					$form->select_in('y',1);
					for($i=1;$i<=960;$i++)$form->select_option($i,$i,$id_promo->prix_fhd_y);
					$form->select_out();
					echo "<br>";
					$form->send("Update");
				$form->close();
			$box->angle_out('.');


			$box->angle_in('660','20','320','180','','steelblue',"",'',100,"","index.php?system=promo/fhd.iframe&sub_system=edit_fhd_gfx&id_prm=$id_prm&img=bground&no_interface",'');
			echo "<img src='img/promo/bground_fhd/$id_promo->bground_fhd' width=100% height=100%></img>";
			$box->angle_out('.');
		
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
	case 'preview_fhd':
		{
		$id_prm=$_GET['id_prm'];
		$id_promo=db_single_read("select * from promo where id_odp=$id_prm");
		
		$box->angle_in('0','0',(1920*0.4),(1080*0.4),'','black',"",'',100,"","",'');
		echo "<img src='img/promo/bground_fhd/$id_promo->bground_fhd' width=100% height=100%></img>";
		$box->angle_out(".");
		
		if($id_promo->img0_fhd!='no_img.gif')
			{
			$box->angle_in(($id_promo->img0_fhd_x*0.4),($id_promo->img0_fhd_y*0.4),(300*0.4),(300*0.4),'','black',"",'',100,"","",'');
			echo "<img src='img/promo/img0/$id_promo->img0_fhd' width=100% height=100%></img>";
			$box->angle_out(".");
			}

		if($id_promo->img1_fhd!='no_img.gif')
			{
			$box->angle_in(($id_promo->img1_fhd_x*0.4),($id_promo->img1_fhd_y*0.4),(150*0.4),(150*0.4),'','black',"",'',100,"","",'');
			echo "<img src='img/promo/img1/$id_promo->img1_fhd' width=100% height=100%></img>";
			$box->angle_out(".");
			}

		if($id_promo->img2_fhd!='no_img.gif')
			{
			$box->angle_in(($id_promo->img2_fhd_x*0.4),($id_promo->img2_fhd_y*0.4),(150*0.4),(150*0.4),'','black',"",'',100,"","",'');
			echo "<img src='img/promo/img2/$id_promo->img2_fhd' width=100% height=100%></img>";
			$box->angle_out(".");
			}

		if($id_promo->img3_fhd!='no_img.gif')
			{
			$box->angle_in(($id_promo->img3_fhd_x*0.4),($id_promo->img3_fhd_y*0.4),(150*0.4),(150*0.4),'','black',"",'',100,"","",'');
			echo "<img src='img/promo/img3/$id_promo->img3_fhd' width=100% height=100%></img>";
			$box->angle_out(".");
			}

		if($id_promo->img4_fhd!='no_img.gif')
			{
			$box->angle_in(($id_promo->img4_fhd_x*0.4),($id_promo->img4_fhd_y*0.4),(150*0.4),(150*0.4),'','black',"",'',100,"","",'');
			echo "<img src='img/promo/img4/$id_promo->img4_fhd' width=100% height=100%></img>";
			$box->angle_out(".");
			}

		if($id_promo->img5_fhd!='no_img.gif')
			{
			$box->angle_in(($id_promo->img5_fhd_x*0.4),($id_promo->img5_fhd_y*0.4),(150*0.4),(150*0.4),'','black',"",'',100,"","",'');
			echo "<img src='img/promo/img5/$id_promo->img5_fhd' width=100% height=100%></img>";
			$box->angle_out(".");
			}

		if($id_promo->img6_fhd!='no_img.gif')
			{
			$box->angle_in(($id_promo->img6_fhd_x*0.4),($id_promo->img6_fhd_y*0.4),(300*0.4),(300*0.4),'','black',"",'',100,"","",'');
			echo "<img src='img/promo/img6/$id_promo->img6_fhd' width=100% height=100%></img>";
			$box->angle_out(".");
			}

		if($id_promo->titre!='')
			{
			$box->angle(($id_promo->titre_fhd_x*0.4),($id_promo->titre_fhd_y*0.4),(800*0.4),(60*0.4),'red','black',"",'',100,"Titre","",'');
			}

		if(($id_promo->cpu!='')or($id_promo->mem!='')or($id_promo->hdd!='')or($id_promo->gfx!='')or($id_promo->os!='')or($id_promo->text_libre!=''))
			{
			$box->angle(($id_promo->fiche_fhd_x*0.4),($id_promo->fiche_fhd_y*0.4),(600*0.4),(400*0.4),'red','black',"",'',100,"Fiche Technique","",'');
			}
		
		if(($id_promo->pv_error!='')or(($id_promo->pv_correct!='')))
			{
			$box->angle_in(($id_promo->prix_fhd_x*0.4),($id_promo->prix_fhd_y*0.4),(200*0.4),(120*0.4),'red','black',"",'',100,"PRIX","",'');
			//echo "<img src='img/promo/img6/$id_promo->img6_fhd' width=100% height=100%></img>";
			$box->angle_out(".");
			}
		/*
		if($id_promo->img6_fhd!='no_img.gif')
			{
			$box->angle_in(($id_promo->img6_fhd_x*0.4),($id_promo->img6_fhd_y*0.4),(300*0.4),(300*0.4),'','black',"",'',100,"","",'');
			echo "<img src='img/promo/img6/$id_promo->img6_fhd' width=100% height=100%></img>";
			$box->angle_out(".");
			}
		*/
		echo"<meta http-equiv='refresh' content='1; url='/>";
		};break;
######################################################################################################################
	case 'edit_fhd_gfx':
		{
		$id_prm=$_GET['id_prm'];
		$img=$_GET['img'];
		if($img=="bground")$img=$img."_fhd";
		$iterator = new DirectoryIterator("img/promo/$img/");
		foreach($iterator as $document)
			{
			if(($document->getFilename()!='.')and($document->getFilename()!='..'))
				{
				switch ($img)
					{
					case 'img0':
						{
						$box->angle('','','300','300','','black',"img/promo/$img/".$document->getFilename(),'',100,"","index.php?system=promo/fhd.iframe&sub_system=update_fhd_gfx&id_prm=$id_prm&img=$img&image=".$document->getFilename()."&no_interface",'');
						};break;
					case 'img1':
						{
						$box->angle('','','150','150','','black',"img/promo/$img/".$document->getFilename(),'',100,"","index.php?system=promo/fhd.iframe&sub_system=update_fhd_gfx&id_prm=$id_prm&img=$img&image=".$document->getFilename()."&no_interface",'');
						};break;
					case 'img2':
						{
						$box->angle('','','150','150','','black',"img/promo/$img/".$document->getFilename(),'',100,"","index.php?system=promo/fhd.iframe&sub_system=update_fhd_gfx&id_prm=$id_prm&img=$img&image=".$document->getFilename()."&no_interface",'');
						};break;
					case 'img3':
						{
						$box->angle('','','150','150','','black',"img/promo/$img/".$document->getFilename(),'',100,"","index.php?system=promo/fhd.iframe&sub_system=update_fhd_gfx&id_prm=$id_prm&img=$img&image=".$document->getFilename()."&no_interface",'');
						};break;
					case 'img4':
						{
						$box->angle('','','150','150','','black',"img/promo/$img/".$document->getFilename(),'',100,"","index.php?system=promo/fhd.iframe&sub_system=update_fhd_gfx&id_prm=$id_prm&img=$img&image=".$document->getFilename()."&no_interface",'');
						};break;
					case 'img5':
						{
						$box->angle('','','150','150','','black',"img/promo/$img/".$document->getFilename(),'',100,"","index.php?system=promo/fhd.iframe&sub_system=update_fhd_gfx&id_prm=$id_prm&img=$img&image=".$document->getFilename()."&no_interface",'');
						};break;
					case 'img6':
						{
						$box->angle('','','300','300','','black',"img/promo/$img/".$document->getFilename(),'',100,"","index.php?system=promo/fhd.iframe&sub_system=update_fhd_gfx&id_prm=$id_prm&img=$img&image=".$document->getFilename()."&no_interface",'');
						};break;
						/*
					case 'bground_a4':
						{
						$box->angle_in('','','152','216','','steelblue',"",'',100,"","index.php?system=promo/fhd.iframe&sub_system=update_fhd_gfx&id_prm=$id_prm&img=$img&image=".$document->getFilename()."&no_interface",'');
						echo "<img src='img/promo/$img/".$document->getFilename()."' width=100% height=100%></img>";
						$box->angle_out('');
						};break;
						*/
					case 'bground_fhd':
						{
						$box->angle_in('','','320','180','','steelblue',"",'',100,"","index.php?system=promo/fhd.iframe&sub_system=update_fhd_gfx&id_prm=$id_prm&img=$img&image=".$document->getFilename()."&no_interface",'');
						echo "<img src='img/promo/$img/".$document->getFilename()."' width=100% height=100%></img>";
						$box->angle_out('');
						};break;
					}
				}
			}
		};break;
######################################################################################################################
	case 'update_fhd_gfx':
		{
		if($_GET['img']!='bground_fhd')$img=$_GET['img']."_fhd";
		else $img=$_GET['img'];
		$image=$_GET['image'];
		db_write("update promo set $img ='$image' where id_odp=$id_prm;");
		echo"<meta http-equiv='refresh' content='0; url=index.php?system=promo/fhd.iframe&sub_system=edit_fhd_img&id_prm=$id_prm&no_interface'/>";	
		};break;
######################################################################################################################
	}
?>