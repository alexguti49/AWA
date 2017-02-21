<?php 

session_start();
	
	require 'conexion.php';
	require 'cifrado.php';
	
		if(!isset($_SESSION["sesion_idusuario"]))
		{
			header('Location:index');
		}
		
		$sesion_idusuario = $_SESSION['sesion_idusuario'];
		$sesion_idtipo = $_SESSION['sesion_idtipo'];	
		
	$mensaje = '';
	$id = "0";
	
	if (isset($_GET['_id'])) { $id = encrypt_decrypt('decrypt', $_GET['_id']); }
	
	/*-----------------------------------------------------------------*/
	$sql_user = "SELECT * FROM usuarios WHERE idusuario = '$sesion_idusuario'";
	$rs_user = $mysqli->query($sql_user);
	$row_user = $rs_user->fetch_assoc();
	//$rows_user = $rs_user->num_rows();
	/*-----------------------------------------------------------------*/
	
	/*-------------------------------------------------------------*/
	$sql_usuario = "SELECT * FROM usuarios WHERE idusuario = '$id'";
	$rs_usuario = $mysqli->query($sql_usuario);
	$row_usuario = $rs_usuario->fetch_assoc();
	$rows_usuario = $rs_usuario->num_rows;
	/*-------------------------------------------------------------*/
	
	$usuario = encrypt_decrypt('decrypt', $row_usuario['usuario']);
	
	if(($row_usuario['idusuario']==$row_user['idusuario'] || $sesion_idtipo==1) && ($row_usuario['idtipo']!=1)){
				 
		$sql_Usuarios_eli 	= "DELETE FROM usuarios WHERE idusuario='$id'";
		$rs_Usuarios_eli	= $mysqli->query($sql_Usuarios_eli);
	
		if($rs_Usuarios_eli > 0) {
			if($sesion_idtipo==1){ 
				$mensaje = "Usuario: $usuario eliminado correctamente.";
				echo "<script>";
				echo "alert('$mensaje');";
				echo "window.location='usuarios';";
				echo "</script>";
			} else { 
				$mensaje = "Usuario: $usuario eliminado correctamente.";
				echo "<script>";
				echo "alert('$mensaje');";
				echo "window.location='salir';";
				echo "</script>";	
			}
		} else {
			$mensaje = "Error al eliminar usuario: $usuario.";
			echo "<script>";
			echo "alert('$mensaje');";
			echo "history.back();";
			echo "</script>";		
		}
	} else {
		$mensaje = "Acceso denegado.";
		echo "<script>";
		echo "alert('$mensaje');";
		echo "history.back();";
		echo "</script>";
	} 
?>