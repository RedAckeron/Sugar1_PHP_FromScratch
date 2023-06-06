<?php
class _slideshow
	{
	public $id_odp=0;
	public $loop_odp=0;
	public $odp_status;
	public $id_prm=0;
	public $prm_status;
	public $color;
	public $debug=0;
	public $timer=15;
	public $coef=1;
	public $shop_id=0;
	public $shop_logo;
	public $shop_adresse;
	public $cpu="";
	public $mem="";
	public $hdd="";
	public $gfx="";
	public $os="";
	

	
######################################################################################################################
public function load($sugar)
	{
	//si un odp est selectionner on l affiche sinon on en rand 1
	if($this->loop_odp==1)
		{
		$promo=db_single_read("SELECT * FROM promo where id_odp=$this->id_odp;");
		}
	else 
		{
		$promo=db_single_read("SELECT * FROM promo where status = 'on' and ((id_shop = 0) or (id_shop = $this->shop_id)) order by RAND() LIMIT 1");
		}
	
	$odp=db_single_read("SELECT * FROM cmd where id = $promo->id_odp;");
	$shop=db_single_read("SELECT * FROM shop where id=$this->shop_id");
	
	$this->odp_status=$odp->status;
	$this->shop_logo=$shop->img_logo;
	$this->shop_adresse="$shop->nom<br></b>$shop->adresse_rue<br>$shop->adresse_cp $shop->adresse_ville<br>$shop->mail<br>".$sugar->show_call_formated($shop->call1);

	$this->id_prm=$promo->id;
	$this->prm_status=$promo->status;
	$this->audience=$promo->audience;
	$this->titre=$promo->titre;
	$this->color=$promo->color;
	$this->cpu=$promo->cpu;
	$this->mem=$promo->mem;
	$this->hdd=$promo->hdd;
	$this->gfx=$promo->gfx;
	$this->os=$promo->os;
    $this->prix_ok=$promo->prix_ok;
    $this->prix_ko=$promo->prix_ko;
	$this->text_libre=$promo->text_libre;
	
	
	//$box->empty("$posx","$posy","$width","$height","$color",'',"",'',100,"<font size=$titre_size>$fiche</font>","",'');


	
	$this->prm_status=$promo->status;
	
	$this->id_odp=$promo->id_odp;
	}
######################################################################################################################
public function select_prm()
	{
	
	}
}

?>