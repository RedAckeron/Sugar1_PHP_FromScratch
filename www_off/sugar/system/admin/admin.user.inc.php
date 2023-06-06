<?php
echo "<body style='background-color:$sugar->background_color'>";
if($sugar->security_admin==0)$js->alert_redirect("No acces","index.php");
if(!isset($_GET['no_interface']))$sugar->admin_menu($system,$box);
switch ($sub_system)
	{
######################################################################################################################
	case 'lobby':
		{
		////Edit user
		if($sugar->security_admin>=2)
			{
			$box->angle_in('20','40',300,'100','white','red','','',100,"Edition profil utilisateur","",'');
			$form->open("index.php?system=admin/admin.user&sub_system=edit_user","POST");
			$form->select_in('id_user',1);
			$uzer_tmp=db_read("select * from user where id!=7 and id!=0");
				while($uzer = $uzer_tmp->fetch())$form->select_option($uzer->nom." ".$uzer->prenom,$uzer->id,'');
			$form->select_out();
			$form->send('Edit');
			$form->close();
			
			$box->angle('40','70','200','20','white','red','','',100,"Ajouter utilisateur","index.php?system=admin/admin.user&sub_system=add_user_step1&no_interface",'');
			$box->angle_out('');
			}
		else $box->angle('20','20',300,'100','red','black','','',100,"Requis : acces Admin","",'');
		};break;
######################################################################################################################
	case 'add_user_step1':
		{
		$js->encode_text("Nom de famille",'nom',"","index.php?system=admin/admin.user&sub_system=add_user_step2&no_interface");
		};break;
######################################################################################################################
	case 'add_user_step2':
		{
		if($_GET['nom']=='null')$js->alert_redirect('Veuillez entrer au moins 4 lettres pour le nom','index.php?system=admin/admin.user&sub_system=lobby',0);
		$nom=$_GET['nom'];
		if ($nom=='null')echo "<meta http-equiv='refresh' content='0; url=index.php?system=admin/admin.user&sub_system=lobby'/>";
		if (strlen($nom)<4)$js->alert_redirect("Nom de famille dois contenir au moins 4 lettres !!!","index.php?system=admin/admin.user&sub_system=add_user_step1",0);//echo "<meta http-equiv='refresh' content='0; url=index.php?system=admin/admin.user&sub_system=lobby'/>";
		else
			{
			//on verifie qu il n y a pas d espace on fout tout en minuscule et on coupe les 4 premier char et on rajoute novo au debut
			$nom=str_replace(" ","",$nom);
			$nom =strtolower($nom);
			$nom="novo".substr("$nom",0,4);
						
			$chk=db_single_read("select count(*) as cnt from user where login = '$nom' limit 1");
			if($chk->cnt==1)
				{
				$rd=rand(10,99);
				$nom=$nom.$rd;
				$chk=db_single_read("select count(*) as cnt from user where login = '$nom' limit 1");
			
				if($chk->cnt==1)
					{
					echo "<li>Test avec le login $nom : $chk->cnt</li>";
					echo "<meta http-equiv='refresh' content='1; url=index.php?system=admin/user&sub_system=add_user_step2&no_interface&nom=De Vilder'/>";
					}
				}
			}
		$login=$nom;
		$password="mditdynHJ2hrg";
		$prenom="Anon";
		$nom=$_GET['nom'];
		$dt_insert=time();
		$status='ok';
		db_write("insert into user (login,password,nom,prenom,dt_insert,status)values('$login','$password','$nom','$prenom','$dt_insert','$status')");
		$select=db_single_read("select * from user order by id desc limit 1");
		echo "<meta http-equiv='refresh' content='1; url=index.php?system=admin/admin.user&sub_system=edit_user&id_user=$select->id'/>";
		};break;
######################################################################################################################
	case 'edit_user':
		{
		if (isset($_GET['id_user']))$id_user=$_GET['id_user'];
		if (isset($_POST['id_user']))$id_user=$_POST['id_user'];
		$user=db_single_read("select * from user where id = $id_user;");
		$form->open("index.php?system=admin/admin.user&sub_system=update_user&no_interface","POST");
		$form->hidden('id_user',$id_user);
		$box->angle_in('20','30','1450','800','','red','','',100,"Edition de $user->prenom $user->nom","",'');
				
			$box->angle_in('20','20','500','300','','black','','',100,"Information utilisateur","",'');
				//login
				$box->angle('','','249','25','','black','','',100,"Login :","",'');
				$box->angle_in('','','249','25','','black','','',100,"","",'');
				echo $form->text_disabled("","",$user->login);
				$box->angle_out('');
				//password
				$box->angle('','','249','25','','black','','',100,"Password :","",'');
				$box->angle_in('','','249','25','','black','','',100,"","",'');
				if($user->password=='mditdynHJ2hrg')echo $form->text_disabled("","","novoffice");
				else echo "<a href='index.php?system=admin/admin.user&sub_system=reset_password&id_user=$id_user&no_interface'>Reset</a> (pw = novoffice)";
				$box->angle_out('');
				//nom
				$box->angle('','','249','25','','black','','',100,"Nom :","",'');
				$box->angle_in('','','249','25','','black','','',100,"","",'');
				echo $form->text("nom","","$user->nom");
				$box->angle_out('');
				//prenom
				$box->angle('','','249','25','','black','','',100,"Prenom :","",'');
				$box->angle_in('','','249','25','','black','','',100,"","",'');
				echo $form->text("prenom","","$user->prenom");
				$box->angle_out('');
				//email
				$box->angle('','','249','25','','black','','',100,"Email :","",'');
				$box->angle_in('','','249','25','','black','','',100,"","",'');
				echo $form->text("email","","$user->email");
				$box->angle_out('');
				//call1
				$box->angle('','','249','25','','black','','',100,"Call 1 :","",'');
				$box->angle_in('','','249','25','','black','','',100,"","",'');
				echo $form->text("call1","","$user->call1");
				$box->angle_out('');
				//call2
				$box->angle('','','249','25','','black','','',100,"Call 2 :","",'');
				$box->angle_in('','','249','25','','black','','',100,"","",'');
				echo $form->text("call2","","$user->call2");
				$box->angle_out('');
				
				//shop
				$box->angle('','','249','25','','black','','',100,"Shop :","",'');
				$box->angle_in('','','249','25','','black','','',100,"","",'');
				$form->select_in('id_shop',1);
					$shop_tmp=db_read("select * from shop");
					while($shop = $shop_tmp->fetch())$form->select_option("[".$shop->id."] - ".$shop->nom,$shop->id,$user->shop);
				$form->select_out();
				$box->angle_out('');
				
				//status
				$box->angle('','','249','25','','black','','',100,"Account :","",'');
				$box->angle_in('','','249','25','','black','','',100,"","",'');
				$form->select_in('status',1);
					$form->select_option('Open','on',$user->status);
					$form->select_option('Locked','off',$user->status);
				$form->select_out();
				$box->angle_out('');
			$box->angle_out('');
			
			if($user->status=='off')$box->angle('50','400','150','150','','red','img/150px/acces_locked.gif','',100,"","",'');
			else $box->angle('50','400','150','150','','red','img/150px/acces_granted.gif','',100,"","",'');
			
			$box->angle_in('550','20','250','340','','black','','',100,"Security Acces","",'');
			
			//main
				$box->angle('','','99','22','','','','',100,"Main","",'');
				$box->angle_in('','','99','22','','','','',100,"","",'');
				$form->select_in('main',1);
					//$form->select_option("Paria",0,substr($user->security,0,1));
					$form->select_option("User",1,substr($user->security,0,1));
					$form->select_option("Admin",2,substr($user->security,0,1));
					if($sugar->security_main==3)$form->select_option("God",3,substr($user->security,0,1));
				$form->select_out();
				$box->angle_out('');
			//customer
				$box->angle('','','99','22','','','','',100,"customer","",'');
				$box->angle_in('','','99','22','','','','',100,"","",'');
				$form->select_in('customer',1);
					$form->select_option("Paria",0,substr($user->security,1,1));
					$form->select_option("User",1,substr($user->security,1,1));
					$form->select_option("Admin",2,substr($user->security,1,1));
					if($sugar->security_customer==3)$form->select_option("God",3,substr($user->security,1,1));
				$form->select_out();
				$box->angle_out('');
			//call
				$box->angle('','','99','22','','','','',100,"Call","",'');
				$box->angle_in('','','99','22','','','','',100,"","",'');
				$form->select_in('call',1);
					$form->select_option("Paria",0,substr($user->security,2,1));
					$form->select_option("User",1,substr($user->security,2,1));
					$form->select_option("Admin",2,substr($user->security,2,1));
					if($sugar->security_call==3)$form->select_option("God",3,substr($user->security,2,1));
				$form->select_out();
				$box->angle_out('');
			//repair
				$box->angle('','','99','22','','','','',100,"Repair","",'');
				$box->angle_in('','','99','22','','','','',100,"","",'');
				$form->select_in('repair',1);
					$form->select_option("Paria",0,substr($user->security,3,1));
					$form->select_option("User",1,substr($user->security,3,1));
					$form->select_option("Admin",2,substr($user->security,3,1));
					if($sugar->security_repair==3)$form->select_option("God",3,substr($user->security,3,1));
				$form->select_out();
                $box->angle_out('');
            //contrat de maintenance
				$box->angle('','','99','22','','','','',100,"CTM","",'');
				$box->angle_in('','','99','22','','','','',100,"","",'');
				$form->select_in('ctm',1);
					$form->select_option("Paria",0,substr($user->security,11,1));
					$form->select_option("User",1,substr($user->security,11,1));
					$form->select_option("Admin",2,substr($user->security,11,1));
					if($sugar->security_repair==3)$form->select_option("God",3,substr($user->security,11,1));
				$form->select_out();
				$box->angle_out('');
			//prm
				$box->angle('','','99','22','','','','',100,"Promo","",'');
				$box->angle_in('','','99','22','','','','',100,"","",'');
				$form->select_in('prm',1);
					$form->select_option("Paria",0,substr($user->security,10,1));
					$form->select_option("User",1,substr($user->security,10,1));
					$form->select_option("Admin",2,substr($user->security,10,1));
					if($sugar->security_prm==3)$form->select_option("God",3,substr($user->security,10,1));
				$form->select_out();
				$box->angle_out('');
			//odp
				$box->angle('','','99','22','','','','',100,"Offre de prix","",'');
				$box->angle_in('','','99','22','','','','',100,"","",'');
				$form->select_in('odp',1);
					$form->select_option("Paria",0,substr($user->security,4,1));
					$form->select_option("User",1,substr($user->security,4,1));
					$form->select_option("Admin",2,substr($user->security,4,1));
					if($sugar->security_odp==3)$form->select_option("God",3,substr($user->security,4,1));
				$form->select_out();
				$box->angle_out('');
			//cmd
				$box->angle('','','99','22','','','','',100,"Commande","",'');
				$box->angle_in('','','99','22','','','','',100,"","",'');
				$form->select_in('cmd',1);
					$form->select_option("Paria",0,substr($user->security,5,1));
					$form->select_option("User",1,substr($user->security,5,1));
					$form->select_option("Admin",2,substr($user->security,5,1));
					if($sugar->security_cmd==3)$form->select_option("God",3,substr($user->security,5,1));
				$form->select_out();
                $box->angle_out('');
            //DLC
				$box->angle('','','99','22','','','','',100,"DLC","",'');
				$box->angle_in('','','99','22','','','','',100,"","",'');
				$form->select_in('dlc',1);
					$form->select_option("Paria",0,substr($user->security,12,1));
					$form->select_option("User",1,substr($user->security,12,1));
					$form->select_option("Admin",2,substr($user->security,12,1));
					if($sugar->security_cmd==3)$form->select_option("God",3,substr($user->security,12,1));
				$form->select_out();
                $box->angle_out('');
			//stats
				$box->angle('','','99','22','','','','',100,"Stats","",'');
				$box->angle_in('','','99','22','','','','',100,"","",'');
				$form->select_in('stats',1);
					$form->select_option("Paria",0,substr($user->security,6,1));
					$form->select_option("User",1,substr($user->security,6,1));
					$form->select_option("Admin",2,substr($user->security,6,1));
					if($sugar->security_cmd==3)$form->select_option("God",3,substr($user->security,6,1));
				$form->select_out();
                $box->angle_out('');
			//repertory
                $box->angle('','','99','22','','','','',100,"Repertory","",'');
                $box->angle_in('','','99','22','','','','',100,"","",'');
                $form->select_in('repertory',1);
                    $form->select_option("Paria",0,substr($user->security,12,1));
                    $form->select_option("User",1,substr($user->security,12,1));
                    $form->select_option("Admin",2,substr($user->security,12,1));
                    if($sugar->security_cmd==3)$form->select_option("God",3,substr($user->security,12,1));
                $form->select_out();
                $box->angle_out('');
			//param
				$box->angle('','','99','22','','','','',100,"Parametre","",'');
				$box->angle_in('','','99','22','','','','',100,"","",'');
				$form->select_in('param',1);
					$form->select_option("Paria",0,substr($user->security,7,1));
					$form->select_option("User",1,substr($user->security,7,1));
					$form->select_option("Admin",2,substr($user->security,7,1));
					if($sugar->security_param==3)$form->select_option("God",3,substr($user->security,7,1));
				$form->select_out();
				$box->angle_out('');
			//admin
				$box->angle('','','99','22','','','','',100,"Admin","",'');
				$box->angle_in('','','99','22','','','','',100,"","",'');
				$form->select_in('admin',1);
					$form->select_option("Paria",0,substr($user->security,8,1));
					$form->select_option("User",1,substr($user->security,8,1));
					$form->select_option("Admin",2,substr($user->security,8,1));
					if($sugar->security_admin==3)$form->select_option("God",3,substr($user->security,8,1));
				$form->select_out();
				$box->angle_out('');
			//help
				$box->angle('','','99','22','','','','',100,"Help","",'');
				$box->angle_in('','','99','22','','','','',100,"","",'');
				$form->select_in('help',1);
					$form->select_option("Paria",0,substr($user->security,9,1));
					$form->select_option("User",1,substr($user->security,9,1));
					$form->select_option("Admin",2,substr($user->security,9,1));
					if($sugar->security_param==3)$form->select_option("God",3,substr($user->security,9,1));
				$form->select_out();
				$box->angle_out('');
			$box->angle_out('');
			$box->angle_in('1350','770','95','25','red','','','',100,"","",'');
			$form->send('Update User');
			$box->angle_out('');
			$form->close();
		$box->angle_out('');
		};break;
######################################################################################################################
	case 'update_user':
		{
		$id_user=$_POST['id_user'];
		$sec_key=$_POST['main'].$_POST['customer'].$_POST['call'].$_POST['repair'].$_POST['odp'].$_POST['cmd'].$_POST['stats'].$_POST['param'].$_POST['admin'].$_POST['help'].$_POST['prm'].$_POST['ctm'].$_POST['dlc']."1111111111111";
		$nom=$_POST['nom'];
		$prenom=$_POST['prenom'];
		$email=$_POST['email'];
		$call1=$_POST['call1'];
		$call2=$_POST['call2'];
		$shop=$_POST['id_shop'];
		$status=$_POST['status'];
		db_write("update user set security='$sec_key',nom='$nom',prenom='$prenom',email='$email',call1='$call1',call2='$call2',shop='$shop',status='$status',force_reload='1' where id =$id_user;");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=admin/admin.user&sub_system=edit_user&id_user=$id_user'/>";
		};break;
######################################################################################################################
	case 'reset_password':
		{
		$id_user=$_GET['id_user'];
		db_write("update user set password='mditdynHJ2hrg' where id =$id_user;");
		$js->alert("Password reset - New password : novoffice");
		echo "<meta http-equiv='refresh' content='5; url=index.php?system=admin/admin.user&sub_system=edit_user&id_user=$id_user'/>";
		};break;
######################################################################################################################
	}
?>