<?php
class _customer
	{
	public $id=0;
	public $prenom;
	public $nom;
	public $adresse;
	public $cp;
	public $ville;
	public $call1;
	public $call2;
	public $mail;
	public $tech_in;
	
##########################################################################################################################
	public function load($id_customer)
		{
		$cust=db_single_read("select * from customer where id = $id_customer");
        $this->id=$cust->id;
        $this->type=$cust->type;
        $this->prenom=$cust->prenom;
		$this->nom=$cust->nom;
		$this->adresse=$cust->adresse;
		$this->cp=$cust->cp;
		$this->ville=$cust->ville;
		$this->call1=$cust->call1;
		$this->call2=$cust->call2;
		$this->mail=$cust->mail;
		$this->tva=$cust->no_tva;
		$this->tech_in=$cust->tech_in;
		}
##########################################################################################################################
	public function show_list_from_rqt($rqt,$box,$sugar)
		{
		$cust_tmp=db_read($rqt);
		while($cust = $cust_tmp->fetch())
			{
            if($cust->type=='B2C')$color='lightgreen';
            if($cust->type=='B2B')$color='orange';
            
			//on choisis la couleur de la ligne en fonction du status du ticket repair
			$box->angle_in('','',1498,'22',$color,'white','','',100,"","index.php?system=customer&sub_system=load_customer&id_customer=$cust->id",'');
				$box->angle('','',50,'20','','black','','',100,"$cust->id</font>","",'');
				$box->angle('','',366,'20','','black','','',100,"</b></center>$cust->prenom $cust->nom","",'');
				$box->angle('','',150,'20','','black','','',100,"</b>".$sugar->show_call_formated($cust->call1),"",'');
				$box->angle('','',550,'20','','black','','',100,"</b></center>$cust->adresse $cust->cp $cust->ville","",'');
				$box->angle('','',250,'20','','black','','',100,"</b>".$sugar->show_name_user($cust->tech_in),"",'');
				$box->angle('','',130,'20','','black','','',100,"</b>".date("d/m/Y",$cust->dt_insert),"",'');
			$box->angle_out('');
			}
		}
##########################################################################################################################
	public function unload()
		{
		$this->id=0;
		echo "<meta http-equiv='refresh' content='0; url=index.php'/>";
		}
	}
?>