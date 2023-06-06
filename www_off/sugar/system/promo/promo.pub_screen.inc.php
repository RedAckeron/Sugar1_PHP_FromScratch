<?php
echo "<body style='background-color:$sugar->background_color'>";
if($sugar->security_prm==0)$js->alert_redirect("No acces","index.php",0);
//on verifie si un ticket est renseigner sinon on est redirect sur la page lobby cmd
if(($sub_system!='lobby')and(isset($_GET['id_prm'])))$id_prm=$_GET['id_prm'];
else $id_prm="100";
$sugar->promo_menu($system,$box);
//promo_menu($sub_system,$id_prm,$box,$js);
switch ($sub_system)
	{
######################################################################################################################
	case 'lobby':
		{
		$sugar->label="prm";
		
		$box->angle_in('','',1252,'23','#d35afd','black','','',100,"","",'');
			$box->angle('','',50,'20',"",'lightgrey','','',100,"Id","",'');
			$box->angle('','',150,'20','','lightgrey','','',100,"Type","",'');
			$box->angle('','',550,'20','','lightgrey','','',100,"Description promo","",'');
			$box->angle('','',100,'20','','lightgrey','','',100,"Qt item","",'');
			$box->angle('','',100,'20','','lightgrey','','',100,"Prix","",'');
			$box->angle('','',200,'20','','lightgrey','','',100,"Implantation ","",'');
			$box->angle('','',100,'20','','lightgrey','','',100,"Status","",'');
		$box->angle_out('');
	
		$cmmd_tmp=db_read("select * from cmd where status = 'SCREEN' and type='prm' and id_shop=0 order by id_shop,titre;");
		while($cmmd = $cmmd_tmp->fetch())
			{
			$promo->load($cmmd->id,$sugar);
			$promo->show_line_pub_screen($box,$js,$sugar);
			}

		//upload file 
		$box->angle_in('1050','800','400','27','red','black','','',100,"",'',"");
		echo "<iframe frameborder=0 height=100% width=100% src='index.php?system=iframe/file.iframe&sub_system=select_file&size_file=2000000&dir=img/promo/bground_screen/&no_interface'></iframe>";
		$box->angle_out("");
		};break;
######################################################################################################################
    case 'add_screen':
		{
		$dt_in=time();
		$dt_out=0;
		db_write("insert into cmd (id_customer,type,titre,tech_in,dt_in,dt_out,status,id_shop)values('$sugar->shop_id','prm','Pub Screen','$sugar->id','$dt_in','$dt_out','SCREEN','0');");
		//on recupere l id du ticket qu on viens de creez
		$chk_prm=db_single_read("select * from cmd order by id desc limit 1");
		db_write("insert into promo(id_odp)values('$chk_prm->id');");
		db_write("insert into promo_item(id_odp,format,type,pos_x,pos_y,width,height,valeur,activated)values('$chk_prm->id','fhd','bground',0,0,1920,1080,'no_img.gif',0);");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=promo/promo.pub_screen&sub_system=edit_screen&id_prm=$chk_prm->id'/>";
		};break;
######################################################################################################################
	case 'edit_info':
		{
		$id_promo=db_single_read("select * from promo where id=".$_GET['id_promo']);
		$odp=db_single_read("select * from cmd where id=$id_promo->id_odp");
		if(($sugar->security_prm>1)or($odp->id_shop==$sugar->shop_id))
			{
			$form->open("index.php?system=promo&sub_system=update_info&id_promo=$id_promo->id&id_shop=$odp->id_shop&no_interface","POST");
			$form->textarea("info",'21','155',$id_promo->info);
			$form->send("Update");
			$form->close();
			}
		else $form->textarea_disabled("info",'21','155',$id_promo->info);
		};break;
######################################################################################################################
	case 'update_info':
		{
		if(($sugar->security_prm>1)or($_GET['id_shop']==$sugar->shop_id))
			{
			db_write("update promo set info='".$_POST['info']."',id_shop='".$_GET['id_shop']."' where id=".$_GET['id_promo']);
			echo"<meta http-equiv='refresh' content='0; url=index.php?system=promo&sub_system=edit_info&id_promo=".$_GET['id_promo']."&no_interface'/>";
			}
		else $js->alert_redirect("No acces","index.php",0);
		};break;
######################################################################################################################
	case 'edit_a4':
		{
		if($sugar->security_prm<2)$js->alert_redirect("No acces","index.php",0);
		$box->angle_in('10','30','900','800','','black','','',100,"","",'');
		echo "<iframe width=100% height=100% frameborder=0 src='index.php?system=promo/a4.iframe&sub_system=edit_a4_img&id_prm=$id_prm&no_interface'></iframe>";
		$box->angle_out(".");

		$box->angle_in('920','10',((760*0.75)+2),((1080*0.75)+2),'','black','','',100,"","",'');
		echo "<iframe width=100% height=100% frameborder=0 src='index.php?system=promo/a4.iframe&sub_system=preview_a4_print&id_prm=$id_prm&no_interface'></iframe>";
		$box->angle_out(".");
		};break;
######################################################################################################################
	case 'edit_fhd':
		{
		if($sugar->security_prm<2)$js->alert_redirect("No acces","index.php",0);
		$box->angle_in('10','30','1480','790','','black','','',100,"","",'');
		echo "<iframe width=100% height=100% frameborder=0 src='index.php?system=promo/fhd.iframe&sub_system=edit_fhd_img&id_prm=$id_prm&no_interface'></iframe>";
		$box->angle_out(".");

		$box->angle_in('700','370',((1920*0.4)+2),((1080*0.4)+2),'','black','','',100,"","",'');
		echo "<iframe width=100% height=100% frameborder=0 src='index.php?system=promo/fhd.iframe&sub_system=preview_fhd&id_prm=$id_prm&no_interface'></iframe>";
		$box->angle_out(".");
		};break;
######################################################################################################################
	case 'update_loc_xy':
		{
		if($sugar->security_prm<2)$js->alert_redirect("No acces","index.php",0);
		$id_prm=$_POST['id_prm'];
		$x=$_POST['x'];
		$y=$_POST['y'];
		$labelx=$_POST['lblx'];
		$labely=$_POST['lbly'];
		$format=$_GET['format'];
		db_write("update promo set $labelx='$x',$labely='$y' where id_odp = $id_prm;");
		if($format=='fhd')echo"<meta http-equiv='refresh' content='0; url=index.php?system=promo&sub_system=edit_fhd_img&id_prm=$id_prm&no_interface'/>";
		else echo"<meta http-equiv='refresh' content='0; url=index.php?system=promo&sub_system=edit_a4_img&id_prm=$id_prm&no_interface'/>";
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
		else $cmd=db_single_read("select * from cmd where id = '$id_prm'");
		$chk_prm=db_single_read("select count(*) as cnt from promo where id_odp = '$id_prm'");
		if($chk_prm->cnt==0)db_write("insert into promo(id_odp,bground,img0,img1,img2,img3,img4,img5,img6)values('$id_prm','dotted.gif','no_img.gif','no_img.gif','no_img.gif','no_img.gif','no_img.gif','no_img.gif','no_img.gif');");
        
		$promo=db_single_read("select * from promo where id_odp = $id_prm");
        $promo_item=db_single_read("select * from promo_item where id_odp = $id_prm and format='fhd' and type='bground';");
        
        $box->empty_in('50','50','960','25','','',"",'',100,"","",'');
            $form->open("index.php?system=promo/promo.pub_screen&sub_system=update_titre&id_prm=$id_prm&no_interface","POST");
            echo "Titre : ";
            $form->text("titre",'100',$cmd->titre);
            $form->close();
        $box->empty_out('');

		if($sugar->security_prm>1)
			{
			$box->angle_in('30','100','960','540','white','steelblue',"",'',100,"","",'');
			echo "<img src='img/promo/bground_screen/$promo_item->valeur' width=100%></img>";
			$box->angle_out('');
			
			$box->angle_in('1050','100','400','700','white','steelblue',"",'',100,"","",'');
			$iterator = new DirectoryIterator("img/promo/bground_screen/");
			foreach($iterator as $document)
				{
				if(($document->getFilename()!='.')and($document->getFilename()!='..'))
					{
					//$box->angle_in('','','360','203','','black',"",'',100,"","index.php?system=promo&sub_system=update_screen&img=".$document->getFilename()."&id_prm=$id_prm&no_interface",'');
					echo "<a href='index.php?system=promo/promo.pub_screen&sub_system=update_screen&img=".$document->getFilename()."&id_prm=$id_prm&no_interface'><li>".$document->getFilename()."</li></a>";
					//echo "<img src='img/promo/bground_screen/".$document->getFilename()."' width=100%></img>";
					//$box->angle_out(".");
					}
				}
			$box->angle_out('');
			}
		else 
			{
			//$box->angle_in('30','30','960','540','white','steelblue',"",'',100,"","",'');
			echo "<img src='img/promo/bground_screen/$promo->bground_fhd' width=95%></img>";
			//$box->angle_out('');
			}
		};break;
######################################################################################################################
	case 'update_titre':
		{
        db_write("update cmd set titre='".$_POST['titre']."' where id=$id_prm;");
		echo"<meta http-equiv='refresh' content='0; url=index.php?system=promo/promo.pub_screen&sub_system=edit_screen&id_prm=$id_prm'/>";  
        };break;
    case 'update_screen':
		{
		$img=$_GET['img'];
		$chk_item_bg=db_single_read("select count(*) as cnt from promo_item where id_odp=$id_prm and format='fhd' and type='bground';");
		if ($chk_item_bg->cnt==0)db_write("insert into promo_item(id_odp,format,type,pos_x,pos_y,width,height,valeur,activated)values('$id_prm','fhd','bground',0,0,1920,1080,'no_img.gif',1);");
		db_write("update promo_item set valeur='$img',activated='1' where id_odp=$id_prm and format='fhd' and type='bground';");
		echo"<meta http-equiv='refresh' content='0; url=index.php?system=promo/promo.pub_screen&sub_system=edit_screen&id_prm=$id_prm'/>";
        };break;
######################################################################################################################
	case 'edit_fiche':
		{
		if($sugar->security_prm<2)$js->alert_redirect("No acces","index.php",0);
		$promo=db_single_read("select * from promo where id_odp = $id_prm");
		$form->open("index.php?system=promo&sub_system=update_fiche&id_prm=$id_prm","POST");
		$box->angle_in('10','40','532','360','','black','','',100,"","",'');
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
				$form->text_disabled('id',45,$id_prm);
				$form->text_disabled('titre',45,date("d/m/Y H:i",$cmd->dt_in));
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
		$rqt="update promo set color='$color',titre='$titre',text_libre='$text_libre',cpu='$cpu',mem='$mem',hdd='$hdd',gfx='$gfx',os='$os',pv_error='$pv_error',pv_correct='$pv_correct' where id_odp=$id_prm;";
		$rqt.="update cmd set titre='$titre' where id = $id_prm;";
		db_write($rqt);
		echo"<meta http-equiv='refresh' content='0; url=index.php?system=promo&sub_system=edit_fiche&tab=edit_fiche&id_prm=$id_prm'/>";
		};break;
######################################################################################################################
	case 'duplicate_odp':
		{
		$id_odp=$_GET['id_odp'];
		
		if($customer->id!=0)
			{
			$offre=db_single_read("select * from cmd where id = $id_odp");
			db_write("insert into cmd (id_customer,type,titre,tech_in,dt_in,dt_out,status,id_shop)values('$customer->id','odp','$offre->titre','$sugar->id','".time()."','".(time()+604800)."','open','$sugar->shop_id');");
			$chk_offre=db_single_read("select * from cmd order by id desc limit 1");
			$rqt='';
			$offre_item_tmp=db_read("select * from cmd_item where id_cmd = $id_odp");
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
	case 'del_odp':
		{
		$id_odp=$_GET['id_odp'];
		db_write("update cmd set status='hidden' where id = $id_odp");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=odp'/>";
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
		$status=db_single_read("select * from promo where id_odp = $id_prm");
		if ($status->status=='on')db_write("update promo set status = 'off' where id_odp = $id_prm");
		else db_write("update promo set status = 'on' where id_odp = $id_prm");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=promo'/>";
		};break;
######################################################################################################################
	case 'duplicate_promo_to_odp':
		{
		$id_odp=$_GET['id_odp'];
		
		if($customer->id!=0)
			{
			$offre=db_single_read("select * from cmd where id = $id_odp");
			
			db_write("insert into cmd (id_customer,type,titre,tech_in,dt_in,dt_out,status,id_shop)values('$customer->id','odp','$offre->titre','$sugar->id','".time()."','".(time()+604800)."','open','$sugar->shop_id');");
			$chk_offre=db_single_read("select * from cmd order by id desc limit 1");
			$rqt='';
			$offre_item_tmp=db_read("select * from cmd_item where id_cmd = $id_odp");
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
			
			//echo "<body onload='window.print();window.close()'>";
		};break;
######################################################################################################################
	case 'print_odp_customer':
		{
		$odp->load($_GET['id_odp']);
		$box->angle_in('0','0','760','1080','','black','','',100,'','','');
		
		
		//affichage de l entete
		$box->angle_in('20','20','202','202','','black','','',100,'','','');
		echo "<img src='img/200px/$odp->shop_logo'></img>";
		$box->angle_out('');
		
		//affichage du no de ticket 
		$box->angle(290,20,200,30,'','','','',100,"<font size=5>Offre de prix no : </font>",'','');
		$box->angle(500,20,100,30,'white','black','','',100,"<font size=5>$odp->id</font>",'','');

		//affichage du nom du client 
		$box->angle(240,70,100,30,'','','','',100,"<font size=5>Nom : </font>",'','');
		$box->angle(340,70,400,30,'white','black','','',100,"<font size=5>".$odp->prenom." ".$odp->nom."</font>",'','');
		//affichage du Tel1
		$box->angle(240,115,100,25,'','','','',100,"<font size=4>Tel : </font>",'','');
		$box->angle(340,115,190,25,'white','black','','',100,"<font size=4>$odp->call1</font>",'','');
		$box->angle(550,115,190,25,'white','black','','',100,"<font size=4>$odp->call2</font>",'','');
		//email
		$box->angle(240,160,100,25,'','','','',100,"<font size=4>E-mail : </font>",'','');
		$box->angle(340,160,400,25,'white','black','','',100,"<font size=4>$odp->mail</font>",'','');
		//affichage des dates
		$box->angle(240,195,200,25,'','','','',100,"<font size=4>Date d entree : </font>",'','');
		$box->angle(440,195,300,25,'white','black','','',100,"<font size=4>".date("d/m/Y G:i",$odp->dt_in)."</font>",'','');

		$grand_total_vente=0;
		$grand_total_achat=0;
		//cadre complet
		$box->angle_in('20','250',720,650,'','black','','',100,"","",'');
		//ligne menu 
			$box->angle_in('','',718,22,'','','','',100,"","",'');
				$box->angle('','',466,20,'lightgreen','green','','',100,"Description","",'');
				$box->angle('','',100,20,'lightgreen','green','','',100,"Prix","",'');
				$box->angle('','',50,20,'lightgreen','green','','',100,"Qt","",'');
				$box->angle('','',100,20,'lightgreen','green','','',100,"Prix total","",'');
			$box->angle_out('');
		
		$cmd_item_tmp=db_read("select * from cmd_item where id_cmd = $odp->id");
		while($cmd_item = $cmd_item_tmp->fetch())
			{
			$box->angle_in('','',718,22,'','','','',100,"","",'');
				
				$box->angle('','',466,20,'','green','','',100,"$cmd_item->nom","",'');//item
				$prix_vente=$cmd_item->prix_vente;
				$box->angle('','',100,20,'','green','','',100,"$prix_vente &euro;","",'');
				$box->angle('','',50,20,'','green','','',100,"$cmd_item->qt","",'');
				$prix_ttl=$prix_vente*$cmd_item->qt;
				$box->angle('','',100,20,'','green','','',100,"$prix_ttl &euro;","",'');
				
			$box->angle_out('');
			$grand_total_vente+=$prix_ttl;
			}
		//affichage du total
		$box->angle_in('','',718,22,'','','','',100,"","",'');
			$box->angle('','',516,20,'','','','',100,"","",'');
			$box->angle('','',100,20,'','','','',100,"Total : ","",'');

			$box->angle('','',100,20,'','red','','',100,"$grand_total_vente &euro;","",'');
		$box->angle_out('');
		//fin cadre principal
		$box->angle_out('');
		
		$box->angle('40','920',200,20,'','','','',100,"</b><u>Vendeur : $sugar->prenom $sugar->nom</u>","",'');

		$box->angle('490','920',250,25,'','black','','',100,"Cette offre est valable 24h","",'');
		/*		
		$novoffice="Novoffice<br>Tel. 02/520.94.76<br>sales@novoffice.be<br>TVA : BE0897225353<br>Boulevard du Triomphe, 174. 1160 Auderghem";
		$box->angle('140','950',500,100,'lightgrey','black','','',100,"$novoffice","",'');
		*/
		$box->angle('20','1050','720','20','lightgrey','black','','',100,"<font size=3>$odp->shop_name - $odp->shop_adresse1 $odp->shop_adresse2 - $odp->shop_mail - $odp->shop_call1</font>",'','');
		
		$box->angle_out('');
		
		echo "<body onload='window.print();window.close()'>";
		
		};break;
######################################################################################################################
	case 'print_promo':
		{
		$id_prm=$_GET['id_prm'];
		$promo=db_single_read("select * from promo where id_odp = $id_prm");
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
			if($promo->img0_a4!='no_img.gif')$box->angle($promo->img0_a4_x,$promo->img0_a4_y,'300','300',"",'',$img0,'',100,"","",'');
			//img1
			if($promo->img1_a4!='no_img.gif')$box->angle($promo->img1_a4_x,$promo->img1_a4_y,'150','150',"",'',$img1,'',100,"","",'');
			//img2
			if($promo->img2_a4!='no_img.gif')$box->angle($promo->img2_a4_x,$promo->img2_a4_y,'150','150',"",'',$img2,'',100,"","",'');
			//img3
			if($promo->img3_a4!='no_img.gif')$box->angle($promo->img3_a4_x,$promo->img3_a4_y,'150','150',"",'',$img3,'',100,"","",'');
			//img4
			if($promo->img4_a4!='no_img.gif')$box->angle($promo->img4_a4_x,$promo->img4_a4_y,'150','150',"",'',$img4,'',100,"","",'');
			//img5
			if($promo->img5_a4!='no_img.gif')$box->angle($promo->img5_a4_x,$promo->img5_a4_y,'150','150',"",'',$img5,'',100,"","",'');
			//img6
			if($promo->img6_a4!='no_img.gif')$box->angle($promo->img6_a4_x,$promo->img6_a4_y,'300','300',"",'',$img6,'',100,"","",'');
			

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
		//if(($sub_system!='lobby')and($sub_system!='add_prm'))
		//	{
			//on verifie si le ticket existe
			$chk_prm=db_single_read("select count(*) as cnt from cmd where id = '$id_prm'");
			if($chk_prm->cnt!=1)$js->alert_redirect("Se ticket n existe pas","index.php?system=promo&sub_system=lobby",0);//message Url dalei avant redirect
			$chk_prm=db_single_read("select count(*) as cnt from promo where id_odp = '$id_prm'");
			if($chk_prm->cnt==0)db_write("insert into promo(id_odp,bground,img0,img1,img2,img3,img4,img5,img6)values('$id_prm','dotted.gif','no_img.gif','no_img.gif','no_img.gif','no_img.gif','no_img.gif','no_img.gif','no_img.gif');");
		
			//menu tab
			if(isset($_GET['tab']))$tab=$_GET['tab'];
			else $tab='lobby';
		
			if($tab=='lobby')$box->angle('','','150','20','lightgreen','black','','',100,"Lobby","",'');
			else $box->angle('','','150','20','grey','black','','',100,"Lobby","index.php?system=promo&sub_system=edit_promo&tab=lobby&id_prm=$id_prm",'');

			if($tab=='edit_fiche')$box->angle('','','150','20','lightgreen','black','','',100,"Fiche","",'');
			else $box->angle('','','150','20','grey','black','','',100,"Fiche","index.php?system=promo&sub_system=edit_fiche&tab=edit_fiche&id_prm=$id_prm",'');

			if($tab=='edit_a4')$box->angle('','','150','20','lightgreen','black','','',100,"Edit A4","",'');
			else $box->angle('','','150','20','grey','black','','',100,"Edit A4","index.php?system=promo&sub_system=edit_a4&tab=edit_a4&id_prm=$id_prm",'');

			if($tab=='edit_fhd')$box->angle('','','150','20','lightgreen','black','','',100,"Edit FHD","",'');
			else $box->angle('','','150','20','grey','black','','',100,"Edit FHD","index.php?system=promo&sub_system=edit_fhd&tab=edit_fhd&id_prm=$id_prm",'');
		//	}
		}
	}
?>