<?php
if(isset($_GET['id_customer']))
	{
	$id_customer=$_GET['id_customer'];
	$cust=db_single_read("select * from customer where id = $id_customer");
	}
//else echo "<meta http-equiv='refresh' content='0; url=index.php?system=customer/client_actif.iframe&sub_system=show_list_user&no_interface'/>";

switch ($sub_system)
	{
######################################################################################################################
	case 'show':
		{
		//affichage
		$box->empty_in('10','10','75','166','','','','',100,"","",'');
			$box->empty('','','80','22','','','','',100,"Prenom :","",'');
			$box->empty('','','80','22','','','','',100,"Nom :","",'');
			$box->empty('','','80','50','','','','',100,"Adresse :","",'');
			$box->empty('','','80','22','','','','',100,"Call :","",'');
			$box->empty('','','80','22','','','','',100,"Mail :","",'');
			$box->empty('','','80','22','','','','',100,"Tva :","",'');
		$box->empty_out('');

		$box->empty_in('85','10','262','188','','','','',100,"","",'');
			$box->empty_in('','','260','22','','','','',100,"","",'');$form->text_disabled("prenom",32,"$cust->prenom");$box->empty_out('');
			$box->empty_in('','','260','22','','','','',100,"","",'');$form->text_disabled("nom",32,"$cust->nom");$box->empty_out('');
			$box->empty_in('','','260','50','','','','',100,"","",'');$form->textarea_disabled("adresse",2,33,"$cust->adresse \n$cust->cp $cust->ville");$box->empty_out('');
			$box->empty_in('','','260','22','','','','',100,"","",'');$form->text_disabled("call1",13,"$cust->call1");$form->text_disabled("call2",13,"$cust->call2");$box->empty_out('');
			$box->empty_in('','','260','22','','','','',100,"","",'');$form->text_disabled("mail",32,"$cust->mail");$box->empty_out('');
			$box->empty_in('','','260','22','','','','',100,"","",'');$form->text_disabled("no_tva",32,"$cust->no_tva");$box->empty_out('');
			$box->empty_in('','','260','22','','','','',100,"","",'');$form->text_disabled("",32,"Id client : $cust->id");$box->empty_out('');
		$box->empty_out('');
				
		$box->angle('10','220','150','20','orange','black','','',100,"Unload @ ".date("H:i",(time()+900)),"index.php?system=customer/client_actif.iframe&sub_system=unload_customer&no_interface",'');
		
		echo "<a href='index.php?system=customer&sub_system=load_customer&id_customer=$cust->id' target=_parent>";
		$box->angle('180','220','150','20','orange','black','','',100,"Edit","",'');
		echo "</a>";
		echo "<meta http-equiv='refresh' content='900; url=index.php?system=customer/client_actif.iframe&sub_system=unload_customer&no_interface'/>";
		};break;
######################################################################################################################
	case 'unload_customer':
		{
		$customer->id=0;
		unset($_SESSION['customer']);
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=customer/client_actif.iframe&sub_system=show_list_user&no_interface'/>";
		};break;
######################################################################################################################
case 'show_list_user':
		{
		$box->empty_in('0','0','350','250','','','','',100,"User connected","",'');
			$cust_tmp=db_read("select * from user where id !=7 and id!=0 and status !='off' order by dt_last_login desc limit 10");
			while($cust = $cust_tmp->fetch())
				{
				$color='red';
				$box->empty_in('','','340','20','','','','',100,"","",'');
					if ($cust->dt_last_login > (time()-3600))$color='orange';
					if ($cust->dt_last_login > (time()-600))$color='green';
					$box->angle('','','10','20',$color,'black','','',100,"","",'');
				
					$box->angle_in('','','210','20','','','','',100,"","",'');
					echo $cust->prenom." ".$cust->nom;
					$box->angle_out('');
				
					$box->angle_in('','','120','22','','','','',100,"","",'');
					echo date("d/m/y H:i",$cust->dt_last_login);
					$box->angle_out('');
				$box->empty_out('');
				}
		$box->angle_out('');
		
		echo "<meta http-equiv='refresh' content='60; url=index.php?system=customer/client_actif.iframe&sub_system=show_list_user&no_interface'/>";
		};break;
	}
?>