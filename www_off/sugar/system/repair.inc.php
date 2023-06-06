<?php
echo "<body style='background-color:$sugar->background_color'>";
if($sugar->security_repair==0)$js->alert_redirect("No acces","index.php",0);

if($sub_system=='lobby')$sub_system='show_repair';

if(isset($_POST['id_shop']))$id_shop=$_POST['id_shop'];
else $id_shop=$sugar->shop_id;

switch ($sub_system)
	{
######################################################################################################################
	case 'show_repair':
		{
		$sugar->label="rep";
		$box->box_rond('','',200,'23','yellow','black','','',100,"Ajouter un Repair","index.php?system=repair&sub_system=add_repair&id_customer=$customer->id",'');
		$box->angle('','','1098','23','black','black','','',100,"<marquee><font color=lightgreen>Machines fini et sorti.<font color=black>____________________<font color=lightblue>Machines fini et encore presente<font color=black>____________________<font color=yellow>Machines en attente.<font color=black>____________________<font color =orange>Machines a faire.</marquee>","",'');
		$box->angle_in('','',1498,'22','#88a0a8','','','',100,"","",'');
			$box->angle('','',50,'20',"",'lightgrey','','',100,"Ticket","",'');
			$box->angle('','',200,'20',"",'lightgrey','','',100,"Client","",'');
			$box->angle('','',150,'20','','lightgrey','','',100,"No de contact","",'');
			$box->angle('','',590,'20','','lightgrey','','',100,"Description","",'');
			$box->angle('','',130,'20','','lightgrey','','',100,"Date d entre",'','');
			$box->angle('','',130,'20','','lightgrey','','',100,"Date de cloture","",'');
			$box->angle('','',60,'20','','lightgrey','','',100,"Status",'',"");
			$box->angle('','',60,'20','','lightgrey','','',100,"Prix",'',"");
			$box->angle('','',126,'20','','lightgrey','','',100,"Shop",'',"");
		$box->angle_out('');
		$cnt_tckt=36;

		if($sugar->security_repair>1)
			{
			//admin select shop
			$box->empty_in('200','0','200','22','','','','',100,"","",'');
				$form->open("index.php?system=repair","POST");
				$form->select_in('id_shop',1);
					$shop_tmp=db_read("select * from shop");
					while($shop = $shop_tmp->fetch())
						{
						$form->select_option("$shop->nom",$shop->id,$id_shop);
						}
				$form->select_out();
				$form->send("GO");
				$form->close();
			$box->empty_out(".");
			}
		
		//voir les open 
		if($id_shop==0)$rqt="select * from repair where status = 'open' order by dt_out desc limit $cnt_tckt;";
		else $rqt="select * from repair where id_shop = $id_shop and status = 'open' order by dt_out desc limit $cnt_tckt;";
		$repair_tmp=db_read("$rqt");
		while($repair = $repair_tmp->fetch())
			{
			$ticket->load($repair->id);
			$ticket->show_line($box,$sugar);
			$cnt_tckt--;
			}
			
		//voir les wait
		if($id_shop==0)$rqt="select * from repair where status = 'wait' order by dt_in desc limit $cnt_tckt;";
		else $rqt="select * from repair where id_shop = $id_shop and status = 'wait' order by dt_in desc limit $cnt_tckt;";
		$repair_tmp=db_read("$rqt");
		while($repair = $repair_tmp->fetch())
			{
			$ticket->load($repair->id);
			$ticket->show_line($box,$sugar);
			$cnt_tckt--;
			}

		//voir les end
		if($sugar->shop_id==0)$rqt="select * from repair where status = 'end' order by dt_in desc limit $cnt_tckt;";
		else $rqt="select * from repair where id_shop = $id_shop and status = 'end' order by dt_in desc limit $cnt_tckt;";
		$repair_tmp=db_read("$rqt");
		while($repair = $repair_tmp->fetch())
			{
			$ticket->load($repair->id);
			$ticket->show_line($box,$sugar);
			$cnt_tckt--;
			}

		//voir les close
		if($sugar->shop_id==0)$rqt="select * from repair where status = 'close' order by dt_out desc limit $cnt_tckt;";
		else $rqt="select * from repair where id_shop = $id_shop and status = 'close' order by dt_out desc limit $cnt_tckt;";
		$repair_tmp=db_read("$rqt");
		while($repair = $repair_tmp->fetch())
			{
			$ticket->load($repair->id);
			$ticket->show_line($box,$sugar);
			$cnt_tckt--;
			}

		//voir les hidden
		if($sugar->security_repair>1)$repair_tmp=db_read("select * from repair where status = 'hidden' order by dt_out desc limit 5;");
		while($repair = $repair_tmp->fetch())
			{
			$ticket->load($repair->id);
			$ticket->show_line($box,$sugar);
			$cnt_tckt--;
			}
		};break;
######################################################################################################################
    case 'add_repair':
		{
		$sugar->label="rep";
		if($customer->id!=0)
			{
			$dt_in=time();
			db_write("insert into repair (id_customer,dt_in,tech_in,dt_out,id_shop,status)values($customer->id,$dt_in,$sugar->id,0,$sugar->shop_id,'open');");
			$id_repair=db_single_read("select * from repair order by id desc limit 1");
			$form->open("index.php?system=repair&sub_system=validate_add_repair","POST");
			$form->hidden('id_ticket',$id_repair->id);
			$box->angle_in('300','20',800,'600','lightgrey','grey','','',100,"Ticket : $id_repair->id","",'');
				echo "<center>";
				echo"Description de la panne : ";$form->textarea("msg_in",12,90,"");
				echo"<br>Materiel depose : <br>";$form->textarea("hardware_in",8,90,"");
				$box->angle_in('','','798','100','','','','',100,"Password","",'');
					echo"<li>Session Windows : ";$form->text("pass_windows",20,"");echo"</li>";
					echo"<li>Mail (login/password): ";$form->text("login_mail",20,"");$form->text("pass_mail",20,"");echo"</li>";
					echo"<li>Antivirus (login/password): ";$form->text("login_antivirus",20,"");$form->text("pass_antivirus",20,"");echo"</li>";
				$box->angle_out('');
			echo"<br>";$form->send("Suite");
			$box->angle_out('');
			$form->close();
			}
		else $js->alert_redirect("Aucun client actif","index.php?system=customer",0);
		};break;
######################################################################################################################
    case 'validate_add_repair':
		{
		$rqt="";
		$id_ticket=$_POST['id_ticket'];
		$id_cust=$customer->id;
		$msg_in=$sugar->clean_string($_POST['msg_in']);
		
		if($_POST['pass_windows']!="")$rqt.="insert into customer_password (designation,type,id_customer,login,password)values('Password Windows','win_session','$id_cust','Password Windows','".$_POST['pass_windows']."');";
		if($_POST['pass_mail']!="")$rqt.="insert into customer_password (designation,type,id_customer,login,password)values('Password Mail','mail','$id_cust','".$_POST['login_mail']."','".$_POST['pass_mail']."');";
		if($_POST['pass_antivirus']!="")$rqt.="insert into customer_password (designation,type,id_customer,login,password)values('Password Antivirus','antivirus','$id_cust','".$_POST['login_antivirus']."','".$_POST['pass_antivirus']."');";
		
		$hardware_in=$sugar->clean_string($_POST['hardware_in']);
		$rqt.="update repair set id_customer='$id_cust' where id = $id_ticket;";
		//$rqt.="update repair set msg_in='$msg_in',hardware_in='$hardware_in',id_customer='$id_cust' where id = $id_ticket;";
		
		$rqt.="insert into feedback (sys,id_record,dt,id_tech,type,msg)values('repair','$id_ticket',".time().",'$sugar->id','open','Ouverture du repair no $id_ticket par ".$sugar->prenom." ".substr($sugar->nom,0,1)."');";
		$rqt.="insert into feedback (sys,id_record,dt,id_tech,type,msg)values('repair','$id_ticket',".time().",'$sugar->id','panne','$msg_in');";
		$rqt.="insert into feedback (sys,id_record,dt,id_tech,type,msg)values('repair','$id_ticket',".time().",'$sugar->id','hardware_in','$hardware_in');";
		
		db_write("$rqt");
		
		
		$sugar->admin_add_log($system,$sub_system,"Ajoute du repair $id_ticket pour le client $id_cust",1);
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=repair&sub_system=edit_repair&id_repair=$id_ticket'/>";
		};break;
######################################################################################################################
	case 'edit_repair':
		{
		$sugar->label="rep";
		//on verifie si un ticket est renseigner sinon on est redirect sur la page repair
		if(!isset($_GET['id_repair']))$js->alert_redirect("Pas de ticket selectionner","index.php?system=repair",0);//message Url dalei avant redirect
		
		//on verifie si le ticket existe
		$id_repair=$_GET['id_repair'];
		$chk_ticket=db_single_read("select count(*) as cnt from repair where id = $id_repair");
		if($chk_ticket->cnt!=1)$js->alert_redirect("Se ticket n existe pas","index.php?system=repair",0);//message Url dalei avant redirect
		
		//on load le ticket 
        $ticket->load($id_repair);
        //iframe info client
        $box->angle_in('10','10','402','230','#FFFFEF','black','','','100',"",'',"");	
			echo "<iframe src='index.php?system=customer/fiche.iframe&sub_system=show&id_customer=$ticket->id_customer&no_interface' frameborder=0 width=100% height=100%></iframe>";			
		$box->angle_out("");
        
        //FACTURATION
        $box->angle_in('10','250','402','452','orange','black','','',100,"","",'');
        echo "<iframe frameborder=0 width=100% height=100% src=index.php?system=repair/facturation.iframe&sub_system=select_add_item_repair&id_repair=$ticket->id&facturation=direct&no_interface></iframe>";
        $box->angle_out('');
        
        //affichage des feedback
		$width=840;
        $height=750;
        $box->angle_in('420','40',$width+2,$height+2,'white','black','','',100,'',"",'');
			echo "<iframe frameborder=0 width=100% height=100% src=index.php?system=feedback.iframe&sub_system=show_feedback&sys=repair&id_record=$ticket->id&width=$width&height=$height&no_interface></iframe>";
        $box->angle_out('');
        
		//affichage des infos ticket
		$box->angle_in('1290','10','200','220','','steelblue','','',100,"Info ticket","",'');
			echo "<li>Ticket no : <br>";$form->text_disabled("","10","$ticket->id");echo"</li>";
			$form->hidden('id_ticket',$ticket->id);
			$tech_in=db_single_read("select * from user where id=$ticket->tech_in");
			echo "<li>Ouvert par : ";$form->text_disabled("","20","$tech_in->prenom $tech_in->nom");echo"</li>";
			echo "<li>Date ouverture : ";$form->text_disabled("","15",date("d/m/Y H:i",$ticket->dt_in));echo"</li>";
			if($ticket->dt_out!=0)
				{
				echo "<li>Date fermeture : ";
				$form->text_disabled("","15",date("d/m/Y H:i",$ticket->dt_out));
				echo"</li>";
				}
				echo "<li>Status : ";$form->text_disabled("","15",$ticket->status);echo"</li>";
		$box->angle_out('');
        
        //MENU BOUTTON
		$box->empty_in('1290','250','200','250','','','','',100,"","",'');//imprimer reception
			//bouton imprimer bon d entre
			echo "<a href='index.php?system=repair&sub_system=print_ticket_customer&id_ticket=$ticket->id&no_interface' target=_blank>";
			$box->angle('','','200','25','lightgreen','black','','',100,"Imprimer ouverture","",'');//imprimer reception
			echo "</a>";
        $box->empty('','','200','10','','','','',100,"","",'');//box vide entre 2 bouttons
        
		//bouton imprimer bon de sortie
        if(($ticket->status=='end')or($ticket->status=='close'))
            {
            echo "<a href='index.php?system=repair&sub_system=print_close&feedback=on&id_ticket=$ticket->id&no_interface&feedback' target=_blank>";
            $box->angle('','','200','25','lightgreen','black','','',100,"Imprimer cloture","",'');//imprimer reception
            echo "</a>";
            }
        else $box->angle('','','200','25','grey','black','','',100,"Imprimer cloture","",'');
        $box->empty('','','200','10','','','','',100,"","",'');//box vide entre 2 bouttons
		
		//bouton ourir repair
        if(($ticket->status=='end')or($ticket->status=='close')or($ticket->status=='wait'))
            {
            $box->angle('','','200',25,'lightgreen','black','','',100,"Ouvrir repair","index.php?system=repair&sub_system=open_ticket&id_ticket=$ticket->id",'');
            }
        else $box->angle('','','200',25,'grey','black','','',100,"Ouvrir repair","",'');
        $box->empty('','','200','10','','','','',100,"","",'');//box vide entre 2 bouttons
		
		//bouton suspendre repair
        if($ticket->status=='open')
            {
            $box->angle('','','200',25,'lightgreen','black','','',100,"Suspendre repair","index.php?system=repair&sub_system=wait_ticket&id_ticket=$ticket->id","");
            }
        else $box->angle('','','200',25,'grey','black','','',100,"Suspendre repair","","");
        $box->empty('','','200','10','','','','',100,"","",'');//box vide entre 2 bouttons
    
		//bouton finir repair
        if($ticket->status=='open')
            {
            $box->angle('','','200',25,'lightgreen','black','','',100,"Finir repair","index.php?system=repair&sub_system=end_ticket&id_ticket=$ticket->id",'');//imprimer reception
            }
        else $box->angle('','','200',25,'grey','black','','',100,"Finir repair","",'');//imprimer reception
        $box->empty('','','200','10','','','','',100,"","",'');//box vide entre 2 bouttons
		
		//bouton sortir repair
        if($ticket->status=='end')
            {
            $box->angle('','','200',25,'lightgreen','black','','',100,"Sortir repair","index.php?system=repair&sub_system=close_ticket&id_ticket=$ticket->id&no_interface",'');//imprimer reception
            }
        else $box->angle('','','200',25,'grey','black','','',100,"Sortir repair","",'');//imprimer reception
        $box->empty('','','200','10','','','','',100,"","",'');//box vide entre 2 bouttons

		//bouton effacer repair
        if($ticket->status=='hidden')$box->angle('','',200,25,'#CC5BF4','black','','',100,"Detruire repair","index.php?system=repair&sub_system=destroy_repair&id_repair=$ticket->id&no_interface",'');//imprimer reception
        else $box->angle('','','200',25,'red','black','','',100,"Effacer repair","index.php?system=repair&sub_system=chk_del_repair&id_ticket=$ticket->id&no_interface",'');//imprimer reception

        $box->empty_out(".");
        //iframe password
        $box->angle_in('1290','550','202','250','lightblue','black','','',100,"Password","",'');
        echo "<iframe src='index.php?system=customer/password.iframe&sub_system=list_password&no_comment&no_interface&id_customer=$ticket->id_customer' frameborder=0 height=192px width=400px></iframe>";
        $box->angle_out("");
		};break;
######################################################################################################################
	case 'print_ticket_customer':
		{
		include('../../www_off/sugar/obj/print.obj.php');
		$print=new _print;
		$ticket->load($_GET['id_ticket']);
		$print->header($box,$system,$_GET['id_ticket'],$sugar);

		//description panne
		$panne=db_single_read("select * from feedback where sys='repair' and id_record=$ticket->id and type='panne';");
		echo "<font size=4><b><u>Description de la panne : </b></u></font>";
		$box->empty('','',738,180,'white','','','',100,"<font size=4></b>$panne->msg</font>",'','');
		
		//materiel depose
		$hardware=db_single_read("select * from feedback where sys='repair' and id_record=$ticket->id and type='hardware_in';");

		echo "<br><font size=4><b><u>Description du materiel depose : </b></u></font>";
		$box->angle('','',738,180,'white','','','',100,"<font size=4></b>$hardware->msg</font>",'','');
				
		//password
		echo "<br><b><u><font size=4>Password :</b></u></font>";
		$box->angle_in('','',738,82,'','','','',100,"",'','');
		$box->angle('','','120','20','lightgrey','black','','',100,"Designation",'','');
		$box->angle('','','350','20','lightgrey','black','','',100,'Login','','');
		$box->angle('','','266','20','lightgrey','black','','',100,'Password','','');
		$password_tmp=db_read("select * from customer_password where ((type = 'win_session') or (type = 'mail') or (type = 'antivirus'))and id_customer = $ticket->id_customer order by id desc limit 3;");
		while($password = $password_tmp->fetch())
			{
			$box->angle('','','120','20','','grey','','',100,"</b>".ucfirst($password->type)." : ",'','');
			$box->angle('','','350','20','','grey','','',100,"</b>".$password->login,'','');
			$box->angle('','','266','20','','grey','','',100,"</b>".$password->password,'','');
			}
		$box->angle_out('.');

		//frais de dossier
		$box->angle('','',20,20,'white','black','','',100,"",'','');
		$box->angle('','',150,40,'','','','',100,"<font size=3>Frais de dossier : 30 </font>",'','');
		
		//avertissement
		$disclaimer="NOUS VOUS RAPPELONS QUE NOUS NE SOMMES EN AUCUN CAS RESPONSABLE DE VOS DONNEES.<BR>TOUT APPAREIL NON REPRIS APRES 12 MOIS SERA DETRUIT SANS DE PLUS AMPLES AVERTISSEMENTS.";
		$box->angle('','',738,40,'lightgrey','black','','',100,"<font size=2>$disclaimer</font>",'','');
		
		//signature client
		$box->angle('','',738,20,'','','','',100,"",'','');
		$box->angle('','',369,170,'','','','',100,"<font size=2>SIGNATURE CLIENT<br>$ticket->prenom $ticket->nom</font>",'','');
		
		//signature tech
		$box->angle('','',369,170,'','','','',100,"<font size=2>SIGNATURE TECHNICIEN<br>$sugar->prenom ".substr($sugar->nom,0,1)."</font>",'','');
		
		
		//$box->angle_out('');

		$print->footer($box,$sugar);

		//echo "<body onload='window.print();window.close()'>";
		};break;

######################################################################################################################
	case 'end_ticket':
		{
		//$id_ticket=$_POST['id_ticket'];
		$id_ticket=$_GET['id_ticket'];
		//$report=$_POST['report'];
		$report="Repair cloturer par $sugar->prenom ".substr($sugar->nom,0,1);
		$price_work=0;
		$item_repair_tmp=db_read("select * from repair_item where id_repair = $id_ticket");
		while($item_repair = $item_repair_tmp->fetch())$price_work+=$item_repair->prix;
		db_write("update repair set tech_out='$sugar->id',status='end',price_work='$price_work',dt_out=".(time())." where id = $id_ticket");
		db_write("insert into feedback (sys,id_record,dt,id_tech,type,msg)values('repair','$id_ticket',".time().",'$sugar->id','close','Fermeture du repair no $id_ticket par $sugar->prenom ".substr($sugar->nom,0,1)."');");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=repair&sub_system=edit_repair&id_repair=$id_ticket'/>";
		};break;
######################################################################################################################
	case 'close_ticket':
		{
		$id_ticket=$_GET['id_ticket'];
		db_write("update repair set status='close' where id = $id_ticket");
		db_write("insert into feedback (sys,id_record,dt,id_tech,type,msg)values('repair','$id_ticket',".time().",'$sugar->id','out_rpr','Sortie du repair no $id_ticket par $sugar->prenom ".substr($sugar->nom,0,1)."');");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=repair'/>";
		};break;
######################################################################################################################
	case 'print_close':
		{
		include('../../www_off/sugar/obj/print.obj.php');
		$print=new _print;
		$ticket->load($_GET['id_ticket']);
		$print->header($box,$system,$_GET['id_ticket'],$sugar);
		echo "<center><font size =5><u>Rapport de cloture</u></font></center>";
		//affichage des remarques de cloture 
        //ouverture
        $box->empty_in('','','738','18','','','','','100',"",'','');
			$nom_tech=db_single_read("select * from user where id=$ticket->tech_in");
			$nom=$nom_tech->prenom.' '.substr($nom_tech->nom,'0','1');
			$box->angle('','','738','18','lightblue','black','','',100,"</b><font size=2>Ouverture par $nom le ".date("d/m/Y G:i",$ticket->dt_in)."</font>",'','');
		$box->empty_out(".");

	
		
		$feedback_tmp=db_read("select * from feedback where sys='repair' and type != 'open' and type != 'close' and id_record='$ticket->id' order by dt");
		while($feedback = $feedback_tmp->fetch())
			{
			$box->empty_in('','','738','18','','','','',100,"",'','');
				$nom_tech=db_single_read("select * from user where id=$feedback->id_tech");
				$nom=$nom_tech->prenom.' '.substr($nom_tech->nom,0,1)." ".date("j/m/y-G:i",$feedback->dt);
                $box->angle('','','200','18','lightgrey','black','','',100,"</b><font size=2><i>$nom</i></font>",'','');
                
                if($feedback->type=='panne')$box->angle('','','200','18','pink','black','','',100,"</b><font size=2>Probleme constater : </font>",'','');
                if($feedback->type=='hardware_in')$box->angle('','','200','18','pink','black','','',100,"</b><font size=2>Materiel deposer : </font>",'','');
                if($feedback->type=='feedback')$box->angle('','','200','18','lightgreen','black','','',100,"</b><font size=2>Rapport</font>",'','');
              
                
                
			$box->empty_out(".");
			echo "<br><font size=3>".nl2br($feedback->msg)."</font>";
			}
		//fermeture
		$box->empty_in('','','738','18','','','','','100',"",'','');
			$nom_tech=db_single_read("select * from user where id=$ticket->tech_out");
			$nom=$nom_tech->prenom.' '.substr($nom_tech->nom,'0','1');
			$box->angle('','','738','18','lightblue','black','','',100,"</b><font size=2>Cloture par $nom le ".date("d/m/Y G:i",$ticket->dt_out)."</font>",'','');
		$box->empty_out(".");

		
		//fenetre checklist + facturation
		$box->angle_in('','','738','204','','','','',100,'','','');
			//in checklist
			
			$box->angle_in('10','10','354','182','lightgrey','blue','','',100,'','','');
				$box->angle('','','352','20','white','black','','',100,'CheckList','','');
			
				//gest periph
				$box->angle('','',20,20,'white','black','','',100,'','','');
			
				$box->angle('','',332,20,'','black','','',100,'</b>Gestionnaire de Peripheriques','','');
				//editeur antivirus
				$box->angle('','',152,20,'','black','','',100,'</b>Antivirus','','');
				$box->angle_in('','',200,20,'white','black','','',100,'','','');
				$box->angle_out('');
				//lecteur cd
				$box->angle_in('','',20,20,'white','black','','',100,'','','');
				$box->angle_out('');
				$box->angle('','',332,20,'','black','','',100,'</b>Test Lecteur BR/DVD/CD','','');
				//antivirus day restant
				$box->angle('','',200,20,'','black','','',100,'</b>Jours restant antivirus','','');
				$box->angle_in('','',152,20,'white','black','','',100,'','','');
				$box->angle_out('');
				//word excel
				$box->angle_in('','',20,20,'white','black','','',100,'','','');
				$box->angle_out('');
				$box->angle('','',332,20,'','black','','',100,'</b>Test Office','','');
				//check mail
				$box->angle_in('','',20,20,'white','black','','',100,'','','');
				$box->angle_out('');
				$box->angle('','',332,20,'','black','','',100,'</b>Test Mail in - out','','');
				//test reboot
				$box->angle_in('','',20,20,'white','black','','',100,'','','');
				$box->angle_out('');
				$box->angle('','',332,20,'','black','','',100,'</b>Test reboot','','');
				//test net
				$box->angle_in('','',20,20,'white','black','','',100,'','','');
				$box->angle_out('');
				$box->angle('','',332,20,'','black','','',100,'</b>Test internet','','');
			$box->angle_out('');
			
			//Facturation
			$box->angle_in('374','10','354','182','','black','','',100,'','','');
				$box->angle('','','352','20','','black','','',100,'Facturation','','');
				$ttl=0;
				$item_tmp=db_read("select * from repair_item where id_repair = $ticket->id order by dt");
				while($item = $item_tmp->fetch())
					{
					$box->angle('','','280','20','','black','','',100,"</b><font size=3>$item->name</font>","",'');
					$box->angle('','','72','20','','black','','',100,"</b><font size=3>$item->prix &euro;</font>","",'');
					$ttl+=$item->prix;
					}
					$box->angle('','','280','20','','black','','',100,"Total","",'');
					$box->angle('','','72','20','pink','black','','',100,"$ttl &euro;","",'');
			
			$box->angle_out('');
		$box->angle_out('.');
		$print->footer($box,$sugar);
		//echo "<body onload='window.print();window.close()'>";
	
		};break;
######################################################################################################################
	case 'add_feedback':
		{
		$id_repair=$_POST['id_ticket'];
		$dt_insert=time();
		$remarque=$sugar->clean_string($_POST['remarque']);
		if($remarque!='')db_write("insert into repair_feedback(id_tech,id_repair,dt_insert,remarque)values($sugar->id,$id_repair,$dt_insert,'$remarque')");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=repair&sub_system=edit_repair&id_repair=$id_repair'/>";
		};break;
######################################################################################################################
	case 'open_ticket':
		{
		$id_ticket=$_GET['id_ticket'];
		db_write("update repair set status='open',dt_out=0 where id = $id_ticket");
		db_write("insert into feedback (sys,id_record,dt,id_tech,type,msg)values('repair','$id_ticket',".time().",'$sugar->id','open','ouverture du repair no $id_ticket par $sugar->prenom ".substr($sugar->nom,0,1)."');");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=repair&sub_system=edit_repair&id_repair=$id_ticket'/>";
		};break;
######################################################################################################################
	case 'wait_ticket':
		{
		$id_ticket=$_GET['id_ticket'];
		db_write("update repair set status='wait' where id = $id_ticket");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=repair&sub_system=edit_repair&id_repair=$id_ticket'/>";
		};break;
######################################################################################################################
	case 'chk_del_repair':
		{
		$id_ticket=$_GET['id_ticket'];

		$url_yes="index.php?system=repair&sub_system=del_repair&id_repair=$id_ticket&no_interface";
		$url_no="index.php?system=repair&sub_system=edit_repair&id_repair=$id_ticket";
		$js->confirmation("Etes vous certain de vouloir effacer le repair no $id_ticket ?",$url_yes,$url_no);
		//echo "<meta http-equiv='refresh' content='0; url=index.php?system=cmd&sub_system=edit_cmd&id_cmd=$id_cmd'/>";
		};break;
######################################################################################################################
	case 'del_repair':
		{
		$id_repair=$_GET['id_repair'];
		db_write("update repair set status='hidden',dt_out=".(time())." where id = $id_repair");
		$sugar->admin_add_log($system,$sub_system,"supression du repair $id_repair",2);
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=repair'/>";
		};break;
######################################################################################################################
	case 'destroy_repair':
		{
		$id_repair=$_GET['id_repair'];

		if($sugar->security_repair<2)$js->alert_redirect("No acces","index.php",0);

		$id_repair=$_GET['id_repair'];
		$rqt="delete from repair_feedback where id_repair = $id_repair;";
		$rqt.="delete from repair_item where id_repair = $id_repair;";
		$rqt.="delete from repair where id = $id_repair;";
		$sugar->admin_add_log($system,$sub_system,"Admin Destruction du repair $id_repair.",3);
		
		db_write("$rqt");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=repair'/>";
		};break;
######################################################################################################################
	}
?>