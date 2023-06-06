<?php
function db_read($rqt)
	{
	try 
		{
		//on verifie si on est sur le server Local ou en ligne et on charge la db approprié
		if($_SERVER['HTTP_HOST']=='devil.kprod.ovh')$conn = new PDO("mysql:host=localhost;dbname=sugar;", 'root', 'pi');
		else $conn = new PDO("mysql:host=df14394-002.privatesql;dbname=sugar;port=35803;", 'redlife', 'N0v0ffice');
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

function db_single_read($rqt)
	{
	try {
		//on verifie si on est sur le server Local ou en ligne et on charge la db approprié
		if($_SERVER['HTTP_HOST']=='devil.kprod.ovh')$conn = new PDO("mysql:host=localhost;dbname=sugar;", 'root', 'pi');
		else $conn = new PDO("mysql:host=df14394-002.privatesql;dbname=sugar;port=35803;", 'redlife', 'N0v0ffice');
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

function db_write($rqt)
	{
	try {
		//on verifie si on est sur le server Local ou en ligne et on charge la db approprié
		if($_SERVER['HTTP_HOST']=='devil.kprod.ovh')$conn = new PDO("mysql:host=localhost;dbname=sugar;", 'root', 'pi');
		else $conn = new PDO("mysql:host=df14394-002.privatesql;dbname=sugar;port=35803;", 'redlife', 'N0v0ffice');
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
?>