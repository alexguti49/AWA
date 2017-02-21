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
		
		$sql_user = "SELECT * FROM usuarios WHERE idusuario = $sesion_idusuario";
		$rs_user = $mysqli->query($sql_user);
		$row_user = $rs_user->fetch_assoc();
	
		$idc = $mysqli->real_escape_string($_POST['_id']);
		$id = encrypt_decrypt('decrypt', $idc);
		$grupo	= strtoupper($mysqli->real_escape_string($_POST['_grupo']));
		$descripcion = ucfirst(strtolower($_POST['_descripcion']));
		$estado	= $mysqli->real_escape_string($_POST['_estado']);
		if(empty($_POST['_idusuario'])){ $idusuario = $sesion_idusuario; }  else { $idusuario = $_POST['_idusuario']; }
	
			$grupo_cifrado = encrypt_decrypt('encrypt', $grupo);
			$descripcion_cifrado = encrypt_decrypt('encrypt', $descripcion);
			
		$sql_Grupo_val = "SELECT * FROM grupos WHERE grupo = '$grupo_cifrado' AND idgrupo != '$id'"; 
		$rs_Grupo_val = $mysqli->query($sql_Grupo_val);
		$row_Grupo_val = $rs_Grupo_val->fetch_assoc();
		$rows_Grupo_val	= $rs_Grupo_val->num_rows;
		
		/*-------------------------------------------------------*/
		$sql_grupo = "SELECT * FROM grupos WHERE idgrupo = '$id'";
		$rs_grupo = $mysqli->query($sql_grupo);
		$row_grupo = $rs_grupo->fetch_assoc();
		$rows_grupo = $rs_grupo->num_rows;
		/*-------------------------------------------------------*/
				
		if($rows_Grupo_val > 0) { 
			$grupo = encrypt_decrypt('decrypt', $row_Grupo_val['grupo']);
			$usuario = encrypt_decrypt('decrypt', $row_user['usuario']);
			$mensaje = "Error al modificar informacion del grupo. El grupo: $grupo, ya existe para el usuario: $usuario.";
			echo "<script>";
			echo "alert('$mensaje');";
			echo "window.location='grupos_modificar?_id=$idc';";
			echo "</script>";
		} else {
			$sql_Grupos_mod = 	"UPDATE grupos 
								SET		grupo = '$grupo_cifrado', 
										descripcion = '$descripcion_cifrado',
										estado = '$estado',
										idusuario = '$idusuario'
								WHERE 	idgrupo = '$id'";
			$rs_Grupos_mod = $mysqli->query($sql_Grupos_mod);
			
			$grupo = encrypt_decrypt('decrypt', $grupo_cifrado);
			
				if($rs_Grupos_mod > 0) {
					$mensaje = "Informacion del grupo: $grupo, modificada correctamente.";
					echo "<script>";
					echo "alert('$mensaje');";
					//echo "history.back();";
					echo "window.location='grupos_modificar?_id=$idc';";
					echo "</script>";
				} else {
					$mensaje = "Error al modificar informacion del grupo: $grupo.";
					echo "<script>";
					echo "alert('$mensaje');";
					echo "window.location='grupos_modificar?_id=$idc';";
					echo "</script>"; 
				}
		}
?>								