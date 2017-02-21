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
	$sql_grupo = "SELECT * FROM grupos WHERE idgrupo = '$id'";
	$rs_grupo = $mysqli->query($sql_grupo);
	$row_grupo = $rs_grupo->fetch_assoc();
	//$rows_grupo = $rs_grupo->num_rows;
	/*-------------------------------------------------------*/ 
	 
if($row_grupo['idusuario']==$row_user['idusuario'] || $sesion_idtipo==1){
	
	$sql_Grupos_eli = "DELETE FROM grupos WHERE idgrupo='$id'";
	$rs_Grupos_eli	= $mysqli->query($sql_Grupos_eli);
	
	$grupo = encrypt_decrypt('decrypt', $row_grupo['grupo']);
		
	if($rs_Grupos_eli > 0) {
		$mensaje = "Informacion del grupo: $grupo eliminada correctamente.";
		echo "<script>";
		echo "alert('$mensaje');";
		echo "window.location = 'grupos';";
		echo "</script>";
	} else {
		$mensaje = "Error al eliminar informacion del grupo: $grupo.";
		echo "<script>";
		echo "alert('$mensaje');";
		echo "window.location = 'grupos';";
		echo "</script>"; 
	}
} else { 
	$mensaje = "Acceso denegado.";
	echo "<script>";
	echo "alert('$mensaje');";
	echo "window.location='grupos';";
	//echo "history.go(-1);";				
	echo "</script>";
}
?>