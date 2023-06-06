<?php
if(isset($_GET['load']))$mt_in=microtime();

if(isset($_GET['timer']))$timer=$_GET['timer'];
else $timer=15;

include('../../www_off/sugar/dll/dll_db.php');
include('../../www_off/sugar/obj/box.obj.php');
include('../../www_off/sugar/obj/sugar.obj.php');
if(!isset($sugar))$sugar=new _sugar;
$box=new _box;

if(isset($_GET['id_shop']))$id_shop=$_GET['id_shop'];
else 
	{
	if($sugar->id!=0)$id_shop=$sugar->shop_id;
	else $id_shop=1;
	}
$shop=db_single_read("SELECT * FROM shop where id=$id_shop");
/*	
$promo_cmd=db_single_read("SELECT * FROM cmd where type='prm' and (id_shop=$id_shop or id_shop=0) and status !='hidden' order by RAND() LIMIT 1");
$promo=db_single_read("SELECT * FROM promo where id_odp=$promo_cmd->id");
*/
if(isset($_GET['id_odp']))
	{
	$promo=db_single_read("SELECT * FROM promo where id_odp=".$_GET['id_odp']);
	$promo_cmd=db_single_read("SELECT * FROM cmd where id = ".$_GET['id_odp']);
	}
else 
	{
	$promo=db_single_read("SELECT * FROM promo where status = 'on' and ((id_shop = 0) or (id_shop = $id_shop)) order by RAND() LIMIT 1");
	$promo_cmd=db_single_read("SELECT * FROM cmd where id = $promo->id_odp");
	}
	
if(substr($promo_cmd->status,0,6)!='SCREEN')
	{
	$box->angle_in('0','0','1920','1080',"",'',"img/promo/bground_fhd/$promo->bground_fhd",'',100,"$promo->id_odp","",'');
		//img0 TOWER
		if($promo->img0_fhd!="no_img.gif")$box->angle($promo->img0_fhd_x,$promo->img0_fhd_y,'300','300',"",'',"img/promo/img0/".$promo->img0_fhd,'',100,"","",'');
		//img1 CPU
		if($promo->img1_fhd!="no_img.gif")$box->angle($promo->img1_fhd_x,$promo->img1_fhd_y,'150','150',"",'',"img/promo/img1/".$promo->img1_fhd,'',100,"","",'');
		//img2 RAM
		if($promo->img2_fhd!="no_img.gif")$box->angle($promo->img2_fhd_x,$promo->img2_fhd_y,'150','150',"",'',"img/promo/img2/".$promo->img2_fhd,'',100,"","",'');
		//img3 HDD
		if($promo->img3_fhd!="no_img.gif")$box->angle($promo->img3_fhd_x,$promo->img3_fhd_y,'150','150',"",'',"img/promo/img3/".$promo->img3_fhd,'',100,"","",'');
		//img4 GFX
		if($promo->img4_fhd!="no_img.gif")$box->angle($promo->img4_fhd_x,$promo->img4_fhd_y,'150','150',"",'',"img/promo/img4/".$promo->img4_fhd,'',100,"","",'');
		//img5 OS
		if($promo->img5_fhd!="no_img.gif")$box->angle($promo->img5_fhd_x,$promo->img5_fhd_y,'150','150',"",'',"img/promo/img5/".$promo->img5_fhd,'',100,"","",'');
		//img6 Goodies
		if($promo->img6_fhd!="no_img.gif")$box->angle($promo->img6_fhd_x,$promo->img6_fhd_y,'300','300',"",'',"img/promo/img6/".$promo->img6_fhd,'',100,"","",'');
		//Titre
		if ($promo->titre!="")$box->angle($promo->titre_fhd_x,$promo->titre_fhd_y,'800','60','','','','',100,"<font size=8 color=$promo->color>$promo->titre</font>","",'');
		
		
		//info technique 
		$box->angle_in($promo->fiche_fhd_x,$promo->fiche_fhd_y,'600','400','','','','',100,"<font size=6 color=$promo->color></b><u>Caracteristique technique</u></b></center></font>","",'');
			if ($promo->cpu!="")echo "<br><font size=5 color=$promo->color><li>Processeur : $promo->cpu</li>";
			if ($promo->mem!="")echo "<font size=5><li>Memoire : $promo->mem</li>";
			if ($promo->hdd!="")echo "<font size=5><li>Disque dur : $promo->hdd</li>";
			if ($promo->gfx!="")echo "<font size=5><li>Graphique : $promo->gfx</li>";
			if ($promo->os!="")echo "<font size=5><li>System operatif : $promo->os</li>";
			if ($promo->text_libre!="")echo "<font size=5><br><center>$promo->text_libre</font></center>";
		$box->angle_out('');
		//prix
		$box->angle_in($promo->prix_fhd_x,$promo->prix_fhd_y,'200','120',"",'',"",'',100,"","",'');
			if ($promo->pv_error!="")$box->angle('0','80','80','25',"",'',"",'',100,"<font size=4 color=grey><s>$promo->pv_error &euro;</s></font>","",'');
			if ($promo->pv_correct!="")$box->angle('40','20','150','60',"",'',"",'',100,"<font size =7>$promo->pv_correct &euro;</font>","",'');
		$box->angle_out('');

		//Les 3 cases dans les coins 
		$txt="$shop->nom<br></b>$shop->adresse_rue<br>$shop->adresse_cp $shop->adresse_ville<br>$shop->mail<br>".$sugar->show_call_formated($shop->call1);
		$box->angle('1520','35','300','150','',$promo->color,"","",90,"<font size =5>$txt</font>","",'');
		$box->angle('10','1024','230','37','',$promo->color,'','',90,"<font size =2>CETTE OFFRE EST SUSCEPTIBLE <br>D ETRE MODIFIE SANS PREAVIS</font>","",'');
	$box->angle_out('');
	}
else 
	{
	$box->angle('0','0','1920','1080',"",'',"img/promo/bground_screen/$promo->bground_fhd",'',100,"","",'');
	}

$box->angle('20','20','150','150',"",'black',"img/150px/logo/$shop->img_logo",'',100,"","index.php",'');
		
echo "<meta http-equiv='refresh' content='$timer; url='/>";
if(isset($_GET['load']))$box->angle('1790','1050','120','22',"red",'black',"",'',100,"<font size=2>".((microtime()-$mt_in)*1000)."Ms</font>","",'');
		
?>