<?php declare(strict_types=1); // włączenie typowania zmiennych
session_start();
if (!isset($_SESSION['loggedin']))
{
	header('Location: login.php');
	exit();
}

	$dbhost=""; $dbuser=""; $dbpassword=""; $dbname="";
	$link = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
	if (!$link)
	{
		echo " MySQL Connection error." . PHP_EOL;
		echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}
	
	$idpl = $_POST['addto'];
	$idf = $_POST['idf'];
	
	$add_sql = "INSERT INTO playlistdatabase(idpl, idf) VALUES('$idpl', '$idf')";
	mysqli_query($link, $add_sql);
	
	mysqli_close($link);
	header('Location: portal.php');
?>