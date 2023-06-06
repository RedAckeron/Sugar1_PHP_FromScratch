<?php
class _gfx
	{
	##########################################################################################################################
	public function help()
		{
		echo "<table border = 1 width=100% bgcolor='red' color='black'>";
		echo "<tr><td>Function</td><td>Parametres</td><td>Description</td></tr>";
		echo "<tr><td>put_pix</td><td>(x,y,width,height,name,img,url)</td><td>Cette fonction insert une image a l ecran au coordonée X Y</td></tr>";//put_pix
		echo "<tr><td>put_pix_color</td><td>(x,y,size,name,color,url)</td><td>Cette fonction insert un carré de couleur a l ecran au coordonée X Y</td></tr>";//put_pix_color
		echo "</table>";
		}
##########################################################################################################################
	public function put_pix($x,$y,$width,$height,$name,$img,$url)
		{
		if($url!='')echo "<a href='$url' title='$name'>";
		echo"<div 
			style='position:absolute; 
			left:$x"."px;
			top:$y"."px;
			width:".$width."px;
			height:".$height."px;
			overflow:none;
 			background-image:url($img);
			'>";
		echo "</div>";
		if($url!='')echo "</a>";
		}

##########################################################################################
	public function put_pix_color($x,$y,$size,$name,$color,$url)
		{
		if($url!='')echo "<a href='$url' title='$name'>";
		echo"<div 
			style='position:absolute; 
			left:$x"."px;
			top:$y"."px;
			width:".$size."px;
			height:".$size."px;
			overflow:none;
 			background-color:$color;
			'>";
		echo "</div>";
		if($url!='')echo "</a>";
		}
##########################################################################################
	}

/*

##########################################################################################
function show_pct_box($val_go,$val_end,$val_del,$size)
	{
	if ($val_del<=ts())
		{
		echo "<br><br><br><br>";
		echo "<div style='height:5px;width:".(100*$size)."px;background-color:grey;'></div>";
		}
	else
		{
		$total=$val_end-$val_go;
		$now=$val_end-ts();
		$now=(($now/$total)*100);
		$total=(($total/$total)*100);
		if(100-$now>=100)
			{
			echo "<br><br><br><br>";
			echo "<div style='height:5px;width:".($total*$size)."px;background-color:blue;'>";
			echo "<div style='float:right;height:5px;width:".($now*$size)."px;background-color:blue;'>";
			echo "</div>";
			echo "</div>";
			}
		else
			{
			echo "<br><br><br><br>";
			echo "<div style='height:5px;width:".($total*$size)."px;background-color:green;'>";
			echo "<div style='float:right;height:5px;width:".($now*$size)."px;background-color:red;'>";
			echo "</div>";
			echo "</div>";
			}
		}
	}
##########################################################################################
function show_pct_box_0($x,$y,$width,$height,$pct,$pct_ttl,$color_total,$color_curent)
	{
	if ($pct>$pct_ttl)$pct=$pct_ttl;
	$val=($pct/$pct_ttl)*$width;
	$val_ttl=($pct_ttl/$pct_ttl)*$width;
	echo "<div style='position:absolute;top:$y;left:$x;height:".$height."px;width:".$val_ttl."px;background-color:$color_total;'></div>";
	echo "<div style='position:absolute;top:$y;left:$x;height:".$height."px;width:".$val."px;background-color:$color_curent;'></div>";
	}
##########################################################################################
function show_pct_box_1($val_go,$val_end,$val_del,$size)
	{
	if ($val_del<=ts())
		{
		echo "<div style='height:5px;width:".(100*$size)."px;background-color:grey;'></div>";
		}
	else
		{
		$total=$val_end-$val_go;
		$now=$val_end-ts();
		$now=(($now/$total)*100);
		$total=(($total/$total)*100);
		if(100-$now>=100)
			{
			echo "<div style='height:5px;width:".($total*$size)."px;background-color:blue;'>";
			echo "<div style='float:right;height:5px;width:".($now*$size)."px;background-color:blue;'>";
			echo "</div>";
			echo "</div>";
			}
		else
			{
			echo "<div style='height:5px;width:".($total*$size)."px;background-color:green;'>";
			echo "<div style='float:right;height:5px;width:".($now*$size)."px;background-color:red;'>";
			echo "</div>";
			echo "</div>";
			}
		}
	}
##########################################################################################
function show_pct_box_2($loc_x,$loc_y,$width,$height,$col_in,$col_out,$col_end,$col_del,$val_go,$val_end,$val_del)
	{
	// loc_x loc_y width height  position et taille du cadre
	// col_in col_out col_end col_del les couleur couleur de partie libre occuper quand fini et quand obsolete 
	// val_go val_end val_del valeur de debut de fin et de supression
	$total=$val_end-$val_go;
	$now=$val_end-ts();
	$now=(($now/$total)*$width);
	$total=(($total/$total)*$width);

	if ((ts()>($val_go))and(ts()<$val_end))
		{
		echo "<div style='height:".$height."px;width:".$total."px;background-color:green;position:absolute;left:".$loc_x."px;top:".$loc_y."px;'>
						<div style='float:right;height:".$height."px;width:".$now."px;background-color:red;'></div></div>";
		}
	if ((ts()>=$val_end)and(ts()<$val_del))
		{
		echo "<div style='height:".$height."px;width:".$width."px;background-color:blue;position:absolute;left:".$loc_x."px;top:".$loc_y."px;'></div>";
		}
	if (ts()>=$val_del)
		{
		echo "<div style='height:".$height."px;width:".$width."px;background-color:grey;position:absolute;left:".$loc_x."px;top:".$loc_y."px;'></div>";
		}
	}
	*/
?>
