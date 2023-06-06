<?php
if($sugar->security_cmd==0)$js->alert_redirect("No acces","index.php",0);
if(isset($_GET['id_cmd']))$id_cmd=$_GET['id_cmd'];
switch ($sub_system)
	{
######################################################################################################################
	case 'show_item':
		{
		$height=34;
		$grand_total_pa=0;
		$grand_total_pv=0;
		$box->empty_in('','',1430,22,'','','','',100,"","",'');
			$box->angle('','',720,20,'lightgreen','green','','',100,"Item","",'');
			$box->angle('','',120,20,'lightgreen','green','','',100,"Fournisseur","",'');
			$box->angle('','',50,20,'lightgreen','green','','',100,"Url","",'');
			$box->angle('','',100,20,'lightgreen','green','','',100,"Prix achat","",'');
			$box->angle('','',100,20,'lightgreen','green','','',100,"Prix vente","",'');
			$box->angle('','',100,20,'lightgreen','green','','',100,"Qt","",'');
			$box->angle('','',100,20,'lightgreen','green','','',100,"Prix total","",'');
			$box->angle('','',100,20,'lightgreen','green','','',100,"Marge","",'');
			$box->angle('','',20,20,'lightgreen','green','img/edit.gif','',100,"","",'');
			$box->angle('','',20,20,'lightgreen','green','img/delete.gif','',100,"","",'');
		$box->empty_out('');
		
		$cmd_item_tmp=db_read("select * from cmd_item where id_cmd = $id_cmd order by prix_vente desc");
		while($cmd_item = $cmd_item_tmp->fetch())
			{
			$height+=22;
			$box->empty_in('','',1430,22,'','','','',100,"","",'');
				$box->angle('','',720,20,'','green','','',100,"</b>$cmd_item->nom","",'');//item
				$box->angle('','',120,20,'','green','','',100,"</b>$cmd_item->fournisseur","",'');//fournisseur
				$box->angle_in('','',50,20,'','green',"","",100,"","","");//url_item
				echo "<a href='$cmd_item->url_item' target=_blank><img src='img/link.gif'></img></a>";
				$box->angle_out('');
				$box->angle('','',100,20,'','green','','',100,"$cmd_item->prix_achat &euro;","",'');
				$box->angle('','',100,20,'','green','','',100,"$cmd_item->prix_vente &euro;","index.php?system=$system&sub_system=edit_pv&id_item=$cmd_item->id&id_cmd=$cmd_item->id_cmd&no_interface",'');
				$box->angle('','',100,20,'','green','','',100,"$cmd_item->qt","",'');
				
				$prix_ttl_pa=$cmd_item->prix_achat*$cmd_item->qt;
				$prix_ttl_pv=$cmd_item->prix_vente*$cmd_item->qt;
				$box->angle('','',100,20,'','green','','',100,"$prix_ttl_pv &euro;","",'');
				$box->angle('','',100,20,'','green','','',100,round((($cmd_item->marge*100)-100),3)."%","",'');
				
				$box->angle('','',20,20,'','green','img/20px/edit.gif','',100,"","index.php?system=$system&sub_system=edit_item&id_item=$cmd_item->id&no_interface",'');
				$box->angle('','',20,20,'','green','img/20px/delete.gif','',100,"","index.php?system=$system&sub_system=check_delete_item&id_item=$cmd_item->id&id_cmd=$cmd_item->id_cmd&no_interface",'');
			$box->empty_out('');
			$grand_total_pa+=$prix_ttl_pa;
			$grand_total_pv+=$prix_ttl_pv;
			}
		
		$box->angle_in('','',1358,22,'','','','',100,"","",'');
			$box->angle('','',1040,20,'','','','',100,"","",'');
			$box->angle('','',150,20,'','','','',150,"Total Prix achat: ","",'');
			$box->angle('','',100,20,'','green','','',100,"$grand_total_pa &euro;","",'');
		$box->angle_out('');
		$box->angle_in('','',1358,22,'','','','',100,"","",'');
			$box->angle('','',1040,20,'','','','',100,"","",'');
			$box->angle('','',150,20,'','','','',100,"Total Prix vente: ","",'');
			$box->angle('','',100,20,'','red','','',100,"$grand_total_pv &euro;","",'');
		$box->angle_out('');
		$box->angle('1380',$height,'50','50','','','img/50px/add_item.gif','',100,"","index.php?system=cmd/item.iframe&sub_system=add_item&id_cmd=$id_cmd&no_interface",'');//imprimer reception
		
		};break;
######################################################################################################################
	case 'add_item':
		{
		$id_cmd=$_GET['id_cmd'];
		db_write("INSERT INTO cmd_item (`id`, `id_cmd`, `nom`, `fournisseur`, `url_item`, `qt`, `prix_achat`, `marge`) VALUES (NULL, $id_cmd, '0', 'Techdata', '0', '0', '0', '1.73');");
		$id_item=db_single_read("select * from cmd_item order by id desc limit 1");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=cmd/item.iframe&sub_system=edit_item&id_item=$id_item->id&no_interface'/>";
		};break;
######################################################################################################################
	case 'edit_item':
		{
		$id_item=$_GET['id_item'];
		$item=db_single_read("select * from cmd_item where id = $id_item");
		$form->open("index.php?system=cmd/item.iframe&sub_system=update_item&no_interface","POST");
		echo "<center>";
		echo "Id item : ";$form->text_disabled("id",5,"$item->id");
		$form->hidden("id_item","$item->id");
		$form->hidden("id_cmd","$item->id_cmd");
		echo "<br>Nom : ";$form->text("nom",80,"$item->nom");
		echo "<br>Fournisseur : ";$form->text("fournisseur",10,"$item->fournisseur");
		echo "<br>Url Item : ";$form->textarea("url_item",5,80,"$item->url_item");
		echo"<li>Prix achat : ";$form->text("prix_achat",10,"$item->prix_achat");echo"</li>";
		echo"<li>Marge : ";$form->text("marge",5,"$item->marge");echo"%</li>";
		echo "<li>Qt : ";$form->text("qt",5,"$item->qt");
		echo"<br>";$form->send("Suite");
		$form->close();
		};break;
######################################################################################################################
	case 'update_item':
		{
		$id_item=$_POST['id_item'];
		$id_cmd=$_POST['id_cmd'];
		$nom=$_POST['nom'];
		$fournisseur=$_POST['fournisseur'];
		$url_item=$_POST['url_item'];
		$qt=$_POST['qt'];
		$prix_achat=round($_POST['prix_achat'],2);
		$marge=$_POST['marge'];
		$prix_vente=round($prix_achat*$marge,2);
		db_write("UPDATE `cmd_item` SET `nom` = '$nom', `fournisseur` = '$fournisseur', `url_item` = '$url_item', `qt` = '$qt', `prix_achat` = '$prix_achat', `marge` = '$marge',prix_vente='$prix_vente' WHERE `cmd_item`.`id` = $id_item; ");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=cmd/item.iframe&sub_system=show_item&id_cmd=$id_cmd&no_interface'/>";
		};break;
######################################################################################################################
	case 'edit_pv':
		{
		$id_item = $_GET['id_item'];
		$item=db_single_read("select * from cmd_item where id =$id_item");
		$js->encode_chiffre('pv',$item->prix_vente,"index.php?system=cmd/item.iframe&sub_system=update_pv&id_cmd=$id_cmd&id_item=$id_item&no_interface");
		};break;
######################################################################################################################
	case 'update_pv':
		{
		$id_item = $_GET['id_item'];
		$new_pv = $_GET['pv'];
		$item=db_single_read("select * from cmd_item where id =$id_item");
		$marge =round(($new_pv/$item->prix_achat),3);
		db_write("UPDATE cmd_item SET marge='$marge',prix_vente='$new_pv' WHERE id = $id_item;");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=cmd/item.iframe&sub_system=show_item&id_cmd=$id_cmd&no_interface'/>";
		};break;
######################################################################################################################
	case 'check_delete_item':
		{
		$id_item=$_GET['id_item'];
		$url_yes="index.php?system=cmd/item.iframe&sub_system=delete_item&id_item=$id_item&id_cmd=$id_cmd&no_interface";
		$url_no="index.php?system=cmd/item.iframe&sub_system=edit_cmd&id_cmd=$id_cmd&no_interface";
		$js->confirmation("Etes vous certain de vouloir effacer l item ?",$url_yes,$url_no);
		};break;
######################################################################################################################
	case 'delete_item':
		{
		$id_item=$_GET['id_item'];
		db_write("delete from cmd_item where id = $id_item");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=cmd/item.iframe&sub_system=show_item&id_cmd=$id_cmd&no_interface'/>";break;
		};break;
######################################################################################################################
	}
?>