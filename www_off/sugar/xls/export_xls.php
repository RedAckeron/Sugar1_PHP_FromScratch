<?php
//header_remove("X-Foo"); 
header("Content-type:   application/x-msexcel; charset=utf-8");
header("Content-Disposition: attachment; filename=customer_list.xls"); 

$cust_tmp=db_read("$rqt");
echo "
<br>
<table border=1>
<tr><th>Id</th><th>Prenom</th><th>Nom</th><th>Call 1</th><th>Call 2</th><th>Email</th><th>Adresse</th><th>Code postal</th><th>Ville</th><th>Date d inscription</th><th>Technicien</th></tr>";
	while($cust = $cust_tmp->fetch())
		{
		$name_tech=db_single_read("select * from user where id = $cust->tech_in");
		echo "<tr><td>$cust->id</td><td>$cust->prenom</td><td>$cust->nom</td><td>$cust->call1</td><td>$cust->call2</td><td>$cust->mail</td><td>$cust->adresse</td><td>$cust->cp</td><td>$cust->ville</td><td>".date("d/m/y h:i",$cust->dt_insert)."</td><td>$name_tech->prenom $name_tech->nom</td></tr>";
		}
echo "</table>";

?>