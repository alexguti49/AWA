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
	
		$idc 	= $mysqli->real_escape_string($_POST['_id']);
		$id 	= encrypt_decrypt('decrypt',$idc);
		$foto 	= ""; 
		
			$sql_usuario = "SELECT * FROM usuarios WHERE idusuario = '$id'";
			$rs_usuario = $mysqli->query($sql_usuario);
			$row_usuario = $rs_usuario->fetch_assoc();
			
			$nick = encrypt_decrypt('decrypt', $row_usuario['usuario']);
		
			$sql_Usuarios_eli	= "UPDATE usuarios SET foto ='$foto' WHERE idusuario ='$id'";
			$rs_Usuarios_eli 	= $mysqli->query($sql_Usuarios_eli);
			
				if($rs_Usuarios_eli > 0)
				{
					$mensaje = "Foto de perfil del usuario: $nick, eliminada correctamente.";
					echo "<script>";
					echo "alert('$mensaje');";  
					echo "window.location='usuarios_modificar?_id=$idc';";
					echo "</script>";
				}
				else 
				{
					$mensaje = "Error al eliminar foto de perfil del usuario: $nick.";
					echo "<script>";
					echo "alert('$mensaje');";  
					echo "history.back();";
					echo "</script>"; 
				}
			
/*?>
<html>
	<head>
		<!--<title>Modificar usuario</title>-->
	</head>
		<body>
			<?php 
				if($rs_Usuarios_edi > 0){
				?>
				<script type=text/javascript>	alert("Usuario Modificado");	</script>
                <!--<h1>Usuario Modificado</h1>-->
                <?php  } 
				else { ?>
                <script type=text/javascript>	alert("Usuario NO Modificado");	</script>
				<!--<h1>Error al Modificar Usuario</h1>-->
				<?php } ?>
				<!--<a href="ver_usuario.php">Regresar</a>-->
		</body>
</html>*/
?>				