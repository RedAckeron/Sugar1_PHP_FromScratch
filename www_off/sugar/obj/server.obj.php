<?php
class _server
	{
    public $motd="Bienvenu, et passez une bonne journée - #behappyatwork";
    
#####################################################################################################################################################
public function load()
	{
	$var_serv_tmp=db_read("select * from var_server order by nom");
	while($var_serv = $var_serv_tmp->fetch())
		{
		$nom_var=$var_serv->nom;
		$this->$nom_var = $var_serv->var;
		}
	}
#####################################################################################################################################################
	}
?>