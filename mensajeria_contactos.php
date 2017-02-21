<?php

require_once "cifrado.php";

/*$host = 'mysql.hostinger.co';
$base = 'u842143985_awa';
$usuario = 'u842143985_awa';
$password ='Hostalex91';*/

$espacio1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$espacio2 = "&nbsp;&nbsp;&nbsp;";

$host = '127.0.0.1';
$base = 'u842143985_awa';
$usuario = 'root';
$password ='';

try{
	$conn = new PDO('mysql:host='.$host.';dbname='.$base.'', $usuario, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$conn->exec("SET CHARACTER SET utf8");
}catch(PDOException $e){
	echo "ERROR: " . $e->getMessage();
}
if (isset($_REQUEST['contacto'])) {
//$name = $_REQUEST['municipio'];

$c=$_POST['contacto'];
 $sql = $conn->prepare('SELECT * FROM contactos WHERE idgrupo='.$c.' ');
    $sql->execute();
    $resultado = $sql->fetchAll();
    foreach ($resultado as $row) {
        echo "<option value='".encrypt_decrypt('decrypt',$row['celular'])."'> 	
		
				".encrypt_decrypt('decrypt',$row['celular'])."".$espacio1."
				".encrypt_decrypt('decrypt',$row['nombre'])." 
				".encrypt_decrypt('decrypt',$row['apellido'])."".$espacio2."	
																	  
			  </option>";
}
} else {
$name = "";
}
?>
				