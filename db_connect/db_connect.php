<?php


	$hostname = "localhost";
	$username = "root";
	$password = "";

	$mysqli = mysqli_connect($hostname , $username , $password , "codeigniter_equipment_db");
	if(mysqli_connect_error()){
		echo mysqli_connnect_error();
	}

	$mysqli->set_charset("utf8");

?>