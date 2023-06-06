<?php
class _promo
	{
	public $id=0;
	public $id_promo=0;
	public $info;
	public $status;
	public $audience;
	/*
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
*/
##########################################################################################################################
	public function load($id,$sugar)
		{
		$cmd=db_single_read("select * from cmd where id = $id");
		$prm=db_single_read("select * from promo where id_odp = $id");
		$shop=db_single_read("select * from shop where id = $sugar->shop_id");

		$this->id=$id;
		$this->titre=$cmd->titre;
		$this->tech_in=$cmd->tech_in;
		$this->dt_in=$cmd->dt_in;
		$this->dt_out=$cmd->dt_out;
		$this->type=$cmd->type;
		$this->status=$prm->status;
		$this->audience=$prm->audience;

		//$this->id_promo=$prm->id;
		$this->info=$prm->info;
		//$this->titre=$prm->titre;
		$this->color=$prm->color;
		$this->text_libre=$prm->text_libre;
		$this->cpu=$prm->cpu;
		$this->mem=$prm->mem;
		$this->hdd=$prm->hdd;
		$this->gfx=$prm->gfx;
		$this->os=$prm->os;
		$this->pv_error=$prm->prix_ko;
		$this->pv_correct=$prm->prix_ok;
		
		$this->shop_id=$shop->id;
		$this->shop_logo=$shop->img_logo;
		$this->shop_name=$shop->nom;
		$this->shop_mini_name=$shop->mini_name;
		$this->shop_adresse1=$shop->adresse_rue;
		$this->shop_adresse2=$shop->adresse_cp." ".$shop->adresse_ville;
		$this->shop_mail=$shop->mail;
		$this->shop_call1=$shop->call1;
		$this->shop_call2=$shop->call2;
		}
##########################################################################################################################
	public function delete()
		{
		$rqt="";
		//supression des items 
		$rqt.="delete from cmd_item where id_cmd = $this->id;";
		//supression du record promo
		$rqt.="delete from promo where id_odp = $this->id;";
		//supression du record cmd
		$rqt.="delete from cmd where id = $this->id;";
		db_write($rqt);
		}
##########################################################################################################################
	public function clone_to_odp()
		{
		$id_odp=$_GET['id_odp'];
		
		if($customer->id!=0)
			{
			$offre=db_single_read("select * from cmd where id = $id_odp");
			db_write("insert into cmd (id_customer,type,titre,tech_in,dt_in,dt_out,status,id_shop)values('$customer->id','odp','$offre->titre','$sugar->id','".time()."','".(time()+604800)."','open','$sugar->shop_id');");
			$chk_offre=db_single_read("select * from cmd order by id desc limit 1");
			$rqt='';
			$offre_item_tmp=db_read("select * from cmd_item where id_cmd = $id_odp");
			while($offre_item = $offre_item_tmp->fetch())
				{
				$rqt.="insert into cmd_item (id_cmd,nom,fournisseur,url_item,qt,prix_achat,marge,prix_vente)values('$chk_offre->id','$offre_item->nom','$offre_item->fournisseur','$offre_item->url_item','$offre_item->qt','$offre_item->prix_achat','$offre_item->marge','$offre_item->prix_vente');";
				}
			db_write("$rqt");
			echo "<meta http-equiv='refresh' content='0; url=index.php?system=odp&sub_system=edit_odp&id_odp=$chk_offre->id'/>";
			}
		else $js->alert_redirect("Vous devez avoir un client actif pour dupliquer une offre.","index.php?system=customer",0);
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
		
			//on choisis la couleur de la ligne en fonction du status du ticket repair
		$box->angle_in('','',1498,'22',$color,'white','','',100,"","index.php?system=odp&sub_system=edit_odp&id_odp=$this->id",'');
			$box->angle('','',50,'20',$color,'black','','',100,"$this->id","",'');
			$box->angle('','',316,'20',$color,'black','','',100,"</b>".$this->prenom." ".$this->nom,"",'');
			$box->angle('','',130,'20',$color,'black','','',100,"</b>".$sugar->show_call_formated($this->call1),"",'');
			$box->angle('','',550,'20',$color,'black','','',400,"</b>$titre","",'');
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
public function show_line_pub_screen($box,$js,$sugar)
		{
		if($this->type='SCREEN')$box->angle_in('','',1152,'22','lightblue','','','',100,"","index.php?system=promo/promo.pub_screen&sub_system=edit_screen&id_prm=$this->id",'');
		else $box->angle_in('','',1152,'22','lightblue','','','',100,"","index.php?system=promo/promo.groupe&sub_system=edit_promo&id_prm=$this->id",'');
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
			if($this->shop_id==0)$box->angle('','','200','20','','black','','',100,"Groupe Novoffice","",'');
			else $box->angle('','','200','20','','black','','',100,"$this->shop_name","",'');
			//$promo=db_single_read("select * from promo where id_odp = $this->id");
		
		$box->angle_out('.');

		if($sugar->security_prm>1)
			{
			if($this->status=='on')$box->angle('','','100','22','#4CC417','black','','',100,"$this->status","index.php?system=promo/promo.groupe&sub_system=swap_status&id_prm=$this->id&no_interface",'');
			else $box->angle('','','100','22','red','black','','',100,"$this->status","index.php?system=promo/promo.groupe&sub_system=swap_status&id_prm=$this->id&no_interface",'');
			$box->angle('','','100','22','','black','','',100,"$this->audience %","",'');
			}
		else 
			{
			if($this->status=='on')$box->angle('','','100','22','#4CC417','black','','',100,"$this->status","",'');
			else $box->angle('','','100','22','red','black','','',100,"$this->status","",'');
			$box->angle('','','100','22','','black','','',100,"$this->audience %","",'');
			}
		}
##########################################################################################################################
	public function show_line_promo_groupe($box,$js,$sugar)
		{
		$box->angle_in('','',1152,'22','lightblue','','','',100,"","index.php?system=promo/promo.groupe&sub_system=edit_promo&id_prm=$this->id",'');
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
			if($this->shop_id==0)$box->angle('','','200','20','','black','','',100,"Groupe Novoffice","",'');
			else $box->angle('','','200','20','','black','','',100,"$this->shop_name","",'');
			//$promo=db_single_read("select * from promo where id_odp = $this->id");
		
		$box->angle_out('.');

		if($sugar->security_prm>1)
			{
			if($this->status=='on')$box->angle('','','100','22','#4CC417','black','','',100,"$this->status","index.php?system=promo/promo.groupe&sub_system=swap_status&id_prm=$this->id&no_interface",'');
			else $box->angle('','','100','22','red','black','','',100,"$this->status","index.php?system=promo/promo.groupe&sub_system=swap_status&id_prm=$this->id&no_interface",'');
			$box->angle('','','100','22','','black','','',100,"$this->audience %","",'');
			}
		else 
			{
			if($this->status=='on')$box->angle('','','100','22','#4CC417','black','','',100,"$this->status","",'');
			else $box->angle('','','100','22','red','black','','',100,"$this->status","",'');
			$box->angle('','','100','22','','black','','',100,"$this->audience %","",'');
			}	
		
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
	public function show_button($box,$sugar)
		{
		//imprimer flyer
		echo "<a href='index.php?system=promo/promo.groupe&sub_system=print_promo&id_prm=$this->id&no_interface' target = _blank>";
		$box->angle('','',200,22,'lightgreen','black','','',100,"Print Flyer",'','');//imprimer reception
		echo "</a>";
		$box->empty('','',200,10,'','','','',100,"","",'');
		//imprimer promo item
		echo "<a href='index.php?system=promo/promo.groupe&sub_system=print_promo_item&id_prm=$this->id&no_interface' target = _blank>";
		$box->angle('','',200,22,'lightgreen','black','','',100,"Print item","",'');//imprimer reception
		echo "</a>";
		$box->empty('','',200,10,'','','','',100,"","",'');
		//dupliquer promo sur une odp
		$box->angle('','',200,22,'lightgreen','black','','',100,"Clone sur ODP","index.php?system=promo/promo.groupe&sub_system=duplicate_promo_to_odp&id_prm=$this->id&no_interface",'');//imprimer reception
		$box->empty('','',200,10,'','','','',100,"","",'');
		//effacer promo
		if($sugar->security_prm>1)
			{
			$box->angle('','',200,22,'#CC5BF4','black','','',100,"Detruire promo","index.php?system=promo/promo.groupe&sub_system=del_prm_grp&id_prm=$this->id&no_interface",'');
			$box->angle('','',200,10,'','','','',100,"","",'');
			}
		}
##########################################################################################################################
	}
?>
