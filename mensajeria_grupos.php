<?php

session_start();
	
	require 'conexion.php';
	require 'cifrado.php';
	
		if(!isset($_SESSION["sesion_idusuario"]))
		{
			header('Location:index');
		}

function ListarGrupos()
{

/*$host = 'mysql.hostinger.co';
$base = 'u842143985_awa';
$usuario = 'u842143985_awa';
$password ='Hostalex91';
*/
$host = 'localhost';
$base = 'u842143985_awa';
$usuario = 'root';
$password ='';

	try
	{
		$conn = new PDO('mysql:host='.$host.';dbname='.$base.'', $usuario, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conn->exec("SET CHARACTER SET utf8");
	}
	catch(PDOException $e)
	{
		echo "ERROR: " . $e->getMessage();
	}
	
	$sesion_idusuario = $_SESSION['sesion_idusuario'];
	$sql = $conn->prepare("SELECT * FROM grupos, usuarios WHERE grupos.idusuario = usuarios.idusuario AND grupos.idusuario = '$sesion_idusuario'");
    $sql->execute();
    $resultado = $sql->fetchAll();
    
	foreach ($resultado as $row) 
	{
        echo "<option value='".$row['idgrupo']."'>".encrypt_decrypt('decrypt',$row['grupo'])."</option>";
    }
  }
?>