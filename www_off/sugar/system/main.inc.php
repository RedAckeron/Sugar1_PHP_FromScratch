<?php
echo "<body style='background-color:$sugar->background_color'>";
if(($sugar->id==0)and($sub_system!="chk_login"))$sub_system="input_login";

switch ($sub_system)
	{
######################################################################################################################
	case 'input_login':
		{

		$box->angle_in('500','150',500,200,'lightgrey','black','','',100,"Login","",'');
			$form->open("index.php?system=main&sub_system=chk_login&no_interface","POST");
			echo "<br>Login : <br>";$form->text("login",40,"");
			echo "<br>Password : <br>";$form->password("password",40,"");
			$form->send("Login");
			$form->close();
		$box->angle_out('');
		};break;
######################################################################################################################
	case 'chk_login':
		{
		$login=$_POST['login'];
		$password=crypt($_POST['password'],'md5');
		$result="";
		
		$chk_login=db_single_read("select count(*) as cnt from user where login = '$login'");
		if($chk_login->cnt==0)$result.="Login incorrect \n";
		else 
			{
			$chk_pswd=db_single_read("select * from user where login = '$login'");
			if (hash_equals($chk_pswd->password,$password))
				{
				if($chk_pswd->status=='on')
					{
					$sugar->load($chk_pswd->id);
					}
				else 
					{
					$sugar->id=0;
					$js->alert("Compte desactiver");
					}
				}
				else $result.="Password incorrect";
			}
		if($result!="")$js->alert("$result");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=main&sub_system=lobby'/>";
		};break;
######################################################################################################################
	case 'lobby':
		{
		if($sugar->security_main==0)$js->alert_die("No acces");
		$sugar->label="main";
		//logo et verssion sur logo
		$ver=db_single_read("select * from log_update order by id desc limit 1");
		$box->angle_in('20','20',450,300,'','black','img/logo_sugar.gif','',100,"","",'');
		$box->angle('20','270',50,20,'','','','',100,"</b><i>".round(($ver->id/1000),3)."</i>","",'');
		$box->angle_out('');
		//affichage des dernieres mise a jours

		$box->angle_in('490','20',990,300,'','black','img/logo_sugar_paralax.gif','',100,"Update","",'');
			$updt_tmp=db_read("select * from log_update order by id desc limit 10");
			while($updt = $updt_tmp->fetch())
				{
				echo "<li>".date("d/m/Y",$updt->dt_in)." - <font size=4><b>$updt->log</b></li></font>";
				}
		$box->angle_out('');

		$box->angle_in('20','340',200,300,'white','black','','',100,"Stats","",'');
			echo "<table border = 0>";
			$cust=db_single_read("select count(*) as cnt from customer");
			echo "<tr><td><li>$cust->cnt Client </li></td></tr>";
	
			$call=db_single_read("select count(*) as cnt from call_log");
			echo "<tr><td><li>$call->cnt Appel </li></td></tr>";
			
			$rpr=db_single_read("select count(*) as cnt from repair");
			echo "<tr><td><li>$rpr->cnt Repair </li></td></tr>";
	
			$odp=db_single_read("select count(*) as cnt from cmd where type='odp';");
			echo "<tr><td><li>$odp->cnt Offre de prix </li></td></tr>";
		
			$cmd=db_single_read("select count(*) as cnt from cmd where type='cmd';");
			echo "<tr><td><li>$cmd->cnt Commandes </li></td></tr>";
			echo "</table>";
		$box->angle_out('');
		//affichage des dernieres connection 
		$box->angle_in('240','340','322','300','white','black','','',100,"Last Login","",'');
			$cust_tmp=db_read("select * from user where id !=7 order by dt_last_login desc limit 20");
			while($cust = $cust_tmp->fetch())
				{
				$color='red';
				if ($cust->dt_last_login > (time()-3600))$color='orange';
				if ($cust->dt_last_login > (time()-600))$color='green';
				$box->angle('','','10','20',$color,'black','','',100,"","",'');
				
				$box->angle_in('','','185','20','','','','',100,"","",'');
				echo $cust->prenom." ".$cust->nom;
				$box->angle_out('');
				
				$box->angle_in('','','120','22','','','','',100,"","",'');
				echo date("d/m/y H:i",$cust->dt_last_login);
				$box->angle_out('');
				}
		$box->angle_out('');
		
		//affichage de l objet server
		$box->angle_in('600','340','322','480','white','black','','',100,"Variable Server","",'');
			echo "<pre>";
			print_r($server);
			echo "</pre>";
		$box->angle_out('');
		//affichage de l objet sugar
		$box->angle_in('1000','340','322','480','white','black','','',100,"Variable Sugar","",'');
			echo "<pre>";
			print_r($sugar);
			echo "</pre>";
		$box->angle_out('');	
		};break;
######################################################################################################################
	case 'admin_force_reload':
		{
		unset($server);
		unset($_SESSION['server']);
		$server = new _server;
		$server->load();

		$id_user=$sugar->id;
		unset($sugar);
		unset($_SESSION['sugar']);
		$sugar = new _sugar;
		$sugar->load($id_user);
		
		unset($slideshow);
        unset($_SESSION['slideshow']);
        unset($promo);
		unset($_SESSION['promo']);
		
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=main&sub_system=lobby'/>";
		};break;
######################################################################################################################
case 'close_page':
	{
	echo "<script type='text/javascript'>window.close();</script>";
	};break;
	}
?>