<?php
$admin->label="shop";

if(isset($_GET['id_shop']))$id_shop=$_GET['id_shop'];
if(isset($_POST['id_shop']))$id_shop=$_POST['id_shop'];

switch ($sub_system)
	{
######################################################################################################################
	case 'lobby':
		{
		////Edit shop
        $box->angle_in('20','40',300,'100','white','red','','',100,"Edition Shop","",'');
        $form->open("index.php?system=shop&sub_system=edit_shop","POST");
        $form->select_in('id_shop',1);
        $shop_tmp=db_read("select * from shop");
            while($shop = $shop_tmp->fetch())$form->select_option($shop->nom." ".$shop->prenom,$shop->id,'');
        $form->select_out();
        $form->send('Edit');
        $form->close();
        
        $box->angle('40','70','200','20','white','red','','',100,"Ajouter shop","index.php?system=admin/admin.shop&sub_system=add_shop&no_interface",'');
        //echo "<a href='index.php?system=admin&sub_system=add_user'>Ajouter utilisateur</a>";
        $box->angle_out('');
				
		};break;
######################################################################################################################
	case 'add_shop':
		{
		db_write("insert into shop (nom,adresse_rue,adresse_cp,adresse_ville,call1,call2,mail,img_logo,mini_name)values('nom','adresse_rue','adresse_cp','adresse_ville','call1','call2','mail@mail.com','logo_novoffice.gif','mini_name');");
		$id_shp=db_single_read("select * from shop order by id desc limit 1");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=admin/admin.shop&sub_system=edit_shop&id_shop=$id_shp->id'/>";
		};break;
######################################################################################################################
	case 'edit_shop':
		{
		$shop=db_single_read("select * from shop where id = $id_shop;");
		$form->open("index.php?system=admin/admin.shop&sub_system=update_shop&no_interface","POST");
		$form->hidden('id_shop',$id_shop);

		$box->angle_in('20','20','502','400','','black','','',100,"Information shop","",'');
		//Nom
			$box->angle('','','150','25','','black','','',100,"Nom complet :","",'');
			$box->angle_in('','','350','25','','black','','',100,"","",'');
			echo $form->text('nom',44,$shop->nom);
			$box->angle_out('');
		//mini Nom
			$box->angle('','','150','25','','black','','',100,"Nom reduit :","",'');
			$box->angle_in('','','350','25','','black','','',100,"","",'');
			echo $form->text("mini_name",44,$shop->mini_name);
			$box->angle_out('');
		//Adresse
			$box->angle('','','150','50','','black','','',100,"Adresse :","",'');
			$box->angle_in('','','350','25','','black','','',100,"","",'');
			echo $form->text("adresse_rue",44,$shop->adresse_rue);
			$box->angle_out('');
		//adresse cp
			$box->angle_in('','','50','25','','black','','',100,"","",'');
			echo $form->text("adresse_cp",2,$shop->adresse_cp);
			$box->angle_out('');
		//adresse ville
			$box->angle_in('','','300','25','','black','','',100,"","",'');
			echo $form->text("adresse_ville",37,$shop->adresse_ville);
			$box->angle_out('');
		//adresse call
			$box->angle('','','150','25','','black','','',100,"Call :","",'');
			$box->angle_in('','','175','25','','black','','',100,"","",'');
			echo $form->text("call1",18,$shop->call1);
			$box->angle_out('');
			$box->angle_in('','','175','25','','black','','',100,"","",'');
			echo $form->text("call2",18,$shop->call2);
			$box->angle_out('');
		//mail
			$box->angle('','','150','25','','black','','',100,"Mail :","",'');
			$box->angle_in('','','350','25','','black','','',100,"","",'');
			echo $form->text("mail",44,$shop->mail);
			$box->angle_out('');
		$form->send('Update');
		$form->close();
			
		$box->angle('170','200','150','150','','black',"img/150px/$shop->img_logo",'',100,"","index.php?system=admin/admin.shop&sub_system=edit_img&id_shop=$shop->id",'');
		$box->angle_out('');
		};break;
######################################################################################################################
	case 'update_shop':
		{
		$nom=$_POST['nom'];
		$adresse_rue=$_POST['adresse_rue'];
		$adresse_cp=$_POST['adresse_cp'];
		$adresse_ville=$_POST['adresse_ville'];
		$call1=$_POST['call1'];
		$call2=$_POST['call2'];
		$mail=$_POST['mail'];
		$mini_name=$_POST['mini_name'];
		db_write("update shop set nom='$nom',adresse_rue='$adresse_rue',adresse_cp='$adresse_cp',adresse_ville='$adresse_ville',call1='$call1',call2='$call2',mail='$mail',mini_name='$mini_name' where id =$id_shop;");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=admin/admin.shop&sub_system=edit_shop&id_shop=$id_shop'/>";
		};break;
######################################################################################################################
	case 'edit_img':
		{
		$iterator = new DirectoryIterator("img/150px/logo");
		foreach($iterator as $document)
			{
			if(($document->getFilename()!=".")and($document->getFilename()!=".."))$box->angle('','','150','150','','black',"img/150px/logo/".$document->getFilename(),'',100,"","index.php?system=admin/admin.shop&sub_system=update_img&id_shop=".$_GET['id_shop']."&image=".$document->getFilename()."&no_interface",'');
			}
		};break;
######################################################################################################################
	case 'update_img':
		{
		db_write("update shop set img_logo='".$_GET['image']."' where id = ".$_GET['id_shop']);
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=admin/admin.shop&sub_system=edit_shop&id_shop=".$_GET['id_shop']."'/>";
		};break;

######################################################################################################################
	}
?>