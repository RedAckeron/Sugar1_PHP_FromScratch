<?php

$admin->label="var_server";
		
switch ($sub_system)
	{
######################################################################################################################
	case 'lobby':
		{
		$form->open("index.php?system=admin/admin.var_server.iframe&sub_system=edit_var_server&no_interface","POST");
		echo"Edition variable server : ";
		$form->select_in('id_var_server',1);
		$nom_tmp=db_read("select * from var_server");
			while($nom = $nom_tmp->fetch())$form->select_option($nom->nom,$nom->id,'');
		$form->select_out();
		$form->send('Edit');
		$form->close();

		$form->open("index.php?system=admin/admin.var_server.iframe&sub_system=add_var_server&no_interface","POST");
		echo"Ajouter variable server : ";$form->text("nom",50,"");
		$form->send('Ajouter');
		$form->close();
	};break;
######################################################################################################################
	case 'add_var_server':
		{
		$nom=$_POST['nom'];
		if($nom!="")db_write("insert into var_server(nom,var)values('$nom','')");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=admin/admin.var_server.iframe&sub_system=lobby&no_interface'/>";
		};break;
######################################################################################################################
	case 'edit_var_server':
		{
		$id_var_server = $_POST['id_var_server'];
		$var_act=db_single_read("select * from var_server where id = $id_var_server");
		
		$form->open("index.php?system=admin/admin.var_server.iframe&sub_system=update_var_server&id_var_server=$id_var_server&no_interface","POST");
		$form->textarea('var',10,100,$var_act->var);
		$form->send('Update');
		$form->close();
		};break;
######################################################################################################################
	case 'update_var_server':
		{
		$id_var_server=$_GET['id_var_server'];
		$var=$_POST['var'];
		db_write("update var_server set var='$var' where id = $id_var_server;");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=admin/admin.var_server.iframe&sub_system=lobby&no_interface'/>";
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