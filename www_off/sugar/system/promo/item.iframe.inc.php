<?php
if($sugar->security_prm==0)$js->alert_redirect("No acces","index.php",0);
//on verifie si un ticket est renseigner sinon on est redirect sur la page lobby cmd
//if(($sub_system!='lobby')and(isset($_GET['id_prm'])))$id_prm=$_GET['id_prm'];

if(isset($_GET['id_item']))$id_item=$_GET['id_item'];
if(isset($_GET['id_prm']))$id_prm=$_GET['id_prm'];

switch ($sub_system)
	{
######################################################################################################################
	case 'edit_item':
		{
        $item=db_single_read("select * from promo_item where id = $id_item");
       
        //img
        if(($item->type=='titre')or($item->type=='prix_ok')or($item->type=='prix_ko')or($item->type=='fiche'))
            {
           //Type
            $box->angle('10','50','120','20','white','black','','',100,ucfirst($item->type),"",'');
            }
        else 
            {
            $box->angle('10','10','120','20','white','black','','',100,ucfirst($item->type),"",'');
            if($item->type=='bground')
                {
                echo "<a href='index.php?system=promo/item.iframe&sub_system=edit_img&tab=edit_fhd&type=bground&id_prm=$id_prm&id_item=$id_item&no_interface' target=_parent>";
                $box->angle_in('10','40','128','72','red','black',"",'',100,"","",'');
                echo "<img src='img/promo/bground_fhd/$item->valeur' width=100% height=100%></img>";
                $box->angle_out(".");
                echo "</a>";
                }
            else 
                {
                echo "<a href='index.php?system=promo/item.iframe&sub_system=edit_img&tab=edit_fhd&id_prm=$id_prm&id_item=$id_item&no_interface' target=_parent>";
                $box->angle_in('10','10','120','120','red','black',"",'',100,"","",'');
                echo "<img src='img/promo/item/$item->valeur' width=100% height=100%></img>";
                $box->angle_out(".");
                echo "</a>";
                }
            }
        $box->angle_in('150','10','170','110','white','black','','',100,"","",'');
        $box->empty_in('','','80','105','','','','',100,"","",'');
            $box->empty('','','78','20','','','','',100,"</b>Position X : ","",'');
            $box->empty('','','78','20','','','','',100,"</b>Position Y : ","",'');
            $box->empty('','','78','20','','','','',100,"</b>Width : ","",'');
            $box->empty('','','78','20','','','','',100,"</b>Height : ","",'');
            $box->empty('','','78','20','','','','',100,"</b>Activated : ","",'');
        $box->empty_out('.');
        
        $box->empty_in('','','80','105','','','','',100,"","",'');
        $form->open("index.php?system=promo/item.iframe&sub_system=update_item&id_prm=$id_prm&id_item=$id_item&no_interface","POST");
        switch ($item->type)
            {
            case 'bground':
                {
                $form->text_disabled('pos_x','3','0');
                $form->hidden('pos_x',0);
                $form->text_disabled('pos_y','3','0');
                $form->hidden('pos_y',0);
                $form->text_disabled('width','3','1920');
                $form->hidden('width',1920);
                $form->text_disabled('height','3','1080');
                $form->hidden('height',1080);
                echo "<br>";
                if($item->activated==1)$form->check_box('activated',1,'checked');
                else $form->check_box('activated',1,'');
                };break;
            case 'titre':
                {
                $form->select_in('pos_x',1);
                for($i=0;$i<=1919;$i++)$form->select_option($i,$i,$item->pos_x);
                $form->select_out();
                $form->select_in('pos_y',1);
                for($i=0;$i<=1079;$i++)$form->select_option($i,$i,$item->pos_y);
                $form->select_out();
                $form->select_in('width',1);
                for($i=1;$i<=1920;$i++)$form->select_option($i,$i,$item->width);
                $form->select_out();
                $form->select_in('height',1);
                for($i=1;$i<=1080;$i++)$form->select_option($i,$i,$item->height);
                $form->select_out();
                echo "<br>";
                if($item->activated==1)$form->check_box('activated',1,'checked');
                else $form->check_box('activated',1,'');
                };break;
            case 'fiche':
                {
                $form->select_in('pos_x',1);
                for($i=0;$i<=1919;$i++)$form->select_option($i,$i,$item->pos_x);
                $form->select_out();
                $form->select_in('pos_y',1);
                for($i=0;$i<=1079;$i++)$form->select_option($i,$i,$item->pos_y);
                $form->select_out();
                $form->select_in('width',1);
                for($i=1;$i<=1920;$i++)$form->select_option($i,$i,$item->width);
                $form->select_out();
                $form->select_in('height',1);
                for($i=1;$i<=1080;$i++)$form->select_option($i,$i,$item->height);
                $form->select_out();
                echo "<br>";
                if($item->activated==1)$form->check_box('activated',1,'checked');
                else $form->check_box('activated',1,'');
                };break;
            case 'prix_ok':
                {
                $form->select_in('pos_x',1);
                for($i=0;$i<=1919;$i++)$form->select_option($i,$i,$item->pos_x);
                $form->select_out();
                $form->select_in('pos_y',1);
                for($i=0;$i<=1079;$i++)$form->select_option($i,$i,$item->pos_y);
                $form->select_out();
                $form->select_in('width',1);
                for($i=1;$i<=1920;$i++)$form->select_option($i,$i,$item->width);
                $form->select_out();
                $form->select_in('height',1);
                for($i=1;$i<=1080;$i++)$form->select_option($i,$i,$item->height);
                $form->select_out();
                echo "<br>";
                if($item->activated==1)$form->check_box('activated',1,'checked');
                else $form->check_box('activated',1,'');
                };break;
            case 'prix_ko':
                {
                $form->select_in('pos_x',1);
                for($i=0;$i<=1919;$i++)$form->select_option($i,$i,$item->pos_x);
                $form->select_out();
                $form->select_in('pos_y',1);
                for($i=0;$i<=1079;$i++)$form->select_option($i,$i,$item->pos_y);
                $form->select_out();
                $form->select_in('width',1);
                for($i=1;$i<=1920;$i++)$form->select_option($i,$i,$item->width);
                $form->select_out();
                $form->select_in('height',1);
                for($i=1;$i<=1080;$i++)$form->select_option($i,$i,$item->height);
                $form->select_out();
                echo "<br>";
                if($item->activated==1)$form->check_box('activated',1,'checked');
                else $form->check_box('activated',1,'');
                };break;
            case 'img':
                {
                $form->select_in('pos_x',1);
                for($i=0;$i<=1919;$i++)$form->select_option($i,$i,$item->pos_x);
                $form->select_out();
                $form->select_in('pos_y',1);
                for($i=0;$i<=1079;$i++)$form->select_option($i,$i,$item->pos_y);
                $form->select_out();
                $form->select_in('width',1);
                for($i=1;$i<=300;$i++)$form->select_option($i,$i,$item->width);
                $form->select_out();
                $form->select_in('height',1);
                for($i=1;$i<=300;$i++)$form->select_option($i,$i,$item->height);
                $form->select_out();
                echo "<br>";
                if($item->activated==1)$form->check_box('activated',1,'checked');
                else $form->check_box('activated',1,'');
                };break;
            }
            $box->empty_out('.');
            $box->angle_out('.');
            $box->empty_in('270','125','60','20','','','','',100,"","",'');
                $form->send('Update');
            $box->empty_out('.');
            $form->close();
		};break;
######################################################################################################################
	case 'update_item':
		{
		if($sugar->security_prm<2)$js->alert_redirect("No acces","index.php",0);
        $x=$_POST['pos_x'];
        $y=$_POST['pos_y'];
        $width=$_POST['width'];
        $height=$_POST['height'];
        if(isset($_POST['activated']))$activated=$_POST['activated'];
        else $activated=0;
        db_write("update promo_item set pos_x='$x',pos_y='$y',width='$width',height='$height',activated='$activated' where id = $id_item;");
        echo"<meta http-equiv='refresh' content='0; url=index.php?system=promo/item.iframe&sub_system=edit_item&id_prm=$id_prm&id_item=$id_item&no_interface'/>";
        };break;
######################################################################################################################
	case 'edit_img':
		{
        if($_GET['type']=='bground')
            {
            $iterator = new DirectoryIterator("img/promo/bground_fhd/");
            foreach($iterator as $document)
                {
                if(($document->getFilename()!='.')and($document->getFilename()!='..'))
                    {
                    $box->angle_in('','','388','220','','black',"",'',100,"","index.php?system=promo/item.iframe&sub_system=update_img&id_prm=$id_prm&id_item=$id_item&image=".$document->getFilename()."&no_interface",'');
                    echo "<img src='img/promo/bground_fhd/".$document->getFilename()."' width=100%>";
                    $box->angle_out(".");
                    }
                }
            }
        else 
            {
            $iterator = new DirectoryIterator("img/promo/item/");
            foreach($iterator as $document)
                {
                if(($document->getFilename()!='.')and($document->getFilename()!='..'))
                    {
                    $box->angle_in('','','150','150','','red',"",'',100,"","index.php?system=promo/item.iframe&sub_system=update_img&id_prm=$id_prm&id_item=$id_item&image=".$document->getFilename()."&no_interface",'');
                    echo "<img src='img/promo/item/".$document->getFilename()."' width=100%>";
                    $box->angle_out(".");
                    }
			
                }
            }
		};break;
######################################################################################################################
	case 'update_img':
		{
		$image=$_GET['image'];
		db_write("update promo_item set valeur ='$image' where id=$id_item;");
		echo"<meta http-equiv='refresh' content='0; url=index.php?system=promo/promo.groupe&sub_system=edit_fhd&tab=edit_fhd&id_prm=$id_prm'/>";	
		};break;
######################################################################################################################
	}
?>