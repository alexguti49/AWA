<?php

session_start();
	
	require 'cifrado.php';
	
		if(!isset($_SESSION["sesion_idusuario"])) {
			header('Location:index');
		}
		
		$sesion_idusuario = $_SESSION['sesion_idusuario'];
		$sesion_idtipo = $_SESSION['sesion_idtipo'];
	  
	$usuario = encrypt_decrypt('encrypt', $_POST['usuario']);
	
	if(!empty($usuario)) 
	{
	comprobar($usuario);
	}
	
	function comprobar($u) {
		 
		include 'conexion.php';   
		$sql = "SELECT * FROM usuarios WHERE usuario ='$u'";
		$rs = $mysqli->query($sql);
		$rows = $rs->num_rows;
		
		if($rows == 0) {
			echo "<span class='fa fa-check-circle' aria-hidden='true' title='Usuario disponible' style='font-weight:bold;color:#3c763d;margin-top:-5px;'>&nbsp;Disponible</span>";
		} else {
			echo "<span class='fa fa-times-circle' aria-hidden='true' title='Usuario no disponible' style='font-weight:bold;color:#a94442;margin-top:-5px;'>&nbsp;No Disponible</span>";
		}
	} 
?>