<?php
//echo "<body style='background-color:$sugar->background_color'>";
$admin->label="ctm";
//if($customer->id==0)$js->alert_redirect("Aucun client actif",'index.php?system=customer',0);

//include('../../www_off/sugar/obj/ctm.obj.php');
//$ctm = new _ctm;

//$box->angle('','','1248','23','black','black','','',100,"<marquee><font color='#CC5BF4'>Soyez heureux :)<font color='black'>____________________<font color =orange>Soyez heureux :)<font color=black>____________________<font color=lightgreen>Soyez heureux :)</marquee>","",'');
if(isset($_GET['id_ctm']))$id_ctm=$_GET['id_ctm'];
if(isset($_GET['id_customer']))$id_customer=$_GET['id_customer'];
switch ($sub_system)
	{
######################################################################################################################
    case 'lobby':
		{
        $box->angle_in('10','10','402','50',"",'black','','','100',"Ajouter un contrat de maintenance",'',"");	
           /*
        if($customer->type=='B2B')
            {
            $box->empty_in('50','20','350','20','','','','',100,"","",'');
            $form->open("index.php?system=ctm/ctm&sub_system=add_ctm&id_customer=$customer->id&no_interface","POST");
            $form->select_in('min',1);
            $form->select_option('Contrat de maintenance de 5h','300','');
            $form->select_option('Contrat de maintenance de 10h','600','');
            $form->select_option('Contrat de maintenance de 15h','900','');
            $form->select_option('Contrat de maintenance de 20h','1200','');
            $form->select_option('Contrat de maintenance de 25h','1500','');
            $form->select_out();
            $form->send('Ajouter');
            $form->close();
            $box->empty_out('');
            }
        else 
            {
            $box->empty_in('50','20','280','20','red','','','',100,"Pas pour les clients particulier","",'');
            echo "";
            $box->empty_out('');
            }			
             */ 
        $box->angle_out("");

        $box->angle_in('10','300','700','400','white','black','','','100',"Contrat de maintenance",'',"");
        /*	
            $ctm_tmp=db_read("SELECT * FROM customer_ctm where id_customer = $customer->id order by dt_in;");
            while($ctm = $ctm_tmp->fetch())
                {
                echo "<a href='index.php?system=ctm/ctm&sub_system=show_ctm&id_ctm=$ctm->id'>";
                if(($ctm->dt_out)<time())echo "<font color=red><li>".date('d/m/Y',$ctm->dt_in)." - <s>$ctm->label</s> (expire le ".date('d/m/Y',($ctm->dt_out)).")</li></font></a>";
                else echo "<font color=blue><li>".date('d/m/Y',$ctm->dt_in)." - $ctm->label (expire le ".date('d/m/Y',($ctm->dt_out)).")</li></font>";
               echo "</a>";
                } 
        */
        $box->angle_out("");
       
        };break;  
######################################################################################################################
    case 'add_ctm':
        {
        //$id_customer=$_POST['id_customer'];
        $min=$_POST['min'];
        $label="Pack de ".($min/60)." Hr sur le client ".$sugar->show_customer_name($id_customer);
        db_write("insert into customer_ctm (id_customer,id_tech,dt_in,dt_out,label,montant_base,status)values('$customer->id','$sugar->id','".time()."','".(time()+31622400)."','$label','$min','1');");
        echo "<meta http-equiv='refresh' content='0; url=index.php?system=ctm/ctm'/>";
        };break;
######################################################################################################################
    case 'show_ctm':
		{
        $ctm->load($id_ctm);
        $box->angle_in('10','30','402','230','#FFFFEF','black','','','100',"",'',"");	
        echo "<iframe src='index.php?system=customer/fiche.iframe&sub_system=show&id_customer=$customer->id&no_interface' frameborder=0 width=100% height=100%></iframe>";			
        $box->angle_out("");
        
        $box->angle('500','30',500,30,'lightgrey','black','','',100,"Contrat de maintenance","",'');
        $removed=0;
        $added=0;
        
        //$cmt=db_single_read("SELECT * FROM customer_ctm where id = $id_ctm;");
        $box->angle_in('450','70','800','300','lightgrey','black','','',100,"Intervention facturer sur le contrat no $id_ctm","",'');
           
        $transact_tmp=db_read("SELECT * FROM repair_item where id_ctr = $ctm->id;");
        while($transact = $transact_tmp->fetch())
            {
            echo "<a href='index.php?system=repair&sub_system=edit_repair&id_repair=$transact->id_repair'><li>Repair id : $transact->id_repair<br>Date : ".date('d/m/Y',$transact->dt)."<br> Tech : $transact->id_user <br>$transact->name <br>facturer : $transact->prix mins</li></a>";
            }
        $box->angle_out('');
        //affichage des infos ticket
        $box->angle_in('1290','10','200','300','','steelblue','','',100,"Info","",'');
        echo "<li>Contrat no : <br>";$form->text_disabled("","10","$ctm->id");echo"</li>";
        echo "<li>Date ouverture : <br>";$form->text_disabled("","10",date('d/m/Y',$ctm->dt_creation));echo"</li>";
        
        $expire=(($ctm->dt_expiration)-time());
        $day=0;
        while($expire>86400)
            {
            $expire-=86400;
            $day++;  
            }
        echo "<li>Expiration : <br>";
        if($day==0)$form->text_disabled("","10","Expired");
        else $form->text_disabled("","10","$day Jours");
        echo"</li>";
        

        echo "<li>Credit : <br>";$form->text_disabled("","10","$ctm->base Mins");echo"</li>";
        echo "<li>Solde : <br>";$form->text_disabled("","10","$ctm->solde Mins");echo"</li>";
        $box->angle_out('');

         /*
            $box->angle_in('30','70',1202,12,'lightgrey','black','','',100,"","",'');
            for($i=1;$i<=$removed;$i++)$box->angle('','','4','10','red','lightgrey','','',100,"","",'');
            for($i=1;$i<=($min_add->min_facture);$i++)$box->angle('','','4','10','green','lightgrey','','',100,"","",'');
            $box->angle_out('');
        */
       
        };break;
######################################################################################################################
    case 'edit_ctm':
		{
            /*
        $box->angle('500','20',500,30,'lightgrey','black','','',100,"Contrat de maintenance","",'');
        $ttl=600;
        $free=456;
        $busy=$ttl-$free;

        //$ttl=mt_rand(1,1200);

        echo $ttl;
        $box->angle_in('50','100',($ttl*2)+2,'22','lightgrey','black','','',100,"","",'');
       
        for($i=1;$i<=$free;$i++)$box->empty('','','2','20','green','lightgrey','','',100,"","",'');
        for($i=1;$i<=$busy;$i++)$box->empty('','','2','20','red','lightgrey','','',100,"","",'');
        
        $box->angle_out('');
        echo "<div style='valign:bottom'>0</div>";
        $box->angle_in('10','10','402','230','#FFFFEF','black','','','100',"",'',"");	
        echo "<iframe src='index.php?system=customer/fiche.iframe&sub_system=show&id_customer=$dlc->id_customer&no_interface' frameborder=0 width=100% height=100%></iframe>";			
        $box->angle_out("");
        */
        };break;
######################################################################################################################
	}
?>