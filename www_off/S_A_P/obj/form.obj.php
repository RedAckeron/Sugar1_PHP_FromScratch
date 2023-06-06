<?php
class _form
	{
##########################################################################################
	public function help()
		{
		echo "<table border = 1 width=100% bgcolor='red' color='black'>";
		echo "<tr><td>Function</td><td>Parametres</td><td>Description</td></tr>";
		echo "<tr><td>open</td><td>(url,method)</td><td>Ouverture du formulaire on choisis GET ou POST comme methode d envoi</td></tr>";
		echo "<tr><td>close</td><td>()</td><td>Fermeture du formulaire</td></tr>";
		echo "<tr><td>select_in</td><td>(name,size)</td><td>debut de menu deroulant name c est le nom de menu deoulant et siza le nombre de ligne du menu</td></tr>";
		echo "<tr><td>select_option</td><td>(name,value,actuel)</td><td>option du menu deroulant name=nom afficher dans menu value = valeur de l option et selected faut il pointer dessus ou non</td></tr>";
		echo "<tr><td>select_out</td><td>()</td><td>Fermeture du formulaire</td></tr>";
		echo "<tr><td>send</td><td>(nom)</td><td>Boutton pour envoyer formulaire name=nom sur le boutton</td></tr>";
		echo "<tr><td>text</td><td>(name,size,value)</td><td>formulaire text nom du champs size:largeur de la case , value=valeur dans le champs</td></tr>";
		echo "<tr><td>text_disabled</td><td>(name,size,value)</td><td>Formulaire text non modifiable</td></tr>";
		echo "<tr><td>textarea</td><td>(name,rows,cols,value)</td><td>Zone de text editable en hauteur et en largeur</td></tr>";
		echo "<tr><td>hidden</td><td>(name,value)</td><td>Zone de text editable en hauteur et en largeur</td></tr>";
		echo "</table>";
		}
##########################################################################################
	public function open($url,$method)
		{
		echo "<form action='$url' method='$method'>";
		}
##########################################################################################
	public function close()
		{
		echo "</form>";
		}
##########################################################################################
	public function select_in($name,$size)
		{
		echo"<select name='$name' size='$size'>";
		}
##########################################################################################
	public function select_option($name,$value,$actuel)
		{
		if (($value==$actuel)and($actuel!=''))echo("<option value='$value'selected>*$name</option>");
		else echo("<option value='$value'>$name</option>");
		}
##########################################################################################
	public function select_out()
		{
		echo"</select>";
		}
##########################################################################################
	public function text($name,$size,$value)
		{
		echo "<input type='text' name='$name' size='$size' value='$value'>";
		}
##########################################################################################
	public function text_disabled($name,$size,$value)
		{
		echo "<input type='text' name='$name' size='$size' value='$value' disabled>";
		}
##########################################################################################
	public function text_readonly($name,$size,$value)
		{
		echo "<input type='text' name='$name' size='$size' value='$value' readonly>";
		}
##########################################################################################
	public function password($name,$size)
		{
		echo "<input type='password' name='$name' size='$size'>";
		}
##########################################################################################
	public function textarea($name,$rows,$cols,$value)
		{
		echo"<textarea name='$name' rows='$rows' cols='$cols'>$value</textarea>";
		}
##########################################################################################
	public function textarea_disabled($name,$rows,$cols,$value)
		{
		echo"<textarea name='$name' rows='$rows' cols='$cols' disabled>$value</textarea>";
		}
##########################################################################################
	public function textarea_readonly($name,$rows,$cols,$value)
		{
		echo"<textarea name='$name' rows='$rows' cols='$cols' readonly>$value</textarea>";
		}
##########################################################################################
	public function hidden($name,$value)
		{
		echo"<input type='hidden' name='$name' value='$value'>";
		}
##########################################################################################
	public function check_box($name,$value,$checked)
		{
	echo "<input type='checkbox' name='$name' value='$value' $checked>";
		}
	
##########################################################################################
	public function list_count($title,$nom,$count)
		{
		echo"$title<select name='$nom' size='1'>";
		for($i=1;$i<=$count;$i++)echo("<option value='$i'>$i</option>");
		echo"</select>";
		}
##########################################################################################
	public function count_min_max($nom,$min,$max)
		{
		echo"<select name='$nom' size='1'>";
		for($i=$min;$i<=$max;$i++)echo("<option value='$i'>$i</option>");
		echo"</select>";
		}
##########################################################################################
	public function list_day($d)
		{
		echo"<select name='$d' size='1'>";
		for($i=1;$i<=31;$i++)
			if ($i==date('d'))echo("<option value='$i'selected>$i</option>");
			else echo("<option value='$i'>$i</option>");
		echo"</select>";
		}
##########################################################################################
	public function list_month($m)
		{
		echo"<select name='$m' size='1'>";
		for($i=1;$i<=12;$i++)
			{
			if ($i==date('n'))echo "<option value='$i'selected>$i</option>";
				else echo "<option value='$i'>$i</option>";
			}
		echo "</select>";
		}
##########################################################################################
	public function list_year($name,$size,$y_min,$y_max)
		{
		echo"<select name='$name' size='$size'>";
			for($i=$y_min;$i<=$y_max;$i++)
				{
				if ($i == date('Y')) echo("<option value='$i'selected>$i</option>");
				else echo("<option value='$i'>$i</option>");
				}
		echo"</select>";
		}
##########################################################################################
	public function send($name)
		{
		echo"<input type='submit' value='$name'>";
		}
	}
?>