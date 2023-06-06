<?php
session_start();

//objet admin 
include('../../www_off/S_A_P/obj/admin.obj.php');

if(!isset($admin))$admin=new _admin;

if (isset($_SESSION['admin']))$admin=unserialize($_SESSION['admin']);

//objet javascript
include('../../www_off/S_A_P/obj/javascript.obj.php');
if(!isset($js))$js=new _javascript;

//objet form 
include('../../www_off/S_A_P/obj/form.obj.php');
if(!isset($form))$form=new _form;

//DATABASE
include('../../www_off/sugar/dll/dll_db.php');

include('../../www_off/S_A_P/obj/box.obj.php');
$box=new _box;

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

echo "<html><head><title>S.A.P/".ucfirst($system)."/".ucfirst($sub_system)."</title><link rel='shortcut icon' href='img/16px/favicon.ico' type='image/x-icon'/><link rel='icon' href='img/16px/favicon.ico' type='image/x-icon'/></head><body>";
############################################################################################################################################################################
if($admin->pw=='null')
    {
    if(isset($_GET['pw']))$pw=$_GET['pw'];else $pw='null';
    $admin->chk_admin_password($js,$pw);
    }

//include des pages
if(!isset($_GET['no_interface']))
    {
    $box->angle_in('0','42','760','900','white','black','','',100,"","",'');
        if (isset($_GET['system']))include("../../www_off/S_A_P/system/".$_GET['system'].".inc.php");//On verifie que le system a ete declarer dans l url
        else include("../../www_off/S_A_P/system/main.inc.php");//sinon on vas sur la page main 
    $box->angle_out('.');
    $admin->show_menu($system,$box);//affichage du menu 
    }

//DEBUG OBJ
$box->angle_in('900','20','500','500','white','black','','',100,"","",'');
   echo "<pre>";
   print_r($admin);
   echo "</pre>";
$box->angle_out('.');

############################################################################################################################################################################   MENU IN
/*
if(!isset($_GET['no_interface']))
	{
	//affichage des icones de server localisation
	if($_SERVER['HTTP_HOST']=='devil.kprod.ovh')$box->box_rond('1886','0',32,32,'lightgreen',"",'img/32px/home.gif','',100,'','http://devil.kprod.ovh/sugar','');//menu
	else $box->box_rond('1886','0',32,32,'orange',"",'img/32px/home.gif','',100,'','http://devil.kprod.ovh/sugar','');//menu
	if($_SERVER['HTTP_HOST']=='euroscanaa.cluster011.ovh.net')$box->box_rond('1886','32',32,32,'lightgreen',"",'img/32px/internet.gif','',100,'','http://euroscanaa.cluster011.ovh.net/sugar/','');//menu
	else $box->box_rond('1886','32',32,32,'orange',"",'img/32px/internet.gif','',100,'','http://euroscanaa.cluster011.ovh.net/sugar/','');//menu
    }
*/
############################################################################################################################################################################   MENU OUT
if (isset($admin))$_SESSION['admin']=serialize($admin);

echo "</body></html>";
?>