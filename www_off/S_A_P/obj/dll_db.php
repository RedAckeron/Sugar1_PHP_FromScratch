<?php




function db_read($db,$rqt)
	{
	try 
		{
		$servername = "localhost";
		$username = "root";
		$password = "pi";
		$conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//echo "Connected successfully";
		$qry = $conn->query ($rqt);
		$qry->setFetchMode(PDO::FETCH_OBJ); // on dit qu'on veut que le r�sultat soit r�cup�rable sous forme d'objet
		return $qry;
		$qry->closeCursor(); // on ferme le curseur des r�sultats
		}
	catch(PDOException $e)
		{
		echo "Connection failed: " . $e->getMessage();
		}
	}

function db_single_read($db,$rqt)
	{
	try {
		$servername = "localhost";
		$username = "root";
		$password = "pi";
		$conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//echo "Connected successfully";
		$qry = $conn->query ($rqt);
		$qry->setFetchMode(PDO::FETCH_OBJ); // on dit qu'on veut que le r�sultat soit r�cup�rable sous forme d'objet
		$qry_tmp = $qry->fetch();
		return $qry_tmp;
		$qry->closeCursor(); // on ferme le curseur des r�sultats
		}
	catch(PDOException $e)
		{
		echo "Connection failed: " . $e->getMessage();
		}
	}

function db_write($db,$rqt)
	{
	try {
		$servername = "localhost";
		$username = "root";
		$password = "pi";
		$conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//echo "Connected successfully";
		$qry = $conn->query ($rqt);
		//$qry->closeCursor(); // on ferme le curseur des r�sultats
		}
	catch(PDOException $e)
		{
		echo "Connection failed: " . $e->getMessage();
		}
	}










/*

function db_read($db,$rqt)
	{
	try	{$db = new PDO("sqlite:../../www_off/$db", '', '');}
	catch(Exception $e){die('Erreur : '.$e->getMessage());}
	$db->query("PRAGMA synchronous = ON;");
	$qry=$db->query($rqt); // on va chercher tous les enregistrements
	$qry->setFetchMode(PDO::FETCH_OBJ); // on dit qu'on veut que le r�sultat soit r�cup�rable sous forme d'objet
	return $qry;
	$qry->closeCursor(); // on ferme le curseur des r�sultats
	}
function db_single_read($db,$rqt)
	{
	try	{$db = new PDO("sqlite:../../www_off/$db", '', '');}
	catch(Exception $e){die('Erreur : '.$e->getMessage());}
	$db->query("PRAGMA synchronous = ON;");
	$qry=$db->query($rqt); // on va chercher tous les enregistrements
	$qry->setFetchMode(PDO::FETCH_OBJ); // on dit qu'on veut que le r�sultat soit r�cup�rable sous forme d'objet
	$qry_tmp = $qry->fetch();
	return $qry_tmp;
	$qry->closeCursor(); // on ferme le curseur des r�sultats
	}

function db_write($db,$rqt)
	{
	try	{$db = new PDO("sqlite:../../www_off/$db", '', '');}
	catch(Exception $e){die('Erreur : '.$e->getMessage());}
	$db->query("PRAGMA synchronous = OFF;");
	$qry=$db->exec($rqt); // on va chercher tous les enregistrements
	//$qry->closeCursor(); // on ferme le curseur des r�sultats
	}
*/
?>