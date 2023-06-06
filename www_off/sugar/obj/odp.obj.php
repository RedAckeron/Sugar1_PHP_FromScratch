<?php
class _odp
	{
	public $id=0;
	public $id_customer;
	public $cmd_description;
	public $prenom;
	public $nom;
	public $call1;
	public $call2;
	public $mail;
	public $dt_in;
	public $dt_out;
	public $tech_in;
	public $shop_id;
	public $shop_logo;
	public $shop_name;
	public $shop_adresse1;
	public $shop_adresse2;
	
	public $id_shop;
	public $status;
	public $type;

##########################################################################################################################
	public function load($id_cmd,$sugar)
		{
		$commande=db_single_read("select * from cmd where id = $id_cmd");
		$customer_chk=db_single_read("select count(*) as cnt from customer where id = $commande->id_customer");
		
		if($commande->id_shop==0)$id_shop=$sugar->shop_id;
		else $id_shop =$commande->id_shop;
		
		$shop=db_single_read("select * from shop where id = $id_shop");
		$this->id=$commande->id;
		$this->id_customer=0;
		$this->titre=$commande->titre;
		$this->tech_in=$commande->tech_in;
		$this->dt_in=$commande->dt_in;
		$this->dt_out=$commande->dt_out;
		$this->status=$commande->status;
		$this->type=$commande->type;

		$this->shop_id=$shop->id;
		$this->shop_logo=$shop->img_logo;
		$this->shop_name=$shop->nom;
		$this->shop_mini_name=$shop->mini_name;

		$this->shop_adresse1=$shop->adresse_rue;
		$this->shop_adresse2=$shop->adresse_cp." ".$shop->adresse_ville;
		$this->shop_mail=$shop->mail;
		$this->shop_call1=$shop->call1;
		$this->shop_call2=$shop->call2;
		
		$this->id_shop=$commande->id_shop;
		//$this->shop_logo=$shop->img_logo;
		
		if($customer_chk->cnt==1)
			{
			$customer=db_single_read("select * from customer where id = $commande->id_customer");
			$this->id_customer=$customer->id;
			$this->prenom=$customer->prenom;
			$this->nom=$customer->nom;
			$this->call1=$customer->call1;
			$this->call2=$customer->call2;
			$this->mail=$customer->mail;
			}
		}
##########################################################################################################################
	public function delete()
		{
		db_write("update cmd set status = 'deleted' where id = $this->id");
		}
##########################################################################################################################
	public function transfert_to_cmd()
		{
		db_write("update cmd set status='open',type='cmd',dt_out='0' where id = $this->id");
		}
##########################################################################################################################
	public function show_line($box,$js,$sugar)
		{
		$color='#00ff99';
		if($this->dt_out<time())$color='orange';
		$titre=$this->titre;
		if($this->status=='admin')
			{
			$color='#CC5BF4';
			if($this->id_shop!=0)$titre="<b><font color=white>[<i> ".$sugar->show_name_user($this->tech_in)."</i> ] $this->titre</font></b>";
			else $titre="<font color=white>".$this->titre."</font>";
			}
		if($this->status=='hidden')$color="red";
		
			//on choisis la couleur de la ligne en fonction du status du ticket repair
		$box->angle_in('','',1498,'22',$color,'white','','',100,"","index.php?system=odp&sub_system=edit_odp&id_odp=$this->id",'');
			$box->angle('','',50,'20',$color,'black','','',100,"$this->id","",'');
			$box->angle('','',316,'20',$color,'black','','',100,"</b>".$this->prenom." ".$this->nom,"",'');
			$box->angle('','',130,'20',$color,'black','','',100,"</b>".$sugar->show_call_formated($this->call1),"",'');
			if($this->status=='hidden')$box->angle('','',550,'20',$color,'black','','',400,"</b><i>[Attente supression]</i>$titre","",'');
			else $box->angle('','',550,'20',$color,'black','','',400,"</b>$titre","",'');
			$nb_item=db_single_read("select count(*) as cnt from cmd_item where id_cmd = $this->id");
			$box->angle('','',50,'20',$color,'black','','',100,"$nb_item->cnt","",'');

			$grand_total_vente=0;
			$cmd_item_tmp=db_read("select * from cmd_item where id_cmd = $this->id");
			while($cmd_item = $cmd_item_tmp->fetch())
				{
				$prix_ttl=$cmd_item->prix_vente*$cmd_item->qt;
				$grand_total_vente+=$prix_ttl;
				}
			$box->angle('','',100,'20',$color,'black','','',100,round ($grand_total_vente,2)."&euro;","",'');
			
			$box->angle('','',120,'20',$color,'black','','',100,"</b>".date("d/m/y H:i", $this->dt_in),"",'');
			if($this->dt_out!=0)$box->angle('','',120,'20',$color,'black','','',300,"</b>".date("d/m/y H:i", $this->dt_out),"",'');//si une date de sortie existe on l affiche sinon vide
			else $box->angle('','',120,'20',$color,'black','','',100,"","",'');
			//affichage du delai du reminder
			$delay_tmp=time()-$this->dt_out;
			$delay=0;
			$d=0;
			$sign="+";
			if ($delay_tmp<0)
				{
				$sign="-";
				$delay-=$delay_tmp;//si delay est negatif on l inverse dans une nouvelle variable 
				}
			else $delay=$delay_tmp;
		
			while($delay>=86400)
				{
				$d+=1;
				$delay-=86400;
				}
			$box->angle('','','60','20',$color,'black','','',100,"$sign $d","",'');
			//affichage du shop
			//$box->angle('','','116','20',$color,'black','','',100,"$this->shop_mini_name","",'');
			
		$box->angle_out('.');
		
		}
##########################################################################################################################
	public function show_line_promo($box,$js,$sugar)
		{
		$color='#00ff99';
		if($this->dt_out<time())$color='orange';
		if($this->id_customer<11)$color="#ff80ff";// si le client est dans les 1O premier et qu 
		//on choisis la couleur de la ligne en fonction du status du ticket repair
		$box->angle_in('','',1498,'22','','','','',100,"","index.php?system=odp&sub_system=edit_odp&id_odp=$this->id",'');
			$box->angle('','',50,'20',$color,'black','','',100,"$this->id","",'');
			$box->angle('','',550,'20',$color,'black','','',400,"</b>$this->titre","",'');
			$nb_item=db_single_read("select count(*) as cnt from cmd_item where id_cmd = $this->id");
			$box->angle('','',100,'20',$color,'black','','',100,"$nb_item->cnt","",'');

			$grand_total_vente=0;
			$cmd_item_tmp=db_read("select * from cmd_item where id_cmd = $this->id");
			while($cmd_item = $cmd_item_tmp->fetch())
				{
				$prix_ttl=$cmd_item->prix_vente*$cmd_item->qt;
				$grand_total_vente+=$prix_ttl;
				}
			$box->angle('','',100,'20',$color,'black','','',100,round ($grand_total_vente,2)."&euro;","",'');
			
			if($this->id_customer>10)
				{
				$box->angle('','',120,'20',$color,'black','','',100,"</b>".date("d/m/y H:i", $this->dt_in),"",'');
				if($this->dt_out!=0)$box->angle('','',120,'20',$color,'black','','',300,"</b>".date("d/m/y H:i", $this->dt_out),"",'');//si une date de sortie existe on l affiche sinon vide
				else $box->angle('','',120,'20',$color,'black','','',100,"","",'');
				//affichage du delai du reminder
				$delay_tmp=time()-$this->dt_out;
				$delay=0;
				$d=0;
				$sign="+";
				if ($delay_tmp<0)
					{
					$sign="-";
					$delay-=$delay_tmp;//si delay est negatif on l inverse dans une nouvelle variable 
					}
				else $delay=$delay_tmp;
		
				while($delay>=86400)
					{
					$d+=1;
					$delay-=86400;
					}
		
				$box->angle('','','60','20',$color,'black','','',100,"$sign $d","",'');

				//affichage du shop
				$box->angle('','','116','20',$color,'black','','',100,"$this->shop_name","",'');
				}
				
		$box->angle_out('');
		}
##########################################################################################################################
	public function show_item_in_line($box)
		{
		$grand_total_vente=0;
		$grand_total_achat=0;

		$box->angle_in('','',1198,22,'','','','',100,"","",'');
			$box->angle('','',396,20,'lightgreen','green','','',100,"Item","",'');
			$box->angle('','',150,20,'lightgreen','green','','',100,"Fournisseur","",'');
			$box->angle('','',50,20,'lightgreen','green','','',100,"Url","",'');
			$box->angle('','',60,20,'lightgreen','green','','',100,"","",'');
			$box->angle('','',100,20,'lightgreen','green','','',100,"Prix achat","",'');
			$box->angle('','',100,20,'lightgreen','green','','',100,"Marge","",'');
			$box->angle('','',100,20,'lightgreen','green','','',100,"Prix vente","",'');
			$box->angle('','',100,20,'lightgreen','green','','',100,"Qt","",'');
			$box->angle('','',100,20,'lightgreen','green','','',100,"Prix total","",'');
			$box->angle('','',20,20,'lightgreen','green','img/edit.gif','',100,"","",'');
			$box->angle('','',20,20,'lightgreen','green','img/delete.gif','',100,"","",'');
		$box->angle_out('');
		
		$cmd_item_tmp=db_read("select * from cmd_item where id_cmd = $this->id");
		while($cmd_item = $cmd_item_tmp->fetch())
			{
			$box->angle_in('','',1198,22,'','','','',100,"","",'');
				$box->angle('','',396,20,'','green','','',100,"$cmd_item->nom","",'');//item
				$box->angle('','',150,20,'','green','','',100,"$cmd_item->fournisseur","",'');//fournisseur
				$box->angle_in('','',50,20,'','green',"","",100,"","","");//url_item
				echo "<a href='$cmd_item->url_item' target=_blank><img src='img/link.gif'></img></a>";
				$box->angle_out('');
				$box->angle('','',60,20,'','green',"","",100,"","","");//blank
				$box->angle('','',100,20,'','green','','',100,"$cmd_item->prix_achat &euro;","",'');
				$box->angle('','',100,20,'','green','','',100,"$cmd_item->marge%","",'');
				$prix_achat=round(($cmd_item->prix_achat),2);
				$prix_vente=round(($cmd_item->prix_vente),2);
				//$prix_vente=round(($cmd_item->prix_achat*$cmd_item->marge),2);
				$box->angle('','',100,20,'','green','','',100,"$prix_vente &euro;","index.php?system=odp&sub_system=edit_pv&id_item=$cmd_item->id&id_odp=$cmd_item->id_cmd&no_interface",'');
				$box->angle('','',100,20,'','green','','',100,"$cmd_item->qt","",'');
				$prix_achat_ttl=$prix_achat*$cmd_item->qt;
				$prix_ttl=$prix_vente*$cmd_item->qt;
				$box->angle('','',100,20,'','green','','',100,"$prix_ttl &euro;","",'');
				$box->angle('','',20,20,'','green','img/edit.gif','',100,"","index.php?system=odp&sub_system=edit_item&id_item=$cmd_item->id",'');
				$box->angle('','',20,20,'','green','img/delete.gif','',100,"","index.php?system=odp&sub_system=check_delete_item&id_item=$cmd_item->id&id_odp=$cmd_item->id_cmd",'');
			$box->angle_out('');
			$grand_total_vente+=$prix_ttl;
			$grand_total_achat+=$prix_achat_ttl;
			}
		
		$box->angle_in('','',1198,22,'','','','',100,"","",'');
			$box->angle('','',556,20,'','','','',100,"","",'');
			$box->angle('','',100,20,'','','','',100,"Total : ","",'');
			$box->angle('','',100,20,'','red','','',100,"$grand_total_achat &euro;","",'');
			$box->angle('','',300,20,'','','','',100,"","",'');
			$box->angle('','',100,20,'','red','','',100,"$grand_total_vente &euro;","",'');

		$box->angle_out('');
		}
##########################################################################################################################
	public function show_button($box,$sugar,$server)
		{
		//passer l odp en odpg
		if(($this->status=='open')and($this->type!='prm')and($sugar->security_odp>1))
			{
			$box->angle('','',200,22,$server->color_admin,'black','','',100,"Transfert en ODPG","index.php?system=odp&sub_system=transfert_to_odpg&id_odp=$this->id&no_interface",'');//imprimer reception
			$box->angle('','',200,10,'','','','',100,"",'','');
			}
		// passer odpg en odp
		if(($this->status=='admin')and($this->type!='prm')and($this->tech_in!=0))
			{
			$box->angle('','',200,22,'lightgreen','black','','',100,"Passer en ODP","index.php?system=odp&sub_system=transfert_to_odp&id_odp=$this->id&no_interface",'');//imprimer reception
			$box->angle('','',200,10,'','','','',100,"",'','');
			}
		//si ODP admin proposer prendre en charge 
		/*
		if(($this->status=='admin')and($this->type!='prm'))
			{
			$box->angle('','',200,22,'lightgreen','black','','',100,"Prendre en charge","index.php?system=odp&sub_system=give_odp_to_tech&id_odp=$this->id",'');//imprimer reception
			$box->angle('','',200,10,'','','','',100,"",'','');
			}
		*/
		if(($this->id_shop==0)and($this->type!='prm'))
			{
			$box->angle('','',200,22,'lightgreen','black','','',100,"Prendre en charge","index.php?system=odp&sub_system=give_odp_to_tech&id_odp=$this->id&no_interface",'');//imprimer reception
			$box->angle('','',200,10,'','','','',100,"",'','');
			}
		//transfert en commande 
		//imprimer offre de prix
		//imprimer offre de prix avec pa + fb
		//Dupliquer Offre sur autre client
		//Effacer Offre de prix
		if(($this->status=='open')and($this->type!='prm'))
			{
			$box->angle('','',200,22,'lightgreen','black','','',100,"Transfert en commande","index.php?system=odp&sub_system=transfert_to_cmd&id_odp=$this->id&no_interface",'');//imprimer reception
			$box->angle('','',200,10,'','','','',100,"",'','');
			
			echo "<a href='index.php?system=odp&sub_system=print_odp_customer&id_odp=$this->id&no_interface' target = _blank>";
			$box->angle('','',200,22,'lightgreen','black','','',100,"Imprimer Offre de prix","",'');//imprimer reception
			echo "</a>";
			$box->angle('','',200,10,'','','','',100,"",'','');//imprimer reception
			
			echo "<a href='index.php?system=odp&sub_system=print_odp_internal&id_odp=$this->id&no_interface' target = _blank>";
			$box->angle('','',200,22,'lightgreen','black','','',100,"Imprimer Offre interne","",'');//imprimer reception
			echo "</a>";
			$box->angle('','',200,10,'','','','',100,"",'','');//imprimer reception
			
			$box->angle('','',200,22,'lightgreen','black','','',100,"Dupliquer sur client actif","index.php?system=odp&sub_system=duplicate_odp&id_odp=$this->id&no_interface",'');//imprimer reception
			$box->angle('','',200,10,'','','','',100,"",'','');//imprimer reception
			
			$box->angle('','',200,22,'lightgreen','black','','',100,"Effacer Offre de prix","index.php?system=odp&sub_system=del_odp&id_odp=$this->id",'');//imprimer reception
			$box->angle('','',200,10,'','','','',100,"",'','');//imprimer reception
			}
		
		//Effacer Offre de prix
		if(($this->status=='hidden')and($sugar->security_odp>1))
			{
			$box->angle('','',200,22,'purple','black','','',100,"Detruire Offre de prix","index.php?system=odp&sub_system=destroy_odp&id_odp=$this->id&no_interface",'');//imprimer reception
			$box->angle('','',200,10,'','','','',100,"",'','');//imprimer reception
			$box->angle('','',200,22,'purple','black','','',100,"Retablire Offre de prix","index.php?system=odp&sub_system=open_odp&id_odp=$this->id&no_interface",'');//imprimer reception
			$box->angle('','',200,10,'','','','',100,"",'','');//imprimer reception
			}
		}
##########################################################################################################################
	}
?>
