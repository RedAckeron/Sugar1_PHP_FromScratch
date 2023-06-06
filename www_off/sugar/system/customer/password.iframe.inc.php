<?php
if($sugar->security_repair==0)$js->alert_redirect("No acces","index.php",0);

switch ($sub_system)
	{
######################################################################################################################
	case 'list_password':
		{
		$id_customer=$_GET['id_customer'];
		//echo "<b><center>Password user $id_customer</center></b>";
		$list_password_tmp=db_read("select * from customer_password where id_customer = $id_customer");
		while($list_password = $list_password_tmp->fetch())
			{
			echo "<li><a href='index.php?system=customer/password.iframe&sub_system=show_password&id_customer=".$_GET['id_customer']."&id_password=$list_password->id&no_interface'>$list_password->designation</li></a>";
			}
		$box->angle('','','200','22','lightblue','steelblue','','',100,"Add Password","index.php?system=customer/password.iframe&sub_system=add_password&id_customer=$id_customer&no_interface",'');
		};break;
######################################################################################################################
	case 'show_password':
		{
		$password=db_single_read("select * from customer_password where id = ".$_GET['id_password']);
		$form->open("index.php?system=customer/password.iframe&sub_system=update_password&id_customer=".$_GET['id_customer']."&id_password=".$_GET['id_password']."&no_interface'","POST");
		echo "Designation : <br>";
		$form->text("designation",30,"$password->designation");
		echo "<br>Login :<br>";
		$form->text("login",30,"$password->login");
		echo "<br>Password :<br> ";
		$form->text("password",30,"$password->password");
		echo "<br>";
		$form->send("Update");
		$form->close();
		$form->open("index.php?system=customer/password.iframe&sub_system=del_password&id_customer=".$_GET['id_customer']."&id_password=".$_GET['id_password']."&no_interface'","POST");
		$form->send("Delete");
		$form->close();
		
		};break;
######################################################################################################################
	case 'update_password':
		{
		$designation=$_POST['designation'];
		$login=$_POST['login'];
		$password=$_POST['password'];
		$id_customer=$_GET['id_customer'];
		$id_password=$_GET['id_password'];
		db_write("update customer_password set designation='$designation',login='$login',password='$password' where id = $id_password;");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=customer/password.iframe&sub_system=list_password&id_customer=$id_customer&no_interface'/>";
		};break;
######################################################################################################################
	case 'add_password':
		{
		$id_customer=$_GET['id_customer'];
		db_write("insert into customer_password (designation,id_customer,login,password)values('designation','$id_customer','login','password');");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=customer/password.iframe&sub_system=list_password&id_customer=$id_customer&no_interface'/>";
		};break;
######################################################################################################################
	case 'del_password':
		{
		$id_customer=$_GET['id_customer'];
		$id_password=$_GET['id_password'];
		db_write("delete from customer_password where id = $id_password;");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=customer/password.iframe&sub_system=list_password&id_customer=$id_customer&no_interface'/>";
		};break;
	}
?>