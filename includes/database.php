<?php

$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "login";

$connection = mysqli_connect($dbHost,$dbUser,$dbPass,$dbName);

	if(!$connection){
		die("Error");
	}
?>