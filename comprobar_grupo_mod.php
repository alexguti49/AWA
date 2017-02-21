<?php

session_start();
	
	require 'cifrado.php';
	
		if(!isset($_SESSION["sesion_idusuario"])) {
			header('Location:index');
		}
		
		$sesion_idusuario = $_SESSION['sesion_idusuario'];
		$sesion_idtipo = $_SESSION['sesion_idtipo'];

	$grupo = encrypt_decrypt('encrypt', $_POST['grupo']);
	$id = encrypt_decrypt('decrypt', $_POST['idgrupo']);
	
	if(!empty($grupo) && !empty($id)) {
	  comprobar($grupo, $id);
	}
	
	function comprobar($g, $i) { 
		$sesion_idusuario = $_SESSION['sesion_idusuario'];   
		
		include 'conexion.php';
		$sql = "SELECT * FROM grupos WHERE grupo = '$g' AND idgrupo != '$i' AND idusuario = '$sesion_idusuario'";
		$rs = $mysqli->query($sql);
		$rows = $rs->num_rows;
		 
		if($rows == 0) {
			echo "<span class='fa fa-check-circle' aria-hidden='true' title='Nombre de grupo disponible' style='font-weight:bold; color:#3c763d; margin-top:-5px;'>&nbsp;Disponible</span>";
		} else {
			echo "<span class='fa fa-times-circle' aria-hidden='true' title='Nombre de grupo no disponible' style='font-weight:bold; color:#a94442; margin-top:-5px;'>&nbsp;No Disponible</span>";
		}
	}
?>