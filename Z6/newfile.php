<?php
session_start();
if (!isset($_SESSION['loggedin']))
{
	header('Location: login.php');
	exit();
}

if (file_exists($_FILES["file"]["tmp_name"]))
{
	$dbhost=""; $dbuser=""; $dbpassword=""; $dbname="";
	$connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
	if (!$connection)
	{
		echo " MySQL Connection error." . PHP_EOL;
		echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}

	$file_name = $_FILES["file"]["name"];
	$file_extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION); //rozszerzenie dodawanego pliku
	$idu = $_SESSION['idu'];
	$datetime = date('Y-m-d H:i:s');

	//przetwarzanie plikow
	if($file_extension == "mp4"){
		$target_location = "films/" . $file_name; //lokacja docelowa nowego pliku
		move_uploaded_file($_FILES["file"]["tmp_name"], $target_location); //przeniesienie nowego pliku
		$title = $_POST['title'];
		$director = $_POST['director'];
		$type = $_POST['type'];
		$subtitles = $_POST['subtitles'];
		$addfile_sql = mysqli_query($connection, "INSERT INTO film (title, director, datetime, idu, filename, subtitles, idft) 
		VALUES ('$title', '$director', '$datetime', '$idu', '$file_name', '$subtitles', '$type');") or die ("DB error: $dbname");
	
		mysqli_close($connection);
	}else{
		echo "Proszę przesłać plik mp4!<br><a href='portal.php'>Wróc do portalu</a>";
	}
}
header ('Location: portal.php');
?>