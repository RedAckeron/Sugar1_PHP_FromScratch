<?php
if(isset($_GET['sys']))$sys=$_GET['sys'];
else die("System non renseigner");
if(isset($_GET['id_record']))$id_record=$_GET['id_record'];
else die("Id record non renseigner");

if(isset($_GET['width']))(($width=$_GET['width']));
else die("width non renseigner");
if(isset($_GET['height']))$height=(($_GET['height']));
else die("height non renseigner");

switch ($sub_system)
	{
######################################################################################################################
	case 'show_feedback':
		{
		$box->angle_in('0','0',$width,$height,'','','','',100,"Feedback","",'');
			$form->open("index.php?system=feedback.iframe&sub_system=add_feedback&sys=$sys&id_record=$id_record&width=$width&height=$height&no_interface","POST");
			$form->textarea("msg",2,103,"");
			$box->empty_in('755','22','60','22','','','','',100,"","",'');
			$form->send("Ajouter");
			$box->empty_out(".");
			$form->close();

			$fb_tmp=db_read("select * from feedback where sys='$sys' and id_record = '$id_record' order by id");
			while($fb = $fb_tmp->fetch())
				{echo"<br>";
				$box->angle('','','200','18','lightblue','black','','',100,"</b><font size = 2>".$sugar->show_name_user($fb->id_tech)." - ".date("d/m/y",$fb->dt),"",'');
				switch ($fb->type)
					{
					case 'open':$box->angle('','','100','18','lightblue','black','','',100,"</b>Open","",'');break;
					case 'transfert':$box->angle('','','100','18','pink','black','','',100,"</b>Transfert","",'');break;
					case 'feedback':$box->angle('','','100','18','lightgreen','black','','',100,"</b>Feedback","",'');break;
					case 'hardware_in':$box->angle('','','100','18','pink','black','','',100,"</b>Materiel","",'');break;
					case 'panne':$box->angle('','','100','18','pink','black','','',100,"</b>Panne","",'');break;
					case 'close':$box->angle('','','100','18','lightblue','black','','',100,"</b>Close","",'');break;
					case 'out_rpr':$box->angle('','','100','18','lightblue','black','','',100,"</b>Sortie","",'');break;

					}
				echo "<font size=3>".ucfirst(nl2br($fb->msg))."<br>";
				
				//Ligne de separation 
				$box->empty('','','838','1','black','','','',100,"","",'');
				}
		$box->angle_out('.');
		};break;
######################################################################################################################
	case 'add_feedback':
		{
		$dt=time();
		$id_tech=$sugar->id;
		if(isset($_POST['type']))$type=$_POST['type'];
		else $type="feedback";
		$msg=$sugar->clean_string($_POST['msg']);
		db_write("insert into feedback (sys,id_record,dt,id_tech,type,msg)values('$sys','$id_record','$dt','$id_tech','$type','$msg')");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=feedback.iframe&sub_system=show_feedback&id_record=$id_record&sys=$sys&width=$width&height=$height&no_interface'/>";
		};break;
######################################################################################################################
	}
?>