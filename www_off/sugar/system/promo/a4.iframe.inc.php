<?php

if($sugar->security_odp<1)$js->alert_redirect("No acces","",0);
//on verifie si un ticket est renseigner sinon on est redirect sur la page lobby cmd
if(($sub_system!='lobby')and(isset($_GET['id_prm'])))$id_prm=$_GET['id_prm'];
else $id_prm="";

switch ($sub_system)
	{
######################################################################################################################
	case 'edit_fhd':
		{
		$box->angle_in('10','30','1480','790','','black','','',100,"","",'');
		echo "<iframe width=100% height=100% frameborder=0 src='index.php?system=promo/fhd.iframe&sub_system=edit_fhd_img&id_prm=$id_prm&no_interface'></iframe>";
		$box->angle_out(".");

		$box->angle_in('700','370',((1920*0.4)+2),((1080*0.4)+2),'','black','','',100,"","",'');
		echo "<iframe width=100% height=100% frameborder=0 src='index.php?system=promo/fhd.iframe&sub_system=preview_fhd&id_prm=$id_prm&no_interface'></iframe>";
		$box->angle_out(".");
		};break;
######################################################################################################################
	case 'update_a4_loc_xy':
		{
		$id_prm=$_POST['id_prm'];
		$x=$_POST['x'];
		$y=$_POST['y'];
		$labelx=$_POST['lblx'];
		$labely=$_POST['lbly'];
		db_write("update promo set $labelx='$x',$labely='$y' where id_odp = $id_prm;");
		echo"<meta http-equiv='refresh' content='0; url=index.php?system=promo/a4.iframe&sub_system=edit_a4_img&id_prm=$id_prm&no_interface'/>";
		};break;
######################################################################################################################
    case 'edit_a4_img':
		{
		$id_promo=db_single_read("select * from promo where id_odp=$id_prm");
		if($cmd->status!='SCREEN')
			{
			//IMG0
			$box->empty_in('20','20','500','150','','steelblue',"",'',100,"","",'');
				$box->angle_in('','','150','150','','steelblue',"",'',100,"","index.php?system=promo/a4.iframe&sub_system=edit_a4_gfx&id_prm=$id_prm&img=img0&no_interface",'');
				echo "<img src='img/promo/img0/$id_promo->img0_a4' width=100% height=100%></img>";
				$box->angle_out('.');
				
				$box->angle_in('','','150','150','','steelblue',"",'',100,"IMG 0","",'');
					$form->open("index.php?system=promo/a4.iframe&sub_system=update_a4_loc_xy&no_interface","POST");
					$form->hidden('id_prm',$id_prm);
					$form->hidden('lblx',"img0_a4_x");
					$form->hidden('lbly',"img0_a4_y");
					echo "300X300px<br><br>";
					echo"X : ";
					$form->select_in('x',1);
					for($i=1;$i<=460;$i++)$form->select_option($i,$i,$id_promo->img0_a4_x);
					$form->select_out();
					echo"<br>Y : ";
					$form->select_in('y',1);
					for($i=1;$i<=780;$i++)$form->select_option($i,$i,$id_promo->img0_a4_y);
					$form->select_out();
					echo "<br>";
					$form->send("Update");
					$form->close();
				$box->angle_out('');
			$box->empty_out('');
			//IMG1
			$box->empty_in('340','20','500','150','','steelblue',"",'',100,"","",'');
				$box->angle_in('','','150','150','','steelblue',"",'',100,"","index.php?system=promo/a4.iframe&sub_system=edit_a4_gfx&id_prm=$id_prm&img=img1&no_interface",'');
				echo "<img src='img/promo/img1/$id_promo->img1_a4' width=100% height=100%></img>";
				$box->angle_out('.');
				
				$box->angle_in('','','150','150','','steelblue',"",'',100,"IMG 1","",'');
					$form->open("index.php?system=promo/a4.iframe&sub_system=update_a4_loc_xy&no_interface","POST");
					$form->hidden('id_prm',$id_prm);
					$form->hidden('lblx',"img1_a4_x");
					$form->hidden('lbly',"img1_a4_y");
					echo "150X150px<br><br>";
					echo"X : ";
					$form->select_in('x',1);
					for($i=1;$i<=610;$i++)$form->select_option($i,$i,$id_promo->img1_a4_x);
					$form->select_out();
					echo"<br>Y : ";
					$form->select_in('y',1);
					for($i=1;$i<=930;$i++)$form->select_option($i,$i,$id_promo->img1_a4_y);
					$form->select_out();
					echo "<br>";
					$form->send("Update");
					$form->close();
				$box->angle_out('');
			$box->empty_out('');
			//IMG2
			$box->empty_in('20','190','500','150','','steelblue',"",'',100,"","",'');
				$box->angle_in('','','150','150','','steelblue',"",'',100,"","index.php?system=promo/a4.iframe&sub_system=edit_a4_gfx&id_prm=$id_prm&img=img2&format=a4&no_interface",'');
				echo "<img src='img/promo/img2/$id_promo->img2_a4' width=100% height=100%></img>";
				$box->angle_out('.');
				$box->angle_in('','','150','150','','steelblue',"",'',100,"IMG 2","",'');
					$form->open("index.php?system=promo/a4.iframe&sub_system=update_a4_loc_xy&no_interface","POST");
					$form->hidden('id_prm',$id_prm);
					$form->hidden('lblx',"img2_a4_x");
					$form->hidden('lbly',"img2_a4_y");
					echo "150X150px<br><br>";
					echo"X : ";
					$form->select_in('x',1);
					for($i=1;$i<=610;$i++)$form->select_option($i,$i,$id_promo->img2_a4_x);
					$form->select_out();
					echo"<br>Y : ";
					$form->select_in('y',1);
					for($i=1;$i<=930;$i++)$form->select_option($i,$i,$id_promo->img2_a4_y);
					$form->select_out();
					echo "<br>";
					$form->send("Update");
					$form->close();
				$box->angle_out('');
			$box->empty_out('');
			//IMG3
			$box->empty_in('340','190','500','150','','steelblue',"",'',100,"","",'');
				$box->angle_in('','','150','150','','steelblue',"",'',100,"","index.php?system=promo/a4.iframe&sub_system=edit_a4_gfx&id_prm=$id_prm&img=img3&format=a4&no_interface",'');
				echo "<img src='img/promo/img3/$id_promo->img3_a4' width=100% height=100%></img>";
				$box->angle_out('.');
				$box->angle_in('','','150','150','','steelblue',"",'',100,"IMG 3","",'');
					$form->open("index.php?system=promo/a4.iframe&sub_system=update_a4_loc_xy&no_interface","POST");
					$form->hidden('id_prm',$id_prm);
					$form->hidden('lblx',"img3_a4_x");
					$form->hidden('lbly',"img3_a4_y");
					echo "150X150px<br><br>";
					echo"X : ";
					$form->select_in('x',1);
					for($i=1;$i<=610;$i++)$form->select_option($i,$i,$id_promo->img3_a4_x);
					$form->select_out();
					echo"<br>Y : ";
					$form->select_in('y',1);
					for($i=1;$i<=930;$i++)$form->select_option($i,$i,$id_promo->img3_a4_y);
					$form->select_out();
					echo "<br>";
					$form->send("Update");
					$form->close();
				$box->angle_out('');
			$box->empty_out('');
			//IMG4
			$box->empty_in('20','360','500','150','','steelblue',"",'',100,"","",'');
				$box->angle_in('','','150','150','','steelblue',"",'',100,"","index.php?system=promo/a4.iframe&sub_system=edit_a4_gfx&id_prm=$id_prm&img=img4&format=a4&no_interface",'');
				echo "<img src='img/promo/img4/$id_promo->img4_a4' width=100% height=100%></img>";
				$box->angle_out('.');
				$box->angle_in('','','150','150','','steelblue',"",'',100,"IMG 4","",'');
					$form->open("index.php?system=promo/a4.iframe&sub_system=update_a4_loc_xy&no_interface","POST");
					$form->hidden('id_prm',$id_prm);
					$form->hidden('lblx',"img4_a4_x");
					$form->hidden('lbly',"img4_a4_y");
					echo "150X150px<br><br>";
					echo"X : ";
					$form->select_in('x',1);
					for($i=1;$i<=610;$i++)$form->select_option($i,$i,$id_promo->img4_a4_x);
					$form->select_out();
					echo"<br>Y : ";
					$form->select_in('y',1);
					for($i=1;$i<=930;$i++)$form->select_option($i,$i,$id_promo->img4_a4_y);
					$form->select_out();
					echo "<br>";
					$form->send("Update");
					$form->close();
				$box->angle_out('');
			$box->empty_out('');
			//IMG5
			$box->empty_in('340','360','500','150','','steelblue',"",'',100,"","",'');
				$box->angle_in('','','150','150','','steelblue',"",'',100,"","index.php?system=promo/a4.iframe&sub_system=edit_a4_gfx&id_prm=$id_prm&img=img5&format=a4&no_interface",'');
				echo "<img src='img/promo/img5/$id_promo->img5_a4' width=100% height=100%></img>";
				$box->angle_out('.');
				$box->angle_in('','','150','150','','steelblue',"",'',100,"IMG 5","",'');
					$form->open("index.php?system=promo/a4.iframe&sub_system=update_a4_loc_xy&no_interface","POST");
					$form->hidden('id_prm',$id_prm);
					$form->hidden('lblx',"img5_a4_x");
					$form->hidden('lbly',"img5_a4_y");
					echo "150X150px<br><br>";
					echo"X : ";
					$form->select_in('x',1);
					for($i=1;$i<=610;$i++)$form->select_option($i,$i,$id_promo->img5_a4_x);
					$form->select_out();
					echo"<br>Y : ";
					$form->select_in('y',1);
					for($i=1;$i<=930;$i++)$form->select_option($i,$i,$id_promo->img5_a4_y);
					$form->select_out();
					echo "<br>";
					$form->send("Update");
					$form->close();
				$box->angle_out('');
			$box->empty_out('');
			//IMG6
			$box->empty_in('20','530','500','150','','steelblue',"",'',100,"","",'');
				$box->angle_in('','','150','150','','steelblue',"",'',100,"","index.php?system=promo/a4.iframe&sub_system=edit_a4_gfx&id_prm=$id_prm&img=img6&format=a4&no_interface",'');
				echo "<img src='img/promo/img6/$id_promo->img6_a4' width=100% height=100%></img>";
				$box->angle_out('.');
				$box->angle_in('','','150','150','','steelblue',"",'',100,"IMG 6","",'');
					$form->open("index.php?system=promo/a4.iframe&sub_system=update_a4_loc_xy&no_interface","POST");
					$form->hidden('id_prm',$id_prm);
					$form->hidden('lblx',"img6_a4_x");
					$form->hidden('lbly',"img6_a4_y");
					echo "150X150px<br><br>";
					echo"X : ";
					$form->select_in('x',1);
					for($i=1;$i<=460;$i++)$form->select_option($i,$i,$id_promo->img6_a4_x);
					$form->select_out();
					echo"<br>Y : ";
					$form->select_in('y',1);
					for($i=1;$i<=780;$i++)$form->select_option($i,$i,$id_promo->img6_a4_y);
					$form->select_out();
					echo "<br>";
					$form->send("Update");
					$form->close();
				$box->angle_out('');
			$box->empty_out('');
			//Titre
			$box->angle_in('340','530','300','60','lightblue','steelblue',"",'',100,"","",'');
				$form->open("index.php?system=promo/a4.iframe&sub_system=update_a4_loc_xy&no_interface","POST");
				$form->hidden('id_prm',$id_prm);
				$form->hidden('lblx',"titre_a4_x");
				$form->hidden('lbly',"titre_a4_y");
				echo "Titre - 450X40px<br>";
				echo"X : ";
				$form->select_in('x',1);
				for($i=1;$i<=310;$i++)$form->select_option($i,$i,$id_promo->titre_a4_x);
				$form->select_out();
				echo"Y : ";
				$form->select_in('y',1);
				for($i=1;$i<=1040;$i++)$form->select_option($i,$i,$id_promo->titre_a4_y);
				$form->select_out();
					
				$form->send("Update");
				$form->close();
			$box->angle_out('.');
			//fiche technique
			$box->angle_in('340','620','300','60','lightblue','steelblue',"",'',100,"","",'');
				$form->open("index.php?system=promo/a4.iframe&sub_system=update_a4_loc_xy&no_interface","POST");
				$form->hidden('id_prm',$id_prm);
				$form->hidden('lblx',"fiche_a4_x");
				$form->hidden('lbly',"fiche_a4_y");
				echo "Info technique - 480X400px<br>";
				echo"X : ";
				$form->select_in('x',1);
				for($i=1;$i<=280;$i++)$form->select_option($i,$i,$id_promo->fiche_a4_x);
				$form->select_out();
				echo"Y : ";
				$form->select_in('y',1);
				for($i=1;$i<=680;$i++)$form->select_option($i,$i,$id_promo->fiche_a4_y);
				$form->select_out();
					
				$form->send("Update");
				$form->close();
			$box->angle_out('');
			//prix
			$box->angle_in('340','710','300','60','lightblue','steelblue',"",'',100,"","",'');
				$form->open("index.php?system=promo/a4.iframe&sub_system=update_a4_loc_xy&no_interface","POST");
				$form->hidden('id_prm',$id_prm);
				$form->hidden('lblx',"prix_a4_x");
				$form->hidden('lbly',"prix_a4_y");
				echo "Prix - 480X400px<br>";
				echo"X : ";
				$form->select_in('x',1);
				for($i=1;$i<=648;$i++)$form->select_option($i,$i,$id_promo->prix_a4_x);
				$form->select_out();
				echo"Y : ";
				$form->select_in('y',1);
				for($i=1;$i<=1018;$i++)$form->select_option($i,$i,$id_promo->prix_a4_y);
				$form->select_out();
					
				$form->send("Update");
				$form->close();
			$box->angle_out('');


			$box->angle_in('660','20','228','324','','steelblue',"",'',100,"","index.php?system=promo/a4.iframe&sub_system=edit_a4_gfx&id_prm=$id_prm&img=bground_a4&format=a4&no_interface",'');
			echo "<img src='img/promo/bground_a4/$id_promo->bground_a4' width=100% height=100%></img>";
			$box->angle_out('.');
		}
		};break;
######################################################################################################################
	case 'preview_a4_print':
		{
		$id_prm=$_GET['id_prm'];
		$id_promo=db_single_read("select * from promo where id_odp=$id_prm");
		
		$box->angle_in('0','0',(760*0.75),(1080*0.75),'','black',"",'',100,"","",'');
		echo "<img src='img/promo/bground_a4/$id_promo->bground_a4' width=100% height=100%></img>";
		$box->angle_out(".");
		
		if($id_promo->img0_a4!='no_img.gif')
			{
			$x=($id_promo->img0_a4_x*0.75);
			$y=($id_promo->img0_a4_y*0.75);
			$box->angle_in($x,$y,(300*0.75),(300*0.75),'','black',"",'',100,"","",'');
			echo "<img src='img/promo/img0/$id_promo->img0_a4' width=100% height=100%></img>";
			$box->angle_out(".");
			}
		if($id_promo->img1_a4!='no_img.gif')
			{
			$box->angle_in(($id_promo->img1_a4_x*0.75),($id_promo->img1_a4_y*0.75),(150*0.75),(150*0.75),'','black',"",'',100,"","",'');
			echo "<img src='img/promo/img1/$id_promo->img1_a4' width=100% height=100%></img>";
			$box->angle_out(".");
			}
		if($id_promo->img2_a4!='no_img.gif')
			{
			$box->angle_in(($id_promo->img2_a4_x*0.75),($id_promo->img2_a4_y*0.75),(150*0.75),(150*0.75),'','black',"",'',100,"","",'');
			echo "<img src='img/promo/img2/$id_promo->img2_a4' width=100% height=100%></img>";
			$box->angle_out(".");
			}
		if($id_promo->img3_a4!='no_img.gif')
			{
			$box->angle_in(($id_promo->img3_a4_x*0.75),($id_promo->img3_a4_y*0.75),(150*0.75),(150*0.75),'','black',"",'',100,"","",'');
			echo "<img src='img/promo/img3/$id_promo->img3_a4' width=100% height=100%></img>";
			$box->angle_out(".");
			}
		if($id_promo->img4_a4!='no_img.gif')
			{
			$box->angle_in(($id_promo->img4_a4_x*0.75),($id_promo->img4_a4_y*0.75),(150*0.75),(150*0.75),'','black',"",'',100,"","",'');
			echo "<img src='img/promo/img4/$id_promo->img4_a4' width=100% height=100%></img>";
			$box->angle_out(".");
			}
		if($id_promo->img5_a4!='no_img.gif')
			{
			$box->angle_in(($id_promo->img5_a4_x*0.75),($id_promo->img5_a4_y*0.75),(150*0.75),(150*0.75),'','black',"",'',100,"","",'');
			echo "<img src='img/promo/img5/$id_promo->img5_a4' width=100% height=100%></img>";
			$box->angle_out(".");
			}
		if($id_promo->img6_a4!='no_img.gif')
			{
			$box->angle_in(($id_promo->img6_a4_x*0.75),($id_promo->img6_a4_y*0.75),(300*0.75),(300*0.75),'','black',"",'',100,"","",'');
			echo "<img src='img/promo/img6/$id_promo->img6_a4' width=100% height=100%></img>";
			$box->angle_out(".");
			}
		//titre
		$box->angle(($id_promo->titre_a4_x*0.75),($id_promo->titre_a4_y*0.75),(450*0.75),(40*0.75),'','black',"",'',100,"<font size=2>$id_promo->titre</font>","",'');
		
		//fiche technique
		$box->angle(($id_promo->fiche_a4_x*0.75),($id_promo->fiche_a4_y*0.75),(480*0.75),(400*0.75),'','black',"",'',100,"<font size=2>$id_promo->text_libre</font>","",'');

		//prix
		$box->angle(($id_promo->prix_a4_x*0.75),($id_promo->prix_a4_y*0.75),(110*0.75),(60*0.75),'','black',"",'',100,"<font size=2>PRIX</font>","",'');

			
		echo"<meta http-equiv='refresh' content='1; url='/>";
		};break;
######################################################################################################################
	case 'edit_fiche':
		{
		die("edite fiche");
		/*
		$promo=db_single_read("select * from promo where id_odp = $id_prm");
		$form->open("index.php?system=promo&sub_system=update_fiche&id_prm=$id_prm","POST");
		$box->angle_in('10','40','532','360','','black','','',100,"","",'');
			$box->angle_in('0','0','140','350','','','','',100,"","",'');
				$box->angle('','','138','22','','','','',100,"Id Promo : ","",'');
				$box->angle('','','138','22','','','','',100,"Date creation : ","",'');
				$box->angle('','','138','22','','','','',100,"Titre : ","",'');
				$box->angle('','','138','22','','','','',100,"Cpu : ","",'');
				$box->angle('','','138','22','','','','',100,"Memoire : ","",'');
				$box->angle('','','138','22','','','','',100,"Hdd : ","",'');
				$box->angle('','','138','22','','','','',100,"Gfx : ","",'');
				$box->angle('','','138','22','','','','',100,"Os : ","",'');
				$box->angle('','','138','22','','','','',100,"Prix Faux: ","",'');
				$box->angle('','','138','22','','','','',100,"Prix Reel : ","",'');
				$box->angle('','','138','22','','','','',100,"Description : ","",'');
			$box->angle_out("");

			$box->angle_in('140','0','390','350','','','','',100,"","",'');
				$form->text_disabled('id',45,$id_prm);
				$form->text_disabled('titre',45,date("d/m/Y H:i",$cmd->dt_in));
				$form->text('titre',45,$promo->titre);
				$form->text("cpu",45,$promo->cpu);
				$form->text("mem",45,$promo->mem);
				$form->text("hdd",45,$promo->hdd);
				$form->text("gfx",45,$promo->gfx);
				$form->text("os",45,$promo->os);
				$form->text("pv_error",45,$promo->pv_error);
				$form->text("pv_correct",45,$promo->pv_correct);
				$form->textarea("text_libre",5,45,str_replace("<br />","",$promo->text_libre));
				$form->send("Update");
			$box->angle_out("");
		$box->angle_out('');
		$form->close();
		*/
		};break;
######################################################################################################################
	case 'update_fiche':
		{
		die("update fiche");
		/*
		$titre=$_POST['titre'];
		$text_libre=nl2br($_POST['text_libre']);
		$cpu=$_POST['cpu'];
		$mem=$_POST['mem'];
		$hdd=$_POST['hdd'];
		$gfx=$_POST['gfx'];
		$os=$_POST['os'];
		$pv_error=$_POST['pv_error'];
		$pv_correct=$_POST['pv_correct'];
		$rqt="update promo set titre='$titre',text_libre='$text_libre',cpu='$cpu',mem='$mem',hdd='$hdd',gfx='$gfx',os='$os',pv_error='$pv_error',pv_correct='$pv_correct' where id_odp=$id_prm;";
		$rqt.="update cmd set titre='$titre' where id = $id_prm;";
		db_write($rqt);
		echo"<meta http-equiv='refresh' content='0; url=index.php?system=promo&sub_system=edit_fiche&tab=edit_fiche&id_prm=$id_prm'/>";
		*/
		};break;
######################################################################################################################
	case 'edit_a4_gfx':
		{
		$id_prm=$_GET['id_prm'];
		$img=$_GET['img'];
		$iterator = new DirectoryIterator("img/promo/$img/");
		foreach($iterator as $document)
			{
			if(($document->getFilename()!='.')and($document->getFilename()!='..'))
				{
				switch ($img)
					{
					case 'img0':
						{
						$box->angle('','','300','300','','black',"img/promo/$img/".$document->getFilename(),'',100,"","index.php?system=promo/a4.iframe&sub_system=update_a4_gfx&id_prm=$id_prm&img=$img"."_a4&image=".$document->getFilename()."&no_interface",'');
						};break;
					case 'img1':
						{
						$box->angle('','','150','150','','black',"img/promo/$img/".$document->getFilename(),'',100,"","index.php?system=promo/a4.iframe&sub_system=update_a4_gfx&id_prm=$id_prm&img=$img"."_a4&image=".$document->getFilename()."&no_interface",'');
						};break;
					case 'img2':
						{
						$box->angle('','','150','150','','black',"img/promo/$img/".$document->getFilename(),'',100,"","index.php?system=promo/a4.iframe&sub_system=update_a4_gfx&id_prm=$id_prm&img=$img"."_a4&image=".$document->getFilename()."&no_interface",'');
						};break;
					case 'img3':
						{
						$box->angle('','','150','150','','black',"img/promo/$img/".$document->getFilename(),'',100,"","index.php?system=promo/a4.iframe&sub_system=update_a4_gfx&id_prm=$id_prm&img=$img"."_a4&image=".$document->getFilename()."&no_interface",'');
						};break;
					case 'img4':
						{
						$box->angle('','','150','150','','black',"img/promo/$img/".$document->getFilename(),'',100,"","index.php?system=promo/a4.iframe&sub_system=update_a4_gfx&id_prm=$id_prm&img=$img"."_a4&image=".$document->getFilename()."&no_interface",'');
						};break;
					case 'img5':
						{
						$box->angle('','','150','150','','black',"img/promo/$img/".$document->getFilename(),'',100,"","index.php?system=promo/a4.iframe&sub_system=update_a4_gfx&id_prm=$id_prm&img=$img"."_a4&image=".$document->getFilename()."&no_interface",'');
						};break;
					case 'img6':
						{
						$box->angle('','','300','300','','black',"img/promo/$img/".$document->getFilename(),'',100,"","index.php?system=promo/a4.iframe&sub_system=update_a4_gfx&id_prm=$id_prm&img=$img"."_a4&image=".$document->getFilename()."&no_interface",'');
						};break;
					case 'bground_a4':
						{
						$box->angle_in('','','152','216','','steelblue',"",'','100',"","index.php?system=promo/a4.iframe&sub_system=update_a4_gfx&id_prm=$id_prm&img=$img&image=".$document->getFilename()."&no_interface",'');
						echo "<img src='img/promo/$img/".$document->getFilename()."' width=100% height=100%></img>";
						$box->angle_out('');
						};break;
					}
				}
			}
		};break;
######################################################################################################################
	case 'update_a4_gfx':
		{
		$id_prm=$_GET['id_prm'];
		$img=$_GET['img'];
		$image=$_GET['image'];
		db_write("update promo set $img ='$image' where id_odp=$id_prm;");
		echo"<meta http-equiv='refresh' content='0; url=index.php?system=promo/a4.iframe&sub_system=edit_a4_img&id_prm=$id_prm&no_interface'/>";	
		};break;
######################################################################################################################
	}
?>