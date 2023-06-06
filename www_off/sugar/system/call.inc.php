<?php
echo "<body style='background-color:$sugar->background_color'>";
if($sugar->security_call==0)$js->alert_redirect("No acces","index.php",0);

if(isset($_GET['id_call']))$id_call=$_GET['id_call'];
else $id_call=0;
$sugar->label="cal";

switch ($sub_system)
	{
######################################################################################################################
	case 'lobby':
		{
		//bouton ajouter call
		$box->box_rond('','',200,'23','yellow','black','','',100,"Ajouter un Appel","index.php?system=call&sub_system=add_call",'');
		$box->angle('','','1300','23','black','black','','',100,"<marquee><font color=orange>Call qui attend une reponse de vous<font color=black>____________________<font color =lightblue>Call ou vous etes impliquer mais en attente d une reponse de qqun d autre<font color=black>____________________<font color =lightgreen>Call cloturer</marquee>","",'');
		//$box->angle('','','1300','23','black','black','','',100,"<marquee><font color=orange>Call qui attend une reponse de vous<font color=black>____________________<font color =lightgreen>Call cloturer</marquee>","",'');
		
		//1ere ligne avec les intitul�
		$box->empty_in('','',1500,'22','black','white','','',100,"","",'');
			$box->angle('','',50,'20','white','black','','',100,"Id",'',"");
			$box->angle('','',150,'20','white','black','','',100,"Date",'',"");
			$box->angle('','',300,'20','white','black','','',100,"Client",'',"");
			$box->angle('','',600,'20','white','black','','',100,"Sujet",'',"");
            $box->angle('','',100,'20','white','black','','',100,"In / Out",'',"");
            $box->angle('','',100,'20','white','black','','',100,"Feedback",'',"");
            $box->angle('','',200,'20','white','black','','',100,"Localisation",'',"");
		$box->empty_out('');
		
        $chk_cnt=36;
        //affichage des call ouvert que tu dois traiter 
        //$call_a_moi_tmp=db_read("select distinct id_call from call_log_feedback where id_tech = '$sugar->id';");
        //while($call_a_moi = $call_a_moi_tmp->fetch())
        //    {
            $call_tmp=db_read("select * from call_log where status = 'open' limit $chk_cnt");
            while($call = $call_tmp->fetch())
            if($call->id_tech==$sugar->id)
                {
                $box->empty_in('','',1500,'22',"white",'white','','',100,"","index.php?system=call&sub_system=edit_call&id_call=$call->id",'');
                $box->angle('','',50,'20','orange','black','','',100,$call->id,'',"");
                $box->angle('','',150,'20','orange','black','','',100,date("d/m/Y - H:i",$call->dt_in),'',"");
                $box->angle('','',300,'20','orange','black','','',100,$sugar->show_customer_name($call->id_customer),'',"");
                $box->angle('','',600,'20','orange','black','','',100,"$call->sujet",'',"");
                
                $cnt_fb=db_single_read("select count(*) as cnt from call_log_feedback where id_call = $call->id");
                $box->angle('','',100,'20','orange','black','','',100,"$cnt_fb->cnt",'',"");
                
                $box->angle('','',100,'20','orange','black','','',100,"$call->status",'',"");
                $box->angle('','',200,'20','orange','black','','',100,$sugar->show_name_user($call->id_tech),'',"");
                $box->empty_out('');
                $chk_cnt--;
                }
        //    }
        //affichage des call ouvert ou tu est impliquer 
        $call_a_moi_tmp=db_read("select distinct id_call from call_log_feedback where id_tech = '$sugar->id';");
        while($call_a_moi = $call_a_moi_tmp->fetch())
            {
            $call=db_single_read("select * from call_log where id = $call_a_moi->id_call limit $chk_cnt");
            if(($call->id_tech!=$sugar->id)and($call->status=='open'))
                {
                $box->empty_in('','',1500,'22',"white",'white','','',100,"","index.php?system=call&sub_system=edit_call&id_call=$call->id",'');
                $box->angle('','',50,'20','lightblue','black','','',100,$call->id,'',"");
                $box->angle('','',150,'20','lightblue','black','','',100,date("d/m/Y - H:i",$call->dt_in),'',"");
                $box->angle('','',300,'20','lightblue','black','','',100,$sugar->show_customer_name($call->id_customer),'',"");
                $box->angle('','',600,'20','lightblue','black','','',100,"$call->sujet",'',"");
                
                $cnt_fb=db_single_read("select count(*) as cnt from call_log_feedback where id_call = $call->id");
                $box->angle('','',100,'20','lightblue','black','','',100,"$cnt_fb->cnt",'',"");
                
                $box->angle('','',100,'20','lightblue','black','','',100,"$call->status",'',"");
                $box->angle('','',200,'20','lightblue','black','','',100,$sugar->show_name_user($call->id_tech),'',"");
                $box->empty_out('');
                $chk_cnt--;
                }
            }
        
        $call_tmp=db_read("select * from call_log where status='close' order by dt_in desc limit $chk_cnt;");
        while($call = $call_tmp->fetch())
            {
            $box->empty_in('','',1500,'22',"white",'white','','',100,"","index.php?system=call&sub_system=edit_call&id_call=$call->id",'');
            $box->angle('','',50,'20','lightgreen','black','','',100,$call->id,'',"");
            $box->angle('','',150,'20','lightgreen','black','','',100,date("d/m/Y - H:i",$call->dt_in),'',"");
            $box->angle('','',300,'20','lightgreen','black','','',100,$sugar->show_customer_name($call->id_customer),'',"");
            $box->angle('','',600,'20','lightgreen','black','','',100,"$call->sujet",'',"");
            
            $cnt_fb=db_single_read("select count(*) as cnt from call_log_feedback where id_call = $call->id");
            $box->angle('','',100,'20','lightgreen','black','','',100,"$cnt_fb->cnt",'',"");
            $box->angle('','',100,'20','lightgreen','black','','',100,"$call->status",'',"");
            $box->angle('','',200,'20','lightgreen','black','','',100,$sugar->show_name_user($call->id_tech),'',"");
            $box->empty_out('');
            $chk_cnt--;
            }
		};break;
######################################################################################################################
	case 'add_call':
		{
        if($customer->id!=0)
			{
            //customer
            $box->angle_in('10','10','402','230','#FFFFEF','black','','','100',"",'',"");	
            echo "<iframe src='index.php?system=customer/fiche.iframe&sub_system=show&id_customer=$customer->id&no_interface' frameborder=0 width=100% height=100%></iframe>";			
            $box->angle_out("");
            $box->angle_in('420','10','600','230','lightgrey','black','','',100,'Indiquez le motif du call ','',"");
                $form->open("index.php?system=call&sub_system=validate_add_call","POST");
                $form->textarea("sujet",10,82,"");
                echo "<br>";
                $form->send("Valider");
                $form->close();
            $box->angle_out('.');
            }
            else $js->alert_redirect("Aucun client actif","index.php?system=customer",0);
		};break;
######################################################################################################################
	case 'validate_add_call':
		{
		if($customer->id!=0)
			{
			$sujet=$_POST['sujet'];
			$dt_in=time();
            db_write("insert into call_log (dt_in,id_tech,id_customer,sujet,dt_out,status)values($dt_in,$sugar->id,$customer->id,'$sujet',0,'open')");
            $id_call=db_single_read("select * from call_log order by id desc limit 1");
            
            $sugar->admin_add_log($system,$sub_system,"Creation du call $id_call->id",1);
		
			$dt=time();
			$name=$sugar->prenom." ".substr($sugar->nom,0,1);
			$feedback="Ouvert par $name le ".date('d/m/y',$dt)." a ".date("H:i",$dt);
            $rqt="insert into call_log_feedback (dt,id_call,id_tech,type,feedback,readed)values('$dt','$id_call->id','$sugar->id','open','$feedback','0');";
            $rqt.="insert into call_log_feedback (dt,id_call,id_tech,type,feedback)values($dt_in,$id_call->id,$sugar->id,'feedback','$sujet')";
            db_write($rqt);
            echo "<meta http-equiv='refresh' content='0; url=index.php?system=call&sub_system=edit_call&id_call=$id_call->id'/>";
			}
		else $js->alert_redirect("Vous devez avoir un client actif avant d ajouter un appel","index.php?system=customer",0);
		};break;
######################################################################################################################
	case 'edit_call':
		{
		$call=db_single_read("select * from call_log where id=$id_call");
		$cust=db_single_read("select * from customer where id = $call->id_customer");
		
        //customer
        $box->angle_in('10','10','402','230','#FFFFEF','black','','','100',"",'',"");	
            echo "<iframe src='index.php?system=customer/fiche.iframe&sub_system=show&id_customer=$call->id_customer&no_interface' frameborder=0 width=100% height=100%></iframe>";			
        $box->angle_out("");
		
		$box->angle_in('10','250','400','100','','black','','','100',"",'',"");	
			echo "<li>Ouvert par : ".$sugar->show_name_user($call->id_tech)."</li>";
			echo "<li>Ouvert le : ".date('d/m/y - H:i',$call->dt_in)."</li>";
			echo "<li>Status : $call->status</li>";
		$box->angle_out("");

		if($call->id_tech==$sugar->id)
			{
			$box->angle_in('10','360','400','200','','black','','','100',"Ajouter un feedback",'',"");	
			$form->open("index.php?system=call&sub_system=add_feedback&id_call=$id_call&no_interface","POST");
			$form->textarea('feedback',9,53,'');
			echo"<br>";$form->send('Envoyer');
			$form->close();
			$box->angle_out("");
            
            //transfert call
			$box->angle_in('10','570','400','60','','black','','','100',"Transfert du call",'',"");	
				$form->open("index.php?system=call&sub_system=transfert_call&id_call=$id_call&no_interface","POST");
				$form->select_in('id_tech',1);
				$uzr_tmp=db_read("select * from user where id!=7 and id!=0 and id!=$sugar->id and status ='on';");
				while($uzr = $uzr_tmp->fetch())$form->select_option("$uzr->prenom $uzr->nom",$uzr->id,'');
				$form->select_out();
				$form->send('Transfert');
				$form->close();
			$box->angle_out("");
            
            //bouton close call
			if($call->status=='open')$box->angle('10','640','195','22','orange','black','','','100',"Fermeture du call","index.php?system=call&sub_system=close_call&id_call=$id_call&no_interface","");	
			else $box->angle('10','640','195','22','lightgreen','black','','','100',"Ouverture du call","index.php?system=call&sub_system=open_call&id_call=$id_call&no_interface","");	
            
            echo "<a href='index.php?system=call&sub_system=print_call&id_call=$id_call&no_interface' target=_blank>";
            $box->angle('215','640','195','22','lightgreen','black','','','100',"Print call","","");	
            echo "</a>";
        
        }
		
		//info call et client 
		$box->angle_in('450','20','1002','800','lightgrey','','','','100','','',"");
			$fb_tmp=db_read("select * from call_log_feedback where id_call = $id_call");
			while($fb = $fb_tmp->fetch())
				{
                $name_tech_in=db_single_read("select * from user where id = $fb->id_tech");
				switch ($fb->type)
					{
					case 'open':
						{
						echo "<b><i><div style='position:auto;float:left;width:980px;height:18px;background-color:lightblue;'>".nl2br($fb->feedback)."</div></i></b>";
                        };break;	
					case 'transfert':
						{
						echo "<b><i><div style='position:auto;float:left;width:980px;background-color:pink;'>".nl2br($fb->feedback)."</div></i></b>";
						};break;
					case 'feedback':
						{
						$box->angle('','','980','20','lightgreen','black','','','100',"<font size=3></center><i>Feedback ajouter par ".$sugar->show_name_user($fb->id_tech)." le ".date('d/m/Y - H:i',$fb->dt)." :",'',"");
                        echo "<i><div style='position:auto;float:left;width:980px;background-color:lightgreen;'>".nl2br($fb->feedback)."</div></i>";
						};break;
                    case 'close':
						{
						echo "<b><i><div style='position:auto;float:left;width:980px;height:18px;background-color:orange;'>".nl2br($fb->feedback)."</div></i></b>";
                        };break;
					}
				$box->empty('','','980','1','black','','','','100','','',"");
				echo "<br>";
				}
		$box->angle_out("");
		$box->angle('450','20','982','800','','black','','','100','','',"");
		
		};break;
######################################################################################################################
	case 'transfert_call':
		{
		db_write("update call_log set id_tech=".$_POST['id_tech']." where id=".$_GET['id_call'].";");
		db_write("insert into call_log_feedback (dt,id_call,id_tech,type,feedback)values(".time().",".$_GET['id_call'].",$sugar->id,'transfert','Call transfert de ".$sugar->show_name_user($sugar->id)." vers ".$sugar->show_name_user($_POST['id_tech'])." le ".date('d/m/y - H:i',time())."');");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=call'/>";
		};break;
######################################################################################################################
	case 'add_feedback':
		{
		$msg=$_POST['feedback'];
		db_write("insert into call_log_feedback (dt,id_call,id_tech,type,feedback,readed)values(".time().",$id_call,$sugar->id,'feedback','$msg','0')");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=call&sub_system=edit_call&id_call=$id_call'/>";
		};break;
######################################################################################################################
	case 'close_call':
		{
		db_write("update call_log set status='close' where id = $id_call");
        db_write("insert into call_log_feedback (dt,id_call,id_tech,type,feedback)values(".time().",".$_GET['id_call'].",$sugar->id,'close','Call fermer par ".$sugar->show_my_name_mini()." le ".date('d/m/Y - H:i',time())."');");
		//die("insert into call_log_feedback (dt,id_call,id_tech,type,feedback)values(".time().",".$_GET['id_call'].",$sugar->id,'close','Call fermer le ".date('d/m/y - H:i',time())."');");
        $sugar->admin_add_log($system,$sub_system,"Fermeture du call $id_call",1);
		
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=call'/>";
		};break;
######################################################################################################################
	case 'open_call':
		{
		db_write("update call_log set status='open' where id = $id_call");
        db_write("insert into call_log_feedback (dt,id_call,id_tech,type,feedback)values(".time().",".$_GET['id_call'].",$sugar->id,'open','Call ouvert par ".$sugar->show_my_name_mini()." le ".date('d/m/Y - H:i',time())."');");
		
        $sugar->admin_add_log($system,$sub_system,"Ouverture du call $id_call",1);
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=call&sub_system=edit_call&id_call=$id_call'/>";
		};break;

######################################################################################################################
    case 'print_call':
        {
        echo "<body style='background-color:white'>";
        include('../../www_off/sugar/obj/print.obj.php');
        $print=new _print;
        
        $print->header($box,$system,$id_call,$sugar);
        
        $fb_tmp=db_read("select * from call_log_feedback where id_call = $id_call");
        while($fb = $fb_tmp->fetch())
            {
            $name_tech_in=db_single_read("select * from user where id = $fb->id_tech");
            switch ($fb->type)
                {
                case 'open':
                    {
                    echo "<b><i><div style='position:auto;float:left;width:738px;height:18px;'>".nl2br($fb->feedback)."</div></i></b>";
                    };break;	
                case 'transfert':
                    {
                    echo "<b><i><div style='position:auto;float:left;width:738px;'>".nl2br($fb->feedback)."</div></i></b>";
                    };break;
                case 'feedback':
                    {
                    $box->angle('','','738px','20','','black','','','100',"<font size=3></center><i>Feedback ajouter par ".$sugar->show_name_user($fb->id_tech)." le ".date('d/m/Y - H:i',$fb->dt)." :",'',"");
                    echo "<i><div style='position:auto;float:left;width:738px;'>".nl2br($fb->feedback)."</div></i>";
                    };break;
                case 'close':
                    {
                    echo "<b><i><div style='position:auto;float:left;width:738px;height:18px;'>".nl2br($fb->feedback)."</div></i></b>";
                    };break;
                }
            $box->empty('','','738px','1','black','','','','100','','',"");
            echo "<br>";
            }
        
        $print->footer($box,$sugar);
         
        };break;

######################################################################################################################
	}
?>