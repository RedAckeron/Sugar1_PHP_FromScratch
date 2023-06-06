<?php
$admin->label="main";
switch ($sub_system)
	{
######################################################################################################################
	case 'lobby':
		{
		////edit work cost
        $box->angle_in('10','10',300,'100','white','red','','',100,"Edition des couts d intervention","",'');
        echo "<li>Cout main d oeuvre : ";$form->text("cost_work","1","1");echo"&euro;/min</li>";
        echo "<li>Deplacement : ";$form->text("cost_drive","1","20");echo"&euro;</li>";
        $box->angle_out('');
	
		////log update soft
        $box->angle_in('10','120','600','100','white','red','','',100,"Log update software","",'');
        $form->open("index.php?system=admin/admin.lobby&sub_system=add_update_log","POST");
        echo "Entrez une ligne de presentation d update<br>";$form->text("log",70,"");
        $form->send('Add');
        $form->close();
        $box->angle_out('');
        
        ////Log server
		$box->angle_in('10','240','600','200','white','red','','',100,"","",'');
		//echo "<iframe src='index.php?system=admin/admin.var_server.iframe&sub_system=lobby&no_interface' frameborder=0 width=100% height=100%></iframe>";
		$box->angle_out('');

		};break;
######################################################################################################################
	case 'add_update_log':
		{
		$log=$_POST['log'];
		db_write("insert into log_update (dt_in,log)values('".time()."','$log')");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=admin/admin.lobby'/>";
		};break;
######################################################################################################################
	case 'add_var_server':
		{
		$nom=$_POST['nom'];
		if($nom!="")db_write("insert into var_server(nom,var)values('$nom','')");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=admin/admin.lobby'/>";
		};break;
######################################################################################################################
	case 'edit_var_server':
		{
		$id_var_server = $_POST['id_var_server'];
		$var_act=db_single_read("select * from var_server where id = $id_var_server");
		$js->encode_chiffre('var',$var_act->var,"index.php?system=admin/admin.lobby&sub_system=update_var_server&id_var_server=$id_var_server&no_interface");
		};break;
######################################################################################################################
	case 'update_var_server':
		{
		$id_var_server=$_GET['id_var_server'];
		$var=$_GET['var'];
		if($var!='null')db_write("update var_server set var='$var' where id = $id_var_server;");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=admin/admin.lobby'/>";
		};break;
######################################################################################################################
	case 'update_user_security':
		{
		$id_user=$_POST['id_user'];
		$sec_key=$_POST['main'].$_POST['customer'].$_POST['call'].$_POST['repair'].$_POST['odp'].$_POST['cmd'].$_POST['stats'].$_POST['param'].$_POST['admin'].$_POST['help']."1111111111111111";
		db_write("update user set security='$sec_key' where id =$id_user;");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=admin&sub_system=edit_user&id_user=$id_user'/>";
		};break;
######################################################################################################################
	}
?>