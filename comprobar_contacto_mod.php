<?php

session_start();
	
	require 'cifrado.php';
	
		if(!isset($_SESSION["sesion_idusuario"])) {
			header('Location:index');
		}
		
		$sesion_idusuario = $_SESSION['sesion_idusuario'];
		$sesion_idtipo = $_SESSION['sesion_idtipo'];

	$celular = encrypt_decrypt('encrypt', $_POST['celular']);
	$idgrupo = encrypt_decrypt('decrypt', $_POST['idgrupo']);
	$idcontacto = encrypt_decrypt('decrypt', $_POST['idcontacto']);
			  
	if(!empty($celular) && !empty($idgrupo) && !empty($idcontacto)) {
	  comprobar($celular, $idgrupo, $idcontacto);
	}
	   
	function comprobar($c, $i, $id) { 
		$sesion_idusuario = $_SESSION['sesion_idusuario'];  
		
		include 'conexion.php';
		$sql = 	"SELECT * 
				FROM 	contactos, grupos 
				WHERE 	contactos.celular = '$c' 
				AND 	contactos.idgrupo = '$i'
				AND 	contactos.idcontacto != '$id'
				AND 	grupos.idgrupo = contactos.idgrupo 
				AND 	grupos.idusuario = '$sesion_idusuario'";
		$rs = $mysqli->query($sql);
		$rows = $rs->num_rows;
		 
		if($rows == 0) {
			echo "<span class='fa fa-check-circle' aria-hidden='true' title='Celular disponible' style='font-weight:bold; color:#3c763d; margin-top:-5px;'>&nbsp;Disponible</span>";
		} else {
			echo "<span class='fa fa-times-circle' aria-hidden='true' title='Celular no disponible' style='font-weight:bold; color:#a94442; margin-top:-5px;'>&nbsp;No Disponible</span>";
		}
	}
?>