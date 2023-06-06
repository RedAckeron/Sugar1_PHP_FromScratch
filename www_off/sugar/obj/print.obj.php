<?php
class _print
	{
##########################################################################################
public function help()
		{
		echo "<table border = 1 width=100% bgcolor='red' color='black'>";
		echo "<tr><td>Function</td><td>Parametres</td><td>Description</td></tr>";
		echo "<tr><td>open</td><td>(url,method)</td><td>Ouverture du formulaire on choisis GET ou POST comme methode d envoi</td></tr>";
		echo "<tr><td>close</td><td>()</td><td>Fermeture du formulaire</td></tr>";
		echo "<tr><td>select_in</td><td>(name,size)</td><td>debut de menu deroulant name c est le nom de menu deoulant et siza le nombre de ligne du menu</td></tr>";
		echo "<tr><td>select_option</td><td>(value,name,selected)</td><td>option du menu deroulant value = valeur de l option name=nom afficher dans menu et selected faut il pointer dessus ou non</td></tr>";
		echo "<tr><td>select_out</td><td>()</td><td>Fermeture du formulaire</td></tr>";
		echo "<tr><td>send</td><td>()</td><td>Boutton pour envoyer formulaire name=nom sur le boutton</td></tr>";
		echo "<tr><td>text</td><td>(name,size,value)</td><td>formulaire text nom du champs size:largeur de la case , value=valeur dans le champs</td></tr>";
		echo "<tr><td>  </td><td>(  )</td><td>  </td></tr>";
		echo "</table>";
		}
##########################################################################################
public function header($box,$system,$id_ticket,$sugar)
	{
	$box->angle_in('0','0','760','1090','white','black','','','100',"","",'');
	//affichage du logo
	$box->angle_in('10','10','200','200','','black','','',100,'','','');
	echo "<img src='img/200px/logo/$sugar->shop_logo'width=100%></img>";
	$box->angle_out('');
	
	//affichage info client
	$box->angle_in('220','10','530','200','lightgrey','black','','',100,'','','');

	switch ($system)
		{
		case 'repair':
			{
			$ticket=db_single_read("select * from repair where id = $id_ticket");
			$titre_header="Reparation";
			};break;
		case 'odp':
			{
			$ticket=db_single_read("select * from cmd where id = $id_ticket");
			$titre_header="Offre de prix";
			};break;
		case 'cmd':
			{
			$ticket=db_single_read("select * from cmd where id = $id_ticket");
			$titre_header="Commande";
			};break;
		case 'dlc/dlc':
			{
			$ticket=db_single_read("select * from customer_dlc where id = $id_ticket");
			$titre_header="Download Content";
			};break;
		case 'promo/promo.groupe':
			{
			$ticket=db_single_read("select * from cmd where id = $id_ticket");
			$titre_header="Promotion";
            };break;
        case 'call':
			{
			$ticket=db_single_read("select * from call_log where id = $id_ticket");
			$titre_header="Call";
            };break;
		}
	$customer=db_single_read("select * from customer where id = $ticket->id_customer");
	$box->angle('12','5','215','30','','','','',100,"<font size=5></center>$titre_header :</font>",'','');
	$box->angle('227','5','100','30','white','black','','',100,"<font size=5>$ticket->id</font>",'','');
	
		//affichage des dates
		$box->empty('365','9','50','22','','','','',100,"<font size=3>Date : </b></font>",'','');
		$box->angle('415','9','100','22','white','black','','',100,"<font size=3></b>".date("d/m/Y",$ticket->dt_in)."</font>",'','');
		//affichage du nom du client 
		$box->angle('5','40','80','30','','','','',100,"<font size=5>Nom : </font>",'','');
		$box->angle('80','40','435','30','white','black','','',100,"<font size=5>".$customer->prenom." ".$customer->nom."</font>",'','');
		//mail
		$box->angle('5','75','70','20','','','','',100,"<font size=3>Email :</font>",'','');
		$box->angle('75','75','440','20','white','black','','',100,"<font size=3></b>$customer->mail</font>",'','');
		//affichage du no de telephone
		$box->angle('5','100','40','50','','','','',100,"<font size=4>Tel : </font>",'','');
		$box->angle('45','100','120','50','white','black','','',100,"<font size=4></b>".$sugar->show_call_formated($customer->call1)."<br>".$sugar->show_call_formated($customer->call2)."</font>",'','');
		//Adresse
		$box->angle('170','100','80','65','','','','',100,"<font size=4>Adresse :</font>",'','');
		$box->angle('250','100','265','65','white','black','','',100,"<font size=4></b>$customer->adresse <br>$customer->cp $customer->ville</font>",'','');
		//tva
		$box->angle('5','170','50','20','','','','',100,"<font size=3>Tva :</font>",'','');
		$box->angle('55','170','460','20','white','black','','',100,"<font size=3></b>$customer->no_tva</font>",'','');
		
	$box->angle_out('');
	$box->angle_in('10','220','740','780','white','black','','',100,'','','');

	}
##########################################################################################
public function footer($box,$sugar)
	{
	$box->angle_out('.');
		
		//affichage info shop
		$box->angle_in('10','1010','580','75','lightgrey','black','','',100,'','','');
        //affichage du nom du shop
			$box->angle('2','2','20','20','lightblue','black','img/20px/shop.gif','',100,"",'','');
            $box->angle('24','2','295','20','white','black','','',100,$sugar->shop_name,'',''); 
        //affichage des horraires
			$box->angle('2','26','20','20','lightblue','black','img/20px/clock.gif','',100,"",'','');
            $box->angle('24','26','295','20','white','black','','',100,$sugar->shop_clock,'','');  
       
        //affichage du telephone 
			$box->angle('2','50','20','20','lightblue','black','img/20px/phone.gif','',100,"",'','');
			$box->angle('24','50','100','20','white','black','','',100,$sugar->show_call_formated($sugar->shop_call),'','');
		
		//affichage du mail
			$box->angle('126','50','20','20','lightblue','black','img/20px/mail.gif','',100,"",'','');
			$box->angle('148','50','190','20','white','black','','',100,"$sugar->shop_mail",'','');
        
        //affichage du nom du tech
            $box->angle('324','2','20','20','lightblue','black','img/20px/user.gif','',100,"",'','');
            $box->angle('346','2','230','20','white','black','','',80,$sugar->prenom." ".substr($sugar->prenom,0,1),'','');
		//affichage de l adresse
			$box->angle('324','26','20','20','lightblue','black','img/20px/street.gif','',100,"",'','');
			$box->angle('346','26','230','44','white','black','','',100,"$sugar->shop_adresse1<br>$sugar->shop_adresse2",'','');

		$box->angle_out('');

		//affichage logo groupe
            $box->empty_in('600','1020','150','50','','','','',100,'','','');
            echo "<img src='img/150px/novoffice.gif' width=150px height=50px></img>";
            $box->empty_out('');
	    $box->angle_out('.');
	echo"<script type='text/javascript'>window.print();</script>";
	echo "<meta http-equiv='refresh' content='0; url=index.php?system=main&sub_system=close_page&no_interface'/>";
	}
}
?>
