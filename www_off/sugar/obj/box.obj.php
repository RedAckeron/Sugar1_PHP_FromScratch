<?php
class _box
	{
##########################################################################################
public function help()
		{
		echo "<table border = 1 width=100% bgcolor='red' color='black'>";
		echo "<tr><td>Function</td><td>Parametres</td><td>Description</td></tr>";
		echo "<tr><td>open</td><td>(url,method)</td><td>Ouverture du formulaire on choisis GET ou POST comme methode d envoi</td></tr>";
		echo "<tr><td>close</td><td>()</td><td>Fermeture du formulaire</td></tr>";
		echo "<tr><td>select_in</td><td>(name,size)</td><td>debut de menu deroulant name c est le nom de menu deoulant et siza le nombre de ligne du menu</td></tr>";
		echo "<tr><td>select_option</td><td>(value,name,selected)</td><td>option du menu deroulant value = valeur de l option name=nom afficher dans menu et selected faut il pointer dessus ou non</td></tr>";
		echo "<tr><td>select_out</td><td>()</td><td>Fermeture du formulaire</td></tr>";
		echo "<tr><td>send</td><td>()</td><td>Boutton pour envoyer formulaire name=nom sur le boutton</td></tr>";
		echo "<tr><td>text</td><td>(name,size,value)</td><td>formulaire text nom du champs size:largeur de la case , value=valeur dans le champs</td></tr>";
		echo "<tr><td>  </td><td>(  )</td><td>  </td></tr>";
		echo "</table>";
		}
##########################################################################################
public function angle($x,$y,$width,$height,$color,$bgcolor,$bgimg,$txtcolor,$transparency,$txt,$url,$url_title)
	{//Box principal
	//position
	if (($x!='')and($y!=''))$position = "position:absolute;left:$x;top:$y;";
	else $position = 'position:auto;float:left;';
	//dimension
	$dimension="width:$width px;height:$height px;";
	//backgroundcolor
	if($color!='')$backgroundcolor="background-color:$color;";
	else $backgroundcolor="";
	//bg_img
	if($bgimg!='')$bg_img="background-image:url($bgimg);";
	else $bg_img='';
	//txt_color
	if($txtcolor!='')$txt_color="color:$txtcolor;";
	else $txt_color="";
	
	//transparence
	if($transparency>0 and $transparency<101)$transparence="-moz-opacity:".($transparency/100).";opacity: ".($transparency/100).";filter:alpha(opacity=".$transparency.");";
	else $transparence="";
	//$transparence="-moz-opacity:".($transparency/100).";opacity: ".($transparency/100).";filter:alpha(opacity=".$transparency.");";
	if($url!='')echo "<a href='$url'>";
	echo "<div style='";
	echo $position;
	echo $dimension;
	echo $backgroundcolor;
	echo $bg_img;
	echo $txt_color;
	echo "overflow:hidden;";
	echo $transparence;
	echo "'>";
		
	
	//Box d encrage
	echo "<div style='width:$width;height:$height;position:relative;'>";
	//barre haut
	echo "<div style='width:".$width."px;height:1px;position:absolute;left:0px;top:0px;background-color:$bgcolor;'></div>";
	//barre bas
	echo "<div style='width:".$width."px;height:1px;position:absolute;left:0px;top:".($height-1)."px;background-color:$bgcolor;'></div>";
	//barre gauche
	echo "<div style='width:1px;height:".$height."px;position:absolute;left:0px;top:0px;background-color:$bgcolor;'></div>";
	//barre droite
	echo "<div style='width:1px;height:".$height."px;position:absolute;left:".($width-1)."px;top:0px;background-color:$bgcolor;'></div>";
		
	//Box central
	echo "<div style='width:".($width-2)."px;height:".($height-2)."px;position:absolute;left:1px;top:1px;overflow:auto;'>";
	
	//si entet box vide on n affiche pas 
	
	if ($txt!='')echo "<center><b>$txt</b></center>";
	
	echo "</div></div></div>";
	if($url!='')echo "</a>";
	
	}
##########################################################################################
public function box_rond($x,$y,$width,$height,$color,$bgcolor,$bgimg,$txtcolor,$transparency,$txt,$url,$url_title)
	{//Box principal
	//position
	if (($x!='')and($y!=''))$position = "position:absolute;left:$x;top:$y;";
	else $position = 'position:auto;float:left;';
	//dimension
	$dimension="width:$width px;height:$height px;";
	//backgroundcolor
	if($color!='')$backgroundcolor="background-color:$color;";
	else $backgroundcolor="";
	//bg_img
	if($bgimg!='')$bg_img="background-image:url($bgimg);";
	else $bg_img='';
	//txt_color
	if($txtcolor!='')$txt_color="color:$txtcolor;";
	else $txt_color="";
	
	//transparence
	if($transparency>0 and $transparency<101)$transparence="-moz-opacity:".($transparency/100).";opacity: ".($transparency/100).";filter:alpha(opacity=".$transparency.");";
	else $transparence="";
	//$transparence="-moz-opacity:".($transparency/100).";opacity: ".($transparency/100).";filter:alpha(opacity=".$transparency.");";
	if($url!='')echo "<a href='$url'>";
	echo "<div style='";
	echo $position;
	echo $dimension;
	echo $backgroundcolor;
	echo $bg_img;
	echo $txt_color;
	echo "overflow:hidden;";
	echo $transparence;
	echo "'>";
		
	
	//Box d encrage
	echo "<div style='width:$width;height:$height;position:relative;'>";
	//barre haut
	echo "<div style='width:".$width."px;height:1px;position:absolute;left:0px;top:0px;background-color:$bgcolor;'></div>";
	//barre bas
	echo "<div style='width:".$width."px;height:1px;position:absolute;left:0px;top:".($height-1)."px;background-color:$bgcolor;'></div>";
	//barre gauche
	echo "<div style='width:1px;height:".$height."px;position:absolute;left:0px;top:0px;background-color:$bgcolor;'></div>";
	//barre droite
	echo "<div style='width:1px;height:".$height."px;position:absolute;left:".($width-1)."px;top:0px;background-color:$bgcolor;'></div>";
		
	//coin hg
	echo "<div style='width:2px;height:2px;position:absolute;left:1px;top:1px;background-color:$bgcolor;'></div>";
	echo "<div style='width:2px;height:1px;position:absolute;left:3px;top:1px;background-color:$bgcolor;'></div>";
	echo "<div style='width:1px;height:2px;position:absolute;left:1px;top:3px;background-color:$bgcolor;'></div>";
	
	//coin hd
	echo "<div style='width:2px;height:2px;position:absolute;left:".($width-3)."px;top:1px;background-color:$bgcolor;'></div>";
	echo "<div style='width:1px;height:2px;position:absolute;left:".($width-2)."px;top:3px;background-color:$bgcolor;'></div>";
	echo "<div style='width:2px;height:1px;position:absolute;left:".($width-5)."px;top:1px;background-color:$bgcolor;'></div>";
	
	//coin bg
	echo "<div style='width:2px;height:2px;position:absolute;left:1px;top:".($height-3)."px;background-color:$bgcolor;'></div>";
	echo "<div style='width:2px;height:1px;position:absolute;left:3px;top:".($height-2)."px;background-color:$bgcolor;'></div>";
	echo "<div style='width:1px;height:2px;position:absolute;left:1px;top:".($height-5)."px;background-color:$bgcolor;'></div>";
	
	//coin bd
	echo "<div style='width:2px;height:2px;position:absolute;left:".($width-3)."px;top:".($height-3)."px;background-color:$bgcolor;'></div>";
	echo "<div style='width:1px;height:2px;position:absolute;left:".($width-2)."px;top:".($height-5)."px;background-color:$bgcolor;'></div>";
	echo "<div style='width:2px;height:1px;position:absolute;left:".($width-5)."px;top:".($height-2)."px;background-color:$bgcolor;'></div>";
	
	//Box central
	echo "<div style='width:".($width-2)."px;height:".($height-2)."px;position:absolute;left:1px;top:1px;overflow:auto;'>";
	
	//si entet box vide on n affiche pas 
	if ($txt!='')echo "<center><b>$txt</b></center>";
	echo "</div></div></div>";
	if($url!='')echo "</a>";
	}
##########################################################################################
public function box_rond_in($x,$y,$width,$height,$color,$bgcolor,$bgimg,$txtcolor,$transparency,$txt,$url,$url_title)
	{//Box principal
	//position
	if (($x!='')and($y!=''))$position = "position:absolute;left:$x;top:$y;";
	else $position = 'position:auto;float:left;';
	//dimension
	$dimension="width:$width px;height:$height px;";
	//$width="width:$width px;";
	//$height="height:$height px;";
	//backgroundcolor
	if($color!='')$backgroundcolor="background-color:$color;";
	else $backgroundcolor="";
	//bg_img
	if($bgimg!='')$bg_img="background-image:url($bgimg);";
	else $bg_img='';
	//txt_color
	if($txtcolor!='')$txt_color="color:$txtcolor;";
	else $txt_color="";
	
	//transparence
	if($transparency>0 and $transparency<101)$transparence="-moz-opacity:".($transparency/100).";opacity: ".($transparency/100).";filter:alpha(opacity=".$transparency.");";
	else $transparence="";
	//$transparence="-moz-opacity:".($transparency/100).";opacity: ".($transparency/100).";filter:alpha(opacity=".$transparency.");";
	if($url!="")echo "<a href='$url'>";
	echo "<div style='";
	echo $position;
	echo $dimension;
	echo $width;
	echo $hieght;
	echo $backgroundcolor;
	echo $bg_img;
	echo $txt_color;
	echo "overflow:hidden;";
	echo $transparence;
	echo "'>";
	
	
	//Box d encrage
	echo "<div style='width:$width;height:$height;position:relative;'>";
	//barre haut
	echo "<div style='width:".$width."px;height:1px;position:absolute;left:0px;top:0px;background-color:$bgcolor;'></div>";
	//barre bas
	echo "<div style='width:".$width."px;height:1px;position:absolute;left:0px;top:".($height-1)."px;background-color:$bgcolor;'></div>";
	//barre gauche
	echo "<div style='width:1px;height:".$height."px;position:absolute;left:0px;top:0px;background-color:$bgcolor;'></div>";
	//barre droite
	echo "<div style='width:1px;height:".$height."px;position:absolute;left:".($width-1)."px;top:0px;background-color:$bgcolor;'></div>";
		
	//coin hg
	echo "<div style='width:2px;height:2px;position:absolute;left:1px;top:1px;background-color:$bgcolor;'></div>";
	echo "<div style='width:2px;height:1px;position:absolute;left:3px;top:1px;background-color:$bgcolor;'></div>";
	echo "<div style='width:1px;height:2px;position:absolute;left:1px;top:3px;background-color:$bgcolor;'></div>";
	
	//coin hd
	echo "<div style='width:2px;height:2px;position:absolute;left:".($width-3)."px;top:1px;background-color:$bgcolor;'></div>";
	echo "<div style='width:1px;height:2px;position:absolute;left:".($width-2)."px;top:3px;background-color:$bgcolor;'></div>";
	echo "<div style='width:2px;height:1px;position:absolute;left:".($width-5)."px;top:1px;background-color:$bgcolor;'></div>";
	
	//coin bg
	echo "<div style='width:2px;height:2px;position:absolute;left:1px;top:".($height-3)."px;background-color:$bgcolor;'></div>";
	echo "<div style='width:2px;height:1px;position:absolute;left:3px;top:".($height-2)."px;background-color:$bgcolor;'></div>";
	echo "<div style='width:1px;height:2px;position:absolute;left:1px;top:".($height-5)."px;background-color:$bgcolor;'></div>";
	
	//coin bd
	echo "<div style='width:2px;height:2px;position:absolute;left:".($width-3)."px;top:".($height-3)."px;background-color:$bgcolor;'></div>";
	echo "<div style='width:1px;height:2px;position:absolute;left:".($width-2)."px;top:".($height-5)."px;background-color:$bgcolor;'></div>";
	echo "<div style='width:2px;height:1px;position:absolute;left:".($width-5)."px;top:".($height-2)."px;background-color:$bgcolor;'></div>";
	
	//Box central
	echo "<div style='width:".($width-2)."px;height:".($height-2)."px;position:absolute;left:1px;top:1px;overflow:auto;'>";
	
	//si entet box vide on n affiche pas 
	if ($txt!='')echo "<center><b>$txt</b></center>";
	}
##########################################################################################
public function box_rond_out($url)
	{
	echo "</div></div></div>";
	if($url!="")echo "</a>";
	}
##########################################################################################
public function angle_in($x,$y,$width,$height,$color,$bgcolor,$bgimg,$txtcolor,$transparency,$txt,$url,$url_title)
	{//Box principal
	//position
	if (($x!='')and($y!=''))$position = "position:absolute;left:$x;top:$y;";
	else $position = 'position:auto;float:left;';
	//dimension
	$dimension="width:$width px;height:$height px;";
	//backgroundcolor
	if($color!='')$backgroundcolor="background-color:$color;";
	else $backgroundcolor="";
	//bg_img
	if($bgimg!='')$bg_img="background-image:url($bgimg);";
	else $bg_img='';
	//txt_color
	if($txtcolor!='')$txt_color="color:$txtcolor;";
	else $txt_color="";
	
	//transparence
	if($transparency>0 and $transparency<101)$transparence="-moz-opacity:".($transparency/100).";opacity: ".($transparency/100).";filter:alpha(opacity=".$transparency.");";
	else $transparence="";
	//$transparence="-moz-opacity:".($transparency/100).";opacity: ".($transparency/100).";filter:alpha(opacity=".$transparency.");";
	if($url!='')echo "<a href='$url'>";
	echo "<div style='";
	echo $position;
	echo $dimension;
	echo $backgroundcolor;
	echo $bg_img;
	echo $txt_color;
	echo "overflow:hidden;";
	echo $transparence;
	echo "'>";
	
	//Box d encrage
	echo "<div style='width:$width;height:$height;position:relative;'>";
	//barre haut
	echo "<div style='width:".$width."px;height:1px;position:absolute;left:0px;top:0px;background-color:$bgcolor;'></div>";
	//barre bas
	echo "<div style='width:".$width."px;height:1px;position:absolute;left:0px;top:".($height-1)."px;background-color:$bgcolor;'></div>";
	//barre gauche
	echo "<div style='width:1px;height:".$height."px;position:absolute;left:0px;top:0px;background-color:$bgcolor;'></div>";
	//barre droite
	echo "<div style='width:1px;height:".$height."px;position:absolute;left:".($width-1)."px;top:0px;background-color:$bgcolor;'></div>";
	//Box central
	echo "<div style='width:".($width-2)."px;height:".($height-2)."px;position:absolute;left:1px;top:1px;overflow:auto;'>";
	
	//si entet box vide on n affiche pas 
	if ($txt!='')echo "<center><b>$txt</b></center>";
	}
##########################################################################################
public function angle_out($url)
	{
	echo "</div></div></div>";
	if($url!='')echo "</a>";
	}
##########################################################################################
public function empty($x,$y,$width,$height,$color,$bgcolor,$bgimg,$txtcolor,$transparency,$txt,$url,$url_title)
	{//Box principal
	//position
	if (($x!='')and($y!=''))$position = "position:absolute;left:$x;top:$y;";
	else $position = 'position:auto;float:left;';
	//dimension
	$dimension="width:$width px;height:$height px;";
	//backgroundcolor
	if($color!='')$backgroundcolor="background-color:$color;";
	else $backgroundcolor="";
	//bg_img
	if($bgimg!='')$bg_img="background-image:url($bgimg);";
	else $bg_img='';
	//txt_color
	if($txtcolor!='')$txt_color="color:$txtcolor;";
	else $txt_color="";
	
	//transparence
	if($transparency>0 and $transparency<101)$transparence="-moz-opacity:".($transparency/100).";opacity: ".($transparency/100).";filter:alpha(opacity=".$transparency.");";
	else $transparence="";
	//$transparence="-moz-opacity:".($transparency/100).";opacity: ".($transparency/100).";filter:alpha(opacity=".$transparency.");";
	if($url!='')echo "<a href='$url'>";
	echo "<div style='";
	echo $position;
	echo $dimension;
	echo $backgroundcolor;
	echo $bg_img;
	echo $txt_color;
	echo "overflow:hidden;";
	echo $transparence;
	echo "'>";
	
	//Box d encrage
	echo "<div style='width:$width;height:$height;position:relative;'>";
	
	//Box central
	echo "<div style='width:$width px;height:$height px;position:absolute;left:1px;top:1px;overflow:auto;'>";
	
	//si entet box vide on n affiche pas 
	if ($txt!='')echo "<center><b>$txt</b></center>";
	echo "</div></div></div>";
	if($url!='')echo "</a>";
	}
##########################################################################################
public function empty_in($x,$y,$width,$height,$color,$bgcolor,$bgimg,$txtcolor,$transparency,$txt,$url,$url_title)
	{//Box principal
	//position
	if (($x!='')and($y!=''))$position = "position:absolute;left:$x;top:$y;";
	else $position = 'position:auto;float:left;';
	//dimension
	$dimension="width:$width px;height:$height px;";
	//backgroundcolor
	if($color!='')$backgroundcolor="background-color:$color;";
	else $backgroundcolor="";
	//bg_img
	if($bgimg!='')$bg_img="background-image:url($bgimg);";
	else $bg_img='';
	//txt_color
	if($txtcolor!='')$txt_color="color:$txtcolor;";
	else $txt_color="";
	
	//transparence
	if($transparency>0 and $transparency<101)$transparence="-moz-opacity:".($transparency/100).";opacity: ".($transparency/100).";filter:alpha(opacity=".$transparency.");";
	else $transparence="";
	//$transparence="-moz-opacity:".($transparency/100).";opacity: ".($transparency/100).";filter:alpha(opacity=".$transparency.");";
	if($url!='')echo "<a href='$url'>";
	echo "<div style='";
	echo $position;
	echo $dimension;
	echo $backgroundcolor;
	echo $bg_img;
	echo $txt_color;
	echo "overflow:hidden;";
	echo $transparence;
	echo "'>";
	
	//Box d encrage
	echo "<div style='width:$width;height:$height;position:relative;'>";
	
	//Box central
	echo "<div style='width:$width px;height:$height px;position:absolute;left:0px;top:0px;overflow:auto;'>";
	
	//si entet box vide on n affiche pas 
	if ($txt!='')echo "<center><b>$txt</b></center>";
	}
##########################################################################################
public function empty_out($url)
	{
	echo "</div></div></div>";
	if($url!='')echo "</a>";
	}
}
?>
