<?php
class _ticket
	{
	public $id=0;
	public $id_customer;
	public $msg_in;
	public $msg_out;
	public $price_work;
	public $hardware_in;
	public $tech_in;
	public $date_in;
	public $tech_out;
	public $date_out;
	public $status;
	
	public $id_shop;
	public $shop_id;
	public $shop_logo;
	public $shop_name;
	public $shop_adresse1;
	public $shop_adresse2;

	public $password;
	public $adresse;
	public $cp;
	public $ville;
	public $tva;


##########################################################################################################################
	public function load($id_ticket)
		{
		$tckt=db_single_read("select * from repair where id = $id_ticket");
		$shop=db_single_read("select * from shop where id = $tckt->id_shop");
		$this->id=$tckt->id;
		$this->id_customer=0;
		//$this->msg_in=$tckt->msg_in;
		//$this->msg_out=$tckt->msg_out;
		$this->price_work=$tckt->price_work;
		//$this->password=$tckt->password;
		//$this->hardware_in=$tckt->hardware_in;
		$this->dt_in=$tckt->dt_in;
		$this->tech_in=$tckt->tech_in;
		$this->dt_out=$tckt->dt_out;
		$this->tech_out=$tckt->tech_out;
		$this->status=$tckt->status;
		
		$this->shop_id=$shop->id;
		$this->shop_logo=$shop->img_logo;
		$this->shop_name=$shop->nom;
		$this->shop_adresse1=$shop->adresse_rue;
		$this->shop_adresse2=$shop->adresse_cp." ".$shop->adresse_ville;
		$this->shop_mail=$shop->mail;
		$this->shop_call1=$shop->call1;
		$this->shop_call2=$shop->call2;
		//$this->id_shop=$tckt->id_shop;
		
		
		$customer_chk=db_single_read("select count(*) as cnt from customer where id = $tckt->id_customer");
		
		if($customer_chk->cnt==1)
			{
			$customer=db_single_read("select * from customer where id = $tckt->id_customer");
			$this->id_customer=$customer->id;
			$this->prenom=$customer->prenom;
			$this->nom=$customer->nom;
			$this->adresse=$customer->adresse;
			$this->cp=$customer->cp;
			$this->ville=$customer->ville;
			$this->call1=$customer->call1;
			$this->call2=$customer->call2;
			$this->mail=$customer->mail;
			$this->tva=$customer->no_tva;
			}
		}
##########################################################################################################################
	public function delete()
		{
		db_write("2k1","update repair set status = 'deleted' where id = $this->id");
		}
##########################################################################################################################
	public function show_line($box,$sugar)
		{
		//recuperation des information du customer
		$customer_chk=db_single_read("select count(*) as cnt from customer where id = $this->id_customer");
		if($customer_chk->cnt==1)
			{
			$customer=db_single_read("select * from customer where id = $this->id_customer");
			$prenom=$customer->prenom;
			$nom=$customer->nom;
			$call1=$customer->call1;
			}
		else 
			{
			$prenom="Client";
			$nom="introuvable";
			$call1="0";
			}
		$color='#00ff80';
		if($this->status=='open')$color='orange';
		if($this->status=='wait')$color='yellow';
		if($this->status=='end')$color='lightblue';
		if($this->status=='hidden')$color='red';
		$cnt_description=db_single_read("select count(*) as cnt from feedback where sys='repair' and id_record ='$this->id' and type ='panne';");
		if($cnt_description->cnt>0)
			{
			$description=db_single_read("select * from feedback where sys='repair' and id_record ='$this->id' and type ='panne';");
			$msg_in=$description->msg;
			}
		else $msg_in="Pas de description de panne";
		
		
		//on choisis la couleur de la ligne en fonction du status du ticket repair
		$box->angle_in('','',1498,'22',$color,'white','','',100,"","index.php?system=repair&sub_system=edit_repair&id_repair=$this->id",'');
			$box->angle('','',50,'20','','black','','',100,"$this->id","",'');
			$box->angle('','',200,'20','','black','','',100,"</center></b>$prenom $nom","",'');
			$box->angle('','',150,'20','','black','','',100,$sugar->show_call_formated($call1)."","",'');
			$box->angle('','',590,'20','','black','','',100,"</center></b>$msg_in","",'');
			$box->angle('','',130,'20','','black','','',100,"</b>".date("d/m/y H:i", $this->dt_in),"",'');
			
			if($this->dt_out!=0)$box->angle('','',130,'20','','black','','',100,"</b>".date("d/m/y H:i", $this->dt_out),"",'');//si une date de sortie existe on l affiche sinon vide
			else $box->angle('','',130,'20','','black','','',300,"","",'');
			$box->angle('','',60,'20','','black','','',300,ucfirst($this->status),'',"");
			$box->angle('','',60,'20','','black','','',300,ucfirst($this->price_work)." &euro;",'',"");

			//$shop=db_single_read("select * from shop where id = $this->id_shop");
			$box->angle('','',126,'20',$color,'black','','',100,"</b>$this->shop_name",'',"");
		
		$box->angle_out('');
		}
##########################################################################################################################
	public function show_obj()
		{
		echo "<pre>";
		print_r($this);
		echo "</pre>";
		}
##########################################################################################################################
	public function add_feedback()
		{
		echo "<pre>";
		print_r($this);
		echo "</pre>";
		}
##########################################################################################################################
	}
?>