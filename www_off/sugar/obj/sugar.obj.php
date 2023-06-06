<?php
class _sugar
	{
	public $id=0;
	public $client;
	public $ip;
	public $width;
	public $height;
	public $login='Anonymous';
	public $password;
	public $nom;
	public $prenom;
	public $last_log=0;
	public $email;
	public $status='on';
	public $dt_inscript=0;
	public $avatar='anon.gif';
    public $label="main";
    public $call_song='dingdong.mp3';//VAR_USER
    public $background_color='grey';//VAR_USER
	public $shop_id=0;
	public $shop_name;
	public $shop_logo;
	public $shop_adresse1;
	public $shop_adresse2;
	public $shop_mail;
	public $shop_call;
	public $security_main;
	public $security_customer;
	public $security_call;
	public $security_repair;
	public $security_prm;
	public $security_odp;
	public $security_cmd;
	public $security_stats;
	public $security_param;
	public $security_admin;
	public $security_help;
#####################################################################################################################################################
public function update_var_user($label,$value)
    {
    $chk_var=db_single_read("select count(*) as cnt from var_user where id_user = $this->id and label = '$label'");
    if($chk_var->cnt==0)$rqt="insert into var_user(id_user,label,value)values('$this->id','$label','$value')";
    else $rqt="update var_user set value='$value' where id_user=$this->id and label='$label'";
    db_write($rqt);
    }
#####################################################################################################################################################
public function load($id)
	{
	$uzr=db_single_read("select * from user where id = $id");
	$shp=db_single_read("select * from shop where id = $uzr->shop");
	$this->id = $uzr->id;
	$this->login = $uzr->login;
	$this->email = $uzr->email;
	$this->nom = $uzr->nom;
	$this->prenom = $uzr->prenom;
	$this->status = $uzr->status;
	$this->shop_id = $shp->id;
	$this->shop_name = $shp->nom;
	$this->shop_adresse1=$shp->adresse_rue;
	$this->shop_adresse2=$shp->adresse_cp." ".$shp->adresse_ville;
	$this->shop_call=$shp->call1;
    $this->shop_mail=$shp->mail;
    $this->shop_clock=$shp->clock;
    
	$this->shop_logo = $shp->img_logo;
	
	$this->security_main=substr($uzr->security, 0, 1);
	$this->security_customer=substr($uzr->security, 1, 1);
	$this->security_call=substr($uzr->security, 2, 1);
    $this->security_repair=substr($uzr->security, 3, 1);
    $this->security_ctm=substr($uzr->security, 11, 1);
    $this->security_prm=substr($uzr->security, 10, 1);
	$this->security_odp=substr($uzr->security, 4, 1);
    $this->security_cmd=substr($uzr->security, 5, 1);
    $this->security_dlc=substr($uzr->security, 12, 1);
    $this->security_stats=substr($uzr->security, 6, 1);
    $this->security_repertory=substr($uzr->security, 12, 1);
	$this->security_param=substr($uzr->security, 7, 1);
	$this->security_admin=substr($uzr->security, 8, 1);
	$this->security_help=substr($uzr->security, 9, 1);


    //chargement des variable user depuis la table var_user et chargement dans l objet sugar (dois remplacer toutes les autres variables au final)
    $var_user_tmp=db_read("select * from var_user where id_user = $id order by label");
	while($var_user = $var_user_tmp->fetch())
		{
		$nom_var=$var_user->label;
		$this->$nom_var = $var_user->value;
		}
    }
#####################################################################################################################################################
public function chk_force_reload($js)
	{
	if($this->id!=0)
		{
		$uzr=db_single_read("select * from user where id = $this->id");
		if($uzr->force_reload==1)
			{
			db_write("update user set force_reload=0 where id = $this->id");
			$js->alert_redirect("Votre profil a ete modifier et vas donc etre reload","index.php?system=main&sub_system=admin_force_reload&no_interface",0);
			}
		}
	}
#####################################################################################################################################################
public function update_last_login()
	{//on update le ts de la derniere visite a maintenant et on renvoi en retour la date de la derniere visite precedente
	$last_log=db_single_read("portal","SELECT dt_last_login FROM user_login where id = $this->id;");
	db_write("portal","update user_login set dt_last_login = ".(time()+3600)." where id = $this->id;");//Si rqt est pas vide c est qu il y a des insert a faire sinon on fais rien 
	return $last_log->dt_last_login;
	}
#####################################################################################################################################################
public function show_login_other_user($id_login)
	{
	$chk=db_single_read("portal","select count(*) as cnt from user_login where id = $id_login;");
	if($chk->cnt==1)
		{
		$uzr=db_single_read("portal","select * from user_login where id = $id_login");
		return $uzr->login;
		}
	else return 0;
	}
#####################################################################################################################################################
public function show_mini_security_card($project)
	{
	$prj_sec=db_single_read("portal","select * from project_security where id_project = $project and id_user = $this->id;");
	$prj=db_single_read("portal","select * from project where id = $project;");
	echo "<div style='position:relative;float:left;width:318px;height:94px;'>";//debut container
	echo "<div style='position:absolute;left:258px;top:28px;height:50;width:50px;float:left;background-image:url(img/50px/projet/$prj->img);'></div>";//img avatar
	echo "<div style='position:absolute;left:0px;top:0px;height:94px;width:318px;float:left;background-image:url(img/security_card_mini.gif);'></div>";//img card
	echo "<div style='position:absolute;left:18px;top:27px;height:19px;width:350px;float:left;color:black;'><font size=3 ><b>Id $prj->id : $prj->name</b></font></div>";//name projet
	echo "<div style='position:absolute;left:8px;top:58px;height:20px;width:22px;float:left;color:black;'><font size=4 ><center>".substr($prj_sec->security,0,1)."</center></font></div>";//key1
	echo "<div style='position:absolute;left:32px;top:58px;height:20px;width:22px;float:left;color:black;'><font size=4 ><center>".substr($prj_sec->security,1,1)."</center></font></div>";//key1
	echo "<div style='position:absolute;left:56px;top:58px;height:20px;width:22px;float:left;color:black;'><font size=4 ><center>".substr($prj_sec->security,2,1)."</center></font></div>";//key1
	echo "<div style='position:absolute;left:80px;top:58px;height:20px;width:22px;float:left;color:black;'><font size=4 ><center>".substr($prj_sec->security,3,1)."</center></font></div>";//key1
	echo "<div style='position:absolute;left:104px;top:58px;height:20px;width:22px;float:left;color:black;'><font size=4 ><center>".substr($prj_sec->security,4,1)."</center></font></div>";//key1
	echo "<div style='position:absolute;left:128px;top:58px;height:20px;width:22px;float:left;color:black;'><font size=4 ><center>".substr($prj_sec->security,5,1)."</center></font></div>";//key1
	echo "<div style='position:absolute;left:152px;top:58px;height:20px;width:22px;float:left;color:black;'><font size=4 ><center>".substr($prj_sec->security,6,1)."</center></font></div>";//key1
	echo "<div style='position:absolute;left:176px;top:58px;height:20px;width:22px;float:left;color:black;'><font size=4 ><center>".substr($prj_sec->security,7,1)."</center></font></div>";//key1
	echo "<div style='position:absolute;left:200px;top:58px;height:20px;width:22px;float:left;color:black;'><font size=4 ><center>".substr($prj_sec->security,8,1)."</center></font></div>";//key1
	echo "<div style='position:absolute;left:224px;top:58px;height:20px;width:22px;float:left;color:black;'><font size=4 ><center>".substr($prj_sec->security,9,1)."</center></font></div>";//key1
	echo"</div>";
	}
#####################################################################################################################################################
public function show_security_level($system,$box)
	{
	switch (substr($system,0,3))
		{
		case 'mai':
			{
			switch ($this->security_main)
				{
				case 0:$box->angle('','',100,22,'#ff6281','black','black','black',100,"No acces","",'');break;
				case 1:$box->angle('','',100,22,'lightgreen','black','black','black',100,"User","",'');break;
				case 2:$box->angle('','',100,22,'#cc5bf4','black','black','black',100,"Admin","",'');break;
				case 3:$box->angle('','',100,22,'#DB9E23','black','black','black',100,"God","",'');break;
				};break;
			};break;
		case 'cus':
			{
			switch ($this->security_customer)
				{
				case 0:$box->angle('','',100,22,'#ff6281','black','black','black',100,"No acces","",'');break;
				case 1:$box->angle('','',100,22,'lightgreen','black','black','black',100,"User","",'');break;
				case 2:$box->angle('','',100,22,'#cc5bf4','black','black','black',100,"Admin","",'');break;
				case 3:$box->angle('','',100,22,'#DB9E23','black','black','black',100,"God","",'');break;
				};break;
			};break;
		case 'cal':
			{
			switch ($this->security_call)
				{
				case 0:$box->angle('','',100,22,'#ff6281','black','black','black',100,"No acces","",'');break;
				case 1:$box->angle('','',100,22,'lightgreen','black','black','black',100,"User","",'');break;
				case 2:$box->angle('','',100,22,'#cc5bf4','black','black','black',100,"Admin","",'');break;
				case 3:$box->angle('','',100,22,'#DB9E23','black','black','black',100,"God","",'');break;
				};break;
			};break;
		case 'rep':
			{
			switch ($this->security_repair)
				{
				case 0:$box->angle('','',100,22,'#ff6281','black','black','black',100,"No acces","",'');break;
				case 1:$box->angle('','',100,22,'lightgreen','black','black','black',100,"User","",'');break;
				case 2:$box->angle('','',100,22,'#cc5bf4','black','black','black',100,"Admin","",'');break;
				case 3:$box->angle('','',100,22,'#DB9E23','black','black','black',100,"God","",'');break;
				};break;
            };break;
        case 'ctm':
			{
			switch ($this->security_ctm)
				{
				case 0:$box->angle('','',100,22,'#ff6281','black','black','black',100,"No acces","",'');break;
				case 1:$box->angle('','',100,22,'lightgreen','black','black','black',100,"User","",'');break;
				case 2:$box->angle('','',100,22,'#cc5bf4','black','black','black',100,"Admin","",'');break;
				case 3:$box->angle('','',100,22,'#DB9E23','black','black','black',100,"God","",'');break;
                };break;
            };break;
		case 'pro':
			{
			switch ($this->security_prm)
				{
				case 0:$box->angle('','',100,22,'#ff6281','black','black','black',100,"No acces","",'');break;
				case 1:$box->angle('','',100,22,'lightgreen','black','black','black',100,"User","",'');break;
				case 2:$box->angle('','',100,22,'#cc5bf4','black','black','black',100,"Admin","",'');break;
				case 3:$box->angle('','',100,22,'#DB9E23','black','black','black',100,"God","",'');break;
				};break;
			};break;
		case 'odp':
			{
			switch ($this->security_odp)
				{
				case 0:$box->angle('','',100,22,'#ff6281','black','black','black',100,"No acces","",'');break;
				case 1:$box->angle('','',100,22,'lightgreen','black','black','black',100,"User","",'');break;
				case 2:$box->angle('','',100,22,'#cc5bf4','black','black','black',100,"Admin","",'');break;
				case 3:$box->angle('','',100,22,'#DB9E23','black','black','black',100,"God","",'');break;
				};break;
			};break;
		case 'cmd':
			{
			switch ($this->security_cmd)
				{
				case 0:$box->angle('','',100,22,'#ff6281','black','black','black',100,"No acces","",'');break;
				case 1:$box->angle('','',100,22,'lightgreen','black','black','black',100,"User","",'');break;
				case 2:$box->angle('','',100,22,'#cc5bf4','black','black','black',100,"Admin","",'');break;
				case 3:$box->angle('','',100,22,'#DB9E23','black','black','black',100,"God","",'');break;
				};break;
			};break;
		case 'dlc':
			{
			switch ($this->security_dlc)
				{
				case 0:$box->angle('','',100,22,'#ff6281','black','black','black',100,"No acces","",'');break;
				case 1:$box->angle('','',100,22,'lightgreen','black','black','black',100,"User","",'');break;
				case 2:$box->angle('','',100,22,'#cc5bf4','black','black','black',100,"Admin","",'');break;
				case 3:$box->angle('','',100,22,'#DB9E23','black','black','black',100,"God","",'');break;
				};break;
			};break;
		case 'sta':
			{
			switch ($this->security_stats)
				{
				case 0:$box->angle('','',100,22,'#ff6281','black','black','black',100,"No acces","",'');break;
				case 1:$box->angle('','',100,22,'lightgreen','black','black','black',100,"User","",'');break;
				case 2:$box->angle('','',100,22,'#cc5bf4','black','black','black',100,"Admin","",'');break;
				case 3:$box->angle('','',100,22,'#DB9E23','black','black','black',100,"God","",'');break;
				};break;
			};break;
		case 'tro':
			{
			switch ($this->security_repertory)
				{
				case 0:$box->angle('','',100,22,'#ff6281','black','black','black',100,"No acces","",'');break;
				case 1:$box->angle('','',100,22,'lightgreen','black','black','black',100,"User","",'');break;
				case 2:$box->angle('','',100,22,'#cc5bf4','black','black','black',100,"Admin","",'');break;
				case 3:$box->angle('','',100,22,'#DB9E23','black','black','black',100,"God","",'');break;
				};break;
			};break;
		case 'par':
			{
			switch ($this->security_param)
				{
				case 0:$box->angle('','',100,22,'#ff6281','black','black','black',100,"No acces","",'');break;
				case 1:$box->angle('','',100,22,'lightgreen','black','black','black',100,"User","",'');break;
				case 2:$box->angle('','',100,22,'#cc5bf4','black','black','black',100,"Admin","",'');break;
				case 3:$box->angle('','',100,22,'#DB9E23','black','black','black',100,"God","",'');break;
				};break;
			};break;
		case 'adm':
			{
			switch ($this->security_admin)
				{
				case 0:$box->angle('','',100,22,'#ff6281','black','black','black',100,"No acces","",'');break;
				case 1:$box->angle('','',100,22,'lightgreen','black','black','black',100,"User","",'');break;
				case 2:$box->angle('','',100,22,'#cc5bf4','black','black','black',100,"Admin","",'');break;
				case 3:$box->angle('','',100,22,'#DB9E23','black','black','black',100,"God","",'');break;
				};break;
			};break;
		case 'hel':
			{
			switch ($this->security_help)
				{
				case 0:$box->angle('','',100,22,'#ff6281','black','black','black',100,"No acces","",'');break;
				case 1:$box->angle('','',100,22,'lightgreen','black','black','black',100,"User","",'');break;
				case 2:$box->angle('','',100,22,'#cc5bf4','black','black','black',100,"Admin","",'');break;
				case 3:$box->angle('','',100,22,'#DB9E23','black','black','black',100,"God","",'');break;
				};break;
			};break;
		}
	}
#####################################################################################################################################################
public function add_con_log()
	{
	$ts=$this->get_ts();
	$rqt="delete from connection_log where id_user = $this->id;";
	$rqt.="INSERT INTO connection_log (id_user,ts) VALUES ('$this->id', '$ts');";
	db_write("portal",$rqt);
	}
##########################################################################################################################
public function clean_string($text) 
	{//remplace le caractere entre [] de la colone 1 par celui de la colone 2

	$order   = array("'", "'", "'");
	$replace = " ";

	// Traitement du premier \r\n, ils ne seront pas convertis deux fois.
	$text = str_replace($order, $replace, $text);
	return $text;
	}
##########################################################################################################################
public function clean_call($text) 
	{//remplace le caractere entre [] de la colone 1 par celui de la colone 2

	$order   = array(".", "/", " ");
	$replace = '';

	// Traitement du premier \r\n, ils ne seront pas convertis deux fois.
	$text = str_replace($order, $replace, $text);
	return $text;
	}
##########################################################################################################################
public function show_call_formated($na) 
	{
	$new_na="";
	//si c est un gsm 
	if(strlen($na)==10)$new_na=substr($na,0,4)."/".substr($na,4,2).".".substr($na,6,2).".".substr($na,8,2);
	//si c est un fixe
	if(strlen($na)==9)
		{
		//si le fixe est un 02
		if(substr($na,0,2)=='02')$new_na=substr($na,0,2)."/".substr($na,2,3).".".substr($na,5,2).".".substr($na,7,2);
		//sinon 
		else $new_na=substr($na,0,3)."/".substr($na,3,2).".".substr($na,5,2).".".substr($na,7,2);
		}

	if((strlen($na)!=10)and(strlen($na)!=9))
	$new_na=$na;
	return $new_na;
	}
#####################################################################################################################################################
public function show_customer_name($id_customer) 
	{
	$customer_chk=db_single_read("select count(*) as cnt from customer where id = $id_customer");
	if($customer_chk->cnt==1)
		{
		$customer=db_single_read("select * from customer where id = $id_customer");
		$name=$customer->prenom." ".$customer->nom;
		}
	else $name="Client introuvable";
	return $name;
	}
#####################################################################################################################################################
public function get_customer($id_customer) 
	{
	$customer_chk=db_single_read("select count(*) as cnt from customer where id = $id_customer");
	if($customer_chk->cnt==1)$customer=db_single_read("select * from customer where id = $id_customer");
	else $customer=false;
	return $customer;
	}
#####################################################################################################################################################
public function show_name_shop($id_shop) 
	{
	$shop_chk=db_single_read("select count(*) as cnt from shop where id = $id_shop");
	if($shop_chk->cnt==1)
		{
		$shop=db_single_read("select * from shop where id = $id_shop");
		return $shop->mini_name;
		}
	else return "Shop inconnus";
	}
#####################################################################################################################################################
public function show_name_user($id_user) 
	{
	//if()die("*".$id_user."*");
	if($id_user!='')
		{
		$chk_name=db_single_read("select count(*) as cnt from user where id = $id_user");
		if($chk_name->cnt==1)
			{
			$name=db_single_read("select * from user where id = $id_user");
			$result=$name->prenom." ".$name->nom;
			}
		else $result="Utilisateur Inconnus";
		}
	else $result="Utilisateur Inconnus";
	return $result;
    }
#####################################################################################################################################################
public function show_my_name_mini()
    {
    $name=$this->prenom." ".substr($this->nom,0,1);
    return $name;
    }
#####################################################################################################################################################
public function admin_menu($system,$box) 
	{
	//MENU lobby
	if($system=='admin/admin.lobby')$box->box_rond('','','150','22','lightgreen','black','','',100,"Lobby","index.php?system=admin/admin.lobby&sub_system=lobby",'');
	else $box->box_rond('','','150','22','grey','black','','',100,"Lobby","index.php?system=admin/admin.lobby&sub_system=lobby",'');
	//MENU USER
	if($system=='admin/admin.user')$box->box_rond('','','150','22','lightgreen','black','','',100,"User","index.php?system=admin/admin.user&sub_system=lobby",'');
	else $box->box_rond('','','150','22','grey','black','','',100,"User","index.php?system=admin/admin.user&sub_system=lobby",'');
	//MENU SHOP
	if($system=='admin/admin.shop')$box->box_rond('','','150','22','lightgreen','black','','',100,"Shop","index.php?system=admin/admin.shop&sub_system=lobby",'');
	else $box->box_rond('','','150','22','grey','black','','',100,"Shop","index.php?system=admin/admin.shop&sub_system=lobby",'');
	//MENU log
	if($system=='admin/admin.log_server')$box->box_rond('','','150','22','lightgreen','black','','',100,"Log server","index.php?system=admin/admin.log_server&sub_system=lobby",'');
	else $box->box_rond('','','150','22','grey','black','','',100,"Log Server","index.php?system=admin/admin.log_server&sub_system=lobby",'');
	$box->empty('','','878','22','black','','','',100,"<marquee width=898><font color=white>$system</marquee>","",'');
	}
#####################################################################################################################################################
public function promo_menu($system,$box) 
	{
	$box->empty_in('','','1498','22','black','','','',100,"","",'');
		//promo Groupe
		$msg="Empty";
		$width=1048;
		if($system=='promo/promo.groupe')
			{
			//$box->empty_in('','','200','22','','','','',100,"","",'');
				$box->box_rond('','','150','22','lightgreen','black','','',100,"Promo Groupe","index.php?system=promo/promo.groupe&sub_system=lobby",'');
				if($this->security_prm>1)$box->box_rond('','','50','18',"yellow",'black','','',100,"<font size=2>Ajouter</font>","index.php?system=promo/promo.groupe&sub_system=add_prm_grp",'');
			//$box->empty_out(".");
			$msg="Promo Groupe : Promotion disponible dans tout les magasin du groupe.";
			}
		else $box->box_rond('','','150','22','grey','black','','',100,"Promo Groupe","index.php?system=promo/promo.groupe&sub_system=lobby",'');
		
		//promo Shop
		if($system=='promo/promo.shop')
			{
			$box->box_rond('','','150','22','lightgreen','black','','',100,"Promo Shop","index.php?system=promo/promo.shop&sub_system=lobby",'');
			$msg="Promo Shop : Promotion disponible uniquement dans se magasin.";
			}
		else $box->box_rond('','','150','22','grey','black','','',100,"Promo Shop","index.php?system=promo/promo.shop&sub_system=lobby",'');
		
		//pub Screen
		if($system=='promo/promo.pub_screen')
			{
			$box->empty_in('','','200','22','','','','',100,"","",'');
			$box->box_rond('','','150','22','lightgreen','black','','',100,"Pub Screen","index.php?system=promo/promo.pub_screen&sub_system=lobby",'');
			
			//if($sugar->security_prm>1)$box->box_rond('','','50','18',"yellow",'black','','',100,"<font size=2>Ajouter</font>","index.php?system=promo/promo.groupe&sub_system=add_prm_grp",'');
			if($this->security_prm>1)$box->box_rond('','','50','18',"yellow",'black','','',100,"<font size=2>Ajouter</font>","index.php?system=promo/promo.pub_screen&sub_system=add_screen",'');
			
			$box->empty_out(".");
			
			//$box->box_rond('','','150','22','lightgreen','black','','',100,"Pub Screen","",'');
			$msg="Pub Screen : Ecran publicitaire.";
			}
		else $box->box_rond('','','150','22','grey','black','','',100,"Pub Screen","index.php?system=promo/promo.pub_screen&sub_system=lobby",'');
		
		$box->empty('','',$width,'22','black','','','',100,"<marquee width=1048px><font color=white>$msg</marquee>","",'');
	$box->empty_out(".");
	}
#####################################################################################################################################################
public function admin_add_log($system,$sub_system,$remarque,$priority) 
	{
	db_write("insert into admin_log_server (dt,id_tech,system,sub_system,remarque,priority)values('".time()."','$this->id','$system','$sub_system','$remarque','$priority')");
    }
#####################################################################################################################################################
public function menu_lobby($sugar,$box) 
	{
    if($sugar->label=="main")$box->box_rond('','',32,32,'',"$sugar->background_color",'img/32px/novoffice_color.gif','',100,'','index.php?system=main&sub_system=lobby','');//Logo
    else $box->box_rond('','',32,32,'lightgrey',"$sugar->background_color",'img/32px/novoffice_grey.gif','',100,'','index.php?system=main','');//Logo
    $box->empty('','','10','32','',"",'','',100,'','','');    //bloc separation
    }
public function menu_slideshow($sugar,$box) 
	{
    $box->box_rond('','',32,32,'lightgrey',"$sugar->background_color",'img/32px/slideshow_grey.gif','',100,'',"slideshow_v3.php?debug=0&coef=1&timer=15&loop_odp=0&no_interface",'');//menu
    $box->empty('','','10','32','',"",'','',100,'','','');    //bloc separation
    }
public function menu_customer($sugar,$box) 
	{
    if($sugar->id!=0)
        {
        //customer
        if((substr($sugar->label,0,3))=="cus")$box->box_rond('','',32,32,'lightblue',"$sugar->background_color",'img/32px/customer.gif','',100,'',"index.php?system=customer",'');//menu
        else $box->box_rond('','',32,32,'lightgrey',"$sugar->background_color",'img/32px/customer.gif','',100,'',"index.php?system=customer",'');//menu
        $box->empty('','','10','32','',"",'','',100,'','','');    //bloc separation
        }
    }
public function menu_call($sugar,$box) 
	{
    if($sugar->id!=0)
        {
        //call
        $chk_call=db_single_read("select count(*) as cnt from call_log where id_tech = $sugar->id and status='open';");
		if($chk_call->cnt==0)
			{
			if($sugar->label=="cal")$box->box_rond('','',32,32,'lightblue',"$sugar->background_color",'img/32px/call_msg_green.gif','',100,'','index.php?system=call','');//menu
			else $box->box_rond('','',32,32,'lightgrey',"$sugar->background_color",'img/32px/call_msg_green.gif','',100,'',"index.php?system=call",'');//menu
			}
		else 
			{
			if((substr($sugar->label,0,3))=="cal")
				{
				$box->empty_in('','','64','32','','','','','100','',"index.php?system=call",'');
				if((substr($sugar->label,0,3))=="cal")$box->box_rond(0,0,'64','32','lightblue',"$sugar->background_color",'img/32px/call_msg_red.gif','','100',"","index.php?system=call",'');
				else $box->box_rond(0,0,'64','32','lightgrey',"$sugar->background_color",'img/32px/call_msg_red.gif','','100',"","index.php?system=call",'');
				$box->empty(36,6,20,20,'','','','','100',"$chk_call->cnt","index.php?system=call",'');
				$box->empty_out(".");
				}
			else 
				{
				$box->empty_in('','','64','32','','','','','100','',"index.php?system=call",'');
				if((substr($sugar->label,0,3))=="cal")$box->box_rond(0,0,'64','32','lightblue',"$sugar->background_color",'img/32px/call_msg_red.gif','','100',"","index.php?system=call",'');
				else $box->box_rond(0,0,'64','32','lightgrey',"$sugar->background_color",'img/32px/call_msg_red.gif','','100',"","index.php?system=call",'');
                    $box->empty_in('36','6','20','20','',"$sugar->background_color",'','','100',"$chk_call->cnt","index.php?system=call",'');
                    echo "<iframe width=100% height=100% frameborder=0 src='index.php?system=iframe/menu.iframe&sub_system=check_call&no_interface'></iframe>";
                    $box->empty_out(".");
				$box->empty_out(".");
				}
			}
		$box->empty('','','10','32','',"",'','',100,'','','');    //bloc separation
        }
    }
public function menu_repair($sugar,$box) 
	{
    $chk_repair=db_single_read("select count(*) as cnt from repair where (id_shop= $sugar->shop_id and (status = 'open')) ;");
    if($chk_repair->cnt==0)
        {
        if((substr($sugar->label,0,3))=="rep")$box->box_rond('','',32,32,'',"$sugar->background_color",'img/32px/repair_blue.gif','',100,'',"index.php?system=repair",'');//menu
        else $box->box_rond('','',32,32,'',"$sugar->background_color",'img/32px/repair_grey.gif','',100,'',"index.php?system=repair",'');//menu
        }
    else 
        {
        if((substr($sugar->label,0,3))=="rep")$img="img/32px/repair_blue_msg.gif";
        else $img="img/32px/repair_grey_msg.gif";
        $box->box_rond_in('','',64,32,'red',"$sugar->background_color",$img,'',100,'',"index.php?system=repair",'');//menu
        $box->angle('31','4',26,24,'','','','',100,$chk_repair->cnt,'','');//menu
        $box->box_rond_out("");
        }
    $box->empty('','','10','32','',"$sugar->background_color",'','',100,'','','');//bloc separation
    }
public function menu_ctm($sugar,$box) 
	{
    //contrat maintenance
    if($sugar->label=="ctm")$box->box_rond('','',32,32,'lightblue',"$sugar->background_color",'img/32px/ctr_mtn.gif','',100,'',"index.php?system=ctm/ctm",'');//menu
    else $box->box_rond('','',32,32,'lightgrey',"$sugar->background_color",'img/32px/ctr_mtn.gif','',100,'',"index.php?system=ctm/ctm",'');//menu
    $box->empty('','','10','32','',"$sugar->background_color",'','',100,'','','');//bloc separation
    }
public function menu_promo($sugar,$box) 
	{
    if($sugar->label=="prm")$box->box_rond('','',32,32,'lightblue',"$sugar->background_color",'img/32px/sale.gif','',100,'',"index.php?system=promo/promo.groupe",'');//menu
    else $box->box_rond('','',32,32,'lightgrey',"$sugar->background_color",'img/32px/sale.gif','',100,'',"index.php?system=promo/promo.groupe",'');//menu
    $box->empty('','','10','32','',"$sugar->background_color",'','',100,'','',''); //bloc separation
    }
public function menu_odp($sugar,$box) 
	{
   //offre de prix
		$chk_odp=db_single_read("select count(*) as cnt from cmd where id_shop=$sugar->shop_id and type = 'odp' and status !='hidden' and dt_out <".time().";");
		if($chk_odp->cnt==0)
			{
			if((substr($system,0,3))=="odp")$box->box_rond('','',32,32,'',"$sugar->background_color",'img/32px/odp_blue.gif','',100,'',"index.php?system=odp",'');//menu
			else $box->box_rond('','',32,32,'',"$sugar->background_color",'img/32px/odp_grey.gif','',100,'',"index.php?system=odp",'');//menu
			}
		else 
			{
			if((substr($sugar->label,0,3))=="odp")$img="img/32px/odp_blue_msg.gif";
			else $img="img/32px/odp_grey_msg.gif";
			$box->box_rond_in('','',64,32,'red',"$sugar->background_color",$img,'',100,'',"index.php?system=odp",'');//menu
			$box->angle('31','4',26,24,'','','','',100,$chk_odp->cnt,'','');//menu
			$box->box_rond_out("");
			}
        
        //bloc separation
        $box->empty('','','10','32','',"",'','',100,'','','');    //bloc separation
    }
public function menu_cmd($sugar,$box) 
	{
    //commande
    $chk_cmd=db_single_read("select count(*) as cnt from cmd where id_shop=$sugar->shop_id and type = 'cmd' and status !='hidden' and status = 'open';");
    if($chk_cmd->cnt==0)
        {
        $box->empty_in('','','32','32','','','','','100','',"index.php?system=cmd",'');
        if((substr($sugar->label,0,3))=="cmd")$box->box_rond(0,0,'32','32','lightblue',"$sugar->background_color",'img/32px/cmd.gif','','100',"","",'');
        else $box->box_rond(0,0,'32','32','lightgrey',"$sugar->background_color",'img/32px/cmd.gif','','100',"","",'');
        $box->empty_out(".");
        }
    else
        {
        $box->empty_in('','','64','32','','','','','100','',"index.php?system=cmd",'');
        if((substr($sugar->label,0,3))=="cmd")$box->box_rond(0,0,'64','32','lightblue',"$sugar->background_color",'img/32px/cmd_msg.gif','','100',"","index.php?system=cmd",'');
        else $box->box_rond(0,0,'64','32','lightgrey',"$sugar->background_color",'img/32px/cmd_msg.gif','','100',"","index.php?system=cmd",'');
        $box->empty(36,6,20,20,'','','','','100',"$chk_cmd->cnt","index.php?system=cmd",'');
        $box->empty_out(".");
        }
    //bloc separation
    $box->empty('','','10','32','',"",'','',100,'','','');    //bloc separation
    }
public function menu_dlc($sugar,$box) 
	{
    //dlc
    if((substr($sugar->label,0,3))=="dlc") $box->box_rond('','',32,32,'lightblue',"$sugar->background_color",'img/32px/dlc.gif','',100,'',"index.php?system=dlc/dlc",'');//menu
    else $box->box_rond('','',32,32,'lightgrey',"$sugar->background_color",'img/32px/dlc.gif','',100,'',"index.php?system=dlc/dlc",'');//menu
    $box->empty('','','10','32','',"",'','',100,'','','');    //bloc separation
    }
public function menu_stats($sugar,$box) 
	{
   //statistique
    if((substr($sugar->label,0,3))=="sta")$box->box_rond('','',32,32,'lightblue',"$sugar->background_color",'img/32px/stats.gif','',100,'',"index.php?system=stats",'');//menu
    else $box->box_rond('','',32,32,'lightgrey',"$sugar->background_color",'img/32px/stats.gif','',100,'',"index.php?system=stats",'');//menu
    $box->empty('','','10','32','',"",'','',100,'','','');    //bloc separation
    }
public function menu_repertory($sugar,$box) 
	{
   	if((substr($sugar->label,0,3))=="tro") $box->box_rond('','',32,32,'lightblue',"$sugar->background_color",'img/32px/trombinoscope.gif','',100,'',"index.php?system=trombinoscope",'');//menu
    else $box->box_rond('','',32,32,'lightgrey',"$sugar->background_color",'img/32px/trombinoscope.gif','',100,'',"index.php?system=trombinoscope",'');//menu
    $box->empty('','','10','32','',"",'','',100,'','','');    //bloc separation
    }
public function menu_param($sugar,$box) 
	{
    if((substr($sugar->label,0,3))=="par")$box->box_rond('','',32,32,'lightblue',"$sugar->background_color",'img/32px/param.gif','',100,'',"index.php?system=param",'');//menu
    else $box->box_rond('','',32,32,'lightgrey',"$sugar->background_color",'img/32px/param.gif','',100,'',"index.php?system=param",'');//menu
    $box->empty('','','10','32','',"",'','',100,'','','');    //bloc separation
    }
public function menu_admin($sugar,$box) 
	{
    if((substr($sugar->label,0,3))=="adm") $box->box_rond('','','50','32','lightblue',"$sugar->background_color",'img/32px/admin_color.gif','',100,'',"index.php?system=admin/admin.lobby",'');//menu
    else $box->box_rond('','','50','32','lightgrey',"$sugar->background_color",'img/32px/admin_grey.gif','',100,'',"index.php?system=admin/admin.lobby",'');//menu
    $box->empty('','','10','32','',"",'','',100,'','','');    //bloc separation
    }
public function menu_help($sugar,$box) 
	{
    if((substr($sugar->label,0,3))=="hel")$box->box_rond('','',42,32,'lightblue',"$sugar->background_color",'img/32px/help.gif','',100,'',"index.php?system=help",'');//menu
    else $box->box_rond('','',42,32,'lightgrey',"$sugar->background_color",'img/32px/help.gif','',100,'',"index.php?system=help",'');//menu
    $box->empty('','','10','32','',"",'','',100,'','','');    //bloc separation
    }
public function menu_logout($sugar,$box) 
	{
    $box->box_rond('','',32,'32','',"$sugar->background_color",'img/32px/logout.gif','',100,'',"index.php?system=main&sub_system=logout",'');//EXIT
    $box->empty('','','10','32','',"",'','',100,'','','');    //bloc separation
    }
}
?>