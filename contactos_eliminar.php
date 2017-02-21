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
		
		$id = "0";
		if (isset($_GET['_id'])) { $id = encrypt_decrypt('decrypt', $_GET['_id']); }
				
	$sql_user = "SELECT * FROM usuarios WHERE idusuario = $sesion_idusuario";
	$rs_user = $mysqli->query($sql_user);
	$row_user = $rs_user->fetch_assoc();
	
	/*-------------------------------------------------------*/
	$sql_contacto = "SELECT * 
					FROM 	contactos, grupos 
					WHERE 	contactos.idgrupo = grupos.idgrupo 
					AND		contactos.idcontacto = '$id'";
	$rs_contacto = $mysqli->query($sql_contacto);
	$row_contacto = $rs_contacto->fetch_assoc();
	//$rows_grupo = $rs_grupo->num_rows;
	/*-------------------------------------------------------*/ 
	
if($row_contacto['idusuario']==$row_user['idusuario'] || $sesion_idtipo==1){ 

	$sql_Contactos_eli 	= "DELETE FROM contactos WHERE idcontacto='$id'";
	$rs_Contactos_eli	= $mysqli->query($sql_Contactos_eli);
	
		$nombre = encrypt_decrypt('decrypt', $row_contacto['nombre']);
		$apellido = encrypt_decrypt('decrypt', $row_contacto['apellido']);
		
		if($rs_Contactos_eli > 0)
		{
			$mensaje = "Contacto: $nombre $apellido eliminado correctamente.";
			echo "<script>";
			echo "alert('$mensaje');";
			echo "window.location = 'contactos';";
			echo "</script>";
		}
		else 
		{
			$mensaje = "Error al eliminar contacto: $nombre $apellido.";
			echo "<script>";
			echo "alert('$mensaje');";
			echo "window.location = 'contactos';";
			echo "</script>"; 
		}
} else { 
	$mensaje = "Acceso denegado.";
	echo "<script>";
	echo "alert('$mensaje');";
	echo "window.location='contactos';";
	//echo "history.go(-1);";				
	echo "</script>";
}

?>