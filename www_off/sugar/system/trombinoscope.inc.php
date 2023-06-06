<?php
echo "<body style='background-color:$sugar->background_color'>";
if($sugar->security_stats==0)$js->alert_redirect("No acces","index.php",0);
$sugar->label="trombinoscope";

switch ($sub_system)
	{
######################################################################################################################
	case 'lobby':
		{
		$box->angle_in('350','20','802','800','white','black','','',100,"","",'');
			$shop_tmp=db_read("select * from shop where id !=0");
			while($shop = $shop_tmp->fetch())
				{
				$box->angle('','','800','22','lightgrey','black','','',100,"$shop->nom","",'');
				
				
				$uzr_tmp=db_read("select * from user where shop=$shop->id and status='on' order by nom;");
				while($uzr = $uzr_tmp->fetch())
					{
					echo "<li><a href='index.php?system=trombinoscope&sub_system=show_user&id_user=$uzr->id'>$uzr->nom $uzr->prenom</a></li></li>";
					}
				}
		$box->angle_out('');
		
		};break;
######################################################################################################################
	case 'show_user':
		{
		$user=db_single_read("select * from user where id = ".$_GET['id_user']);
		$box->angle('','','200','200','','black',"img/200px/trombinoscope/$user->pix",'',100,"","",'');
		echo "$user->nom";
		echo "<br>$user->prenom";
		echo "<br>$user->email";
		echo "<br>$user->call1";
		echo "<br>$user->call2";
		echo "<br>Status : $user->status";
		};break;
######################################################################################################################
	}
?>