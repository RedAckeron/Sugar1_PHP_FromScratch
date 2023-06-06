<?php
class _admin
	{
    public $pw="null";
    public $label="main";
#####################################################################################################################################################
public function chk_admin_password($js,$pw)
    {
    $d=date("d",time());
    $m=date("m",time());
    $y=date("y",time());
    $pw_test=intval($d)+intval($m)+intval($y);
    if($pw_test==$pw)
        {
        $this->pw=$pw;
        }
    else 
        {
        $js->encode_text("Entrez votre mot de passe ",'pw','','index.php?system=main');
        die();
        }
    }
#####################################################################################################################################################
public function show_menu($system,$box) 
	{
    //bouton main
    if($this->label=="main")$box->box_rond('','',32,32,'red',"white",'img/32px/novoffice.gif','',100,'','index.php?system=main&sub_system=lobby','');//Logo
    else $box->box_rond('','',32,32,'white',"white",'img/32px/novoffice.gif','',100,'','index.php?system=main','');//Logo
    $box->empty('','','5','32','',"",'','',100,'','','');    //bloc separation
    //bouton stats
    if($this->label=="stats")$box->box_rond('','',32,32,'red',"white",'img/32px/stats.gif','',100,'','index.php?system=stats&sub_system=lobby','');//Logo
    else $box->box_rond('','',32,32,'white',"white",'img/32px/stats.gif','',100,'','index.php?system=stats&sub_system=lobby','');//Logo
    $box->empty('','','5','32','',"",'','',100,'','','');    //bloc separation
    //bouton user
    if($this->label=="user")$box->box_rond('','',32,32,'red',"white",'img/32px/user.gif','',100,'','index.php?system=user&sub_system=lobby','');//Logo
    else $box->box_rond('','',32,32,'white',"white",'img/32px/user.gif','',100,'','index.php?system=user&sub_system=lobby','');//Logo
    $box->empty('','','5','32','',"",'','',100,'','','');    //bloc separation
     //bouton shop
     if($this->label=="shop")$box->box_rond('','',32,32,'red',"white",'img/32px/shop.gif','',100,'','index.php?system=shop&sub_system=lobby','');//Logo
     else $box->box_rond('','',32,32,'white',"white",'img/32px/shop.gif','',100,'','index.php?system=shop&sub_system=lobby','');//Logo
     $box->empty('','','5','32','',"",'','',100,'','','');    //bloc separation
    //bouton CTM
    if($this->label=="ctm")$box->box_rond('','',32,32,'red',"white",'img/32px/ctm.gif','',100,'','index.php?system=ctm&sub_system=lobby','');//Logo
    else $box->box_rond('','',32,32,'white',"white",'img/32px/ctm.gif','',100,'','index.php?system=ctm&sub_system=lobby','');//Logo
    $box->empty('','','5','32','',"",'','',100,'','','');    //bloc separation
    //bouton server
    if($this->label=="var_server")$box->box_rond('','',32,32,'red',"white",'img/32px/server.gif','',100,'','index.php?system=var_server&sub_system=lobby','');//Logo
    else $box->box_rond('','',32,32,'white',"white",'img/32px/server.gif','',100,'','index.php?system=var_server&sub_system=lobby','');//Logo
    $box->empty('','','5','32','',"",'','',100,'','','');    //bloc separation
     //bouton log server
     if($this->label=="log_server")$box->box_rond('','',32,32,'red',"white",'img/32px/log_server.gif','',100,'','index.php?system=log_server&sub_system=lobby','');//Logo
     else $box->box_rond('','',32,32,'white',"white",'img/32px/log_server.gif','',100,'','index.php?system=log_server&sub_system=lobby','');//Logo
     $box->empty('','','5','32','',"",'','',100,'','','');    //bloc separation
     
    $box->box_rond('','','300','32','lightblue',"white",'','',100,"<font size=5>".ucfirst($this->label)."</font>","",'');//affichage de l intitul� des icones
    }

}
?>