<?php
$id_repair=$_GET['id_repair'];

switch ($sub_system)
	{
######################################################################################################################
	case 'show_feedback':
		{
		$repair=db_single_read("select * from repair where id = $id_repair");
		//description
		$box->angle('','','100','20','','steelblue','','',100,"Description","",'');
		$box->empty('','','810','0','','','','',100,"","",'');
		echo "<br><li>".$repair->msg_in."</li>";
		$box->empty('','','810','1','blue','','','',100,"","",'');
		
		//Materiel
		$box->angle('','','100','20','','steelblue','','',100,"Materiel","",'');
		$box->empty('','','810','0','','','','',100,"","",'');
		echo "<br><li>".$repair->hardware_in."</li>";
		$box->empty('','','810','1','blue','','','',100,"","",'');
		
		//feedback
		$box->angle('','','100','20','','steelblue','','',100,"Feedback","",'');
		$box->empty('','','810','0','','','','',100,"","",'');
		$feedback_tmp=db_read("select * from repair_feedback where id_repair = $repair->id order by dt_insert");
		echo"<br>";
		while($feedback = $feedback_tmp->fetch())
			{
			$nom_tech=db_single_read("select * from user where id=$feedback->id_tech");
			$nom=$nom_tech->nom.' '.substr($nom_tech->prenom, 0, 1)." ".date("j/m/y-G:i",$feedback->dt_insert);
			echo "<li><b>$nom : </b><i><br>".nl2br($feedback->remarque)."</i></li>";
			$box->empty('','','810','1','red','','','',100,"","",'');
			}
			
		//cloture
		if(($repair->status=='end')or($repair->status=='close'))
			{
			$box->angle('','','100','20','','steelblue','','',100,"Cloture","",'');
			$box->empty('','','810','0','','','','',100,"","",'');
			echo "<br><li>$repair->msg_out le ".date("d/m/y - H:i",$repair->dt_out)."</li>";
			$box->empty('','','810','1','blue','','','',100,"","",'');
			}
		
		//affichage de la saisie de feedback
		if(($repair->status=='open')or($repair->status=='wait'))
			{
			$box->empty_in('','','830','70','','','','',100,"","",'');
			
				$form->open("index.php?system=repair/feedback.iframe&sub_system=add_feedback&id_repair=$repair->id&no_interface","POST");
				
				$form->textarea("remarque",4,105,"");
				$form->send("Ajouter");
				$form->close();
			$box->angle_out(".");
			}
		
		};break;
######################################################################################################################
	case 'add_feedback':
		{
		$dt_insert=time();
		$remarque=$sugar->clean_string($_POST['remarque']);
		if($remarque!='')db_write("insert into repair_feedback(id_tech,id_repair,dt_insert,remarque)values($sugar->id,$id_repair,$dt_insert,'$remarque')");
		echo "<meta http-equiv='refresh' content='0; url=index.php?system=repair/feedback.iframe&sub_system=show_feedback&id_repair=$id_repair&no_interface'/>";
		};break;
######################################################################################################################
	}
?>