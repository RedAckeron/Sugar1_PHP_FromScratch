<?php
echo "<body style='background-color:$sugar->background_color'>";
if($sugar->security_prm==0)$js->alert_redirect("No acces","index.php",0);
//on verifie si un ticket est renseigner sinon on est redirect sur la page lobby cmd
//if(($sub_system!='lobby')and(isset($_GET['id_prm'])))$id_prm=$_GET['id_prm'];
if(!isset($_GET['no_interface']))$sugar->promo_menu($system,$box);
if(isset($_GET['id_prm']))$promo->load($_GET['id_prm'],$sugar);
switch ($sub_system)
	{
######################################################################################################################
	case 'lobby':
		{
		$sugar->label="prm";
	
		$box->empty_in('','',1352,'20','grey','','','',100,"","",'');
			$box->angle('','',50,'20',"",'white','','',100,"Id","",'');
			$box->angle('','',150,'20','','white','','',100,"Type","",'');
			$box->angle('','',550,'20','','white','','',100,"Description promo","",'');
			$box->angle('','',100,'20','','white','','',100,"Qt item","",'');
			$box->angle('','',100,'20','','white','','',100,"Prix","",'');
			$box->angle('','',200,'20','','white','','',100,"Implantation ","",'');
			$box->angle('','',100,'20','','white','','',100,"Status","",'');
			$box->angle('','',100,'20','','white','','',100,"Audience","",'');
		$box->empty_out('');
		
		$cmmd_tmp=db_read("select * from cmd where status = 'open' and type='prm' and id_shop=0 order by titre;");
		while($cmmd = $cmmd_tmp->fetch())
			{
			$promo->load($cmmd->id,$sugar);
			$promo->show_line_promo_groupe($box,$js,$sugar);
			}
		};break;
######################################################################################################################
    case 'add_prm_grp':
		{
		$dt_in=time();
		$dt_out=0;
		db_write("insert into cmd (id_customer,type,titre,tech_in,dt_in,dt_out,status,id_shop)values('$sugar->shop_id','prm','Promo','$sugar->id','$dt_in','$dt_out','open','0');");
		//on recupere l id du ticket qu on viens de creez
		$chk_prm=db_single_read("select * from cmd order by id desc limit 1");
		db_write("insert into promo(id_odp)values('$chk_prm->id');");
		$sugar->admin_add_log($system,$sub_system,"Ajoute de la Promo Groupe $chk_prm->id",1);
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=promo/promo.groupe&sub_system=edit_promo&id_prm=$chk_prm->id'/>";
		};break;
######################################################################################################################
	case 'edit_promo':
		{
		//si la promo est un panneau pub on redirige au bonne endroit 
		if($promo->status=='SCREEN')echo "<meta http-equiv='refresh' content='0; url=index.php?system=promo/promo.pub_screen&sub_system=edit_screen&id_prm=$promo->id'/>";
		
		if($sugar->security_prm>1)promo_menu($sub_system,$promo->id,$box,$js);
		
		//affichage de la box info 
		$box->angle_in('20','50','1150','370','white','red','','',100,"","",'');
		echo "<iframe frameborder=0 src='index.php?system=promo/promo.groupe&sub_system=edit_info&id_prm=$promo->id&no_interface' width=100% height=100%></iframe>";
		$box->angle_out('');

		//affichage de la liste des item de la commande 
		$box->angle_in('20','433',1458,380,'white','red','','',100,"","",'');
		echo "<iframe frameborder=0 src='index.php?system=cmd/item.iframe&sub_system=show_item&id_cmd=$promo->id&no_interface' width=100% height=100%></iframe>";
		$box->angle_out('');
		if($sugar->security_prm<2)$box->angle('20','433',1458,380,'blue','','','',20,"","",'');
			
		//afficher info 
		$box->angle_in('1280','50','200','190','','steelblue','','',100,"Info promo","",'');
			echo "<li>Promo no : <br>";$form->text_disabled("","10","$promo->id");echo"</li>";
			//$form->hidden('id_ticket',$ticket->id);
			//$tech_in=db_single_read("select * from user where id=$ticket->tech_in");
			echo "<li>Ouvert par : ";$form->text_disabled("","20",$sugar->show_name_user($promo->tech_in));echo"</li>";
			echo "<li>Date ouverture : ";$form->text_disabled("","15",date("d/m/Y H:i",$promo->dt_in));echo"</li>";
			echo "<li>Status : ";$form->text_disabled("","15",$promo->status);echo"</li>";
		$box->angle_out('');
		
		//afficher les boutons
		$box->empty_in('1280','250',200,150,'','','','',100,"",'','');
			$promo->show_button($box,$sugar);
		$box->empty_out("");
		
		};break;
######################################################################################################################
	case 'edit_info':
		{
		if($sugar->security_prm>1)
			{
			$form->open("index.php?system=promo/promo.groupe&sub_system=update_info&id_prm=$promo->id&no_interface","POST");
			$form->textarea("info",'21','155',$promo->info);
			$form->send("Update");
			$form->close();
			}
		else $form->textarea_disabled("info",'21','155',$promo->info);
		};break;
######################################################################################################################
	case 'update_info':
		{
		if($sugar->security_prm>1)
			{
			db_write("update promo set info='".$_POST['info']."' where id_odp=$promo->id");
			echo"<meta http-equiv='refresh' content='0; url=index.php?system=promo/promo.groupe&sub_system=edit_info&id_prm=$promo->id&no_interface'/>";
			}
		else $js->alert_redirect("No acces","index.php",0);
		};break;
######################################################################################################################
	case 'edit_a4':
		{
		if($sugar->security_prm<2)$js->alert_redirect("No acces","index.php",0);
		if($sugar->security_prm>1)promo_menu($sub_system,$promo->id,$box,$js);
        
        //add item
        $box->angle_in("720","700",'300','60','green','black',"",'',100,"Add Item","",'');
        $chk_cnt_item=db_single_read("select count(*) as cnt from promo_item where id_odp=$promo->id and format='a4';");
        if($chk_cnt_item->cnt<10)
            {
            $form->open("index.php?system=promo/promo.groupe&sub_system=add_item&id_prm=$promo->id&no_interface","POST");
            $form->select_in('type_item',1);
                $chk_bg=db_single_read("select count(*) as cnt from promo_item where id_odp=$promo->id and format='a4' and type='bground';");
                if($chk_bg->cnt>0)$form->select_option_disabled('Background');
                else $form->select_option('Background','bground',$actuel);
                
                $chk_titre=db_single_read("select count(*) as cnt from promo_item where id_odp=$promo->id and format='a4' and type='titre';");
                if($chk_titre->cnt>0)$form->select_option_disabled('Titre');
                else $form->select_option('Titre','titre','');
                
                $chk_fiche=db_single_read("select count(*) as cnt from promo_item where id_odp=$promo->id and format='a4' and type='fiche';");
                if($chk_fiche->cnt>0)$form->select_option_disabled('Fiche');
                else $form->select_option('Fiche','fiche',$actuel);
                
                $chk_prix_ok=db_single_read("select count(*) as cnt from promo_item where id_odp=$promo->id and format='a4' and type='prix_ok';");
                if($chk_prix_ok->cnt>0)$form->select_option_disabled('Prix reel');
                else $form->select_option('Prix reel','prix_ok',$actuel);
                
                $chk_prix_ko=db_single_read("select count(*) as cnt from promo_item where id_odp=$promo->id and format='a4' and type='prix_ko';");
                if($chk_prix_ko->cnt>0)$form->select_option_disabled('Prix faux');
                else $form->select_option('Prix faux','prix_ko',$actuel);
                
                $chk_img=db_single_read("select count(*) as cnt from promo_item where id_odp=$promo->id and format='a4' and type='img';");
                if($chk_img->cnt>2)$form->select_option_disabled('Image');
                else $form->select_option('Image','img',$actuel);
            $form->select_out();
            $form->send('Add');
            $form->close();
            }
        else echo "Vous avez atteint le nombre d objet maximum";
        $box->angle_out(''); 
        
        
        
        
        /*
        $box->angle_in('10','50','900','780','','black','','',100,"","",'');
		//echo "<iframe width=100% height=100% frameborder=0 src='index.php?system=promo/a4.iframe&sub_system=edit_a4_img&id_prm=$promo->id&no_interface'></iframe>";
		$box->angle_out(".");

		$box->angle_in('920','20',((760*0.75)+2),((1080*0.75)+2),'','black','','',100,"","",'');
		//echo "<iframe width=100% height=100% frameborder=0 src='index.php?system=promo/a4.iframe&sub_system=preview_a4_print&id_prm=$promo->id&no_interface'></iframe>";
		$box->angle_out(".");
		/*
		$box->angle_in('40','750','400','27','red','black','','',100,"",'',"");
		    echo "<iframe frameborder=0 height=100% width=100% src='index.php?system=iframe/file.iframe&sub_system=select_file&size_file=300000&dir=img/promo/item/&no_interface'></iframe>";
		$box->angle_out("");
        */

		};break;
######################################################################################################################
	case 'edit_fhd':
		{
		if($sugar->security_prm<2)$js->alert_redirect("No acces","index.php",0);
		if($sugar->security_prm>1)promo_menu($sub_system,$promo->id,$box,$js);
		//preview
		$box->angle_in('720','50',((1920*0.4)+2),((1080*0.4)+2),'','black','','',100,"","",'');
		echo "<iframe width=100% height=100% frameborder=0 src='slideshow_v3.php?timer=0.3&id_shop=3&id_odp=$promo->id&coef=0.4&no_interface&loop_odp=1&debug'></iframe>";
		$box->angle_out(".");
		
		//show item
		$box->empty_in("10","50",'700','770','','',"",'',100,"","",'');
			$item_tmp=db_read("select * from promo_item where id_odp=$promo->id and format='fhd';");
			while($item = $item_tmp->fetch())
				{
				$box->angle_in("","",'350','152','grey','black',"",'',100,"","",'');
				echo "<iframe width=100% height=100% frameborder=0 src='index.php?system=promo/item.iframe&sub_system=edit_item&id_item=$item->id&id_prm=$promo->id&no_interface'></iframe>";
				$box->angle_out(''); 
				}
		$box->empty_out(''); 
	
        //add item
        $box->angle_in("720","490",'300','60','green','black',"",'',100,"Add Item","",'');
        $chk_cnt_item=db_single_read("select count(*) as cnt from promo_item where id_odp=$promo->id and format='fhd';");
        if($chk_cnt_item->cnt<10)
            {
            $form->open("index.php?system=promo/promo.groupe&sub_system=add_item&id_prm=$promo->id&no_interface","POST");
            $form->select_in('type_item',1);
                $chk_bg=db_single_read("select count(*) as cnt from promo_item where id_odp=$promo->id and format='fhd' and type='bground';");
                if($chk_bg->cnt>0)$form->select_option_disabled('Background');
                else $form->select_option('Background','bground',$actuel);
                
                $chk_titre=db_single_read("select count(*) as cnt from promo_item where id_odp=$promo->id and format='fhd' and type='titre';");
                if($chk_titre->cnt>0)$form->select_option_disabled('Titre');
                else $form->select_option('Titre','titre','');
                
                $chk_fiche=db_single_read("select count(*) as cnt from promo_item where id_odp=$promo->id and format='fhd' and type='fiche';");
                if($chk_fiche->cnt>0)$form->select_option_disabled('Fiche');
                else $form->select_option('Fiche','fiche',$actuel);
                
                $chk_prix_ok=db_single_read("select count(*) as cnt from promo_item where id_odp=$promo->id and format='fhd' and type='prix_ok';");
                if($chk_prix_ok->cnt>0)$form->select_option_disabled('Prix reel');
                else $form->select_option('Prix reel','prix_ok',$actuel);
                
                $chk_prix_ko=db_single_read("select count(*) as cnt from promo_item where id_odp=$promo->id and format='fhd' and type='prix_ko';");
                if($chk_prix_ko->cnt>0)$form->select_option_disabled('Prix faux');
                else $form->select_option('Prix faux','prix_ko',$actuel);
                
                $chk_img=db_single_read("select count(*) as cnt from promo_item where id_odp=$promo->id and format='fhd' and type='img';");
                if($chk_img->cnt>4)$form->select_option_disabled('Image');
                else $form->select_option('Image','img',$actuel);
            $form->select_out();
            $form->send('Add');
            $form->close();
            }
        else echo "Vous avez atteint le nombre d objet maximum";
        $box->angle_out(''); 

        //upload file item
        $box->angle('720','570','100','27','','black','Item : ','',100,"Item : ",'',"");
        $box->angle_in('820','570','400','27','red','black','','',100,"",'',"");
        echo "<iframe frameborder=0 height=100% width=100% src='index.php?system=iframe/file.iframe&sub_system=select_file&size_file=2000000&dir=img/promo/item/&no_interface'></iframe>";
        $box->angle_out("");
    	//upload file bground
		$box->angle('720','650','100','27','','black','Item : ','',100,"Bground : ",'',"");
        $box->angle_in('820','650','400','27','red','black','','',100,"",'',"");
		echo "<iframe frameborder=0 height=100% width=100% src='index.php?system=iframe/file.iframe&sub_system=select_file&size_file=2000000&dir=img/promo/bground_fhd/&no_interface'></iframe>";
		$box->angle_out("");



		};break;
######################################################################################################################
	case 'add_item':
		{
        $id_odp=$promo->id;
        $format='fhd';
        $type=$_POST['type_item'];
        switch ($type)
            {
            case 'bground':
                {
                $pos_x=0;$pos_y=0;
                $width=1920;$height=1080;
                $valeur='no_img.gif';
                $activated=1;
                };break;
            case 'titre':
                {
                $pos_x=mt_rand(0,1420);$pos_y=mt_rand(0,580);
                $width=500;$height=100;
                $valeur='Titre';
                $activated=1;
                };break;
            case 'fiche':
                {
                $pos_x=mt_rand(0,1420);$pos_y=mt_rand(0,580);
                $width=500;$height=400;
                $valeur='fiche';
                $activated=1;
                };break;
            case 'prix_ok':
                {
                $pos_x=mt_rand(0,1520);$pos_y=mt_rand(0,580);
                $width=300;$height=80;
                $valeur='Prix reel';
                $activated=1;
                };break;
            case 'prix_ko':
                {
                $pos_x=mt_rand(0,1520);$pos_y=mt_rand(0,580);
                $width=300;$height=80;
                $valeur='Prix faux';
                $activated=1;
                };break;
            case 'img':
                {
                $pos_x=mt_rand(0,1520);$pos_y=mt_rand(0,780);
                $width=300;$height=300;
                $valeur='no_img.gif';
                $activated=1;
                };break;
            }

		db_write("insert into promo_item (id_odp,format,type,pos_x,pos_y,width,height,valeur,activated)values('$id_odp','$format','$type','$pos_x','$pos_y','$width','$height','$valeur','$activated');");
       
        echo"<meta http-equiv='refresh' content='0; url=index.php?system=promo/promo.groupe&sub_system=edit_fhd&tab=edit_fhd&id_prm=$promo->id'/>";
		};break;
######################################################################################################################
	case 'edit_screen':
		{
		//on verifie si un ticket est renseigner sinon on est redirect sur la page lobby cmd
		if(isset($_GET['id_prm']))$id_prm=$_GET['id_prm'];
		else $js->alert_redirect("Pas de promo selectionner","index.php?system=cmd&sub_system=lobby",0);//message Url dalei avant redirect
		
		//on verifie si le ticket existe
		$chk_prm=db_single_read("select count(*) as cnt from cmd where id = '$id_prm'");
		if($chk_prm->cnt!=1)$js->alert_redirect("Se ticket n existe pas","index.php?system=prm&sub_system=lobby",0);//message Url dalei avant redirect
		
		$chk_prm=db_single_read("select count(*) as cnt from promo where id_odp = '$id_prm'");
		if($chk_prm->cnt==0)db_write("insert into promo(id_odp,bground,img0,img1,img2,img3,img4,img5,img6)values('$id_prm','dotted.gif','no_img.gif','no_img.gif','no_img.gif','no_img.gif','no_img.gif','no_img.gif','no_img.gif');");
		
		$promo=db_single_read("select * from promo where id_odp = $id_prm");
		
		if($sugar->security_prm>1)
			{
			$box->angle_in('30','30','960','540','white','steelblue',"",'',100,"","index.php?system=promo&sub_system=select_screen&id_prm=$id_prm",'');
			echo "<img src='img/promo/bground_screen/$promo->bground_fhd' width=100%></img>";
			$box->angle_out('');
			}
		else 
			{
			$box->angle_in('30','30','960','540','white','steelblue',"",'',100,"","",'');
			echo "<img src='img/promo/bground_screen/$promo->bground_fhd' width=100%></img>";
			$box->angle_out('');
			}
		};break;
######################################################################################################################
	case 'edit_fiche':
		{
		if($sugar->security_prm<2)$js->alert_redirect("No acces","index.php",0);
		if($sugar->security_prm>1)promo_menu($sub_system,$promo->id,$box,$js);
		//$prm=db_single_read("select * from promo where id_odp = $promo->id");
		$form->open("index.php?system=promo/promo.groupe&sub_system=update_fiche&id_prm=$promo->id&no_interface","POST");
		$box->angle_in('10','50','532','360','','black','','',100,"","",'');
			$box->angle_in('0','0','140','350','','','','',100,"","",'');
				$box->angle('','','138','22','','','','',100,"Id Promo : ","",'');
				$box->angle('','','138','22','','','','',100,"Date creation : ","",'');
				$box->angle('','','138','22','','','','',100,"Text Color : ","",'');
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
				$form->text_disabled('id',45,$promo->id);
				$form->text_disabled('titre',45,date("d/m/Y H:i",$promo->dt_in));
				$form->text('color',45,$promo->color);
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
		};break;
######################################################################################################################
	case 'update_fiche':
		{
		$color=$_POST['color'];
		$titre=$_POST['titre'];
		$text_libre=nl2br($_POST['text_libre']);
		$cpu=$_POST['cpu'];
		$mem=$_POST['mem'];
		$hdd=$_POST['hdd'];
		$gfx=$_POST['gfx'];
		$os=$_POST['os'];
		$pv_error=$_POST['pv_error'];
		$pv_correct=$_POST['pv_correct'];
		$rqt="update promo set color='$color',titre='$titre',text_libre='$text_libre',cpu='$cpu',mem='$mem',hdd='$hdd',gfx='$gfx',os='$os',prix_ko='$pv_error',prix_ok='$pv_correct' where id_odp=$promo->id;";
		$rqt.="update cmd set titre='$titre' where id = $promo->id;";
		db_write($rqt);
		echo"<meta http-equiv='refresh' content='0; url=index.php?system=promo/promo.groupe&sub_system=edit_fiche&tab=edit_fiche&id_prm=$promo->id'/>";
		};break;
######################################################################################################################
	case 'duplicate_odp':
		{
		$promo->clone_to_odp();
		};break;
######################################################################################################################
	case 'del_prm_grp':
		{
		$promo->delete();
		$sugar->admin_add_log($system,$sub_system,"Destruction de la promo Groupe $promo->id",3);
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=promo/promo.groupe&sub_system=lobby'/>";
		};break;
######################################################################################################################
	case 'open_odp':
		{
		$id_odp=$_GET['id_odp'];
		db_write("update cmd set status='open' where id = $id_odp");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=odp&sub_system=edit_odp&id_odp=$id_odp'/>";
		};break;
######################################################################################################################
	case 'swap_status':
		{
		if($sugar->security_prm>1)
			{
			$status=db_single_read("select * from promo where id_odp = $promo->id");
			if ($status->status=='on')db_write("update promo set status = 'off' where id_odp = $promo->id");
			else db_write("update promo set status = 'on' where id_odp = $promo->id");
			echo "<meta http-equiv='refresh' content='0; url=index.php?system=promo/promo.groupe'/>";
			}
		else $js->redirect("T'as pas le niveau !!!","",0);
		};break;
######################################################################################################################
	case 'duplicate_promo_to_odp':
		{
		if($customer->id!=0)
			{
			$offre=db_single_read("select * from cmd where id = $promo->id");
			db_write("insert into cmd (id_customer,type,titre,tech_in,dt_in,dt_out,status,id_shop)values('$customer->id','odp','$offre->titre','$sugar->id','".time()."','".(time()+604800)."','open','$sugar->shop_id');");
			$chk_offre=db_single_read("select * from cmd order by id desc limit 1");
			$rqt='';
			$offre_item_tmp=db_read("select * from cmd_item where id_cmd = $promo->id");
			while($offre_item = $offre_item_tmp->fetch())
				{
				$rqt.="insert into cmd_item (id_cmd,nom,fournisseur,url_item,qt,prix_achat,marge,prix_vente)values('$chk_offre->id','$offre_item->nom','$offre_item->fournisseur','$offre_item->url_item','$offre_item->qt','$offre_item->prix_achat','$offre_item->marge','$offre_item->prix_vente');";
				}
			db_write("$rqt");
			echo "<meta http-equiv='refresh' content='0; url=index.php?system=odp&sub_system=edit_odp&id_odp=$chk_offre->id'/>";
			}
		else $js->alert_redirect("Vous devez avoir un client actif pour dupliquer une offre.","index.php?system=customer",0);
		};break;
######################################################################################################################
	case 'print_odp_internal':
		{
		$odp->load($_GET['id_odp']);
		$box->angle_in('0','0','800','1120','','black','','',100,'','','');
		
		//affichage de l entete
		$box->box_rond_in(40,20,152,152,'','black','','',100,'','','');
			echo "<img src='img/150px/$odp->shop_logo'></img>";
		$box->box_rond_out('');
		
		//affichage du no de ticket 
		$box->angle(250,20,300,25,'','black','','',100,"<font size=3>Offre de prix no : </b>$odp->id</font>",'','');
		//affichage de la date
		$box->angle(570,20,200,25,'','black','','',100,"<font size=3>Date : </b>".date("d/m/Y G:i",$odp->dt_in)."</font>",'','');
		//affichage du nom du client 
		$box->angle(250,55,520,25,'','black','','',100,"<font size=3>Nom : </b>".$odp->prenom." ".$odp->nom."</font>",'','');
		//affichage du Tel1
		$box->angle(250,90,240,25,'','black','','',100,"<font size=3>Tel :</b> $odp->call1</font>",'','');
		$box->angle(530,90,240,25,'','black','','',100,"<font size=3>Tel :</b> $odp->call2</font>",'','');
		//email
		$box->angle(250,125,520,25,'','black','','',100,"<font size=3>Email : $odp->mail</font>",'','');
		

		//affichage du menu des colonnes
		$grand_total_vente=0;
		$grand_total_achat=0;
		//cadre complet
		$box->angle_in('10','200',772,900,'','','','',100,"","",'');
			$box->angle_in('','',770,62,'lightgrey','black','','',100,"","",'');
				$box->angle('0','0',500,20,'lightgreen','black','','',100,"</b>Nom Item","",'');//item
				$box->angle('0','20',400,20,'lightgreen','black','','',100,"</b>Fournisseur","",'');//item
				$box->angle('0','40',768,20,'lightgreen','black','','',100,"</b>Url item","",'');//item
				
				
				$box->angle('500','0',150,20,'lightgreen','black','','',100,"</b>Prix achat","",'');
				$box->angle('500','20',150,20,'lightgreen','black','','',100,"</b>Prix vente","",'');

				$box->angle('400','20',100,20,'lightgreen','black','','',100,"</b>Quantite","",'');
				$box->angle('650','0',118,20,'lightgreen','black','','',100,"</b>Prix total achat","",'');
				$box->angle('650','20',118,20,'lightgreen','black','','',100,"</b>Prix total vente","",'');
			$box->angle_out('');
			$box->angle('','',770,20,'white','','','',100,".","",'');//espace entre ligne
		//affichage des collones
		$cmd_item_tmp=db_read("select * from cmd_item where id_cmd = $odp->id");
		while($cmd_item = $cmd_item_tmp->fetch())
			{
			$prix_achat=$cmd_item->prix_achat;
			$prix_ttl_achat=$prix_achat*$cmd_item->qt;
			$grand_total_achat+=$prix_ttl_achat;
			
			$prix_vente=$cmd_item->prix_vente;
			$prix_ttl_vente=$prix_vente*$cmd_item->qt;
			$grand_total_vente+=$prix_ttl_vente;

			$box->angle_in('','',770,62,'lightgrey','black','','',100,"","",'');
				$box->angle('0','0',500,20,'','black','','',100,"Item : </b>$cmd_item->nom","",'');//item
				$box->angle('0','20',400,20,'','black','','',100,"Fournisseur : </b>$cmd_item->fournisseur","",'');//item
				$box->angle('0','40',768,20,'lightgreen','black','','',100,"</b>$cmd_item->url_item","",'');//item
				
				
				$box->angle('500','0',150,20,'','black','','',100,"</b>$prix_achat &euro;","",'');
				$box->angle('500','20',150,20,'','black','','',100,"</b>$prix_vente &euro;","",'');

				$box->angle('400','20',100,20,'','black','','',100,"</b>$cmd_item->qt","",'');
				$box->angle('650','0',118,20,'','black','','',100,"</b>$prix_ttl_achat &euro;","",'');
				$box->angle('650','20',118,20,'','black','','',100,"</b>$prix_ttl_vente &euro;","",'');
			$box->angle_out('');
			$box->angle('','',770,20,'white','','','',100,".","",'');//espace entre ligne
			}
			//affichage du total
			$box->angle_in('','',770,50,'','','','',100,"","",'');
				$box->angle('450','0',300,20,'orange','black','','',100,"Prix achat total : $grand_total_achat &euro;","",'');
				$box->angle('450','20',300,20,'lightgreen','black','','',100,"Prix de vente client : $grand_total_vente &euro;","",'');
			$box->angle_out('');
			//fin cadre principal
			$box->angle_out('');
		
			$box->angle_out('');
		
			echo "<meta http-equiv='refresh' content='10; url=index.php?system=odp&sub_system=close_page'/>";
			
			echo "<body onload='window.print();window.close()'>";
		};break;
######################################################################################################################
	case 'print_promo_item':
		{
		include('../../www_off/sugar/obj/print.obj.php');
		if(!isset($print))$print=new _print;
		$print->header($box,$system,$promo->id,$sugar);
		
		$grand_total_vente=0;
		$grand_total_achat=0;
		//ligne menu 
		$box->angle_in('','',738,22,'lightgreen','','','',100,"","",'');
			$box->angle('','',486,20,'','green','','',100,"Description","",'');
			$box->angle('','',100,20,'lightgreen','green','','',100,"Prix","",'');
			$box->angle('','',50,20,'lightgreen','green','','',100,"Qt","",'');
			$box->angle('','',100,20,'lightgreen','green','','',100,"Prix total","",'');
		$box->angle_out('');
		
		$cmd_item_tmp=db_read("select * from cmd_item where id_cmd = $promo->id");
		while($cmd_item = $cmd_item_tmp->fetch())
			{
			$box->angle_in('','',738,22,'','','','',100,"","",'');
				$box->angle('','',486,20,'','green','','',100,"</b>$cmd_item->nom","",'');//item
				$prix_vente=$cmd_item->prix_vente;
				$box->angle('','',100,20,'','green','','',100,"</b>$prix_vente &euro;","",'');
				$box->angle('','',50,20,'','green','','',100,"</b>$cmd_item->qt","",'');
				$prix_ttl=$prix_vente*$cmd_item->qt;
				$box->angle('','',100,20,'','green','','',100,"</b>$prix_ttl &euro;","",'');
			$box->angle_out('');
			$grand_total_vente+=$prix_ttl;
			}
		//affichage du total
		$box->angle_in('','',738,22,'','','','',100,"","",'');
			$box->angle('','',536,20,'','','','',100,"","",'');
			$box->angle('','',100,20,'','','','',100,"Total : ","",'');
			$box->angle('','',100,20,'','red','','',100,"$grand_total_vente &euro;","",'');
		$box->angle_out('');
		
		$box->angle('480','755',250,25,'','black','','',100,"Cette offre est valable 24h","",'');
		
		$print->footer($box,$sugar);
		echo "<body onload='window.print();window.close()'>";
		
		};break;
######################################################################################################################
	case 'print_promo':
		{
		//$id_prm=$_GET['id_prm'];
		$promo=db_single_read("select * from promo where id_odp = $promo->id");
		$titre=$promo->titre;
		$text_libre=$promo->text_libre;
		$cpu="Processeur : ".$promo->cpu;
		$mem="Memoire : ".$promo->mem;
		$hdd="Disque dur : ".$promo->hdd;
		$gfx="Graphique : ".$promo->gfx;
		$os="OS : ".$promo->os;
		$pv_error="".$promo->pv_error;
		$pv_correct="".$promo->pv_correct;
		$bground="img/promo/bground_a4/$promo->bground_a4";
		$img0="img/promo/img0/".$promo->img0_a4;
		$img1="img/promo/img1/".$promo->img1_a4;
		$img2="img/promo/img2/".$promo->img2_a4;
		$img3="img/promo/img3/".$promo->img3_a4;
		$img4="img/promo/img4/".$promo->img4_a4;
		$img5="img/promo/img5/".$promo->img5_a4;
		$img6="img/promo/img6/".$promo->img6_a4;
		
		$box->angle_in('0','0','760','1080',"",'black',"$bground",'',100,"","",'');
		
			//img0
			if($promo->img0_a4!='no_img.gif')
				{
				$box->empty_in($promo->img0_a4_x,$promo->img0_a4_y,'200','200',"",'','','',100,"","",'');
				echo "<img src='$img0' width=200px></img>";
				$box->empty_out(".");
				}
			//img1
			if($promo->img1_a4!='no_img.gif')
				{
				$box->empty_in($promo->img1_a4_x,$promo->img1_a4_y,'100','100',"",'','','',100,"","",'');
				echo "<img src='$img1' width=100px></img>";
				$box->empty_out(".");
				}
			//img2
			if($promo->img2_a4!='no_img.gif')
				{
				$box->empty_in($promo->img2_a4_x,$promo->img2_a4_y,'100','100',"",'',$img2,'',100,"","",'');
				echo "<img src='$img2' width=100px></img>";
				$box->empty_out(".");
				}
			//img3
			if($promo->img3_a4!='no_img.gif')
				{
				$box->empty_in($promo->img3_a4_x,$promo->img3_a4_y,'100','100',"",'',$img3,'',100,"","",'');
				echo "<img src='$img3' width=100px></img>";
				$box->empty_out(".");
				}
			//img4
			if($promo->img4_a4!='no_img.gif')
				{
				$box->empty_in($promo->img4_a4_x,$promo->img4_a4_y,'100','100',"",'',$img4,'',100,"","",'');
				echo "<img src='$img4' width=100px></img>";
				$box->empty_out(".");
				}
			//img5
			if($promo->img5_a4!='no_img.gif')
				{
				$box->empty_in($promo->img5_a4_x,$promo->img5_a4_y,'100','100',"",'',$img5,'',100,"","",'');
				echo "<img src='$img5' width=100px></img>";
				$box->empty_out(".");
				}
			//img6
			if($promo->img6_a4!='no_img.gif')
				{
				$box->empty_in($promo->img6_a4_x,$promo->img6_a4_y,'200','200',"",'',$img6,'',100,"","",'');
				echo "<img src='$img6' width=100px></img>";
				$box->empty_out(".");
				}
			
			$box->angle_in($promo->prix_a4_x,$promo->prix_a4_y,'110','60',"",'',"",'',100,"","",'');
			//prix_faux
			$box->angle('0','0','50','25',"",'',"",'',100,"<font size = 4 color=grey></b><s>$pv_error &euro;</s></font>","",'');
			//prix_correct
			$box->angle('20','15','80','40',"",'',"",'',100,"<font size =6>$pv_correct &euro;</font>","",'');
			$box->angle_out(".");

			//Titre
			$box->angle($promo->titre_a4_x,$promo->titre_a4_y,'450','40','','','','',100,"<font size=6>$titre</font>","",'');
			//info technique 
			$box->angle_in($promo->fiche_a4_x,$promo->fiche_a4_y,'480','400','','','','',100,"<font size=5></b><u>Caracteristique technique</u></b></center></font>","",'');
			echo "<font size=5><li>$cpu</li>";
			echo "<li>$mem</li>";
			echo "<li>$hdd</li>";
			echo "<li>$gfx</li>";
			echo "<li>$os</li>";
			echo "<br><center>$text_libre</center></font>";
			$box->angle_out('');
			//LOGO SHOP
			//$box->angle('20','20','150','150',"",'black',"img/150px/$sugar->shop_logo",'',100,"","",'');
			//ADRESSE SHOP
			$txt="$sugar->shop_name<br>$sugar->shop_adresse1<br>$sugar->shop_adresse2<br>$sugar->shop_mail<br>".$sugar->show_call_formated($sugar->shop_call);
			$box->angle('520','970','200','100','white','black',"","",70,"$txt","",'');
			//AVERTISSEMENT
			$box->angle('10','1024','230','37',"white",'black','','',80,"<font size =2>CETTE OFFRE EST SUSCEPTIBLE <br>D ETRE MODIFIE SANS PREAVIS</font>","",'');

		$box->angle_out('');
		
		echo "<body onload='window.print();window.close()'>";

		};break;
######################################################################################################################
	case 'close_page':
		{
		echo "<body onload='window.close()'>";
		}
	}
######################################################################################################################  FUNCION MENU PROMO
function promo_menu($sub_system,$id_prm,$box,$js)
	{
	if(!isset($_GET['no_interface']))
		{
		$box->empty_in("","",'1480','20','','',"",'',100,"","",'');
			
		//on verifie si le ticket existe
		$chk_prm=db_single_read("select count(*) as cnt from cmd where id = '$id_prm'");
		if($chk_prm->cnt!=1)$js->alert_redirect("Se ticket n existe pas","index.php?system=promo&sub_system=lobby",0);//message Url dalei avant redirect
		$chk_prm=db_single_read("select count(*) as cnt from promo where id_odp = '$id_prm'");
		if($chk_prm->cnt==0)db_write("insert into promo(id_odp,bground,img0,img1,img2,img3,img4,img5,img6)values('$id_prm','dotted.gif','no_img.gif','no_img.gif','no_img.gif','no_img.gif','no_img.gif','no_img.gif','no_img.gif');");
	
		//menu tab
		if(isset($_GET['tab']))$tab=$_GET['tab'];
		else $tab='lobby';
	
		if($tab=='lobby')$box->box_rond('','','150','20','cyan','lightgrey','','',100,"Lobby","",'');
		else $box->box_rond('','','150','20','grey','lightgrey','','',100,"Lobby","index.php?system=promo/promo.groupe&sub_system=edit_promo&tab=lobby&id_prm=$id_prm",'');

		if($tab=='edit_fiche')$box->box_rond('','','150','20','cyan','lightgrey','','',100,"Fiche","",'');
		else $box->box_rond('','','150','20','grey','lightgrey','','',100,"Fiche","index.php?system=promo/promo.groupe&sub_system=edit_fiche&tab=edit_fiche&id_prm=$id_prm",'');

		if($tab=='edit_a4')$box->box_rond('','','150','20','cyan','lightgrey','','',100,"Edit A4","",'');
		else $box->box_rond('','','150','20','grey','lightgrey','','',100,"Edit A4","index.php?system=promo/promo.groupe&sub_system=edit_a4&tab=edit_a4&id_prm=$id_prm",'');

		if($tab=='edit_fhd')$box->box_rond('','','150','20','cyan','lightgrey','','',100,"Edit FHD","",'');
		else $box->box_rond('','','150','20','grey','lightgrey','','',100,"Edit FHD","index.php?system=promo/promo.groupe&sub_system=edit_fhd&tab=edit_fhd&id_prm=$id_prm",'');
		$box->empty_out('');
		}
	}
?>