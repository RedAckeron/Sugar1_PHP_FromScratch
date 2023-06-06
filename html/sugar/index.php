<?php
if(isset($_GET['load']))$mt_in=microtime();
session_start();

include('../../www_off/sugar/obj/sugar.obj.php');
if(!isset($sugar))$sugar=new _sugar;
if (isset($_SESSION['sugar']))$sugar=unserialize($_SESSION['sugar']);

include('../../www_off/sugar/obj/javascript.obj.php');
if(!isset($js))$js=new _javascript;

include('../../www_off/sugar/obj/customer.obj.php');
if(!isset($customer))$customer=new _customer;
if (isset($_SESSION['customer']))$customer=unserialize($_SESSION['customer']);

include('../../www_off/sugar/obj/form.obj.php');
if(!isset($form))$form=new _form;

include('../../www_off/sugar/obj/ticket.obj.php');
if(!isset($ticket))$ticket=new _ticket;

include('../../www_off/sugar/obj/cmd.obj.php');
if(!isset($cmd))$cmd=new _cmd;

include('../../www_off/sugar/obj/odp.obj.php');
if(!isset($odp))$odp=new _odp;

include('../../www_off/sugar/obj/promo.obj.php');
if(!isset($promo))$promo=new _promo;




include('../../www_off/sugar/dll/dll_db.php');
include('../../www_off/sugar/obj/box.obj.php');
$box=new _box;

include('../../www_off/sugar/obj/server.obj.php');
if(!isset($server))$server=new _server;
if (isset($_SESSION['server']))$server=unserialize($_SESSION['server']);
else $server->load();

//on verifie si le client dois reload de force son profil
$sugar->chk_force_reload($js);

if(!isset($_GET['no_interface']))
	{
	echo "<style type='text/css'>
	a {text-decoration: none;color: black;}
	a:visited {color: black;}
	a:hover, a:focus, a:active {text-decoration: underline;color: white;}
	 </style>";
	}

if (isset($_GET['system']))$system=$_GET['system'];
else $system='main';

if (isset($_GET['sub_system']))$sub_system=$_GET['sub_system'];
else $sub_system="lobby";
	
echo "<html><head><title>SUGAR/".ucfirst($system)."/".ucfirst($sub_system)."</title><link rel='shortcut icon' href='img/16px/favicon.ico' type='image/x-icon'/><link rel='icon' href='img/16px/favicon.ico' type='image/x-icon'/></head><body>";

if(!isset($_GET['no_interface']))
	{
	if($sugar->id!=0)
		{
		//affichage du client actif ou de la liste des user 
		$box->angle_in('1522','52','352','252','#FFFFEF','black','','','100',"",'',"");	
		if($customer->id!=0)echo "<iframe src='index.php?system=customer/client_actif.iframe&sub_system=show&id_customer=$customer->id&no_interface' frameborder=0 width=350px height=250px></iframe>";			
		else echo "<iframe src='index.php?system=customer/client_actif.iframe&sub_system=show_list_user&no_interface&no_interface' frameborder=0 width=350px height=250px></iframe>";			
		$box->angle_out("");

		// affichage du chat
		$box->angle_in('1522','314','352','475','lightblue','black','','',100,"","",'');
		echo "<iframe src='index.php?system=chat&sub_system=lobby&id_user=$sugar->id&no_interface' height=100% width=100% frameborder=0></iframe>";
		$box->angle_out('');
			
		//affichage du compteur 
		$box->angle_in('1522','799',352,102,'','black','','',100,"","",'');
		echo "<iframe width=100% height=100% frameborder=0 src='index.php?system=compteur&sub_system=lobby&no_interface'></iframe>";
		$box->angle_out('');
		}
	}

//delog si sub system est logout
if ((isset($_GET['sub_system']))and($_GET['sub_system']=='logout'))
	{
	$sugar= new _sugar;
	$customer= new _customer;
	unset($_SESSION['customer']);
	unset($_SESSION['sugar']);
	echo "<meta http-equiv='refresh' content='0; url=index.php'/>";
	}

//affichage du nom du technicien et du niveau d Acces et l implantation
	if(($sugar->id!=0)and(!isset($_GET['no_interface'])))
		{
		//mise a jours de last login dans la table user et affichage du nom du user
		db_write("update user set dt_last_login=".time()." where id = $sugar->id");
		$box->empty_in('10','914','1000','32','','','','',100,'','','');//Logo
			$box->angle('','','400','22','lightgrey','black','','',100,"</center>Utilisateur : </b><i>$sugar->nom $sugar->prenom</i>","",'');//BOX VIDE
			//implantation
			$box->angle('','','400','22','lightgrey','black','','',100,"</center>Implantation : </b><i>$sugar->shop_name</i>","",'');//BOX VIDE
			//niveau d acces
			$sugar->show_security_level($system,$box);
		$box->empty_out("");
		}
//include des pages 
if(!isset($_GET['no_interface']))$box->angle_in('10','52','1502','852','lightgrey','black','','',100,"","",'');
if ($sugar->id!=0)
	{
	if (isset($_GET['system']))include("../../www_off/sugar/system/".$_GET['system'].".inc.php");//On verifie que le system a ete declarer dans l url
	else include("../../www_off/sugar/system/main.inc.php");//sinon on vas sur la page main 
	}
else include("../../www_off/sugar/system/main.inc.php");//On verifie que le system a ete declarer dans l url
	
if(!isset($_GET['no_interface']))$box->angle_out('.');//echo "</div>";
	
//affichage du menu 
switch (substr($sugar->label,0,3))
	{
    case 'mai':$title="Menu principal";break;
	case 'cus':$title="Clients";break;
	case 'cal':$title="Appel";break;
    case 'rep':$title="Repair";break;
	case 'ctm':$title="Contrat de maintenance";break;
	case 'prm':$title="Promo";break;
	case 'odp':$title="Offre de prix";break;
	case 'cmd':$title="Commande";break;
	case 'sta':$title="Statistique";break;
	case 'sli':$title="Slideshow";break;
	case 'par':$title="Parametre";break;
	case 'adm':$title="Administrateur";break;
	case 'tro':$title="Trombinoscope";break;
	case 'dlc':$title="Download content";break;
	case 'hel':$title="Help";break;
	default : $title="Empty";
	}
############################################################################################################################################################################   MENU IN
if(!isset($_GET['no_interface']))
	{
	$box->empty_in('10','10','1870','32','','','','',100,'','','');
	    $sugar->menu_lobby($sugar,$box);
	    $sugar->menu_slideshow($sugar,$box);
        if($sugar->id!=0)
            {
            if($sugar->security_customer>0)$sugar->menu_customer($sugar,$box);
            if($sugar->security_call>0)$sugar->menu_call($sugar,$box);
            if($sugar->security_repair>0)$sugar->menu_repair($sugar,$box);
            if($sugar->security_ctm>0)$sugar->menu_ctm($sugar,$box);
            if($sugar->security_prm>0)$sugar->menu_promo($sugar,$box);
            if($sugar->security_odp>0)$sugar->menu_odp($sugar,$box);
            if($sugar->security_cmd>0)$sugar->menu_cmd($sugar,$box);
            if($sugar->security_dlc>0)$sugar->menu_dlc($sugar,$box);
            if($sugar->security_stats>0)$sugar->menu_stats($sugar,$box);
            if($sugar->security_repertory>0)$sugar->menu_repertory($sugar,$box);
            if($sugar->security_param>0)$sugar->menu_param($sugar,$box);
            if($sugar->security_admin>0)$sugar->menu_admin($sugar,$box);
            if($sugar->security_help>0)$sugar->menu_help($sugar,$box);
            $sugar->menu_logout($sugar,$box);
            
            $box->box_rond('','','300','32','lightblue',"$sugar->background_color",'','',100,"<font size=5>$title</font>","",'');//affichage de l intitul� des icones
            $box->empty('','','10','32','',"",'','',100,'','','');    //bloc separation
            $box->box_rond('','','800','32','black',"$sugar->background_color",'','',100,"<marquee><font color='#FFEEEE' size=5>$server->motd</font></marquee>","",''); //affichage du motd
                
        }
    $box->empty_out(".");
	
	//affichage des icones de server localisation
	if($_SERVER['HTTP_HOST']=='devil.kprod.ovh')$box->box_rond('1886','0',32,32,'lightgreen',"$sugar->background_color",'img/32px/home.gif','',100,'','http://devil.kprod.ovh/sugar','');//menu
	else $box->box_rond('1886','0',32,32,'orange',"$sugar->background_color",'img/32px/home.gif','',100,'','http://devil.kprod.ovh/sugar','');//menu
	if($_SERVER['HTTP_HOST']=='euroscanaa.cluster011.ovh.net')$box->box_rond('1886','32',32,32,'lightgreen',"$sugar->background_color",'img/32px/internet.gif','',100,'','http://euroscanaa.cluster011.ovh.net/sugar/','');//menu
	else $box->box_rond('1886','32',32,32,'orange',"$sugar->background_color",'img/32px/internet.gif','',100,'','http://euroscanaa.cluster011.ovh.net/sugar/','');//menu
    if($sugar->id!=0)
        {
        $box->box_rond('1886','64',32,32,'',"$sugar->background_color",'img/32px/reload.gif','',100,'','index.php?system=main&sub_system=admin_force_reload&no_interface','');//menu
        $box->box_rond_in('1883','94','37','37','red',"$sugar->background_color",'','',100,'','','');//iframe trigger
        echo "<iframe width=100% height=100% frameborder=0 src='index.php?system=iframe/trigger.iframe&no_interface'></iframe>";
        $box->box_rond_out('');//menu
        }
	}
############################################################################################################################################################################   MENU OUT

if (isset($customer))$_SESSION['customer']=serialize($customer);
if (isset($sugar))$_SESSION['sugar']=serialize($sugar);
if (isset($server))$_SESSION['server']=serialize($server);

echo "</body></html>";
echo "<meta http-equiv='refresh' content='1800; url=index.php?system=customer&sub_system=unload_customer'/>";
if(isset($_GET['load']))$box->angle('1350','5','120','22',"red",'black',"",'',100,"<font size=2>".((microtime()-$mt_in)*1000)."Ms</font>","",'');
?>