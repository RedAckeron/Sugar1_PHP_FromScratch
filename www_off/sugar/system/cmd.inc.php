<?php
echo "<body style='background-color:$sugar->background_color'>";
if($sugar->security_cmd==0)$js->alert_redirect("No acces","index.php",0);

if($sub_system=='')$sub_system='lobby';
if(isset($_POST['id_shop']))$id_shop=$_POST['id_shop'];
else $id_shop=$sugar->shop_id;
switch ($sub_system)
	{
######################################################################################################################
	case 'lobby':
		{
		$sugar->label="cmd";
		//$user=db_single_read("select * from user where id_user = $portal->id");
		$box->box_rond('','',200,'23','yellow','black','','',100,"Ajouter une commande","index.php?system=cmd&sub_system=add_cmd&no_interface",'');
		$box->box_rond('','',200,'23','yellow','black','','',100,"Recherche","index.php?system=cmd&sub_system=add_cmd",'');
		$box->angle('','','1098','23','black','black','','',100,"<marquee><font color=lightgreen>Commande sorti.<font color=black>____________________<font color=lightblue>Commande en stock en attente client.<font color=black>____________________<font color=yellow>Commmande suspendu.<font color=black>____________________<font color =orange>Commande en cours.</marquee>","",'');
		
		if($sugar->security_cmd>1)
			{
			//admin select shop
			$box->empty_in('400','0','200','22','','','','',100,"","",'');
				$form->open("index.php?system=cmd","POST");
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
		$box->angle_in('','',1498,'22','lightgrey','white','','',100,"","",'');
			$box->angle('','',50,'20','','black','','',100,"Cmd","",'');
			$box->angle('','',310,'20','','black','','',100,"Client","",'');
			$box->angle('','',120,'20','','black','','',100,"No de contact","",'');
			$box->angle('','',568,'20','','black','','',100,"Description commande","",'');
			$box->angle('','',50,'20','','black','','',100,"Qt","",'');
			$box->angle('','',98,'20','','black','','',100,"Prix","",'');
			$box->angle('','',120,'20','','black','','',100,"Date entree",'','');
			$box->angle('','',120,'20','','black','','',100,"Date sortie",'','');
			$box->angle('','',60,'20','','black','','',100,"Status",'',"");
			//$box->angle('','',100,'20','','lightgrey','','',100,"Shop",'',"");
		$box->angle_out('');
		
		if($sugar->security_cmd>1)$cnt_tckt=34;
		else $cnt_tckt=35;
		
		//voir les open 
		$cmmd_tmp=db_read("select * from cmd where id_shop=$id_shop and status = 'open' and type='cmd' order by dt_in  limit $cnt_tckt;");
		while($cmmd = $cmmd_tmp->fetch())
			{
			$cmd->load($cmmd->id);
			$cmd->show_line($box,$sugar);
			$cnt_tckt--;
			}
		//voir les wait
		$wait_tmp=db_read("select * from cmd where id_shop = $id_shop and status = 'wait' and type='cmd' order by dt_in limit $cnt_tckt;");
		while($wait = $wait_tmp->fetch())
			{
			$cmd->load($wait->id);
			$cmd->show_line($box,$sugar);
			$cnt_tckt--;
			}
		//voir les end
		$end_tmp=db_read("select * from cmd where id_shop = $id_shop and status = 'end' and type='cmd' order by dt_out desc limit $cnt_tckt;");
		while($end = $end_tmp->fetch())
			{
			$cmd->load($end->id);
			$cmd->show_line($box,$sugar);
			$cnt_tckt--;
			}
		//voir les close
		$close_tmp=db_read("select * from cmd where id_shop = $id_shop and status = 'close' and type='cmd' order by dt_out desc limit $cnt_tckt;");
		while($close = $close_tmp->fetch())
			{
			$cmd->load($close->id);
			$cmd->show_line($box,$sugar);
			$cnt_tckt--;
			}
		//voir les effacer
		if($sugar->security_cmd>1)
			{
			$repair_tmp=db_read("select * from cmd where status = 'hidden' and type='cmd' order by dt_in limit 1;");
			while($repair = $repair_tmp->fetch())
				{
				$cmd->load($repair->id);
				$cmd->show_line($box,$sugar);
				$cnt_tckt--;
				}
			}
		};break;
######################################################################################################################
    case 'add_cmd':
		{
		if($customer->id!=0)
			{
			$dt_in=time();
			db_write("insert into cmd (id_customer,type,titre,tech_in,dt_in,dt_out,status,id_shop)values($customer->id,'cmd','Description commande',$sugar->id,$dt_in,0,'open',$sugar->shop_id);");
			$chk_cmd=db_single_read("select * from cmd order by id desc limit 1");
			$sugar->admin_add_log($system,$sub_system,"Ajoute de la commande $chk_cmd->id pour le client $customer->id",1);
			echo "<meta http-equiv='refresh' content='0; url=index.php?system=cmd&sub_system=edit_cmd&id_cmd=$chk_cmd->id'/>";
			}
		else $js->alert_redirect("Aucun client actif","index.php?system=customer",0);
		};break;
######################################################################################################################
    case 'edit_cmd':
		{
		//on verifie si un ticket est renseigner sinon on est redirect sur la page lobby cmd
		if(!isset($_GET['id_cmd']))$js->alert_redirect("Pas de commande selectionner","index.php?system=cmd&sub_system=lobby",0);//message Url dalei avant redirect
		
		//on verifie si le ticket existe
		$id_cmd=$_GET['id_cmd'];
		$chk_cmd=db_single_read("select count(*) as cnt from cmd where id = $id_cmd");
		if($chk_cmd->cnt!=1)$js->alert_redirect("Se ticket n existe pas","index.php?system=cmd&sub_system=lobby",0);//message Url dalei avant redirect
		
		//on load le ticket
        $cmd->load($id_cmd);
        
        //iframe info client
        $box->angle_in('10','10','402','230','#FFFFEF','black','','','100',"",'',"");	
        echo "<iframe src='index.php?system=customer/fiche.iframe&sub_system=show&id_customer=$cmd->id_customer&no_interface' frameborder=0 width=100% height=100%></iframe>";			
        $box->angle_out("");

		$box->angle_in('430','0',600,60,'','','','',100,"Titre","",'');
			$form->open("index.php?system=cmd&sub_system=update_titre&no_interface","POST");
				$form->hidden("id_cmd","$cmd->id");
				$form->text("titre",80,"$cmd->titre");
			$form->close();
		$box->angle_out("");
		
		//affichage des feedback
		$width=840;$height=380;
		$box->angle_in('420','40',$width+2,$height+2,'white','black','','',100,'',"",'');
			echo "<iframe frameborder=0 width=100% height=100% src=index.php?system=feedback.iframe&sub_system=show_feedback&sys=cmd&id_record=$cmd->id&width=$width&height=$height&no_interface></iframe>";
		$box->angle_out('');
		
		//affichage de la liste des item de la commande 
		$box->angle_in('20','433',1458,380,'white','red','','',100,"","",'');
			echo "<iframe frameborder=0 src='index.php?system=cmd/item.iframe&sub_system=show_item&id_cmd=$cmd->id&no_interface' width=100% height=100%></iframe>";
		$box->angle_out('');
        
        
		//info odp
		$box->angle_in('1280','20','200','190','','steelblue','','',100,"Commande","",'');
            echo "<li>Ticket no : ";$form->text_disabled("","6","$cmd->id");echo"</li>";
            echo "<li>Status : ";$form->text_disabled("","9",$cmd->status);echo"</li>";
			//$form->hidden('id_ticket',$ticket->id);
			//$tech_in=db_single_read("select * from user where id=$ticket->tech_in");
			echo "<li>Ouvert par : ";$form->text_disabled("","20",$sugar->show_name_user($cmd->tech_in));echo"</li>";
			echo "<li>Date ouverture : ";$form->text_disabled("","15",date("d/m/Y H:i",$cmd->dt_in));echo"</li>";
			
		$box->angle_out('');
		
		//Menu boutton
		$box->empty_in('1280','230',200,210,'','','','',100,"",'','');//imprimer reception
        
        //imprimer mail commande
		echo "<a href='index.php?system=cmd&sub_system=print_mail_cmd&id_cmd=$cmd->id&no_interface' target=_blank>";
        $box->angle('','','200','25','lightgreen','black','','',100,"Mail commande","",'');//imprimer reception
        echo "</a>";
        $box->angle('','','200',10,'','','','',100,"","",'');//case vide
		
		//imprimmer commande Client
		echo "<a href='index.php?system=cmd&sub_system=print_cmd_customer&id_cmd=$cmd->id&no_interface' target=_blank>";
        $box->angle('','','200',25,'lightgreen','black','','',100,"Imprimer commande","",'');//imprimer reception
        echo "</a>";
        $box->angle('','','200',10,'','','','',100,"","",'');//case vide
        
        //bouton Ouvrir
        if(($cmd->status=='close')or($cmd->status=='wait')or($cmd->status=='end'))
            {
            $box->angle('','','200',25,'lightgreen','black','','',100,"Ouvrir commande","index.php?system=cmd&sub_system=open_cmd&id_cmd=$cmd->id&no_interface",'');//imprimer reception
            $box->angle('','','200',10,'','','','',100,"","",'');//case vide
            }
		//bouton suspendre
        if(($cmd->status=='open'))
            {
            $box->angle('','','200',25,'lightgreen','black','','',100,"Suspendre commande","index.php?system=cmd&sub_system=wait_cmd&id_cmd=$cmd->id&no_interface",'');//imprimer reception
            $box->angle('','','200',10,'','','','',100,"","",'');//case vide
            }
        
		//commande recu
        if(($cmd->status=='open')or($cmd->status=='wait'))
            {
            $box->angle('','','200',25,'lightgreen','black','','',100,"Commande recu","index.php?system=cmd&sub_system=end_cmd&id_cmd=$cmd->id&no_interface",'');//imprimer reception
		    $box->angle('','','200',10,'','','','',100,"","",'');//case vide
            }
        
		//commande remis au client
        if(($cmd->status=='end'))
            {
            $box->angle('','','200',25,'lightgreen','black','','',100,"Commande remis au client","index.php?system=cmd&sub_system=close_cmd&id_cmd=$cmd->id&no_interface",'');//imprimer reception
            $box->angle('','','200',10,'','','','',100,"","",'');//case vide
            }
        
		//Effacer commande
        if(($cmd->status=='hidden')and($sugar->security_cmd>1))
            {
            $box->angle('','','200',25,'#CC5BF4','black','','',100,"Destruction definitive","index.php?system=cmd&sub_system=del_admin_cmd&id_cmd=$cmd->id&no_interface",'');//imprimer reception
            $box->angle('','','200',10,'','','','',100,"","",'');//case vide
            }
        if($cmd->status!='hidden')
            {
            $box->angle('','','200',25,'red','black','','',100,"Effacer commande","index.php?system=cmd&sub_system=del_cmd&id_cmd=$cmd->id&no_interface",'');//imprimer reception
            $box->angle('','','200',10,'','','','',100,"","",'');//case vide
            }
        //$odp->show_button($box,$sugar,$server);
		$box->empty_out("");
		
		};break;
######################################################################################################################
	case 'edit_pv':
		{
		$id_cmd = $_GET['id_cmd'];
		$id_item = $_GET['id_item'];
		$item=db_single_read("select * from cmd_item where id =$id_item");
		$js->encode_chiffre('pv',$item->prix_vente,"index.php?system=cmd&sub_system=update_pv&id_cmd=$id_cmd&id_item=$id_item&no_interface");
		};break;
######################################################################################################################
	case 'update_pv':
		{
		$id_cmd = $_GET['id_cmd'];
		$id_item = $_GET['id_item'];
		$new_pv = $_GET['pv'];
		$item=db_single_read("select * from cmd_item where id =$id_item");
		$marge =round(($new_pv/$item->prix_achat),3);
		db_write("UPDATE cmd_item SET marge='$marge',prix_vente='$new_pv' WHERE id = $id_item;");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=cmd&sub_system=edit_cmd&id_cmd=$id_cmd'/>";
		};break;
######################################################################################################################
	case 'update_titre':
		{
		$id_cmd=$_POST['id_cmd'];
		$titre=$_POST['titre'];
		db_write("update cmd set titre='$titre' where id = $id_cmd;");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=cmd&sub_system=edit_cmd&id_cmd=$id_cmd'/>";
		};break;
######################################################################################################################
	case 'add_feedback':
		{
		$id_cmd=$_POST['id_cmd'];
		$dt_insert=time();
		$remarque=$_POST['remarque'];
		db_write("insert into cmd_feedback(id_tech,id_cmd,dt_insert,remarque)values($sugar->id,$id_cmd,$dt_insert,'$remarque')");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=cmd&sub_system=edit_cmd&id_cmd=$id_cmd'/>";
		};break;
######################################################################################################################
	case 'add_item':
		{
		if(isset($_GET['label']))$label=$_GET['label'];else $label="cmd";

		$id_cmd=$_GET['id_cmd'];
		db_write("INSERT INTO `cmd_item` (`id`, `id_cmd`, `nom`, `fournisseur`, `url_item`, `qt`, `prix_achat`, `marge`) VALUES (NULL, $id_cmd, '', 'Techdata', '', '1', '', '1.73');");
		$id_item=db_single_read("select * from cmd_item order by id desc limit 1");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=cmd&sub_system=edit_item&id_item=$id_item->id&label=$label'/>";
		};break;
######################################################################################################################
	case 'edit_item':
		{
		$id_item=$_GET['id_item'];
		//$label=$_GET['label'];
		$item=db_single_read("select * from cmd_item where id = $id_item");
		$box->box_rond_in('300','0',800,'600','orange','lightgrey','','',100,"","",'');
			$form->open("index.php?system=cmd&sub_system=update_item&no_interface","POST");
			echo "<center>";
			echo "Id cmd : ";$form->text_disabled("id",5,"$item->id");
			$form->hidden("id_item","$item->id");
			$form->hidden("id_cmd","$item->id_cmd");
			//$form->hidden("label","$label");
			echo "<br>Nom : ";$form->text("nom",80,"$item->nom");
			echo "<br>Fournisseur : ";$form->text("fournisseur",10,"$item->fournisseur");
			echo "<br>Url Item : ";$form->textarea("url_item",5,80,"$item->url_item");
			echo "<br>Qt : ";$form->text("qt",5,"$item->qt");
			echo"<li>Prix achat : ";$form->text("prix_achat",10,"$item->prix_achat");echo"</li>";
			echo"<li>Marge : ";$form->text("marge",5,"$item->marge");echo"%</li>";
			echo"<br>";$form->send("Suite");
			$form->close();
		$box->box_rond_out('');
		};break;
######################################################################################################################
	case 'update_item':
		{
		$id_item=$_POST['id_item'];
		$id_cmd=$_POST['id_cmd'];
		//$label=$_POST['label'];
		$nom=$_POST['nom'];
		$fournisseur=$_POST['fournisseur'];
		$url_item=$_POST['url_item'];
		$qt=$_POST['qt'];
		$prix_achat=$_POST['prix_achat'];
		$marge=$_POST['marge'];
		$prix_vente=round($prix_achat*$marge,2);
		db_write("UPDATE `cmd_item` SET `nom` = '$nom', `fournisseur` = '$fournisseur', `url_item` = '$url_item', `qt` = '$qt', `prix_achat` = '$prix_achat', `marge` = '$marge',prix_vente='$prix_vente' WHERE `cmd_item`.`id` = $id_item; ");
		
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=$sugar->label&sub_system=edit_$sugar->label&id_$sugar->label=$id_cmd'/>";break;
		
		};break;
######################################################################################################################
	case 'check_delete_item':
		{
		$id_item=$_GET['id_item'];
		$id_cmd=$_GET['id_cmd'];
		$url_yes="index.php?system=cmd&sub_system=delete_item&id_item=$id_item&id_cmd=$id_cmd&no_interface";
		$url_no="index.php?system=cmd&sub_system=edit_cmd&id_cmd=$id_cmd";
		$js->confirmation("Etes vous certain de vouloir effacer l item ?",$url_yes,$url_no);
		};break;
######################################################################################################################
	case 'delete_item':
		{
		$id_item=$_GET['id_item'];
		$id_cmd=$_GET['id_cmd'];
		db_write("delete from cmd_item where id = $id_item");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=$sugar->label&sub_system=edit_$sugar->label&id_$sugar->label=$id_cmd'/>";break;
		};break;
######################################################################################################################
	case 'end_cmd':
		{
		$id_cmd=$_GET['id_cmd'];
		db_write("update cmd set status='end',dt_out=0 where id = $id_cmd");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=cmd&sub_system=edit_cmd&id_cmd=$id_cmd'/>";
		};break;
######################################################################################################################
	case 'wait_cmd':
		{
		$id_cmd=$_GET['id_cmd'];
		db_write("update cmd set status='wait',dt_out=0 where id = $id_cmd");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=cmd&sub_system=edit_cmd&id_cmd=$id_cmd'/>";
		};break;
######################################################################################################################
	case 'close_cmd':
		{
		$id_cmd=$_GET['id_cmd'];
		db_write("update cmd set status='close',dt_out=".(time())." where id = $id_cmd");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=cmd&sub_system=edit_cmd&id_cmd=$id_cmd'/>";
		};break;
######################################################################################################################
	case 'chk_del_cmd':
		{
		$id_cmd=$_GET['id_cmd'];
		$url_yes="index.php?system=cmd&sub_system=del_cmd&id_cmd=$id_cmd&no_interface";
		$url_no="index.php?system=cmd&sub_system=edit_cmd&id_cmd=$id_cmd";
		$js->confirmation("Etes vous certain de vouloir effacer la commande no $id_cmd ?",$url_yes,$url_no);
		//echo "<meta http-equiv='refresh' content='0; url=index.php?system=cmd&sub_system=edit_cmd&id_cmd=$id_cmd'/>";
		};break;
######################################################################################################################
	case 'del_cmd':
		{
		$id_cmd=$_GET['id_cmd'];
		db_write("update cmd set status='hidden',dt_out=".time()." where id = $id_cmd");
		$sugar->admin_add_log($system,$sub_system,"Supression de la commande no $id_cmd",2);
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=cmd'/>";
		};break;
######################################################################################################################
	case 'del_admin_cmd':
		{
		if($sugar->security_cmd>1)
			{
			$id_cmd=$_GET['id_cmd'];
			//del from Feedback
			$rqt="delete from cmd_feedback where id_cmd = $id_cmd;";
			//del from item 
			$rqt.="delete from cmd_item where id_cmd = $id_cmd;";
			//del from cmd
			$rqt.="delete from cmd where id = $id_cmd;";
			db_write($rqt);
			$sugar->admin_add_log($system,$sub_system,"Admin - destruction de la commande no $id_cmd",3);
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=cmd'/>";
			}
		};break;
######################################################################################################################
	case 'open_cmd':
		{
		$id_cmd=$_GET['id_cmd'];
		db_write("update cmd set status='open',dt_out='0' where id = $id_cmd");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=cmd&sub_system=edit_cmd&id_cmd=$id_cmd'/>";
		};break;
######################################################################################################################
	case 'print_mail_cmd':
		{
		$cmd->load($_GET['id_cmd']);
		$cmd_item_tmp=db_read("select * from cmd_item where id_cmd = $cmd->id");
		$color="white";
		$no_item=1;

		echo "<table border=1><tr><td>
		<img src='img/100px/$cmd->shop_logo'></img>
		</td><td width=400>
		<b>Requete de commande no $cmd->id</b><br><br>Bonjour,<br>Pourriez vous commander les articles suivant svp.<br>D avance merci
		</td><td width=500>
		<center><b>Client:</b><br>$cmd->prenom $cmd->nom
		<br>$cmd->call1 - $cmd->call2<br>$cmd->adresse</center>
		</td></tr></table>";
				
		echo "<table border=1>";
		
		while($cmd_item = $cmd_item_tmp->fetch())
			{
			if($color=='lightgrey')$color='white';
			else $color='lightgrey';
			if($cmd_item->qt>1)$qtcolor="orange";
			else $qtcolor=$color;
			echo "<tr bgcolor=$color><td bgcolor=$color>ITEM $no_item : $cmd_item->nom</td><td>Prix achat : $cmd_item->prix_achat &euro;</td><td>Prix vente : $cmd_item->prix_vente &euro;</td><td bgcolor=$qtcolor>Quantite : $cmd_item->qt</td></tr>";
			
			if($cmd_item->url_item=="")echo "<tr><td colspan=4 bgcolor=$color>Pas de lien</td></tr>";
			else echo "<tr><td colspan=4 bgcolor=$color><a href='$cmd_item->url_item' target=_blank>$cmd_item->url_item</a></td></tr>";
			//echo "<tr><td colspan=4 bgcolor=$color><a href='$url' target=_blank>$url</a></td></tr>";
			$no_item++;
			}
		echo "</table>";
		echo "<font size=1><i>Generated by SUGAR (System unifie gestion aller retour) --- Kprod 2019</i></font>";
		
		//echo "<body onload='window.print()'>";
		echo "<meta http-equiv='refresh' content='5; url=index.php?system=cmd&sub_system=close_page'/>";
		
		};break;
######################################################################################################################
	case 'print_cmd_customer':
		{
		include('../../www_off/sugar/obj/print.obj.php');
		$print=new _print;
		$cmd->load($_GET['id_cmd']);
		$print->header($box,$system,$_GET['id_cmd'],$sugar);
		
		$grand_total_vente=0;
		$grand_total_achat=0;
		
		//ligne menu 
		$box->angle_in('','',738,22,'lightgreen','green','','',100,"","",'');
				
			$box->angle('','',486,20,'lightgreen','green','','',100,"Description","",'');
			$box->angle('','',100,20,'lightgreen','green','','',100,"Prix","",'');
			$box->angle('','',50,20,'lightgreen','green','','',100,"Qt","",'');
			$box->angle('','',100,20,'lightgreen','green','','',100,"Prix total","",'');
			
		$box->angle_out('');
		
		$cmd_item_tmp=db_read("select * from cmd_item where id_cmd = $cmd->id");
		while($cmd_item = $cmd_item_tmp->fetch())
			{
			$box->angle_in('','',738,22,'','','','',100,"","",'');
				$box->angle('','',486,20,'','green','','',100,"$cmd_item->nom","",'');//item

				$prix_vente=$cmd_item->prix_vente;
				$box->angle('','',100,20,'','green','','',100,"$prix_vente &euro;","",'');
				$box->angle('','',50,20,'','green','','',100,"$cmd_item->qt","",'');
				$prix_ttl=$prix_vente*$cmd_item->qt;
				$box->angle('','',100,20,'','green','','',100,"$prix_ttl &euro;","",'');
			$box->angle_out('');
			$grand_total_vente+=$prix_ttl;
			}
		//affichage du total
		$box->angle_in('','',738,22,'','','','',100,"","",'');
			$box->angle('','',536,20,'','','','',100,"","",'');
			$box->angle('','',100,20,'','','','',100,"Total : ","",'');

			$box->angle('','',100,20,'','red','','',100,"$grand_total_vente &euro;","",'');
		$box->angle_out('');
		
		$print->footer($box,$sugar);
		};break;
######################################################################################################################
	}
?>