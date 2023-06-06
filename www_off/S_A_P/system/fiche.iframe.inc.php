<?php
if(isset($_GET['id_customer']))$id_customer=$_GET['id_customer'];
else die("ID CUSTOMER BAD");
$cust=db_single_read("select * from customer where id = $id_customer");
switch ($sub_system)
	{
######################################################################################################################
	case 'show':
		{
        $box->angle('100','5','200','20','','black','','',100,"Contrat de maintenance","",'');
        if($customer->type=='B2B')
            {
            $box->empty_in('20','30','312','50','red','','','',100,"Ajouter un contrat de maintenance","",'');
            $form->open("index.php?system=ctm/fiche.iframe&sub_system=add_ctm&id_customer=$customer->id&no_interface","POST");
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
            $box->empty_in('20','30','312','40','red','','','',100,"Pas de contrat de maintenance pour les clients particulier","",'');
            echo "";
            $box->empty_out('');
            }
        
   	};break;
######################################################################################################################
case 'add_ctm':
    {
    $min=$_POST['min'];
    $label="Ajoute  d un pack de ".($min/60)." Hr sur le client $id_customer";
    db_write("insert into customer_ctm (id_customer,id_tech,dt_in,dt_out,label,operateur,min_credit,min_solde)values('$customer->id','$sugar->id','".time()."','".(time()+31622400)."','$label','+','$min','$min');");
   // echo "<meta http-equiv='refresh' content='0; url=index.php' target='top'/>";
    };break;
######################################################################################################################
	}
?>