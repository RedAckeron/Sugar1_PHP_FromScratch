<?php
//if(!isset($form))$form=new _form;
switch ($_GET['sub_system'])
	{
	######################################################################################################################
	case 'lobby':
		{
		$form->open("index.php?system=chat&sub_system=add_msg&no_interface","POST");
			$form->text("msg",34,"");$form->send("Envoi");
			
			$chat_tmp=db_read("select * from chat order by dt desc limit 20;");
			$box->angle_in('0','40','350','430','','','','',100,"","",'');
			while($chat = $chat_tmp->fetch())
				{
				$uzr=db_single_read("select * from user where id = $chat->id_user");
				echo"<b>[$uzr->prenom ".date("H:i",$chat->dt)."] </b><i>$chat->msg</i><br>";
				}
			$box->angle_out("");
		$form->close();
		};break;
######################################################################################################################
	case 'add_msg':
		{
		$msg=$sugar->clean_string($_POST['msg']);
		$dt=time();
		if($msg!='')db_write("delete from chat where dt <".(time()-86400).";insert into chat (id_user,dt,msg)values('$sugar->id','$dt','$msg');");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=chat&sub_system=lobby&no_interface'/>";
		};break;
######################################################################################################################
	}
?>