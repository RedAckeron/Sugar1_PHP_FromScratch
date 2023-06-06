<?php
if(isset($_GET['load']))$mt_in=microtime();
if(isset($_GET['id_shop']))$id_shop=$_GET['id_shop'];
else $id_shop=0;

if(isset($_GET['timer']))$timer=$_GET['timer'];
else $timer=15;

include('../../www_off/sugar/dll/dll_db.php');
include('../../www_off/sugar/obj/box.obj.php');
include('../../www_off/sugar/obj/sugar.obj.php');
if(!isset($sugar))$sugar=new _sugar;
$box=new _box;
$shop=db_single_read("SELECT * FROM shop where id=$id_shop");
		
	$promo_cmd=db_single_read("SELECT * FROM cmd where type='prm' and (id_shop=$id_shop or id_shop=0) and status !='hidden' order by RAND() LIMIT 1");
	$promo=db_single_read("SELECT * FROM promo where id_odp=$promo_cmd->id");
		
	if($promo_cmd->status=='SCREEN')$bground="img/promo/bground_screen/".$promo->bground_fhd;
	else $bground="img/promo/bground_fhd/".$promo->bground_fhd;
		
	$box->angle_in('0','0','1920','1080',"white",'',$bground,'',100,"","",'');
	if(substr($promo_cmd->status,0,6)!='SCREEN')
		{
		//img0 TOWER
		if($promo->img0_fhd!="no_img.gif")$box->empty('1050','350','300','300',"",'',"img/promo/img0/".$promo->img0_fhd,'',100,"","",'');
		//img1 CPU
		if($promo->img1_fhd!="no_img.gif")$box->empty('1730','250','150','150',"",'',"img/promo/img1/".$promo->img1_fhd,'',100,"","",'');
		//img2 RAM
		if($promo->img2_fhd!="no_img.gif")$box->empty('900','700','150','150',"",'',"img/promo/img2/".$promo->img2_fhd,'',100,"","",'');
		//img3 HDD
		if($promo->img3_fhd!="no_img.gif")$box->empty('1400','660','150','150',"",'',"img/promo/img3/".$promo->img3_fhd,'',100,"","",'');
		//img4 GFX
		if($promo->img4_fhd!="no_img.gif")$box->empty('800','420','150','150',"",'',"img/promo/img4/".$promo->img4_fhd,'',100,"","",'');
		//img5 OS
		if($promo->img5_fhd!="no_img.gif")$box->empty('1730','600','150','150',"",'',"img/promo/img5/".$promo->img5_fhd,'',100,"","",'');
		//img6 Goodies
		if($promo->img6_fhd!="no_img.gif")$box->empty('1400','350','300','300',"",'',"img/promo/img6/".$promo->img6_fhd,'',100,"","",'');
		//Titre
		if ($promo->titre!="")$box->empty('500','180','800','60','','','','',100,"<font size=8>$promo->titre</font>","",'');
		//info technique 
		$box->angle_in('50','300','600','400','','','','',100,"<font size=6></b><u>Caracteristique technique</u></b></center></font>","",'');
			if ($promo->cpu!="")echo "<br><font size=5><li>Processeur : $promo->cpu</li>";
			if ($promo->mem!="")echo "<font size=5><li>Memoire : $promo->mem</li>";
			if ($promo->hdd!="")echo "<font size=5><li>Disque dur : $promo->hdd</li>";
			if ($promo->gfx!="")echo "<font size=5><li>Graphique : $promo->gfx</li>";
			if ($promo->os!="")echo "<font size=5><li>System operatif : $promo->os</li>";
			if ($promo->text_libre!="")echo "<font size=5><br><center>$promo->text_libre</font></center>";
		$box->angle_out('');
			
		//prix_faux
		if ($promo->pv_error!="")$box->angle('120','750','250','50',"",'black',"img/promo/box_prix_croix.gif",'',100,"<font size=6>$promo->pv_error &euro;</font>","",'');
		
		//prix_correct
		if ($promo->pv_correct!="")$box->angle('470','750','250','50',"",'black',"",'',100,"<font size =6>$promo->pv_correct &euro;</font>","",'');
			
		//Les 3 cases dans les coins 
		$txt="$shop->nom<br></b>$shop->adresse_rue<br>$shop->adresse_cp $shop->adresse_ville<br>$shop->mail<br>".$sugar->show_call_formated($shop->call1);
		$box->angle('1520','35','300','150','white','black',"","",90,"<font size =5>$txt</font>","",'');
		$box->angle('10','1024','230','37',"white",'','','',90,"<font size =2>CETTE OFFRE EST SUSCEPTIBLE <br>D ETRE MODIFIE SANS PREAVIS</font>","",'');
		}
	$box->angle('20','20','150','150',"",'black',"img/150px/$shop->img_logo",'',100,"","index.php",'');
		
	$box->angle_out('');
	echo "<meta http-equiv='refresh' content='$timer; url='/>";

if(isset($_GET['load']))$box->angle('1790','1050','120','22',"red",'black',"",'',100,"<font size=2>".((microtime()-$mt_in)*1000)."Ms</font>","",'');
		
?>