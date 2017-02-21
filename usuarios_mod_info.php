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
		$usuario	= strtoupper($mysqli->real_escape_string($_POST['_usuario']));
		$nombre		= ucwords(strtolower($mysqli->real_escape_string($_POST['_nombre'])));
		$apellido	= ucwords(strtolower($mysqli->real_escape_string($_POST['_apellido'])));
		$email		= strtolower(mysqli_real_escape_string($mysqli,$_POST['_email']));
		$sexo		= $mysqli->real_escape_string($_POST['_sexo']);
	
	if($_SESSION['sesion_idtipo']==1) {
		$estado		= $mysqli->real_escape_string($_POST['_estado']);
		$idtipo		= $mysqli->real_escape_string($_POST['_idtipo']);
	}
			$usuario_cifrado 	= encrypt_decrypt('encrypt', $usuario);
			$nombre_cifrado 	= encrypt_decrypt('encrypt', $nombre);
			$apellido_cifrado	= encrypt_decrypt('encrypt', $apellido);
			$email_cifrado		= encrypt_decrypt('encrypt', $email);
			
		$sql_Usuario_val 	= "SELECT * FROM usuarios WHERE usuario = '$usuario_cifrado' AND idusuario != '$id'"; 
		$rs_Usuario_val		= $mysqli->query($sql_Usuario_val);
		$rows_Usuario_val	= $rs_Usuario_val->num_rows;
		$row_Usuario_val	= $rs_Usuario_val->fetch_assoc();
		
		if($rows_Usuario_val > 0) 
		{ 
			$nick = encrypt_decrypt('decrypt', $row_Usuario_val['usuario']);
			$mensaje = "Error al modificar informacion del usuario. El usuario: $nick ya existe, no esta disponible.";
			echo "<script>";
			echo "alert('$mensaje');";
			echo "window.location='usuarios_modificar?_id=$idc';";
			echo "</script>";			
		} 
		else 
		{
		if($_SESSION['sesion_idtipo']==1) { 
			$sql_Usuarios_mod=	"UPDATE usuarios 
								SET		usuario	='$usuario_cifrado', 
										nombre	='$nombre_cifrado', 
										apellido='$apellido_cifrado',
										email	='$email_cifrado',
										sexo 	='$sexo',
										estado	='$estado',
										idtipo	='$idtipo'
										WHERE idusuario ='$id'";
			$rs_Usuarios_mod = $mysqli->query($sql_Usuarios_mod);
       	}else {
			$sql_Usuarios_mod=	"UPDATE usuarios 
								SET		usuario	='$usuario_cifrado', 
										nombre	='$nombre_cifrado', 
										apellido='$apellido_cifrado',
										email	='$email_cifrado',
										sexo 	='$sexo'
										WHERE idusuario ='$id'";
			$rs_Usuarios_mod = $mysqli->query($sql_Usuarios_mod);
		}
			
			$nick = encrypt_decrypt('decrypt', $usuario_cifrado);	
			
			if($rs_Usuarios_mod > 0)
			{
				$mensaje = "Informacion del usuario: $nick, modificada correctamente.";
				echo "<script>";
				echo "alert('$mensaje');";
				echo "window.location='usuarios_modificar?_id=$idc';";
				echo "</script>";
				
			}
			else {
				$mensaje = "Error al modificar informacion del usuario: $nick.";
				echo "<script>";
				echo "alert('$mensaje');";
				echo "window.location='usuarios_modificar?_id=$idc';";
				echo "</script>";
			}
		}
/*?>
<html>
	<head>
		<title>Modificar usuario</title>
	</head>
		<body>
			<?php 
				if($rs_Usuarios_mod > 0){
				?>
				<h1>Usuario Modificado</h1>
				<?php } 
				else { ?>
				<h1>Error al Modificar Usuario</h1>
				<?php } ?>
			<a href="ver_usuario.php">Regresar</a>
		</body>
</html>*/
?>				
				