<?php
class _javascript
	{
	public function help()
		{
		echo "<table border = 1 width=100% bgcolor='red' color='black'>";
		echo "<tr><td>Function</td><td>Parametres</td><td>Description</td></tr>";
		echo "<tr><td>encode_chiffre</td><td>(nom_variable,valeur_variable,url_retour)</td><td>Cette fonction permet de demander une valeur a encode en javascript et la renvoi vi url GET</td></tr>";
		echo "<tr><td>alert</td><td>(nom_variable,valeur_variable,url_retour)</td><td>Cette fonction permet de demander une valeur a encode en javascript et la renvoi vi url GET</td></tr>";
		echo "<tr><td>popup</td><td>(nom_variable,valeur_variable,url_retour)</td><td>Cette fonction permet de demander une valeur a encode en javascript et la renvoi vi url GET</td></tr>";
		echo "<tr><td>confirmation</td><td>(nom_variable,valeur_variable,url_retour)</td><td>Cette fonction permet de demander une valeur a encode en javascript et la renvoi vi url GET</td></tr>";
		echo "</table>";
		}
##########################################################################################################################
	public function full_screen()
		{
		echo "<body onload='fullscreen()'>"; 
		echo"<script>
		function fullscreen() 
			{
			docElm.mozRequestFullScreen();

			var docElm = document.documentElement;
			if (docElm.requestFullscreen) {
				docElm.requestFullscreen();
			}
			else if (docElm.mozRequestFullScreen) {
				docElm.mozRequestFullScreen();
			}
			else if (docElm.webkitRequestFullScreen) {
				docElm.webkitRequestFullScreen();
			}

			}
		</script>";
		}
##########################################################################################################################
	public function encode_text($label,$name_var,$val_act,$url_retour)
		{
		echo "<body onload='myFunction()'>"; 
		echo"<script>
		function myFunction() 
			{
			var person = prompt('$label', '$val_act');
			window.location.href = '".$url_retour."&$name_var=' + person; 
			}
		</script>";
		}
##########################################################################################################################
	public function encode_chiffre($name_var,$val_act,$url_retour)
		{
		echo "<body onload='myFunction()'>"; 
		echo"<script>
		function myFunction() 
			{
			var person = prompt('Entrez une valeur', '$val_act');
			window.location.href = '".$url_retour."&$name_var=' + person; 
			}
		</script>";
		}
##########################################################################################################################
	public function alert($msg)
		{
		echo"
		<script type='text/javascript'>
		alert('$msg')
		</script>
		";
		}
##########################################################################################################################
	public function alert_redirect($msg,$url,$delay)
		{
		echo"
		<script type='text/javascript'>
		alert('$msg')
		</script>";
		echo "<meta http-equiv='refresh' content='$delay; url=$url'/>";
		die();
		}
##########################################################################################################################
	public function alert_die($msg)
		{
		echo"
		<script type='text/javascript'>
		alert('$msg')
		</script>";
		die();
		}
##########################################################################################################################
	public function popup($x,$y,$height,$width,$url,$label)
		{
		echo"
		<SCRIPT LANGUAGE='JavaScript'>
			function popup()
			{
			window.open('$url','_blank','toolbar=0, location=0, directories=0, status=0, scrollbars=0, resizable=0, copyhistory=0, menuBar=0, width=$width, height=$height, left=$x, top=$y');
			}
		</SCRIPT>
		<A HREF='#' ONCLICK='popup()'>$label</A>
		";
		}
##########################################################################################
	public function confirmation($question,$url_yes,$url_no)
		{
		echo "<script>
			if (confirm('$question')) 
				{
				document.location.href='$url_yes';
				}
			else
				{
				document.location.href='$url_no';
				}
			</SCRIPT>";
		}
##########################################################################################
	public function cntdwn_old($count)
		{
		echo "
		<body onload='CountDown()'>
		<SCRIPT LANGUAGE='JavaScript'>
		var time=$count  //Changer ici le temps en seconde

		function CountDown()
			{
			if(time>0) 
				{
				document.s.Time.value=time	
				time=time-1
				setTimeout('CountDown()', 1000)
				}
			else 
				{
				document.s.Time.backgroundColor='green'	
				document.s.Time.value='0'
				}
			}
		</SCRIPT>
		<FORM name='s'><INPUT TYPE='text' NAME='Time' SIZE=5 disabled></FORM>
		";
		}
##########################################################################################
	public function cntdwn($count)
		{
		echo "<iframe src='iframe/timestamp_count.inc.php?count=$count' width='30' height='25' frameborder='0' scrolling='no'>";
		echo "</iframe>";
		}
	}
?>