<?php

if($sugar->security_main==0)$js->alert_redirect("No acces","index.php",0);

switch ($sub_system)
	{
######################################################################################################################
	case 'lobby':
		{
		echo "<body bgcolor='#80B467'>";
		echo "<center>Compteur de passage</center>";
		$dt_in= mktime(0,0,0,date('m',time()),date('d',time()),date('Y',time()));
		$dt_out= mktime(23,59,59,date('m',time()),date('d',time()),date('Y',time()));

		$cnt=db_single_read("select count(*) as cnt from compteur where type_visite='divers' and dt>$dt_in and dt<$dt_out and id_shop=$sugar->shop_id");
		$box->box_rond('10','30','80','50','#BCE02E','#80B467','','',100,"Divers<br>$cnt->cnt",'index.php?system=compteur&sub_system=add_cnt&type=divers&no_interface',"");
		
		$cnt=db_single_read("select count(*) as cnt from compteur where type_visite='repair' and dt>$dt_in and dt<$dt_out and id_shop=$sugar->shop_id");
		$box->box_rond('90','30','80','50','#E0642E','#80B467','','',100,"Repair<br>$cnt->cnt",'index.php?system=compteur&sub_system=add_cnt&type=repair&no_interface',"");
		
		$cnt=db_single_read("select count(*) as cnt from compteur where type_visite='odp' and dt>$dt_in and dt<$dt_out and id_shop=$sugar->shop_id");
		$box->box_rond('170','30','80','50','#E0D62E','#80B467','','',100,"Odp<br>$cnt->cnt",'index.php?system=compteur&sub_system=add_cnt&type=odp&no_interface',"");
		
		$cnt=db_single_read("select count(*) as cnt from compteur where type_visite='cmd' and dt>$dt_in and dt<$dt_out and id_shop=$sugar->shop_id");
		$box->box_rond('250','30','80','50','#2E97E0','#80B467','','',100,"Cmd<br>$cnt->cnt",'index.php?system=compteur&sub_system=add_cnt&type=cmd&no_interface',"");
		
		};break;
######################################################################################################################
	case 'add_cnt':
		{
		$type=$_GET['type'];
		db_write("insert into compteur (id_shop,id_user,type_visite,dt)values('$sugar->shop_id','$sugar->id','$type',".time().");");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=compteur&sub_system=lobby&no_interface'/>";
		};break;
######################################################################################################################
	}
?>