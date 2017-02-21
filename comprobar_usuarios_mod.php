<?php

session_start();
	
	require 'cifrado.php';
	
		if(!isset($_SESSION["sesion_idusuario"])) {
			header('Location:index');
		}
		
		$sesion_idusuario = $_SESSION['sesion_idusuario'];
		$sesion_idtipo = $_SESSION['sesion_idtipo'];
	
	$usuario = encrypt_decrypt('encrypt', $_POST['usuario']);
	$id = encrypt_decrypt('decrypt', $_POST['idusuario']);
	
	if(!empty($usuario) && !empty($id)) {
	  comprobar_mod($usuario, $id);
	}
	
	function comprobar_mod($u, $i) { 
		include 'conexion.php'; 		
		$sql = "SELECT * FROM usuarios WHERE usuario ='$u' AND idusuario != '$i'";
		$rs = $mysqli->query($sql);
		$rows = $rs->num_rows;
		 
		if($rows == 0)
		{
			echo "<span class='fa fa-check-circle' aria-hidden='true' title='Usuario disponible' style='font-weight:bold;color:#3c763d;margin-top:-5px;'>&nbsp;Disponible</span>";
		}
		else
		{
			echo "<span class='fa fa-times-circle' aria-hidden='true' title='Usuario no disponible' style='font-weight:bold;color:#a94442;margin-top:-5px;'>&nbsp;No Disponible</span>";
		}
	} 
/************************************** MODIICAR **************************************************/	     
?>