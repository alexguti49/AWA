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
		$foto 	= addslashes(file_get_contents($_FILES['_foto']['tmp_name']));
		
			$sql_Usuarios_mod=	"UPDATE usuarios 
								SET		foto ='$foto'
								WHERE 	idusuario ='$id'";
			$rs_Usuarios_mod = $mysqli->query($sql_Usuarios_mod);
			
			$sql_usuario = "SELECT * FROM usuarios WHERE idusuario = '$id'";
			$rs_usuario = $mysqli->query($sql_usuario);
			$row_usuario = $rs_usuario->fetch_assoc();
			
			$nick = encrypt_decrypt('decrypt', $row_usuario['usuario']);
			
				if($rs_Usuarios_mod > 0){
					$mensaje = "Foto de perfil del usuario: $nick, modificada correctamente.";
					echo "<script>";
					echo "if(confirm('$mensaje'));";  
					echo "window.location = 'usuarios_modificar?_id=$idc';";
					echo "</script>";
				} else {
					$mensaje = "Error al modificar foto de perfil del usuario: $nick.";
					echo "<script>";
					echo "if(confirm('$mensaje'));";  
					echo "history.back();";
					echo "</script>"; 
				}
?>				