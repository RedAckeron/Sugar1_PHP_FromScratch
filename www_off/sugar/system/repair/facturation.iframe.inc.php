<?php
$id_repair=$_GET['id_repair'];
$repair=db_single_read("select * from repair where id =$id_repair");
$chk_ctm_actif=db_single_read("select count(*) as cnt from customer_ctm where id_customer =$repair->id_customer and status=1");
$chk_ctm_actif=$chk_ctm_actif->cnt;
$facturation=$_GET['facturation'];
if($facturation=='contrat')
   {
    include('../../www_off/sugar/obj/ctm.obj.php');
    $ctm = new _ctm;
    $ctm_actif=$ctm->chk_all_ctm($sugar,$js,$repair->id_customer);
    $facturation='contrat';
    $color='#ffc9cc';
    }
else
    {
    $ctm_actif=0;
    $facturation='direct';
    $color='#e3fffc';
    }
$box->angle('5','5','190','20','lightblue','black','','',100,'Facturation en direct',"index.php?system=repair/facturation.iframe&sub_system=select_add_item_repair&id_repair=$id_repair&facturation=direct&no_interface",'');
if($chk_ctm_actif>0)$box->angle('205','5','190','20','pink','black','','',100,"Facturation par contrat ($chk_ctm_actif)","index.php?system=repair/facturation.iframe&sub_system=select_add_item_repair&id_repair=$id_repair&facturation=contrat&id_ctm=$ctm_actif&no_interface",'');
else $box->angle('205','5','190','20','grey','black','','',100,"Facturation par contrat","",'');

switch ($sub_system)
	{
######################################################################################################################
	case 'select_add_item_repair':
		{
        if($facturation=='direct')
            {
            $box->angle_in('5','30','390','70',$color,'black','','',100,'Facturation en direct','','');
            //Main d oeuvre
            $form->open("index.php?system=repair/facturation.iframe&sub_system=update_add_item_repair_direct&id_repair=$id_repair&format=direct&type=work&facturation=$facturation&no_interface","POST");
                $box->empty('','',290,25,'','','','',100,'</b><li>Main d oeuvre</li>','','');
                $box->angle_in('','',50,25,'','','','',100,'','','');
                echo"<select name='work' size='1'>";
                for($i=0;$i<=240;$i+=5)echo("<option value='$i'>$i</option>");
                echo"</select>";
                $box->angle_out('');
                $box->angle_in('','',45,25,'','','','',100,'','','');
                $form->send("Add");
                $box->angle_out('');
            $form->close();
            //Deplacement
            $form->open("index.php?system=repair/facturation.iframe&sub_system=update_add_item_repair_direct&id_repair=$id_repair&format=direct&type=move&facturation=$facturation&no_interface","POST");
                $box->empty('','',290,25,'','','','',100,'</b><li>Deplacement</li>','','');
                $box->angle_in('','',50,25,'','','','',100,'','','');
                echo"<select name='move' size='1'>";
                for($i=0;$i<=240;$i+=5)echo("<option value='$i'>$i</option>");
                echo"</select>";
                $box->angle_out('');
                $box->angle_in('','',45,25,'','','','',100,'','','');
                $form->send("Add");
                $box->angle_out('');
            $form->close();
            $box->angle_out('');
            }

        if($facturation=='contrat')
            {
            $box->angle_in('5','30','390','70',$color,'black','','',100,'Facturation par contrat','','');
                //Main d oeuvre
                $form->open("index.php?system=repair/facturation.iframe&sub_system=update_add_item_repair_contrat&id_repair=$id_repair&format=contrat&type=work&facturation=$facturation&ctm_actif=$ctm_actif&no_interface","POST");
                $box->empty('','',290,25,'','','','',100,'</b><li>Main d oeuvre</li>','','');
                $box->angle_in('','',50,25,'','','','',100,'','','');
                echo"<select name='work' size='1'>";
                for($i=0;$i<=240;$i+=15)echo("<option value='$i'>$i</option>");
            
                echo"</select>";
                $box->angle_out('');
                $box->angle_in('','',45,25,'','','','',100,'','','');
                $form->send("Add");
                $box->angle_out('');
            $form->close();
            //Deplacement
            $form->open("index.php?system=repair/facturation.iframe&sub_system=update_add_item_repair_contrat&id_repair=$id_repair&format=contrat&type=move&facturation=$facturation&ctm_actif=$ctm_actif&no_interface","POST");
                $box->empty('','',290,25,'','','','',100,'</b><li>Deplacement</li>','','');
                $box->angle_in('','',50,25,'','','','',100,'','','');
                echo"<select name='move' size='1'>";
                echo("<option value='0'>0</option>");
                echo("<option value='25'>25</option>");
                echo("<option value='30'>30</option>");
                echo("<option value='40'>40</option>");
                echo("<option value='50'>50</option>");
            echo"</select>";
                $box->angle_out('');
                $box->angle_in('','',45,25,'','','','',100,'','','');
                $form->send("Add");
                $box->angle_out('');
            $form->close();
            $box->angle_out('');
            }
    
        //add divers tout format 
        $box->angle_in('5','105','390','35','#d3fab6','black','','',100,'','','');
            $form->open("index.php?system=repair/facturation.iframe&sub_system=update_add_item_repair_direct&format=all&type=divers&id_repair=$id_repair&facturation=$facturation&no_interface","POST");
                $box->empty_in('5','5',280,25,'','','','',100,'','','');
                $form->text('divers_name',35,'Divers');
                $box->empty_out('');

                $box->empty_in('290','5',50,25,'','','','',100,'','','');
                $form->text('divers_prix',2,'0');
                $box->empty_out('');
                
                $box->empty_in('340','5',40,25,'','','','',100,'','','');
                $form->send("Add");
                $box->empty_out('');
            $form->close();
        $box->angle_out('');
      
		//recapitulatif
		$ttl=0;
		$box->angle_in('5','145','390','300','white','black','','',100,'<u>Ticket de caisse</u>','','');
            $item_repair_tmp=db_read("select * from repair_item where id_repair = $id_repair");
            while($item_repair = $item_repair_tmp->fetch())
                {
                $box->empty('','',320,20,'#FFFFEF','','','',100,"</b><li>".$item_repair->name."</li>",'','');
                $box->empty('','',48,20,'#FFFFEF','','','',100,"</b>".$item_repair->prix."  &euro;",'','');$ttl+=$item_repair->prix;
                
                if(($repair->status=='open')or($repair->status=='wait'))$box->empty('','',20,20,'#FFFFEF','','','',100,"X","index.php?system=repair/facturation.iframe&sub_system=delete_add_item_repair&id_repair=$id_repair&id_item=$item_repair->id&facturation=$facturation&no_interface",'');
                else $box->empty('','',20,20,'#FFFFEF','','','',100,"","",'');
                }
            //prix total
            //solde des contrats 

            $box->angle_in('0','276',388,22,'','white','','',100,'','','');
                $box->angle('','',270,20,'','','','',100,'','','');//espace vide pour coller total au nombre
                $box->angle('','',50,20,'','','','black',100,'Total :','','');
                $box->angle('','',66,20,'pink','','','black',100,"<b><u><center>$ttl &euro;</center></u></b>",'','');
            $box->angle_out('.');
                
            //$box->angle('','',25,25,'','','','',100,"",'','');
		$box->angle_out('');
		
        };break;
######################################################################################################################
	case 'update_add_item_repair_direct':
		{
        $format=$_GET['format'];
        $dt=time();
        if(isset($_POST['id_ctr']))$id_ctr=$_POST['id_ctr'];
        else $id_ctr=0;
       
        if(isset($_POST['work']))
            {
            $prix=$_POST['work'];
            $name='Main d oeuvre';
            $type='work';
            }
        if(isset($_POST['move']))
            {
            $prix=$_POST['move'];
            $name='Déplacement';
            $type='move';
            }
        if(isset($_POST['divers_prix']))
            {
            $prix=$_POST['divers_prix'];
            $name=$_POST['divers_name'];
            $type='divers';
            }
		
		db_write("insert into  repair_item (id_repair,format,type,id_ctr,name,prix,dt,id_user)values('$id_repair','$format','$type','$id_ctr','$name','$prix','$dt','$sugar->id')");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=repair/facturation.iframe&sub_system=select_add_item_repair&id_repair=$id_repair&facturation=$facturation&no_interface'/>";
		
        };break;
######################################################################################################################
    case 'update_add_item_repair_contrat':
        {
        $box->angle_in('5','35','388','400','white','black','','',100,'','','');
        $ctm->load($_GET['ctm_actif']);
        
        $format=$_GET['format'];
        $dt=time();
        $retrait=0;

        echo"<li>Contrat no : $ctm->id</li>";
        echo"<li>Montant de Base : $ctm->base</li>";
        echo"<li>Solde  : $ctm->solde</li>";
                
        $prix=0;
        if(isset($_POST['work']))
            {
            $prix=$_POST['work'];
            $name='Main d oeuvre';
            $type='work';
            }
        if(isset($_POST['move']))
            {
            $prix=$_POST['move'];
            $name='Déplacement';
            $type='move';
            }
        if(isset($_POST['divers_prix']))
            {
            $prix=$_POST['divers_prix'];
            $name=$_POST['divers_name'];
            $type='divers';
            }
        //$name.=" (sur contrat no $ctm->id)";
        if($prix<$ctm->solde)
            {
            echo"<li>Solde contrat sufisant</li>";
            echo"<li>Retrait de $prix min du contrat</li>";
            echo"<li>Nouveau solde du contrat : ".($ctm->solde-$prix)."</li>";
            db_write("insert into repair_item (id_repair,format,type,id_ctr,name,prix,dt,id_user)values($id_repair,'$format','$type',$ctm->id,'$name (sur contrat no $ctm->id)',$prix,$dt,$sugar->id)");
            }
        else 
            {
            echo"<li>Solde contrat non sufisant</li>";
            echo"<li>Retrait de $ctm->solde min du contrat</li>";
            echo"<li>Nouveau solde du contrat : 0</li>";
            db_write("insert into repair_item (id_repair,format,type,id_ctr,name,prix,dt,id_user)values($id_repair,'$format','$type',$ctm->id,'$name (sur contrat no $ctm->id)','$ctm->solde',$dt,$sugar->id)");
            db_write("update customer_ctm set status=0 where id = $ctm->id");//si il ne reste plus de min dans le contrat on le desactive 
            $reste=$prix-$ctm->solde;
            $name.="(<font color =red> A payer hors contrat)</font>";
            db_write("insert into repair_item (id_repair,format,type,id_ctr,name,prix,dt,id_user)values($id_repair,'$format','$type',0,'$name','$reste',$dt,$sugar->id)"); 
            }
        $box->angle_out('.');
        };break;
######################################################################################################################
	case 'delete_add_item_repair':
		{
		$id_item=$_GET['id_item'];
		db_write("delete from repair_item where id = $id_item");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=repair/facturation.iframe&sub_system=select_add_item_repair&id_repair=$id_repair&facturation=$facturation&no_interface'/>";
		};break;
######################################################################################################################
    }
?>