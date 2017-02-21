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
	
		$idc 		= $mysqli->real_escape_string($_POST['_id']);
		$id 		= encrypt_decrypt('decrypt', $idc);
		$celular	= $mysqli->real_escape_string($_POST['_celular']);
		$nombre		= ucwords(strtolower($mysqli->real_escape_string($_POST['_nombre'])));
		$apellido	= ucwords(strtolower($mysqli->real_escape_string($_POST['_apellido'])));
		$idgrupoc	= $mysqli->real_escape_string($_POST['_idgrupo']);
		$idgrupo	= encrypt_decrypt('decrypt', $idgrupoc);
		$estado		= $mysqli->real_escape_string($_POST['_estado']);
	
			$celular_cifrado 	= encrypt_decrypt('encrypt', $celular);
			$nombre_cifrado 	= encrypt_decrypt('encrypt', $nombre);
			$apellido_cifrado	= encrypt_decrypt('encrypt', $apellido);
			
			/************************************************************************************************/
			$sql_Contacto_val 	= 	"SELECT * 
									FROM 	contactos, grupos 
									WHERE 	contactos.celular = '$celular_cifrado'
									AND 	contactos.idgrupo = '$idgrupo'
									AND 	contactos.idcontacto != '$id'
									AND 	grupos.idgrupo = contactos.idgrupo
									AND 	grupos.idusuario = '$sesion_idusuario'";
			$rs_Contacto_val	= $mysqli->query($sql_Contacto_val);
			$rows_Contacto_val	= $rs_Contacto_val->num_rows;
			$row_Contacto_val	= $rs_Contacto_val->fetch_assoc();
			/************************************************************************************************/
			
		if($rows_Contacto_val > 0) { 
			$celular = encrypt_decrypt('decrypt', $row_Contacto_val['celular']);
			$nombre = encrypt_decrypt('decrypt', $row_Contacto_val['nombre']);
			$apellido = encrypt_decrypt('decrypt', $row_Contacto_val['apellido']);
			$mensaje = "Error al registrar informacion del contacto. El numero celular: $celular, ya existe para el contacto: $nombre $apellido.";
			echo "<script>";
			echo "alert('$mensaje');";
			echo "history.back();";
			echo "</script>";
		} else {
			$sql_Contactos_mod=	"UPDATE contactos 
								SET		celular =	'$celular_cifrado', 
										nombre =	'$nombre_cifrado', 
										apellido =	'$apellido_cifrado',
										idgrupo =	'$idgrupo',
										estado =	'$estado'
								WHERE 	idcontacto ='$id'";
			$rs_Contactos_mod = $mysqli->query($sql_Contactos_mod);
			
			$nombre = encrypt_decrypt('decrypt', $nombre_cifrado);
			$apellido = encrypt_decrypt('decrypt', $apellido_cifrado);
			
				if($rs_Contactos_mod > 0) {
					$mensaje = "Informacion del contacto: $nombre $apellido, modificada correctamente.";
					echo "<script>";
					echo "alert('$mensaje');";
					//echo "history.back();";
					echo "window.location = 'contactos_modificar?_id=$idc';";
					echo "</script>";
				} else {
					$mensaje = "Error al modificar informacion del contacto: $nombre $apellido.";
					echo "<script>";
					echo "alert('$mensaje');";
					//echo "history.back();";
					echo "window.location = 'contactos_modificar?_id=$idc';";
					echo "</script>"; 
				}
		}
?>				
				