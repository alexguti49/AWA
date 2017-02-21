<?php
	
$host 		= "127.0.0.1";
$db 		= "u842143985_awa";
$user 		= "root"; // u842143985_awa
$pass 		= ""; // AlexWeb91
$mysqli 	= new MySQLi("$host","$user","$pass","$db");
//$conexion	= mysqli_connect("$host","$user","$pass","$db");
		
	if(mysqli_connect_errno()){
		echo 'Conexion Fallida : ', mysqli_connect_error();
		exit();
	}
?>