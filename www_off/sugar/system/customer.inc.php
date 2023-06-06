<?php
echo "<body style='background-color:$sugar->background_color'>";
if($sugar->security_customer==0)$js->alert_die("No acces");
if(isset($_GET['id_customer']))$id_customer=$_GET['id_customer'];

if(!isset($_GET['no_interface']))
	{
	$sugar->label="cus";
	$box->empty('','',1498,'24','black','','','',100,"","",'');
	$box->box_rond('0','0',200,'24','yellow','black','','',100,"Ajouter un client","index.php?system=customer&sub_system=add_customer&no_interface",'');
	$box->empty_in('200','2',350,'24','','','','',100,"","",'');
		$form->open("index.php?system=customer","POST");
		$form->text("find",33,"");
		$form->send("Rechercher");
		$form->close();
	$box->empty_out(".");
		
	if($sugar->security_customer>1)$box->empty_in('550','0','24','24','black','','','',100,"","index.php?system=customer&sub_system=select_export_xls",'');
	else $box->empty_in('550','0','24','24','','','','',100,"","",'');
	echo "<img src='img/32px/excel.gif' width=24px></img>";
	$box->empty_out(".");
	
	$box->box_rond('574','0','924','24','black','lightgrey','','',100,"<marquee><font color=lightgreen>Client Particulier<font color=black>____________________<font color=orange>Client Business<font color=black>____________________<font color=yellow><font color=black>____________________<font color =lightblue></marquee>","",'');
	}
switch ($sub_system)
	{
######################################################################################################################
	case 'lobby':
		{
		$box->angle_in('','',1468,'22','lightgrey','white','','',100,"","",'');
            $box->angle('','',50,'20','','black','','',100,"ID","",'');
            $box->angle('','',366,'20','','black','','',100,"Prenom Nom","",'');
			$box->angle('','',150,'20','','black','','',100,"Call","",'');
			$box->angle('','',550,'20','','black','','',100,"Adresse","",'');
			$box->angle('','',220,'20','','black','','',100,"Technicien","",'');
			$box->angle('','',130,'20','','black','','',100,"Date","",'');
		$box->angle_out('');

		if(isset($_POST['find']))
			{
			if($_POST['find']!='')
				{
				$find=$_POST['find'];
				$rqt="SELECT * FROM customer WHERE nom LIKE '%$find%';";
				$customer->show_list_from_rqt($rqt,$box,$sugar);
				$rqt="SELECT * FROM customer WHERE prenom LIKE '%$find%';";
				$customer->show_list_from_rqt($rqt,$box,$sugar);
				$rqt="SELECT * FROM customer WHERE call1 LIKE '%$find%';";
				$customer->show_list_from_rqt($rqt,$box,$sugar);
				$rqt="SELECT * FROM customer WHERE call2 LIKE '%$find%';";
				$customer->show_list_from_rqt($rqt,$box,$sugar);
				}
			else $js->alert_redirect("Veuillez entre qquechose svp","index.php?system=customer",0);
			}
		else 
			{
			$rqt="select * from customer order by id desc limit 35";
			$customer->show_list_from_rqt($rqt,$box,$sugar);
			}
		};break;
######################################################################################################################
	case 'add_customer':
		{
		db_write("INSERT INTO `customer` (`id`, `prenom`, `nom`, `adresse`, `cp`, `ville`, `call1`, `call2`, `mail`, `no_tva`, `dt_insert`, `tech_in`) VALUES (NULL, '', '', '', '', '', '', '', '', '', ".time().", $sugar->id);");
		$new_cust=db_single_read("select * from customer order by id desc limit 1");
		$sugar->admin_add_log($system,$sub_system,"Ajoute du client $new_cust->id par $sugar->nom $sugar->prenom",1);
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=customer&sub_system=load_customer&id_customer=$new_cust->id'/>";
		};break;
######################################################################################################################
	case 'load_customer':
		{
		$customer->load($id_customer);
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=customer&sub_system=show_customer'/>";
		};break;
######################################################################################################################
	case 'unload_customer':
		{
		$customer->id=0;
		unset($_SESSION['customer']);
		echo "<meta http-equiv='refresh' content='0; url=index.php'/>";
		};break;
######################################################################################################################
	case 'show_customer':
		{
		if($customer->id!=0)
			{
			//customer
			$box->angle_in('20','40','402','230','#FFFFEF','black','','','100',"",'',"");	
				echo "<iframe src='index.php?system=customer/fiche.iframe&sub_system=show&id_customer=$customer->id&no_interface' frameborder=0 width=100% height=100%></iframe>";			
            $box->angle_out("");
           
			//box password
            $box->angle_in('20','290','400','200','white','black','','',100,"","",'');
                echo "<iframe src='index.php?system=customer/password.iframe&sub_system=list_password&no_comment&no_interface&id_customer=$customer->id' frameborder=0 height=100% width=100%></iframe>";
            $box->angle_out("");
    
			$box->angle_in('520','40','952','750','white','grey','','',100,"Compte rendu de toutes les interventions","",'');
            //CALL
            $box->angle_in('','','930','22','#ADD8E6','black','','',100,"","",'');
                $box->empty('','','20','20','','','img/20px/call.gif','',100,"","",'');
                $box->angle('','','808','20','','','','',100,"Call","",'');
                $box->box_rond('','','100','20','yellow','#ADD8E6','','',100,"Ajouter","index.php?system=call&sub_system=add_call",'');
            $box->angle_out('');
        
            $call_cnt=db_single_read("SELECT count(*) as cnt FROM call_log where id_customer= $customer->id;");
            if($call_cnt->cnt==0)echo "<center><font color=red>Pas de call</font></center>";
            else 
                {
                $call_cnt=db_read("SELECT * FROM call_log where id_customer= $customer->id;");
                while($call = $call_cnt->fetch())
                    {
                    echo "<a href='index.php?system=call&sub_system=edit_call&id_call=$call->id'><li>$call->sujet</li></a>";
                    }	
                }
        
            //Repair
            $box->angle_in('','','930','22','#ADD8E6','black','','',100,"","",'');
                $box->empty('','','20','20','','','img/20px/repair.gif','',100,"","",'');
                $box->angle('','','808','20','','','','',100,"Repair","",'');
                $box->box_rond('','','100','20','yellow','#ADD8E6','','',100,"Ajouter","index.php?system=repair&sub_system=add_repair",'');
            $box->angle_out('');
            
            $repair_cnt=db_single_read("SELECT count(*) as cnt FROM repair where id_customer= $customer->id;");
            if($repair_cnt->cnt==0)echo "<center><font color=red>Pas de repair</font></center>";
            else 
                {
                $repair_tmp=db_read("SELECT * FROM repair where id_customer= $customer->id;");
                while($repair = $repair_tmp->fetch())
                    {
                    $cnt_description=db_single_read("select count(*) as cnt from feedback where sys='repair' and id_record ='$repair->id' and type ='panne';");
                    if($cnt_description->cnt>0)
                        {
                        $description=db_single_read("select * from feedback where sys='repair' and id_record ='$repair->id' and type ='panne';");
                        $msg_in=$description->msg;
                        }
                    else $msg_in="<font color=red>Pas de description de panne</font>";
                    echo "<a href='index.php?system=repair&sub_system=edit_repair&id_repair=$repair->id'><li>$msg_in</li></a>";
                    }
                }
            //offre de prix
            $box->angle_in('','','930','22','#ADD8E6','black','','',100,"","",'');
                $box->empty('','','20','20','','','img/20px/odp.gif','',100,"","",'');
                $box->angle('','','808','20','','','','',100,"Offre de prix","",'');
                $box->box_rond('','','100','20','yellow','#ADD8E6','','',100,"Ajouter","index.php?system=odp&sub_system=add_odp&no_interface",'');
            $box->angle_out('');
        
            $odp_cnt=db_single_read("SELECT count(*) as cnt FROM cmd where type='odp' and id_customer= $customer->id;");
            if($odp_cnt->cnt==0)echo "<center><font color=red>Pas d offre de prix</font></center>";
            else 
                {
                $offre_tmp=db_read("SELECT * FROM cmd where type='odp' and id_customer= $customer->id;");
                while($offre = $offre_tmp->fetch())
                    {
                    echo "<a href='index.php?system=odp&sub_system=edit_odp&id_odp=$offre->id'><li>$offre->titre</li></a>";
                    }
                }
					
            //commande
            $box->angle_in('','','930','22','#ADD8E6','black','','',100,"","",'');
                $box->empty('','','20','20','','','img/20px/cmd.gif','',100,"","",'');
                $box->angle('','','808','20','','','','',100,"Commande","",'');
                $box->box_rond('','','100','20','yellow','#ADD8E6','','',100,"Ajouter","index.php?system=cmd&sub_system=add_cmd&no_interface",'');
            $box->angle_out('');
            $cmd_cnt=db_single_read("SELECT count(*) as cnt FROM cmd where type='cmd' and id_customer= $customer->id;");
            if($cmd_cnt->cnt==0)echo "<center><font color=red>Pas de commande</font></center>";
            else 
                {
                $cmd_tmp=db_read("SELECT * FROM cmd where type='cmd' and id_customer= $customer->id;");
                while($cmd = $cmd_tmp->fetch())
                    {
                    echo "<a href='index.php?system=cmd&sub_system=edit_cmd&id_cmd=$cmd->id'><li>$cmd->titre</li></a>";
                    }	
                }
            //DLC
            $box->angle_in('','','930','22','#ADD8E6','black','','',100,"","",'');
                $box->empty('','','20','20','','','img/20px/dlc.gif','',100,"","",'');
                $box->angle('','','808','20','','','','',100,"Download content","",'');
                //$box->box_rond('','','100','20','yellow','#ADD8E6','','',100,"","",'');
            $box->angle_out('');
            $dlc_cnt=db_single_read("SELECT count(*) as cnt FROM customer_dlc where id_customer= $customer->id;");
            if($dlc_cnt->cnt==0)echo "<center><font color=red>Pas de dlc</font></center>";
            else 
                {
                $dlc_tmp=db_read("SELECT * FROM customer_dlc where id_customer= $customer->id;");
                while($dlc = $dlc_tmp->fetch())
                    {
                    echo "<a href='index.php?system=dlc/dlc&sub_system=edit_dlc&id_dlc=$dlc->id'><li>$dlc->nom_produit</li></a>";
                    }	
                }
            //CTM
            $box->angle_in('','','930','22','#ADD8E6','black','','',100,"","",'');
                $box->empty('','','20','20','','','img/20px/ctr_mtn.gif','',100,"","",'');
                $box->angle('','','808','20','','','','',100,"Contrat de maintenance","",'');
                $box->box_rond('','','100','20','yellow','#ADD8E6','','',100,"Ajouter","index.php?system=ctm/ctm",'');
            $box->angle_out('');
            
        $ctm_cnt=db_single_read("SELECT count(*) as cnt FROM customer_ctm where id_customer= $customer->id;");
        if($ctm_cnt->cnt==0)echo "<center><font color=red>Pas de ctm</font></center>";
        else 
            {
            $ctm_tmp=db_read("SELECT * FROM customer_ctm where id_customer= $customer->id ;");
            while($ctm = $ctm_tmp->fetch())
                {
                echo "<a href='index.php?system=ctm/ctm&sub_system=show_ctm&id_ctm=$ctm->id'><li>$ctm->label</li></a>";
                }	
            }

        $box->angle_out('');
        }
    else $js->alert_redirect("Aucun client actif","index.php?system=customer",0);
		};break;
######################################################################################################################
	case 'select_export_xls':
		{
		echo "<h1>Collecte data client</h1>";
		$form->open("index.php?system=customer&sub_system=export_xls&no_interface","POST");
		
		//technicien 
		$box->angle_in('','',300,80,'lightgrey','grey','','',100,"Introduit par : ","",'');
			$form->select_in('tech_in',1);
			$form->select_option("Tous",0,'');
			$tech_tmp=db_read("select * from user");
			while($tech = $tech_tmp->fetch())
				{
				$form->select_option($tech->prenom." ".$tech->nom,$tech->id,'');
				}
			$form->select_out();
		$box->angle_out('');
		
		//date
		$box->angle_in('','',300,80,'lightgrey','grey','','',100,"Date debut","",'');
			//jours
			$form->select_in('day_in',1);
			for($d=1;$d<=31;$d++)$form->select_option($d,$d,1);
			$form->select_out();
			//mois
			$form->select_in('month_in',1);
			for($m=1;$m<=12;$m++)$form->select_option($m,$m,6);
			$form->select_out();
			//ann�e in
			$form->select_in('year_in',1);
			for($y=2019;$y<=date('Y',time());$y++)$form->select_option($y,$y,2019);
			$form->select_out();
		$box->angle_out('');
		
		$box->angle_in('','',300,80,'lightgrey','grey','','',100,"Date fin","",'');
			$form->select_in('day_out',1);
			for($d=1;$d<=31;$d++)$form->select_option($d,$d,date('d',time()));
			$form->select_out();
			//mois
			$form->select_in('month_out',1);
			for($m=1;$m<=12;$m++)$form->select_option($m,$m,date('m',time()));
			$form->select_out();
			//ann�e out
			$form->select_in('year_out',1);
			for($y=2019;$y<=date('Y',time());$y++)$form->select_option($y,$y,date('Y',time()));
			$form->select_out();
		$box->angle_out('');
		$box->angle_in('600','250',100,80,'','','','',100,"","",'');
			$form->send("Collecte");
		$box->angle_out('');
		$form->close();
		
		};break;
######################################################################################################################
	case 'export_xls':
		{
		$tech_in=$_POST['tech_in'];
		$d_in=$_POST['day_in'];
		$m_in=$_POST['month_in'];
		$y_in=$_POST['year_in'];
		$dt_in=mktime(0,0,1,$m_in,$d_in,$y_in);
		
		$d_out=$_POST['day_out'];
		$m_out=$_POST['month_out'];
		$y_out=$_POST['year_out'];
		$dt_out=mktime(23,59,59,$m_out,$d_out,$y_out);
		
		$no_and=1;
	
		$rqt="select * from customer";
		if($tech_in!=0)
			{
			$rqt.=" where tech_in = $tech_in";
			$no_and--;
			}
			
			if($no_and==0)$rqt.=" and dt_insert >= $dt_in";
			else $rqt.=" where dt_insert >= $dt_in";
			$no_and--;
			$rqt.=" and dt_insert <= $dt_out";

		include('../../www_off/sugar/xls/export_xls.php');
		};break;
	}
?>