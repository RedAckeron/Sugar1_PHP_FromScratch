<?php
$admin->label="log_server";
if(isset($_POST['limit']))$limit=$_POST['limit'];
else $limit=100;
//$admin->admin_menu($system,$box);
//$sugar->label="adm";
$user_ok=0;
$sys_ok=0;
$sub_sys_ok=0;
if(isset($_POST['user']))$user_ok=$_POST['user'];
if(isset($_POST['sys']))$sys_ok=$_POST['sys'];
if(isset($_POST['sub_sys']))$sub_sys_ok=$_POST['sub_sys'];

$form->open("index.php?system=log_server","POST");
	
	echo "Utilisateur : ";
    
    $form->select_in('user',1);
	$user_tmp=db_read("select distinct id_tech from admin_log_server;");
		$form->select_option('Tous',0,$user_ok);
		while($user = $user_tmp->fetch())$form->select_option($user->id_tech,$user->id_tech,$user_ok);
    $form->select_out();
    
	echo "System : ";
	if(isset($user_ok))
		{
		$form->select_in('sys',1);
		$sys_tmp=db_read("select distinct system from admin_log_server;");
			$form->select_option('Tous',0,$sys_ok);
			while($sys = $sys_tmp->fetch())$form->select_option($sys->system,$sys->system,$sys_ok);
		$form->select_out();
		}	
	echo "Sub System : ";
	if(isset($sys_ok))
		{
		$form->select_in('sub_sys',1);
		$sub_sys_tmp=db_read("select distinct sub_system from admin_log_server where system='$sys_ok';");
			$form->select_option('Tous',0,$sub_sys_ok);
			while($sub_sys = $sub_sys_tmp->fetch())$form->select_option($sub_sys->sub_system,$sub_sys->sub_system,$sub_sys_ok);
		$form->select_out();
		}
		echo "Nombre d enregistrement : "; 
		$form->select_in('limit',1);
			$form->select_option('100',100,$limit);
			$form->select_option('200',200,$limit);
			$form->select_option('500',500,$limit);
			$form->select_option('1000',1000,$limit);
		$form->select_out();


	$form->send('Search');
$form->close();
$rqt_user="";
$rqt_sys="";
$rqt_sub_sys="";

$rqt="select * from admin_log_server where id>0 ";
if($user_ok!='0')$rqt.="and id_tech='$user_ok' ";
if($sys_ok!='0')$rqt.="and system='$sys_ok' ";
if($sub_sys_ok!='0')$rqt.="and sub_system='$sub_sys_ok' ";
$rqt.="order by id desc limit $limit;";

echo "<center><table border=1 cellspacing=0 width=100%><tr bgcolor=white><th>Id</th><th>Date</th><th>Tech</th><th>System</th><th>Sub_system</th><th>Remarque</th></tr>";
//echo $rqt;
$log_tmp=db_read($rqt);
while($log = $log_tmp->fetch())
	{
	$color='lightblue';
	if($log->priority==2)$color='orange';
	if($log->priority==3)$color='#CC5BF4';

	echo "<tr bgcolor=$color><td>$log->id</td><td>".date('d/m/y-H:i',$log->dt)."</td><td>$log->id_tech</td><td>$log->system</td><td>$log->sub_system</td><td>$log->remarque</td></tr>";
	}
echo "</table></center>";

?>