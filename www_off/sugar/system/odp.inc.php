<?php
//echo "<body style='background-color:$sugar->background_color'>";
if($sugar->security_odp==0)$js->alert_redirect("No acces","index.php",0);
if(isset($_GET['id_odp']))$id_odp=$_GET['id_odp'];
if(isset($_POST['id_shop']))$id_shop=$_POST['id_shop'];
else $id_shop=$sugar->shop_id;
switch ($sub_system)
	{
######################################################################################################################
	case 'lobby':
		{
        echo "<body style='background-color:$sugar->background_color'>";

		$sugar->label="odp";
		$box->box_rond('','','200','23','yellow','black','','',100,"Ajouter une offre de prix","index.php?system=odp&sub_system=add_odp",'');
		$box->angle('','','1298','23','black','black','','',100,"<marquee><font color='#CC5BF4'>Offre de prix prioritaire a prendre en charge<font color='black'>____________________<font color =orange>Offre de prix a traiter (appel client / reminder).<font color=black>____________________<font color=lightgreen>Offre de prix en attente.</marquee>","",'');
		
		if($sugar->security_odp>1)
			{
			//admin select shop
			$box->empty_in('200','0','200','22','','','','',100,"","",'');
				$form->open("index.php?system=odp","POST");
				$form->select_in('id_shop',1);
				$shop_tmp=db_read("select * from shop");
				while($shop = $shop_tmp->fetch())
					{
					$form->select_option("$shop->nom",$shop->id,$id_shop);
					}
				$form->select_out();
				$form->send("GO");
				$form->close();
			$box->empty_out(".");
			}
		$box->empty_in('','',1498,'810','','','','',100,"","",'');
			$box->angle_in('','',1498,'22','grey','lightgrey','','',100,"","",'');
				$box->angle('','',50,'20',"",'lightgrey','','',100,"Cmd","",'');
				$box->angle('','',316,'20',"",'lightgrey','','',100,"Client","",'');
				$box->angle('','',130,'20','','lightgrey','','',100,"No de contact","",'');
				$box->angle('','',550,'20','','lightgrey','','',100,"Description commande","",'');
				$box->angle('','',50,'20','','lightgrey','','',100,"Qt","",'');
				$box->angle('','',100,'20','','lightgrey','','',100,"Prix","",'');
				$box->angle('','',120,'20','','lightgrey','','',100,"Date entree",'','');
				$box->angle('','',120,'20','','lightgrey','','',100,"Reminder",'','');
				$box->angle('','',60,'20','','lightgrey','','',100,"Delay",'',"");
				//$box->angle('','',116,'20','','lightgrey','','',100,"Shop",'',"");
			$box->angle_out('');
		
			$cnt_tckt=30;
			
			//voir les ODP GROUPE
			$cmmd_tmp=db_read("select * from cmd where status = 'admin' and type='odp' order by dt_out limit $cnt_tckt;");
			while($cmmd = $cmmd_tmp->fetch())
				{
				$odp->load($cmmd->id,$sugar);
				$odp->show_line($box,$js,$sugar);
				$cnt_tckt--;
				}
			
			//voir les open
			$cmmd_tmp=db_read("select * from cmd where id_shop = $id_shop and status = 'open' and type='odp' order by dt_out limit $cnt_tckt;");
			while($cmmd = $cmmd_tmp->fetch())
				{
				$odp->load($cmmd->id,$sugar);
				$odp->show_line($box,$js,$sugar);
				$cnt_tckt--;
				}

			//voir les hidden
			$cmmd_tmp=db_read("select * from cmd where id_shop = $id_shop and status = 'hidden' and type='odp' order by dt_out limit 5;");
			while($cmmd = $cmmd_tmp->fetch())
				{
				$odp->load($cmmd->id,$sugar);
				$odp->show_line($box,$js,$sugar);
				$cnt_tckt--;
				}
		$box->empty_out('');
		};break;
######################################################################################################################
    case 'add_odp':
		{
		if($customer->id!=0)
			{
			$dt_in=time();
			$dt_out=(time()+604800);//date de reminder
			if($sugar->shop_id==0)db_write("insert into cmd (id_customer,type,titre,tech_in,dt_in,dt_out,status,id_shop)values('$customer->id','odp','Offre de prix','$sugar->id','$dt_in','$dt_out','admin','$sugar->shop_id');");
			else db_write("insert into cmd (id_customer,type,titre,tech_in,dt_in,dt_out,status,id_shop)values('$customer->id','odp','Offre de prix','$sugar->id','$dt_in','$dt_out','open','$sugar->shop_id');");
			$chk_odp=db_single_read("select * from cmd order by id desc limit 1");
			$sugar->admin_add_log($system,$sub_system,"Ajoute de l offre de prix $chk_odp->id pour le client $customer->id",1);
			echo "<meta http-equiv='refresh' content='0; url=index.php?system=odp&sub_system=edit_odp&id_odp=$chk_odp->id'/>";
			}
		else $js->alert_redirect("Aucun client actif","index.php?system=customer",0);
		};break;
######################################################################################################################
	case 'transfert_to_odpg':
		{
		db_write("update cmd set status='admin',tech_in=0,id_shop=0 where id = $id_odp;");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=odp'/>";
		};break;
######################################################################################################################
	case 'edit_odp':
		{
        echo "<body style='background-color:$sugar->background_color'>";

		//on verifie si un ticket est renseigner sinon on est redirect sur la page lobby cmd
		if(!isset($_GET['id_odp']))$js->alert_redirect("Pas de commande selectionner","index.php?system=cmd&sub_system=lobby",0);//message Url dalei avant redirect
		
		//on verifie si le ticket existe
		$id_odp=$_GET['id_odp'];
		$chk_odp=db_single_read("select count(*) as cnt from cmd where id = $id_odp");
		if($chk_odp->cnt!=1)$js->alert_redirect("Se ticket n existe pas","index.php?system=cmd&sub_system=lobby",0);//message Url delai avant redirect
		
		//on load le ticket
		$odp->load($id_odp,$sugar);
		//affichage des infos ticket
				
         //iframe info client
        $box->angle_in('10','10','402','230','#FFFFEF','black','','','100',"",'',"");	
            echo "<iframe src='index.php?system=customer/fiche.iframe&sub_system=show&id_customer=$odp->id_customer&no_interface' frameborder=0 width=100% height=100%></iframe>";			
        $box->angle_out("");

        /*
		$box->angle_in('10','10','402','212','#FFFFEF','black','','','100',"",'',"");	
			echo "<iframe src='index.php?system=customer/fiche.iframe&sub_system=show&id_customer=$odp->id_customer&no_interface' frameborder=0 width=400px height=210px></iframe>";			
		$box->angle_out("");
        */		
		//affichage du reminder
		$box->angle_in('10','250','402','70','orange','black','','',100,'',"",'');
			echo "<iframe frameborder=0 width=100% height=100% src=index.php?system=odp&sub_system=edit_reminder&id=$id_odp&no_interface></iframe>";
		$box->angle_out('');
		
		$box->angle_in('600','10','640','40','','','','',100,'',"",'');
			$form->open("index.php?system=odp&sub_system=update_titre","POST");
			$form->hidden("id_odp","$odp->id");
			echo "Titre :";$form->text("titre",60,"$odp->titre");
			$form->close();
		$box->angle_out('');
		
		//affichage des feedback
		$width=840;$height=380;
		$box->angle_in('420','40',$width+2,$height+2,'white','black','','',100,'',"",'');
			echo "<iframe frameborder=0 width=100% height=100% src=index.php?system=feedback.iframe&sub_system=show_feedback&sys=odp&id_record=$odp->id&width=$width&height=$height&no_interface></iframe>";
		$box->angle_out('');
		
		//info odp
		$box->angle_in('1280','20','200','190','','steelblue','','',100,"Offre de prix","",'');
			echo "<li>Ticket no : <br>";$form->text_disabled("","10","$odp->id");echo"</li>";
			//$form->hidden('id_ticket',$ticket->id);
			//$tech_in=db_single_read("select * from user where id=$ticket->tech_in");
			echo "<li>Ouvert par : ";$form->text_disabled("","20",$sugar->show_name_user($odp->tech_in));echo"</li>";
			echo "<li>Date ouverture : ";$form->text_disabled("","15",date("d/m/Y H:i",$odp->dt_in));echo"</li>";
			echo "<li>Status : ";$form->text_disabled("","15",$odp->status);echo"</li>";
		$box->angle_out('');
		
		//Menu boutton
		$box->empty_in('1280','230',200,210,'','','','',100,"",'','');//imprimer reception
		$odp->show_button($box,$sugar,$server);
		$box->empty_out("");

		//affichage de la liste des item de la commande 
		$box->angle_in('20','433',1458,380,'white','red','','',100,"","",'');
		echo "<iframe frameborder=0 src='index.php?system=cmd/item.iframe&sub_system=show_item&id_cmd=$id_odp&no_interface' width=100% height=100%></iframe>";
		$box->angle_out('');

		};break;
######################################################################################################################
	case 'edit_pv':
		{
		$id_odp = $_GET['id_odp'];
		$id_item = $_GET['id_item'];
		$item=db_single_read("select * from cmd_item where id =$id_item");
		$js->encode_chiffre('pv',$item->prix_vente,"index.php?system=odp&sub_system=update_pv&id_odp=$id_odp&id_item=$id_item&no_interface");
		};break;
######################################################################################################################
	case 'update_pv':
		{
		$id_odp = $_GET['id_odp'];
		$id_item = $_GET['id_item'];
		$new_pv = $_GET['pv'];
		$item=db_single_read("select * from cmd_item where id =$id_item");
		$marge =round(($new_pv/$item->prix_achat),3);
		db_write("UPDATE cmd_item SET marge='$marge',prix_vente='$new_pv' WHERE id = $id_item;");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=odp&sub_system=edit_odp&id_odp=$id_odp'/>";
		};break;
######################################################################################################################
	case 'edit_reminder':
		{
		$_odp=db_single_read("select * from cmd where id = ".$_GET['id']);
		echo "<center><b>Report Reminder</b></center>";
		$form->open("index.php?system=odp&sub_system=update_reminder&id_odp=$_odp->id&no_interface","POST");
			
			$form->select_in('day',1);
			for($i=1;$i<=31;$i++)$form->select_option($i,$i,date("d",$_odp->dt_out));
			$form->select_out();

			$form->select_in('month',1);
			for($i=1;$i<=12;$i++)$form->select_option($i,$i,date("m",$_odp->dt_out));
			$form->select_out();

			$form->select_in('year',1);
			for($i=2019;$i<=2030;$i++)$form->select_option($i,$i,date("Y",$_odp->dt_out));
			$form->select_out();
			
			$form->select_in('hour',1);
			for($i=0;$i<=23;$i++)$form->select_option($i,$i,date("H",$_odp->dt_out));
			$form->select_out();
			
			$form->select_in('minute',1);
			for($i=0;$i<=59;$i++)$form->select_option($i,$i,date("i",$_odp->dt_out));
			$form->select_out();
			
			$form->send("Update");
		$form->close();
			
		};break;
######################################################################################################################
	case 'update_reminder':
		{
		$id_odp=$_GET['id_odp'];
		$hour=$_POST['hour'];
		$minute=$_POST['minute'];
		$day=$_POST['day'];
		$month=$_POST['month'];
		$year=$_POST['year'];
		$dt=mktime($hour,$minute,0,$month,$day,$year);
		db_write("update cmd set dt_out='$dt' where id = $id_odp;");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=odp&sub_system=edit_reminder&no_interface&id=$id_odp'/>";
		};break;
######################################################################################################################
	case 'update_titre':
		{
		$id_odp=$_POST['id_odp'];
		$titre=$_POST['titre'];
		db_write("update cmd set titre='$titre' where id = $id_odp;");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=odp&sub_system=edit_odp&id_odp=$id_odp'/>";
		};break;
######################################################################################################################
	case 'add_feedback':
		{
		$id_tech=$sugar->id;
		$id_cmd=$_POST['id_odp'];
		$dt_insert=time();
		$remarque=$_POST['remarque'];
		db_write("insert into cmd_feedback(id_tech,id_cmd,dt_insert,remarque)values($id_tech,$id_cmd,$dt_insert,'$remarque')");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=odp&sub_system=edit_odp&id_odp=$id_cmd'/>";
		};break;
######################################################################################################################
	case 'add_item':
		{
		$id_odp=$_GET['id_odp'];
		db_write("INSERT INTO `cmd_item` (`id`, `id_cmd`, `nom`, `fournisseur`, `url_item`, `qt`, `prix_achat`, `marge`) VALUES (NULL, $id_odp, '', '', '', '', '', '1.73');");
		$id_item=db_single_read("select * from cmd_item order by id desc limit 1");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=odp&sub_system=edit_item&id_item=$id_item->id'/>";
		};break;
######################################################################################################################
	case 'edit_item':
		{
		$id_item=$_GET['id_item'];
		$item=db_single_read("select * from cmd_item where id = $id_item");
		$box->angle_in('300','0',800,'600','','black','','',100,"","",'');
			$form->open("index.php?system=odp&sub_system=update_item","POST");
			echo "<center>";
			echo "Item id : ";$form->text_disabled("id",5,"$item->id");
			$form->hidden("id_item","$item->id");
			$form->hidden("id_odp","$item->id_cmd");
			
			echo "<br>Nom : ";$form->text("nom",80,"$item->nom");
			echo "<br>Fournisseur : ";$form->text("fournisseur",10,"$item->fournisseur");
			echo "<br>Url Item : ";$form->textarea("url_item",5,80,"$item->url_item");
			echo "<br>Qt : ";$form->text("qt",5,"$item->qt");
			echo"<li>Prix achat : ";$form->text("prix_achat",10,"$item->prix_achat");echo"</li>";
			echo"<li>Marge : ";$form->text("marge",5,"$item->marge");echo"%</li>";
			echo"<br>";$form->send("Suite");
			$form->close();
		$box->angle_out('');
		};break;
######################################################################################################################
	case 'update_item':
		{
		$id_item=$_POST['id_item'];
		$id_odp=$_POST['id_odp'];
		$nom=$_POST['nom'];
		$fournisseur=$_POST['fournisseur'];
		$url_item=$_POST['url_item'];
		$qt=$_POST['qt'];
		$prix_achat=$_POST['prix_achat'];
		$marge=$_POST['marge'];
		$prix_vente=round($prix_achat*$marge,2);
		db_write("UPDATE `cmd_item` SET `nom` = '$nom', `fournisseur` = '$fournisseur', `url_item` = '$url_item', `qt` = '$qt', `prix_achat` = '$prix_achat', `marge` = '$marge',prix_vente='$prix_vente' WHERE `cmd_item`.`id` = $id_item; ");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=odp&sub_system=edit_odp&id_odp=$id_odp'/>";
		
		};break;
######################################################################################################################
	case 'check_delete_item':
		{
		$id_item=$_GET['id_item'];
		$id_odp=$_GET['id_odp'];
		$url_yes="index.php?system=odp&sub_system=delete_item&id_item=$id_item&id_odp=$id_odp";
		$url_no="index.php?system=odp&sub_system=edit_odp&id_odp=$id_odp";
		$js->confirmation("Etes vous certain de vouloir effacer l item ?",$url_yes,$url_no);
		};break;
######################################################################################################################
	case 'delete_item':
		{
		$id_item=$_GET['id_item'];
		$id_odp=$_GET['id_odp'];
		db_write("delete from cmd_item where id = $id_item");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=odp&sub_system=edit_odp&id_odp=$id_odp'/>";
		};break;
######################################################################################################################
	case 'transfert_to_cmd':
		{
		$odp->load($_GET['id_odp'],$sugar);
		$odp->transfert_to_cmd();
		///db_write("update cmd set type='cmd' where id = $id_cmd");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=cmd&sub_system=edit_cmd&id_cmd=$odp->id'/>";
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
		$sugar->admin_add_log($system,$sub_system,"Supression de l offre de prix no $id_odp",2);
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=odp'/>";
		};break;
######################################################################################################################
	case 'destroy_odp':
		{
		$id_odp=$_GET['id_odp'];
		$rqt="";
		//supression des items 
		$rqt.="delete from cmd_item where id_cmd = $id_odp;";
		//supression du record promo
		$rqt.="delete from promo where id_odp = $id_odp;";
		//supression du record cmd
		$rqt.="delete from cmd where id = $id_odp;";
		db_write($rqt);
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=odp'/>";
		};break;
######################################################################################################################
	case 'give_odp_to_tech':
		{
		//$id_odp=$_GET['id_odp'];
		$odp->load($id_odp,$sugar);
		db_write("update cmd set tech_in='$sugar->id',id_shop=$sugar->shop_id where id = $id_odp");
		$sugar->admin_add_log($system,$sub_system,"$sugar->id prend en charge l odp $id_odp",2);
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=odp&sub_system=edit_odp&id_odp=$id_odp'/>";
		};break;
######################################################################################################################
    case 'transfert_to_odp':
		{
		db_write("update cmd set status='open',tech_in=$sugar->id,id_shop=$sugar->shop_id where id = $id_odp;");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=odp&sub_system=edit_odp&id_odp=$id_odp'/>";
		};break;

######################################################################################################################
	case 'open_odp':
		{
		//$id_odp=$_GET['id_odp'];
		db_write("update cmd set status='open' where id = $id_odp");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=odp&sub_system=edit_odp&id_odp=$id_odp'/>";
		};break;
######################################################################################################################
	case 'print_odp_internal':
		{
		$odp->load($_GET['id_odp'],$sugar);
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
        include('../../www_off/sugar/obj/print.obj.php');
        $print=new _print;
		$print->header($box,$system,$_GET['id_odp'],$sugar);
		$odp->load($_GET['id_odp'],$sugar);
		
		$grand_total_vente=0;
		$grand_total_achat=0;
		//ligne menu 
			$box->angle_in('','',738,22,'','','','',100,"","",'');
				$box->angle('','',546,20,'lightgreen','green','','',100,"Description","",'');
				$box->angle('','',80,20,'lightgreen','green','','',100,"Prix","",'');
				$box->angle('','',30,20,'lightgreen','green','','',100,"Qt","",'');
				$box->angle('','',80,20,'lightgreen','green','','',100,"Prix total","",'');
			$box->angle_out('');
		
		$cmd_item_tmp=db_read("select * from cmd_item where id_cmd = $odp->id");
		while($cmd_item = $cmd_item_tmp->fetch())
			{
			$box->angle_in('','',738,22,'','','','',100,"","",'');
				
				$box->angle('','',546,20,'','green','','',100,"$cmd_item->nom","",'');//item
				$prix_vente=$cmd_item->prix_vente;
				$box->angle('','',80,20,'','green','','',100,"$prix_vente &euro;","",'');
				$box->angle('','',30,20,'','green','','',100,"$cmd_item->qt","",'');
				$prix_ttl=$prix_vente*$cmd_item->qt;
				$box->angle('','',80,20,'','green','','',100,"$prix_ttl &euro;","",'');
				
			$box->angle_out('');
			$grand_total_vente+=$prix_ttl;
			}
			//affichage du total
			$box->angle_in('','',738,22,'','','','',100,"","",'');
				$box->angle('','',536,20,'','','','',100,"","",'');
				$box->angle('','',100,20,'','','','',100,"Total : ","",'');

				$box->angle('','',100,20,'','red','','',100,"$grand_total_vente &euro;","",'');
			$box->angle_out('');
		
		$box->angle('485','755',250,20,'','black','','',100,"Cette offre est valable 24h","",'');
	
		$print->footer($box,$sugar);
		
		};break;
######################################################################################################################
	case 'print_promo':
		{
		include('../../www_off/sugar/obj/print.obj.php');
		$print=new _print;
		$titre="";
		$text_libre="";
		$cpu="";
		$mem="";
		$hdd="";
		$gfx="";
		$os="";
		$pv_error="";
		$pv_correct="";
		
		$img0="img/promo/img0/no_img.gif";
		$img1="img/promo/img1/no_img.gif";
		$img2="img/promo/img2/no_img.gif";
		$img3="img/promo/img3/no_img.gif";
		$img4="img/promo/img4/no_img.gif";
		$img5="img/promo/img5/win_10.gif";

		
		$id_odp=$_GET['id_odp'];
		
		$promo=db_single_read("select * from promo where id_odp = $id_odp");
		
		
			$titre=$promo->titre;
			$text_libre=$promo->text_libre;
		
			$cpu="Processeur : ".$promo->cpu;
			$mem="Memoire : ".$promo->mem;
			$hdd="Disque dur : ".$promo->hdd;
			$gfx="Carte graphique : ".$promo->gfx;
			$os="OS : ".$promo->os;
			$pv_error="".$promo->pv_error;
			$pv_correct="".$promo->pv_correct;

			$img0="img/promo/img0/".$promo->img0;
			$img1="img/promo/img1/".$promo->img1;
			$img2="img/promo/img2/".$promo->img2;
			$img3="img/promo/img3/".$promo->img3;
			$img4="img/promo/img4/".$promo->img4;
			$img5="img/promo/img5/".$promo->img5;

		
		$box->angle_in('0','0','760','1080',"",'black','','',100,"","",'');
		
			$box->empty('0','0','758','183',"",'','img/promo/header.gif','',100,"","",'');
			$box->angle('20','20','150','150',"",'black',"img/150px/$sugar->shop_logo",'',100,"","",'');
			$txt="$sugar->shop_name<br>$sugar->shop_adresse1<br>$sugar->shop_adresse2<br>$sugar->shop_mail<br>".$sugar->show_call_formated($sugar->shop_call);
			$box->angle('520','35','200','100','white','black',"","",90,"$txt","",'');
			$box->empty('0','953','758','125',"white",'black','img/promo/footer.gif','',100,"","",'');
		
			//img0
			$box->angle('458','180','300','300',"",'',$img0,'',100,"","",'');
			//img1
			$box->angle('560','550','150','150',"",'',$img1,'',100,"","",'');
			//img2
			$box->angle('20','690','150','150',"",'',$img2,'',100,"","",'');
			//img3
			$box->angle('200','740','150','150',"",'',$img3,'',100,"","",'');
			//img4
			$box->angle('390','720','150','150',"",'',$img4,'',100,"","",'');
			//img5
			$box->angle('580','780','150','150',"",'',$img5,'',100,"","",'');

			//text information 
			$box->angle('10','1024','230','37',"white",'','','',90,"<font size =2>CETTE OFFRE EST SUSCEPTIBLE <br>D ETRE MODIFIE SANS PREAVIS</font>","",'');

			//prix_faux
			$box->angle('20','650','150','30',"",'black',"img/promo/box_prix_croix.gif",'',100,"<font size = 5>$pv_error &euro;</font>","",'');
			//prix_correct
			$box->angle('300','650','150','30',"",'black',"",'',100,"<font size =5>$pv_correct &euro;</font>","",'');
		
			//Titre
			$box->angle('20','190','500','40','','black','','',100,"<font size=6>$titre</font>","",'');
			//info technique 
			$box->angle_in('20','250','480','400','','','','',100,"<font size=6></b><u>Caracteristique technique</u></b></center></font>","",'');
			echo "<font size=5><br><li>$cpu</li>";
			echo "<li>$mem</li>";
			echo "<li>$hdd</li>";
			echo "<li>$gfx</li>";
			echo "<li>$os</li>";
			echo "<br><center>$text_libre</center></font>";
			$box->angle_out('');
		
		$box->angle_out('');
		
		echo "<body onload='window.print();window.close()'>";

		};break;
######################################################################################################################
case 'close_page':
		{
		echo "<body onload='window.close()'>";
		}
	}
?>