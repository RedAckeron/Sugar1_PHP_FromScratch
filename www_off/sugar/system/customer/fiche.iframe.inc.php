<?php
 echo "<body style='background-color:#FFFFEF'></body>";
if(isset($_GET['id_customer']))$id_customer=$_GET['id_customer'];
else die("ID CUSTOMER BAD");
$cust=db_single_read("select * from customer where id = $id_customer");
switch ($sub_system)
	{
######################################################################################################################
	case 'show':
		{
        $box->angle('150','5','150','20','red','black','','',100,"Fiche Client","",'');
        //affichage
        $form->open("index.php?system=customer/fiche.iframe&sub_system=edit&id_customer=$id_customer&no_interface","POST");
        $box->empty_in('10','10','75','210','','','','',100,"","",'');
			$box->empty('','','80','22','','','','',100,"Type :","",'');
			$box->empty('','','80','22','','','','',100,"Prenom :","",'');
			$box->empty('','','80','22','','','','',100,"Nom :","",'');
            $box->empty('','','80','22','','','','',100,"Adresse :","",'');
            $box->empty('','','80','22','','','','',100,"Cp/Ville : ","",'');
			$box->empty('','','80','22','','','','',100,"Call :","",'');
			$box->empty('','','80','22','','','','',100,"Mail :","",'');
			$box->empty('','','80','22','','','','',100,"Tva :","",'');
		$box->empty_out('');

		$box->empty_in('85','10','314','210','','','','',100,"","",'');
            $box->empty_in('','','312','22','','','','',100,"","",'');
                $form->select_in('type',1);
                $form->select_option_disabled('B2C','B2C',$cust->type);
                $form->select_option_disabled('B2B','B2B',$cust->type);
                $form->select_out();
            $box->empty_out('');
            $box->empty_in('','','312','22','','','','',100,"","",'');$form->text_disabled("prenom",39,"$cust->prenom");$box->empty_out('');
			$box->empty_in('','','312','22','','','','',100,"","",'');$form->text_disabled("nom",39,"$cust->nom");$box->empty_out('');
			$box->empty_in('','','312','50','','','','',100,"","",'');$form->textarea_disabled("adresse",3,41,"$cust->adresse \n$cust->cp $cust->ville");$box->empty_out('');
			$box->empty_in('','','312','22','','','','',100,"","",'');$form->text_disabled("call1",17,"$cust->call1");$form->text_disabled("call2",17,"$cust->call2");$box->empty_out('');
			$box->empty_in('','','312','22','','','','',100,"","",'');$form->text_disabled("mail",39,"$cust->mail");$box->empty_out('');
			$box->empty_in('','','312','22','','','','',100,"","",'');$form->text_disabled("no_tva",39,"$cust->no_tva");$box->empty_out('');
			$box->empty_in('','','312','22','','','','',100,"","",'');$form->text_disabled("",39,"Id client : $cust->id");$box->empty_out('');
		$box->empty_out('');

        $box->empty_in('340','5','51','21','','','','',100,"","",'');
		$form->send('Editer');
		$box->empty_out('');
        
        $form->close();
		};break;
######################################################################################################################
	case 'edit':
		{
        $box->angle('150','5','150','20','','black','','',100,"Fiche Client","",'');
		//affichage
        $box->empty_in('10','10','75','210','','','','',100,"","",'');
            $box->empty('','','80','22','','','','',100,"Type :","",'');
			$box->empty('','','80','22','','','','',100,"Prenom :","",'');
			$box->empty('','','80','22','','','','',100,"Nom :","",'');
            $box->empty('','','80','22','','','','',100,"Adresse :","",'');
            $box->empty('','','80','22','','','','',100,"Cp/Ville : ","",'');
            $box->empty('','','80','22','','','','',100,"Call :","",'');
			$box->empty('','','80','22','','','','',100,"Mail :","",'');
			$box->empty('','','80','22','','','','',100,"Tva :","",'');
		$box->empty_out('');
		
		$form->open("index.php?system=customer/fiche.iframe&sub_system=update&id_customer=$id_customer&no_interface","POST");
            $box->empty_in('85','10','314','210','','','','',100,"","",'');
                $box->empty_in('','','312','22','','','','',100,"","",'');
                    $form->select_in('type',1);
                    $form->select_option('B2C','B2C',$cust->type);
                    $form->select_option('B2B','B2B',$cust->type);
                    $form->select_out();
                $box->empty_out('');
				$box->empty_in('','','312','22','','','','',100,"","",'');$form->text("prenom",39,"$cust->prenom");$box->empty_out('');
				$box->empty_in('','','312','22','','','','',100,"","",'');$form->text("nom",39,"$cust->nom");$box->empty_out('');
				$box->empty_in('','','312','22','','','','',100,"","",'');$form->text("adresse",39,"$cust->adresse");$box->empty_out('');
				$box->empty_in('','','312','28','','','','',100,"","",'');$form->text("cp",17,"$cust->cp");$form->text("ville",17,"$cust->ville");$box->empty_out('');
				$box->empty_in('','','312','22','','','','',100,"","",'');$form->text("call1",17,"$cust->call1");$form->text("call2",17,"$cust->call2");$box->empty_out('');
				$box->empty_in('','','312','22','','','','',100,"","",'');$form->text("mail",39,"$cust->mail");$box->empty_out('');
				$box->empty_in('','','312','22','','','','',100,"","",'');$form->text("no_tva",39,"$cust->no_tva");$box->empty_out('');
				$box->empty_in('','','312','22','','','','',100,"","",'');$form->text_disabled("",39,"Id client : $cust->id");$box->empty_out('');
			$box->empty_out('');

			$box->empty_in('330','5','61','21','','','','',100,"","",'');
			$form->send('Update');
			$box->empty_out('');
		$form->close();
		};break;
######################################################################################################################
	case 'update':
		{
        $type=$_POST['type'];
		$prenom=$sugar->clean_string($_POST['prenom']);
		$nom=$sugar->clean_string($_POST['nom']);
		$adresse=$sugar->clean_string($_POST['adresse']);
		$cp=$sugar->clean_string($_POST['cp']);
		$ville=$sugar->clean_string($_POST['ville']);
		$call1=$sugar->clean_string($_POST['call1']);
		$call2=$sugar->clean_string($_POST['call2']);
		$mail=$sugar->clean_string($_POST['mail']);
		$no_tva=$sugar->clean_string($_POST['no_tva']);
		db_write("update customer set type='$type',prenom='$prenom',nom='$nom',adresse='$adresse',cp='$cp',ville='$ville',call1='$call1',call2='$call2',mail='$mail',no_tva='$no_tva' where id = $id_customer");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=customer/fiche.iframe&sub_system=show&id_customer=$id_customer&no_interface'/>";
		};break;
######################################################################################################################
	}
?>