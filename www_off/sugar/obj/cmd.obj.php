<?php
class _cmd
	{
	public $id=0;
	public $id_customer;
	public $type;
	public $titre;
	public $prenom;
	public $nom;
	public $call1;
	public $call2;
	public $mail;
    public $dt_in;
    public $tech_in;
	public $dt_out;
	public $status;
	
	public $img0_a4='no_img.gif';
	public $img1_a4='no_img.gif';
	public $img2_a4='no_img.gif';
	public $img3_a4='no_img.gif';
	public $img4_a4='no_img.gif';
	public $img5_a4='no_img.gif';
	public $img6_a4='no_img.gif';
	public $bground_a4='dotted.gif';

	public $img0_fhd='no_img.gif';
	public $img1_fhd='no_img.gif';
	public $img2_fhd='no_img.gif';
	public $img3_fhd='no_img.gif';
	public $img4_fhd='no_img.gif';
	public $img5_fhd='no_img.gif';
	public $img6_fhd='no_img.gif';
	public $bground_fhd='dotted.gif';
		
	public $shop_id;
	public $shop_logo;
	public $shop_name;
	public $shop_adresse1;
	public $shop_adresse2;
	
##########################################################################################################################
	public function load($id_cmd)
		{
		$commande=db_single_read("select * from cmd where id = $id_cmd");
		$this->id=$commande->id;
		$this->id_customer=0;
		$this->type=$commande->type;
		$this->titre=$commande->titre;
        $this->dt_in=$commande->dt_in;
        $this->tech_in=$commande->tech_in;

		$this->dt_out=$commande->dt_out;
		$this->status=$commande->status;

		$shop=db_single_read("select * from shop where id = $commande->id_shop");
		$this->shop_id=$shop->id;
		$this->shop_logo=$shop->img_logo;
		$this->shop_name=$shop->nom;
		$this->shop_adresse1=$shop->adresse_rue;
		$this->shop_adresse2=$shop->adresse_cp." ".$shop->adresse_ville;
		$this->shop_mail=$shop->mail;
		$this->shop_call1=$shop->call1;
		$this->shop_call2=$shop->call2;
		
		if($this->type=='prm')
			{
			$promo=db_single_read("select * from promo where id_odp=$this->id");
			$this->img0_a4=$promo->img0_a4;
			$this->img1_a4=$promo->img1_a4;
			$this->img2_a4=$promo->img2_a4;
			$this->img3_a4=$promo->img3_a4;
			$this->img4_a4=$promo->img4_a4;
			$this->img5_a4=$promo->img5_a4;
			$this->img6_a4=$promo->img6_a4;
			$this->bground_a4=$promo->bground_a4;
			$this->img0_fhd=$promo->img0_fhd;
			$this->img1_fhd=$promo->img1_fhd;
			$this->img2_fhd=$promo->img2_fhd;
			$this->img3_fhd=$promo->img3_fhd;
			$this->img4_fhd=$promo->img4_fhd;
			$this->img5_fhd=$promo->img5_fhd;
			$this->img6_fhd=$promo->img6_fhd;
			$this->bground_fhd=$promo->bground_fhd;
			}

		$customer_chk=db_single_read("select count(*) as cnt from customer where id = $commande->id_customer");
		if($customer_chk->cnt==1)
			{
			$customer=db_single_read("select * from customer where id = $commande->id_customer");
			$this->id_customer=$customer->id;
			$this->prenom=$customer->prenom;
			$this->nom=$customer->nom;
			$this->adresse=$customer->adresse;
			$this->adresse.="<br>".$customer->cp." ".$customer->ville;


			$this->call1=$customer->call1;
			$this->call2=$customer->call2;
			$this->mail=$customer->mail;
			}
		}
##########################################################################################################################
	public function delete()
		{
		db_write("update repair set status = 'deleted' where id = $this->id");
		}
##########################################################################################################################
	public function show_line($box,$sugar)
		{
		$color='#00ff80';
		if($this->status=='open')$color='orange';
		if($this->status=='end')$color='lightblue';
		if($this->status=='wait')$color='yellow';
		if($this->status=='hidden')$color='red';

			
		//on choisis la couleur de la ligne en fonction du status du ticket repair
		$box->angle_in('','',1498,'22',$color,'white','','',100,"","index.php?system=cmd&sub_system=edit_cmd&id_cmd=$this->id",'');
			$box->angle('','',50,'20','','black','','',100,"$this->id","",'');
			$box->angle('','',310,'20','','black','','',100,"</b></center>$this->prenom $this->nom","",'');
			$box->angle('','',120,'20','','black','','',100,"</b>".$sugar->show_call_formated($this->call1),"",'');
			$box->angle('','',568,'20',$color,'black','','',400,"</b>$this->titre","",'');
			$nb_item=db_single_read("select count(*) as cnt from cmd_item where id_cmd = $this->id");
			$box->angle('','',50,'20',$color,'black','','',100,"$nb_item->cnt","",'');

			$grand_total=0;
			$cmd_item_tmp=db_read("select * from cmd_item where id_cmd = $this->id");
			while($cmd_item = $cmd_item_tmp->fetch())
				{
				$prix_vente=round(($cmd_item->prix_achat*$cmd_item->marge),2);
				$prix_ttl=$prix_vente*$cmd_item->qt;
				$grand_total+=$prix_ttl;
				}
			$box->angle('','',98,'20',$color,'black','','',100,"$grand_total&euro;","",'');
			
			$box->angle('','',120,'20',$color,'black','','',300,"</b>".date("d/m/y H:i", $this->dt_in),"",'');
			if($this->dt_out!=0)$box->angle('','',120,'20',$color,'black','','',300,"</b>".date("d/m/y H:i", $this->dt_out),"",'');//si une date de sortie existe on l affiche sinon vide
			else $box->angle('','',120,'20',$color,'black','','',300,"","",'');
			$box->angle('','',60,'20',$color,'black','','',300,ucfirst($this->status),'',"");
			
			//$shop=db_single_read("select * from shop where id = '$this->id_shop'");
			//$box->angle('','','100','20',$color,'black','red','',100,"</b>".substr($this->shop_name,0,11),"",'');
			
		$box->angle_out('');
		}
##########################################################################################################################
	public function show_item_in_line($box,$system)
		{
		$grand_total_pa=0;
		$grand_total_pv=0;
		$box->empty_in('','',1398,22,'','','','',100,"","",'');
			$box->angle('','',688,20,'lightgreen','green','','',100,"Item","",'');
			$box->angle('','',120,20,'lightgreen','green','','',100,"Fournisseur","",'');
			$box->angle('','',50,20,'lightgreen','green','','',100,"Url","",'');
			$box->angle('','',100,20,'lightgreen','green','','',100,"Prix achat","",'');
			$box->angle('','',100,20,'lightgreen','green','','',100,"Marge","",'');
			$box->angle('','',100,20,'lightgreen','green','','',100,"Prix vente","",'');
			$box->angle('','',100,20,'lightgreen','green','','',100,"Qt","",'');
			$box->angle('','',100,20,'lightgreen','green','','',100,"Prix total","",'');
			$box->angle('','',20,20,'lightgreen','green','img/edit.gif','',100,"","",'');
			$box->angle('','',20,20,'lightgreen','green','img/delete.gif','',100,"","",'');
		$box->empty_out('');
		
		$cmd_item_tmp=db_read("select * from cmd_item where id_cmd = $this->id");
		while($cmd_item = $cmd_item_tmp->fetch())
			{
			$box->empty_in('','',1398,22,'','','','',100,"","",'');
				$box->angle('','',688,20,'','green','','',100,"</b>$cmd_item->nom","",'');//item
				$box->angle('','',120,20,'','green','','',100,"</b>$cmd_item->fournisseur","",'');//fournisseur
				$box->angle_in('','',50,20,'','green',"","",100,"","","");//url_item
				echo "<a href='$cmd_item->url_item' target=_blank><img src='img/link.gif'></img></a>";
				$box->angle_out('');
				$box->angle('','',100,20,'','green','','',100,"$cmd_item->prix_achat &euro;","",'');
				$box->angle('','',100,20,'','green','','',100,round((($cmd_item->marge*100)-100),3)."%","",'');
				$box->angle('','',100,20,'','green','','',100,"$cmd_item->prix_vente &euro;","index.php?system=$system&sub_system=edit_pv&id_item=$cmd_item->id&id_cmd=$cmd_item->id_cmd&no_interface",'');
				$box->angle('','',100,20,'','green','','',100,"$cmd_item->qt","",'');
				
				$prix_ttl_pa=$cmd_item->prix_achat*$cmd_item->qt;
				$prix_ttl_pv=$cmd_item->prix_vente*$cmd_item->qt;
				$box->angle('','',100,20,'','green','','',100,"$prix_ttl_pv &euro;","",'');
				$box->angle('','',20,20,'','green','img/edit.gif','',100,"","index.php?system=$system&sub_system=edit_item&id_item=$cmd_item->id",'');
				$box->angle('','',20,20,'','green','img/delete.gif','',100,"","index.php?system=$system&sub_system=check_delete_item&id_item=$cmd_item->id&id_cmd=$cmd_item->id_cmd&no_interface",'');
			$box->empty_out('');
			$grand_total_pa+=$prix_ttl_pa;
			$grand_total_pv+=$prix_ttl_pv;
			}
		
		$box->angle_in('','',1398,22,'','','','',100,"","",'');
			$box->angle('','',1106,20,'','','','',100,"","",'');
			$box->angle('','',150,20,'','','','',150,"Total Prix achat: ","",'');
			$box->angle('','',100,20,'','green','','',100,"$grand_total_pa &euro;","",'');
		$box->angle_out('');
		$box->angle_in('','',1398,22,'','','','',100,"","",'');
			$box->angle('','',1106,20,'','','','',100,"","",'');
			$box->angle('','',150,20,'','','','',100,"Total Prix vente: ","",'');
			$box->angle('','',100,20,'','red','','',100,"$grand_total_pv &euro;","",'');
		$box->angle_out('');
		}
##########################################################################################################################
	public function show_line_promo($box,$js,$sugar)
		{
		$url="";
		if($this->status=='SCREEN')
			{
			$color="#b68bfc";
			if($sugar->security_prm>1)$url="index.php?system=prm&sub_system=edit_screen&id_prm=$this->id";
			}
		else 
			{
			if ($this->shop_id==0)
				{
				$color="lightblue";
				$url="index.php?system=prm&sub_system=edit_prm&id_prm=$this->id";
				}
			else 
				{
				$color="lightgreen";
				$url="index.php?system=prm&sub_system=edit_prm&id_prm=$this->id";
				}
			}
		
		
		$box->angle_in('','',1152,'22',$color,'','','',100,"","$url",'');
			$box->angle('','',50,'20','','black','','',100,"$this->id","",'');
			$box->angle('','',150,'20','','black','','',400,"</b>$this->status","",'');
			
			$box->angle('','',550,'20','','black','','',400,"</b>$this->titre","",'');
			$nb_item=db_single_read("select count(*) as cnt from cmd_item where id_cmd = $this->id");
			$box->angle('','',100,'20','','black','','',100,"$nb_item->cnt","",'');

			$grand_total_vente=0;
			$cmd_item_tmp=db_read("select * from cmd_item where id_cmd = $this->id");
			while($cmd_item = $cmd_item_tmp->fetch())
				{
				$prix_ttl=$cmd_item->prix_vente*$cmd_item->qt;
				$grand_total_vente+=$prix_ttl;
				}
			$box->angle('','',100,'20','','black','','',100,round ($grand_total_vente,2)."&euro;","",'');
			
			//affichage du shop
			$box->angle('','','200','20','','black','','',100,"$this->shop_name","",'');
				
				
		$box->angle_out('.');
		}

##########################################################################################################################
	public function show_prm_button($box,$js,$sugar)
		{
		//imprimer flyer
		echo "<a href='index.php?system=prm&sub_system=print_promo&id_prm=$this->id&no_interface' target = _blank>";
		$box->angle('','',250,25,'lightgreen','black','','',100,"Imprimer Promo Flyer",'','');//imprimer reception
		echo "</a>";
		//Boite vide
		$box->angle('','',250,25,'','','','',100,"","",'');
		//imprimer promo en offre de prix
		echo "<a href='index.php?system=odp&sub_system=print_odp_customer&id_odp=$this->id&no_interface' target = _blank>";
		$box->angle('','',250,25,'lightgreen','black','','',100,"Imprimer promo item","",'');//imprimer reception
		echo "</a>";
		//Boite vide
		$box->angle('','',250,25,'','','','',100,"","",'');
		//dupliquer promo sur une odp
		$box->angle('','',250,25,'lightgreen','black','','',100,"Dupliquer promo sur offre de prix","index.php?system=odp&sub_system=duplicate_odp&id_odp=$this->id&no_interface",'');//imprimer reception
		//Boite vide
		$box->angle('','',250,25,'','','','',100,"","",'');
		//effacer promo
		$box->angle('','',250,25,'lightgreen','black','','',100,"Effacer promo","index.php?system=odp&sub_system=del_odp&id_odp=$this->id",'');//imprimer reception
		}
	}
?>
