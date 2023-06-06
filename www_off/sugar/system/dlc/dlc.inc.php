<?php
echo "<body style='background-color:$sugar->background_color'>";
if($sugar->security_cmd==0)$js->alert_redirect("No acces","index.php",0);
$sugar->label="dlc";

switch ($sub_system)
	{
######################################################################################################################
	case 'lobby':
		{
		$box->box_rond('','',200,'22','yellow','black','','',100,"Ajouter un DLC","index.php?system=dlc/dlc&sub_system=add_dlc&no_interface",'');
		$box->empty('','','1298','22','black','','','',100,"<marquee width=1298><font color=lightblue>Dlc en stock <font color=black> **********************<font color=lightgreen>Dlc attribue a un client</marquee>","",'');
		$box->angle_in('','',1498,'22','#88a0a8','','','',100,"","",'');
			$box->angle('','',50,'20',"",'lightgrey','','',100,"Id","",'');
			$box->angle('','',420,'20',"",'lightgrey','','',100,"Client","",'');
			//$box->angle('','',150,'20','','lightgrey','','',100,"No de contact","",'');
			$box->angle('','',600,'20','','lightgrey','','',100,"Description","",'');
			$box->angle('','',130,'20','','lightgrey','','',100,"Date d entre",'','');
			$box->angle('','',130,'20','','lightgrey','','',100,"Date d attribution",'','');

			$box->angle('','','83','20','','lightgrey','','',100,"Prix achat",'',"");
			$box->angle('','','83','20','','lightgrey','','',100,"Prix vente",'',"");
		$box->angle_out('');
		$cnt_tckt=30;
		//voir les dlc en stock
		$dlc_tmp=db_read("select * from customer_dlc where id_customer=0 and status !='hidden';");
		while($dlc = $dlc_tmp->fetch())
			{
			//on choisis la couleur de la ligne en fonction du status du ticket repair
			$color='lightblue';
			$url="index.php?system=dlc/dlc&sub_system=edit_dlc&id_dlc=$dlc->id";
			$box->angle_in('','',1498,'22','','','','',100,"","",'');
				$box->angle('','',50,'20',$color,'black','','',100,"$dlc->id",$url,'');
				$box->angle('','','420','20',$color,'black','','',100,"Stock",$url,'');
				//$box->angle('','',150,'20',$color,'black','','',100,'',$url,'');
				$box->angle('','',600,'20',$color,'black','','',100,"$dlc->nom_produit",$url,'');
				$box->angle('','',130,'20',$color,'black','','',100,"</b>".date("d/m/Y", $dlc->dt_in),$url,'');
				$box->angle('','',130,'20',$color,'black','','',100,"",$url,'');
				$box->angle('','','83','20',$color,'black','','',100,"$dlc->prix_achat",$url,'');
				$box->angle('','','83','20',$color,'black','','',100,"$dlc->prix_vente",$url,'');
			$box->angle_out('');
			$cnt_tckt--;
			}
		//voir les dlc des clients 
		$dlc_tmp=db_read("select * from customer_dlc where id_customer !=0 and status !='hidden' order by id desc limit $cnt_tckt;");
		while($dlc = $dlc_tmp->fetch())
			{
			//on choisis la couleur de la ligne en fonction du status du ticket repair
			$color='lightgreen';
			$url="index.php?system=dlc/dlc&sub_system=edit_dlc&id_dlc=$dlc->id";
			$box->angle_in('','',1498,'22','','','','',100,"","",'');
				$box->angle('','',50,'20',$color,'black','','',100,"$dlc->id",$url,'');
				$cust=$sugar->get_customer($dlc->id_customer);
				$box->angle('','','420','20',$color,'black','','',100,"</center></b>$cust->prenom $cust->nom",$url,'');
				//$box->angle('','','150','20',$color,'black','','',100,$sugar->show_call_formated($cust->call1),$url,'');
				$box->angle('','','600','20',$color,'black','','',100,"</center></b>$dlc->nom_produit",$url,'');
				$box->angle('','','130','20',$color,'black','','',100,"</b>".date("d/m/Y", $dlc->dt_in),$url,'');
				$box->angle('','','130','20',$color,'black','','',100,"</b>".date("d/m/Y", $dlc->dt_out),$url,'');
				$box->angle('','','83','20',$color,'black','','',100,"$dlc->prix_achat",$url,'');
				$box->angle('','','83','20',$color,'black','','',100,"$dlc->prix_vente",$url,'');
			$box->angle_out('');
			$cnt_tckt--;
			}
		};break;
######################################################################################################################
	case 'add_dlc':
		{
		//if($customer->id==0)$js->alert_redirect("Aucun client actif","index.php?system=customer",0);
		db_write("insert into customer_dlc(id_tech_input,id_customer,dt_in)values('$sugar->id','0','".time()."');");
		$id_dlc=db_single_read("select * from customer_dlc order by id desc limit 1");
		$sugar->admin_add_log($system,$sub_system,"Creation du dlc $id_dlc->id",1);
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=dlc/dlc&sub_system=edit_dlc&id_dlc=$id_dlc->id'/>";
		};break;
######################################################################################################################
	case 'edit_dlc':
		{
		$x_img=430;
		$y_img=50;
		$x_txt=430;
		$y_txt=570;
		
		if(!isset($_GET['id_dlc']))$js->alert_redirect("Aucun dlc selectionner","index.php?system=dlc",0);
		$id_dlc=$_GET['id_dlc'];
		$dlc=db_single_read("select * from customer_dlc where id =$id_dlc");
        
         //iframe info client
        



		//iframe info client
		if($dlc->id_customer!=0)
			{
            $box->angle_in('10','10','402','230','#FFFFEF','black','','','100',"",'',"");	
                echo "<iframe src='index.php?system=customer/fiche.iframe&sub_system=show&id_customer=$dlc->id_customer&no_interface' frameborder=0 width=100% height=100%></iframe>";			
            $box->angle_out("");
			}
		else $box->angle('10','10','402','230','#FFFFEF','black','','','100',"Pas de client designer",'',"");	
			
		//si le dlc est deja a un client 
		if($dlc->id_customer!=0)
			{
			$form->open("index.php?system=dlc/dlc&sub_system=update_dlc&id_dlc=$dlc->id&no_interface","POST");
				$box->angle_in($x_img,$y_img,'500','500','','black','','',100,"",'',"");
				echo "<img src=img/dlc/$dlc->img width=100%></img>";
				$box->angle_out("");
				$box->angle_in($x_txt,$y_txt,'500','150','','black','','',100,"",'',"");
				echo "Produit<br>";$form->textarea_disabled("name",4,60,"$dlc->nom_produit");
				echo "<br>Key:<br>";$form->text_disabled("key",50,$dlc->code);
				$box->angle_out("");			
			$form->close();
			}
		else 
			{
			if($dlc->id_tech_input==$sugar->id)
				{//si le dlc n a pas de client assigner et a ete creez par l utilisateur
				$box->angle_in($x_img,$y_img,'500','500','','black','','',100,"",'',"");
				//echo "<img src=img/dlc/$dlc->img width=100%></img>";
				echo "<iframe frameborder=0 height=100% width=100% src='index.php?system=dlc/dlc.iframe&sub_system=show_img&no_interface&id_dlc=$dlc->id&img=$dlc->img'></iframe>";
				$box->angle_out("");
				$box->angle_in($x_txt,$y_txt,'700','250','','black','','',100,"",'',"");
					$form->open("index.php?system=dlc/dlc&sub_system=update_dlc&id_dlc=$dlc->id&no_interface","POST");
					echo "Produit<br>";$form->textarea("name",2,90,"$dlc->nom_produit");
					echo "<br>Key:<br>";$form->text("key",50,$dlc->code);
					echo "<br>Prix achat : <br>";$form->text("pa",10,$dlc->prix_achat);
					echo "<br>Prix vente : <br>";$form->text("pv",10,$dlc->prix_vente);
					$box->empty_in("300","180",'100','50','','black','','',100,"",'',"");
					$form->send("Update");
					$box->empty_out(".");
					$form->close();
				$box->angle_out(".");
				
				//upload file 
				$box->angle_in('430','10','400','27','','black','','',100,"",'',"");
				echo "<iframe frameborder=0 height=100% width=100% src='index.php?system=iframe/file.iframe&sub_system=select_file&size_file=300000&dir=img/dlc/&no_interface'></iframe>";
				$box->angle_out("");
				}
			else 
				{//si le dlc n a pas de client assigner et n a pas ete creez par l utilisateur
				//fiche client vierge
				$box->angle('10','10','402','212','#FFFFEF','black','','','100',"",'',"");	
				//image du dlc
				$box->angle_in($x_img,$y_img,'500','500','','black','','',100,"",'',"");
				echo "<img src=img/dlc/$dlc->img width=100%></img>";
				$box->angle_out("");
				//fiche technique du dlc
				$box->angle_in($x_txt,$y_txt,'700','200','','black','','',100,"",'',"");
				echo "Produit<br>";$form->textarea_disabled("name",2,90,"$dlc->nom_produit");
				echo "<br>Key:<br>";
				$form->text_disabled("key",50,'******************************');
				$box->angle_out("");
				}
			}

		//recapitulatif
		$box->angle_in('10','250','402','300','lightblue','black','','',100,"Info DLC",'',"");
		echo "<li>Encode par : ".$sugar->show_name_user($dlc->id_tech_input)." <br>le ".date("d/m/Y - H:i",$dlc->dt_in)."</li>";
		if($dlc->id_tech_attribute!=0)
			{
			echo "<li>Attribue par : ".$sugar->show_name_user($dlc->id_tech_attribute)."<br>le ".date("d/m/Y - H:i",$dlc->dt_out)."</li>";
			}
		$box->angle_out("");
		
		if($dlc->id_customer==0)$box->angle('1280','20','200','25','lightgreen','black','','',100,"Attribuer a mon client actif","index.php?system=dlc/dlc&sub_system=atribute_dlc_customer&id_dlc=$dlc->id","");
		
		echo "<a href='index.php?system=dlc/dlc&sub_system=print_dlc&id_dlc=$dlc->id&no_interface' target=_blank>";
		if($dlc->id_customer!=0)$box->angle('1280','20','200','25','lightgreen','black','','',100,"Imprimer","","");
		echo "</a>";
		if($dlc->id_tech_input==$sugar->id)$box->angle('1280','160','200','25','red','black','','',100,"Effacer DLC","index.php?system=dlc/dlc&sub_system=delete_dlc&id_dlc=$dlc->id","");
		
		};break;
######################################################################################################################
	case 'update_dlc':
		{
		$id=$_GET['id_dlc'];
		$name=$_POST['name'];
		$key=$_POST['key'];
		$pa=$_POST['pa'];
		$pv=$_POST['pv'];
		db_write ("update customer_dlc set nom_produit='$name',code='$key',prix_achat='$pa',prix_vente='$pv' where id = $id");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=dlc/dlc&sub_system=edit_dlc&id_dlc=$id'/>";
		};break;
######################################################################################################################
	case 'delete_dlc':
		{
		$id=$_GET['id_dlc'];
		db_write ("update customer_dlc set status='hidden' where id = '$id'");
		$sugar->admin_add_log($system,$sub_system,"Supression du dlc $id",1);
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=dlc/dlc'/>";
		};break;
######################################################################################################################
	case 'print_dlc':
		{
		$id_dlc=$_GET['id_dlc'];
		$dlc=db_single_read("select * from customer_dlc where id =$id_dlc");
		$cust=db_single_read("select * from customer where id =$dlc->id_customer");
		//$shop=db_single_read("select * from shop where id =$dlc->id_shop");
		
		if($dlc->id_customer!=0)
			{
			include('../../www_off/sugar/obj/print.obj.php');
			$print=new _print;
			$print->header($box,$system,$_GET['id_dlc'],$sugar);
		
			//$box->angle_in('219','100','300','300','lightgrey','black','','',100,'','','');
			echo "<br><br><center><img src='img/dlc/$dlc->img' width=298px></img></center>";
			//$box->angle_out(".");
		
			$box->angle('50','500','638','50','lightgrey','black','','',100,$dlc->nom_produit."<br>".$dlc->code,'','');

			$print->footer($box,$sugar);

			echo "<body onload='window.print();window.close()'>";
			}
		else $js->alert_redirect("Vous ne pouvez pas imprimer un DLC tant qu il n est pas attribue a un client","index.php?system=dlc/dlc",0);
		
		};break;
######################################################################################################################
	case 'atribute_dlc_customer':
		{
		if($customer->id==0)$js->alert_redirect("Pas de client actif","index.php?system=customer",0);
		$id_dlc=$_GET['id_dlc'];
		db_write ("update customer_dlc set id_tech_attribute=$sugar->id,id_customer=$customer->id,status='end',dt_out=".time()." where id = $id_dlc");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=dlc/dlc&sub_system=edit_dlc&id_dlc=$id_dlc'/>";
		};break;
	}
?>