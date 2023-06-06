<?php
echo "<body style='background-color:$sugar->background_color'>";
if($sugar->security_stats==0)$js->alert_redirect("No acces","index.php",0);

$m_in=date('m',time());
if(isset($_POST['m_in']))$m_in=$_POST['m_in'];
if(isset($_GET['m_in']))$m_in=$_GET['m_in'];
 
$y_in=date('y',time());
if(isset($_POST['y_in']))$y_in=$_POST['y_in'];
if(isset($_GET['y_in']))$y_in=$_GET['y_in'];


  $id_shop=$sugar->shop_id;
if(isset($_POST['id_shop']))$id_shop=$_POST['id_shop'];
if(isset($_GET['id_shop']))$id_shop=$_GET['id_shop'];

	$box->angle_in('','',1498,42,'','lightgrey','','',100,"","",'');
		if($sub_system=='lobby')$box->angle('','',150,20,'green','black','','',100,"Lobby","",'');
		else $box->angle('','',150,20,'grey','black','','',100,"Lobby","index.php?system=stats&sub_system=lobby&m_in=$m_in&y_in=$y_in&id_shop=$id_shop",'');
	
		//Compteur
		if(substr($sub_system,0,3)=='cpt')
			{
			$box->angle_in('','',152,40,'green','black','','',100,"Compteur","",'');
				$box->angle('','',75,20,'','black','','',100,"Data","index.php?system=stats&sub_system=cpt_data&m_in=$m_in&y_in=$y_in&id_shop=$id_shop",'');
				$box->angle('','',75,20,'','black','','',100,"Gfx","index.php?system=stats&sub_system=cpt_gfx&m_in=$m_in&y_in=$y_in&id_shop=$id_shop",'');
			$box->angle_out(".");
			}
		else $box->angle('','',152,20,'grey','black','','',100,"Compteur","index.php?system=stats&sub_system=cpt_data&m_in=$m_in&y_in=$y_in&id_shop=$id_shop",'');
		//Repair
		if(substr($sub_system,0,3)=='rpr')
			{
			$box->angle_in('','',152,40,'green','black','','',100,"Repair","","");
				$box->angle('','',75,20,'','black','','',100,"Data","index.php?system=stats&sub_system=rpr_data&m_in=$m_in&y_in=$y_in&id_shop=$id_shop",'');
				$box->angle('','',75,20,'','black','','',100,"Gfx","index.php?system=stats&sub_system=rpr_gfx&m_in=$m_in&y_in=$y_in&id_shop=$id_shop",'');
			$box->angle_out(".");
			}
		else $box->angle('','',152,20,'grey','black','','',100,"Repair","index.php?system=stats&sub_system=rpr_data&m_in=$m_in&y_in=$y_in&id_shop=$id_shop",'');
		//commande
		if(substr($sub_system,0,3)=='cmd')
			{
			$box->angle_in('','',152,40,'green','black','','',100,"Commande","","");
				$box->angle('','',75,20,'','black','','',100,"Data","index.php?system=stats&sub_system=cmd_data&m_in=$m_in&y_in=$y_in&id_shop=$id_shop",'');
				$box->angle('','',75,20,'','black','','',100,"Gfx","index.php?system=stats&sub_system=cmd_gfx&m_in=$m_in&y_in=$y_in&id_shop=$id_shop",'');
			$box->angle_out(".");
			}
		else $box->angle('','',152,20,'grey','black','','',100,"Commande","index.php?system=stats&sub_system=cmd_data&m_in=$m_in&y_in=$y_in&id_shop=$id_shop",'');
			
	// affichage du mois courrant
		$shp=db_single_read("select * from shop where id = $id_shop");
		$box->angle('','',200,20,'lightgreen','black','','',100,"Mois courant : $m_in/$y_in","",'');
		$box->angle('','',200,20,'lightgreen','black','','',100,"Site : $shp->nom","",'');
	$box->angle_out("");

switch ($sub_system)
	{
######################################################################################################################
	case 'lobby':
		{
		$sugar->label="sta";
		$box->angle_in('','',500,200,'','black','','',100,"Critere de selection","",'');
		$form->open("index.php?system=stats&sub_system=lobby","POST");
		
		//mois
			$box->angle('10','20','229','22','','black','','',100,"Mois : ","",'');
			$box->angle_in('239','20','229','22','','black','','',100,"","",'');
			$form->select_in('m_in',1);
				for($i=1;$i<=12;$i++)$form->select_option($i,$i,date('m',time()));
			$form->select_out();
			$box->angle_out('');
		
		//ann�e
			$box->angle('10','42','229','22','','black','','',100,"Annee : ","",'');
			$box->angle_in('239','42','229','22','','black','','',100,"","",'');
			$form->select_in('y_in',1);
				for($i=2018;$i<=date('Y',time());$i++)$form->select_option($i,$i,date('Y',time()));
			$form->select_out();
			$box->angle_out('');
		
		//implantation admin only
			$box->angle('10','64','229','22','#CC5BF4','black','','',100,"Implantation : ","",'');
			$box->angle_in('239','64','229','22','#CC5BF4','black','','',100,"","",'');
			if($sugar->security_stats>1)
				{
				$form->select_in('id_shop',1);
					$shop_tmp=db_read("select * from shop");
					while($shop = $shop_tmp->fetch())$form->select_option($shop->nom,$shop->id,$id_shop);
				$form->select_out();
				}
			else 
				{
				$form->select_in('id_shop',1);
				$form->select_option($sugar->shop_name,$sugar->shop_id,$sugar->shop_id);
				$form->select_out();
				}
			$box->angle_out('');
			$box->angle_in('225','150','60','25','','','','',100,"","",'');
			$form->send("Select");
			$box->angle_out('');
			$form->close();
		
		$box->angle_out("");
		
		};break;
######################################################################################################################
	case 'cpt_data':
		{
		$gd_total=0;
		$shp=db_single_read("select * from shop where id = $id_shop");

		echo "<center><table border=0><tr bgcolor=white><td colspan=6><center><b>Compteur du mois $m_in / $y_in pour l implantation $shp->nom</b></center></td></tr><tr bgcolor=white><td>Date</td><td>Divers</td><td>Offre de prix</td><td>Commande</td><td>Repair</td><td>Total</td></tr>";
		for($i=1;$i<=31;$i++)
		{
		$in=mktime(0,0,0,$m_in,$i,$y_in);
		$out=mktime(23,59,59,$m_in,$i,$y_in);
	
		$divers=0;$offre=0;$command=0;$repair=0;//remise a zero des variables 
		$cpt_cnt=db_single_read("select count(*) as cnt from compteur where dt>$in and dt <$out and id_shop=$id_shop");
		if($cpt_cnt->cnt!=0)
			{
			$cpt_tmp=db_read("select * from compteur where dt>$in and dt <$out and id_shop=$id_shop");
			while($cpt = $cpt_tmp->fetch())
				{
				if($cpt->type_visite=='divers')$divers++;
				if($cpt->type_visite=='odp')$offre++;
				if($cpt->type_visite=='cmd')$command++;
				if($cpt->type_visite=='repair')$repair++;
				}
			}
		echo "<tr bgcolor=white><td>$i/$m_in/$y_in</td>";
		
		if($divers==0)$color='orange';
		else $color='lightgreen';
		echo "<td bgcolor=$color><center>$divers</center></td>";
		
		if($offre==0)$color='orange';
		else $color='lightgreen';
		echo "<td bgcolor=$color><center>$offre</center></td>";
		
		if($command==0)$color='orange';
		else $color='lightgreen';
		echo "<td bgcolor=$color><center>$command</center></td>";
		
		if($repair==0)$color='orange';
		else $color='lightgreen';
		echo "<td bgcolor=$color><center>$repair</center></td>";
		
		
		$total=$divers+$offre+$command+$repair;
		$gd_total+=$total;
		if($total==0)$color='orange';
		else $color='lightgreen';
		echo "<td bgcolor=$color><center>$total</center></td></tr>";
		}
		echo "<tr><td colspan=5 bgcolor=white><font size=5><center>Total</center></font></td><td bgcolor=red><center><b><font size=5>$gd_total</font></font></b></center></td></tr>";
		echo "</table></center>";
		
		};break;
######################################################################################################################
	case 'cpt_gfx':
		{
		$box->angle_in('','','1450','790','','black','','',100,"","",'');
		echo "<iframe frameborder=0 width=100% height=100% src='../sugar/pChart2.1.4/sugar/cpt.php?m=$m_in&y=$y_in&id_shop=$sugar->shop_id'></iframe>";
		$box->angle_out("");
		};break;
######################################################################################################################
	case 'rpr_data':
		{
		$box->angle_in('','','1450','600','','black','','',100,"","",'');
		echo "REPAIR DATA";
		$box->angle_out("");
		};break;
######################################################################################################################
	case 'rpr_gfx':
		{
		$box->angle_in('','','1450','790','','black','','',100,"","",'');
		echo "<iframe frameborder=0 width=100% height=100% src='../sugar/pChart2.1.4/sugar/repair.php?m=$m_in&y=$y_in&id_shop=$sugar->shop_id'></iframe>";
		$box->angle_out("");
		};break;
######################################################################################################################
	case 'cmd_data':
		{
		$box->angle_in('','','1450','600','','black','','',100,"","",'');
		echo "commande DATA";
		$box->angle_out("");
		};break;
######################################################################################################################
	case 'cmd_gfx':
		{
		$box->angle_in('','','1440','780','','black','','',100,"","",'');
		echo "<iframe frameborder=0 width=100% height=100% src='../sugar/pChart2.1.4/sugar/cmd.php?m=$m_in&y=$y_in&id_shop=$sugar->shop_id'></iframe>";
		$box->angle_out("");
		};break;
######################################################################################################################
	}
?>