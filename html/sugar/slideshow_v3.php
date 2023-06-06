<?php
session_start();
include('../../www_off/sugar/obj/slideshow.obj.php');
if(!isset($slideshow))$slideshow=new _slideshow;
if (isset($_SESSION['slideshow']))$slideshow=unserialize($_SESSION['slideshow']);

include('../../www_off/sugar/obj/sugar.obj.php');
if(!isset($sugar))$sugar=new _sugar;
if (isset($_SESSION['sugar']))$sugar=unserialize($_SESSION['sugar']);

if(isset($_GET['debug']))$slideshow->debug=$_GET['debug'];
//debut du calclul de charge
if($slideshow->debug==1)$mt_in=microtime();
if(isset($_GET['timer']))$slideshow->timer=$_GET['timer'];
if(isset($_GET['coef']))$slideshow->coef=$_GET['coef'];
if(isset($_GET['shop_id']))$slideshow->shop_id=$_GET['shop_id'];
if(isset($_GET['id_odp']))$slideshow->id_odp=$_GET['id_odp'];
if(isset($_GET['loop_odp']))$slideshow->loop_odp=$_GET['loop_odp'];

include('../../www_off/sugar/dll/dll_db.php');
include('../../www_off/sugar/obj/box.obj.php');
$box=new _box;
$color="";
$slideshow->load($sugar);

$item_tmp=db_read("select * from promo_item where id_odp=$slideshow->id_odp and format='fhd';");
while($item = $item_tmp->fetch())
	{
	if($item->pos_x!=0)$posx=($item->pos_x*$slideshow->coef);else $posx=0;
	if($item->pos_y!=0)$posy=($item->pos_y*$slideshow->coef);else $posy=0;
	$width=($item->width*$slideshow->coef);
	$height=($item->height*$slideshow->coef);
	//on affiche que se qu on trouve dans la db a propos de cette Promo
	switch ($item->type)
		{
		case 'bground':
			{
            if($item->activated==1)
                {
                $width=($item->width*$slideshow->coef);
                $height=($item->height*$slideshow->coef);
                $box->empty_in("0","0","$width","$height","","","",'',100,"","",'');
                if($slideshow->odp_status=='SCREEN')
                    {
                    echo "<img src='img/promo/bground_screen/$item->valeur' width=$width height=$height></img>";
                    }
                else 
                    {
                    echo "<img src='img/promo/bground_fhd/$item->valeur' width=$width height=$height></img>";
                    //img/promo/bground_fhd/$item->valeur
                    }
                $box->empty_out(".");
                //echo "<img src='img/promo/bground_screen/$item->valeur' width=$width px height=$height px></img>";
                //else echo "<img src='img/promo/bground_fhd/$item->valeur' width=$width px height=$height px></img>";
                //$box->empty_out(".");
                }
            };break;
        case 'fiche':
			{
            if($item->activated==1)
                {
                if($slideshow->debug==1)$debug_color="red";
                else $debug_color="";
                if(($slideshow->cpu!="")or($slideshow->mem!="")or($slideshow->hdd!="")or($slideshow->gfx!="")or($slideshow->os!=""))
                    {
                    $text_size="5";
                    if($slideshow->coef!=1)$text_size=round($text_size*=$slideshow->coef);
                    $box->angle_in("$posx","$posy","$width","$height","","$debug_color","",'',100,"","",'');
                        echo "<font size=".($text_size+1)." color=$slideshow->color></b><u>Caracteristique technique</u></b></center></font>";
                        echo"<br><font size=$text_size color=$slideshow->color><li>Processeur : $slideshow->cpu</font></li>";
                        echo"<br><font size=$text_size color=$slideshow->color><li>Memoire : $slideshow->mem</font></li>";
                        echo"<br><font size=$text_size color=$slideshow->color><li>Disque dur : $slideshow->hdd</font></li>";
                        echo"<br><font size=$text_size color=$slideshow->color><li>Graphique : $slideshow->gfx</font></li>";
                        echo"<br><font size=$text_size color=$slideshow->color><li>Os : $slideshow->os</font></li>";
                        echo"<br><font size=$text_size><center>$slideshow->text_libre</font></center>";
                    $box->angle_out(".");
                    }
                }
			};break;
		case 'titre':
			{
            if($item->activated==1)
                {
                if($slideshow->debug==1)$debug_color="green";
                else $debug_color="";
                $titre_size="20";
                if($slideshow->coef!=1)$titre_size=round($titre_size*=$slideshow->coef);
                $box->angle("$posx","$posy","$width","$height","","$debug_color","",'',100,"<font size=$titre_size color=$slideshow->color>$slideshow->titre</font>","",'');
                }
			};break;
		case 'prix_ok':
			{
            if($item->activated==1)
                {
                if($slideshow->debug==1)$debug_color="orange";
                else $debug_color="";
                
                //if(isset($_GET['debug']))$color="steelblue"; 
                $titre_size="6";
                if($slideshow->coef!=1)round($titre_size*=$slideshow->coef);
                $box->angle("$posx","$posy","$width","$height","","$debug_color","",'',100,"<font size=$titre_size color=$slideshow->color>$slideshow->prix_ok €</font>","",'');
                }
			};break;
		case 'prix_ko':
			{
            if($item->activated==1)
                {
                if($slideshow->debug==1)$debug_color="pink";
                else $debug_color="";
                if(isset($_GET['debug']))$color="lightgrey"; 
                $titre_size="5";
                if($slideshow->coef!=1)round($titre_size*=$slideshow->coef);
                $box->angle("$posx","$posy","$width","$height","","$debug_color","",'',100,"<font size=$titre_size color=grey><s>$slideshow->prix_ko €</s></font>","",'');
                }
			};break;
		case 'img':
			{
            if($item->activated==1)
                {
                $box->empty_in("$posx","$posy","$width","$height","$color",'',"",'',100,"","",'');
                echo "<img src='img/promo/item/$item->valeur' width=$width px height=$height px></img>";
                $box->empty_out(".");
                }
            };break;
		}
	}

if($slideshow->odp_status!='SCREEN')
	{
	//adresse du magasin 
	$x=(1600*$slideshow->coef);
	$y=(20*$slideshow->coef);
	$width=(300*$slideshow->coef);
	$height=(150*$slideshow->coef);
	$titre_size="5";
	if($slideshow->coef!=1)$titre_size=round($titre_size*=$slideshow->coef);
	//$txt="$shop->nom<br></b>$shop->adresse_rue<br>$shop->adresse_cp $shop->adresse_ville<br>$shop->mail<br>".$sugar->show_call_formated($shop->call1);
	$box->angle("$x","$y","$width","$height","$color","$slideshow->color","","",100,"<font size =$titre_size color=$slideshow->color>$slideshow->shop_adresse</font>","",'');
	
	//message avertissement
	$x=(20*$slideshow->coef);
	$y=(1024*$slideshow->coef);
	$width=(250*$slideshow->coef);
	$height=(40*$slideshow->coef);
	$titre_size="2";
	if($slideshow->coef!=1)$titre_size=round($titre_size*=$slideshow->coef);
	$box->angle("$x","$y","$width","$height","","$slideshow->color",'','',100,"<font size=$titre_size color=$slideshow->color>CETTE OFFRE EST SUSCEPTIBLE <br>D ETRE MODIFIE SANS PREAVIS</font>","",'');
	}
/*
$x=(1790*$slideshow->coef);
$y=(1050*$slideshow->coef);
$width=(120*$slideshow->coef);
$height=(22*$slideshow->coef);
$titre_size="2";
if($slideshow->coef!=1)$titre_size=round($titre_size*=$slideshow->coef);
*/


$logo_loc=(20*$slideshow->coef);
$logo_size=(150*$slideshow->coef);
if($slideshow->debug==1)
	{
	//logo magasin
	
	$box->angle_in("$logo_loc","$logo_loc","$logo_size","$logo_size","",'black',"",'',100,"","slideshow_v3.php?debug=0",'');
	echo "<img src='img/150px/logo/$slideshow->shop_logo' width=100% height=100%></img>";
	$box->angle_out(".");
	//Menu debug
	$box->empty_in("20","180","300","830","",'',"",'',100,"","",'');
	//id_prm
		$box->angle("","","300","10","",'',"",'',100,"","",'');
		$box->angle("","","300","20","white",'black',"",'',100,"</b><font size=3>Id : $slideshow->id_odp</font>","",'');
	//Loop odp
		$box->angle("","","300","10","",'',"",'',100,"","",'');
		if ($slideshow->loop_odp==0)$box->angle("","","300","20","lightgreen",'black',"",'',100,"</b><font size=3>Stop loop (OFF)</font>","slideshow_v3.php?loop_odp=1",'');
		else $box->angle("","","300","20","lightgreen",'black',"",'',100,"</b><font size=3>Stop loop (ON)</font>","slideshow_v3.php?loop_odp=0",'');
	//charge server
		$box->angle("","","300","10","",'',"",'',100,"","",'');
		$box->angle("","","300","20","white",'black',"",'',100,"</b><font size=3>Load : ".round(((microtime()-$mt_in)*1000),1)."Ms</font>","",'');
				
	//Coef
		$box->angle("","","300","10","",'',"",'',100,"","",'');
		$box->angle("","","300","20","white",'black',"",'',100,"</b><font size=3>Coef ($slideshow->coef)</font>","index.php",'');
		$box->angle("","","30","20","lightgreen",'black',"",'',100,"</b><font size=3>0.2</font>","slideshow_v3.php?coef=0.2",'');
		$box->angle("","","30","20","lightgreen",'black',"",'',100,"</b><font size=3>0.4</font>","slideshow_v3.php?coef=0.4",'');
		$box->angle("","","30","20","lightgreen",'black',"",'',100,"</b><font size=3>0.6</font>","slideshow_v3.php?coef=0.6",'');
		$box->angle("","","30","20","lightgreen",'black',"",'',100,"</b><font size=3>0.8</font>","slideshow_v3.php?coef=0.8",'');
		$box->angle("","","30","20","lightgreen",'black',"",'',100,"</b><font size=3>1</font>","slideshow_v3.php?coef=1",'');
	
	//Timer
		$box->angle("","","300","10","",'',"",'',100,"","",'');
		$box->angle("","","300","20","white",'black',"",'',100,"</b><font size=3>Timer ($slideshow->timer)</font>","index.php",'');
		$box->angle("","","30","20","lightgreen",'black',"",'',100,"</b><font size=3>0.3</font>","slideshow_v3.php?timer=0.3",'');
		$box->angle("","","30","20","lightgreen",'black',"",'',100,"</b><font size=3>0.6</font>","slideshow_v3.php?timer=0.6",'');
		$box->angle("","","30","20","lightgreen",'black',"",'',100,"</b><font size=3>1</font>","slideshow_v3.php?timer=1",'');
		$box->angle("","","30","20","lightgreen",'black',"",'',100,"</b><font size=3>5</font>","index.php",'');
		$box->angle("","","30","20","lightgreen",'black',"",'',100,"</b><font size=3>10</font>","index.php",'');
		$box->angle("","","30","20","lightgreen",'black',"",'',100,"</b><font size=3>15</font>","index.php",'');
		$box->angle("","","30","20","lightgreen",'black',"",'',100,"</b><font size=3>30</font>","index.php",'');
	
	//Shop
		$box->angle("","","300","10","",'',"",'',100,"","",'');
		$box->angle("","","300","20","white",'black',"",'',100,"</b><font size=3>Shop ($slideshow->shop_id)</font>","index.php",'');
		
		$shop_tmp=db_read("select * from shop where id !=0;");
		while($shop = $shop_tmp->fetch())
			{
			$box->angle("","","30","20","lightgreen",'black',"",'',100,"</b><font size=2>$shop->id</font>","slideshow_v3.php?shop_id=$shop->id",'');
			}
	//reset
	$box->angle("","","300","10","",'',"",'',100,"","",'');
	$box->angle("","","300","20","lightgreen",'black',"",'',100,"</b><font size=3>Reset</font>","slideshow_v3.php?loop_odp=0&coef=1&timer=15",'');
	
	//exit
	$box->angle("","","300","10","",'',"",'',100,"","",'');
	$box->angle("","","300","20","lightgreen",'black',"",'',100,"</b><font size=3>Exit</font>","index.php",'');
	
	//objet slideshow
		$box->angle("","","150","10","",'',"",'',100,"","",'');
		$box->angle_in("","","300","520","white",'black',"",'',80,"","",'');
		echo "<pre><font size=3>";
		print_r($slideshow);
		echo "</font></pre>";
		$box->angle_out(".");
	$box->empty_out(".");
	$box->empty_in("20","1020","1880","40","",'',"",'',80,"","",'');
		$all_prm_tmp=db_read("select * from promo;");
		while($all_prm = $all_prm_tmp->fetch())
			{
			$box->angle("","","40","20","lightgreen",'black',"",'',100,"$all_prm->id_odp","slideshow_v3.php?id_odp=$all_prm->id_odp&timer=1&loop_odp=1",'');
			}
	$box->empty_out(".");
	}
else 
	{
	//logo magasin
	$box->angle_in("$logo_loc","$logo_loc","$logo_size","$logo_size","",'black',"",'',100,"","slideshow_v3.php?debug=1",'');
	echo "<img src='img/150px/logo/$slideshow->shop_logo' width=100% height=100%></img>";
	$box->angle_out(".");
    }
echo "<meta http-equiv='refresh' content='$slideshow->timer; url=slideshow_v3.php'/>";
if (isset($slideshow))$_SESSION['slideshow']=serialize($slideshow);
##########################################################################################


?>