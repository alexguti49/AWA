<?php

session_start();
	
	require 'conexion.php';
	require 'cifrado.php';
	
		if(isset($_SESSION["sesion_idusuario"]))
		{
			header('Location:inicio');
		} else {
				
if(!empty($_POST)){
	$nombre 	= ucwords(strtolower(mysqli_real_escape_string($mysqli,$_POST['_nombre'])));
	$apellido	= ucwords(strtolower(mysqli_real_escape_string($mysqli,$_POST['_apellido'])));
	$usuario 	= strtoupper(mysqli_real_escape_string($mysqli,$_POST['_usuario']));
	$email		= strtolower(mysqli_real_escape_string($mysqli,$_POST['_email']));
	$clave	 	= mysqli_real_escape_string($mysqli,$_POST['_clave']);
	$sexo		= $mysqli->real_escape_string($_POST['_sexo']);
	$estado		= 0;
	$idtipo 	= 2;
	$salt 		= ('$a*l#e%x|');
	
	$clave_encriptada 	= sha1(md5($salt.$clave));
	$usuario_cifrado 	= encrypt_decrypt('encrypt', $usuario);
	$nombre_cifrado 	= encrypt_decrypt('encrypt', $nombre);
	$apellido_cifrado	= encrypt_decrypt('encrypt', $apellido);
	$email_cifrado		= encrypt_decrypt('encrypt', $email);

		$sql_Usuario_val 	= "SELECT * FROM usuarios WHERE usuario = '$usuario_cifrado'";
		$rs_Usuario_val		= $mysqli->query($sql_Usuario_val);
		$rows_Usuario_val	= $rs_Usuario_val->num_rows;
		$row_Usuario_val 	= $rs_Usuario_val->fetch_assoc();
		
		if($rows_Usuario_val > 0){ 
			$nick = encrypt_decrypt('decrypt', $row_Usuario_val['usuario']);
			$mensaje = "Error al registrar informacion del usuario. El nombre de usuario: $nick ya existe.";
			echo "<script>";
			echo "alert('$mensaje');";
			echo "history.back();";
			echo "</script>";
		} else {
			$sql_Usuario_add = 	"INSERT INTO usuarios (nombre, apellido, usuario, email, clave, idtipo, sexo, estado)
								VALUES ('$nombre_cifrado',
										'$apellido_cifrado',
										'$usuario_cifrado',
										'$email_cifrado',
										'$clave_encriptada',
										'$idtipo', 
										'$sexo',
										'$estado')";
			$rs_Usuario_add	= $mysqli->query($sql_Usuario_add); 	
			
			$nick = encrypt_decrypt('decrypt', $usuario_cifrado);
			
			if($rs_Usuario_add > 0) { ?>
            
<!DOCTYPE html>			
<html>
<head>
	<title>USUARIO</title>  
    
    <!--	METAS		-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
	<meta name="" content="">
    
    <!--	LINKS		-->
    <link rel="shortcut icon" href="images/awa.ico">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/font-awesome-4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/awa.css">
    <link rel="stylesheet" href="css/fuentes.css">
    <link rel="stylesheet" href="css/bootstrapValidator.css">
    <link rel="stylesheet" href="js_css_validator/bootstrapValidator.min.css">
	    
    <!--	SCRIPTS		-->
	<script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <!--<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>-->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrapValidator.js"></script>
    <script type="text/javascript" src="js/bootstrapValidator.min.js"></script>
	
    <!--	VALIDADORES	--> 
  	<script type="text/javascript" src="js_css_validator/bootstrapValidator.min.js"></script>
   	<script type="text/javascript" src="js/validaciones.js"></script>
    <script type="text/javascript" src="js/validarCaracteres.js"></script>
	
			
<script type="text/javascript">
</script> 

</head>

<body>
<!-- ------------------------------------------------------------------------------------------------------ -->
<!-- HEADER -->
<!-- ------------------------------------------------------------------------------------------------------ -->

<main>
	<!-- ------------------------------------------------------------------------------------------------------ -->
<div class="container" style="padding:100px 20px;">
	<div class="row">
		<div class="col-sm-offset-2 col-sm-8   col-md-offset-3 col-md-6    col-lg-offset-3 col-lg-6    col-xs-12">
        	<div class="panel panel-primary"> 
          		
                <div class="panel-heading">
					<h3 align="center">INFORMACION DEL USUARIO</h3>
				</div>
          	
            <div class="panel-body" style="background-color:rgba(0,0,0,0.6);">
                <p style="color:#FFF; font-size:16px">
	                La informacion enviada sera revisada por la administracion, si los datos son correctos se activara su cuenta, caso contrario vuelva a registrarse.
                </p>
           
            <div class="panel-negro" style="margin-bottom:0px;">
                <div class="input-group" style="padding:15px">
                        <span class="input-group-addon" style="border-radius:3px; border:2px solid #0CD1D4;"">
                        	<i class="fa fa-eye"></i>
                        </span>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal">Revisar Datos</button>	
                </div>
                
                <div class="input-group" style="padding:15px">
                        <span class="input-group-addon" style="border-radius:3px; border:2px solid #a94442;">
                        	<i class="fa fa-sign-out" style="color:#a94442;"></i>
                     	</span>
                        <button type="button" class="btn btn-danger" onClick="location.href='index'">Salir</button>	
                </div>
        	</div>
        
          
    <!-- ------------------------------------------------------------------------------------------------------ -->                    
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                         <h3 class="modal-title">PERFIL DE USUARIO</h3>
                     </div>
             
                     <div class="modal-body">
             
                        <form id="loginModal" method="post" class="form-horizontal" action="none">
                            
                            <div class="form-group">
                             
                                 <table class="table-modal">
                                    <tbody>
                                        <tr>
                                            <td class="td-modal-imagen" colspan="2">
                                                <?php if($sexo==1) { ?>
                                                    <img src="images/masculino.png" class="img-responsive-modal"/>
                                                <?php } else { ?>
                                                    <img src="images/femenino.png" class="img-responsive-modal"/>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="td-modal-titulos">Usuario:</td>
                                            <td class="td-modal-info"><?php echo $usuario; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="td-modal-titulos">Nombre:</td>
                                            <td class="td-modal-info"><?php echo $nombre; ?></td>
                                        </tr>
                                            <tr>
                                            <td class="td-modal-titulos">Apellido:</td>
                                            <td class="td-modal-info"><?php echo $apellido; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="td-modal-titulos">Email:</td>
                                            <td class="td-modal-info"><?php echo $email ?></td>
                                        </tr>
                                            <tr>
                                            <td class="td-modal-titulos">Sexo:</td>
                                            <?php 
                                                if ($sexo==1) { $sex = "Masculino"; } 
                                                else { $sex = "Femenino"; } 
                                            ?>
                                            <td class="td-modal-info"><?php echo $sex; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                                                 
                             </div> <!-- /form-jroup -->
                             
                         </form>
                     </div>
                 </div>
            </div>
        </div>  
 	<!-- ------------------------------------------------------------------------------------------------------ -->


              	</div><!-- PANEL BODY -->
        	</div> <!-- PANEL PRIMARY -->
    	</div> <!-- COL --> 
	</div> <!-- ROW -->
</div><!-- CONTAINER -->
</main>
<!-- ------------------------------------------------------------------------------------------------------ -->
<footer class="clase-general">
<div class="panel-footer" style="width: 100%; bottom: -1px;">
	<div class="navbar-collapse collapse in" style="font-size: 14px;" aria-expanded="true" align="center">
		<ul class="nav navbar-nav">
			<li>
				<table>
					<tr>
						<th>
							<img title="Awa.hol.es" onClick="location.href='inicio'" class="icono-footer" src="images/awa.png" alt="">
						</th>
						<th style="font: inherit;" align="center">
							<center>
                                <span style="color:#ccc">Copyright ©  2016. All Rights Reserved. Powered by 
	                                <a href="https://twitter.com/luisguti91" target="_blank" style="color:#ccc">Alexander Intriago</a>
                                </span>
                            </center>
						</th>
					</tr>
				</table>
			</li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li>
				<div class="redes" align="center" style="padding-top:10px; margin-right: 15px; margin-top:5px"> 
                    <a class="twetter" href="https://twitter.com/luisguti91" target="_blank" title="Sígueme en Twetter"></a>
                    <a class="google" href="https://plus.google.com/106260460599130190099" target="_blank" title="Sígueme en G+"></a>
                    <a class="instagram" href="https://www.instagram.com/luisguti91/" target="_blank" title="Sígueme en Instagram"></a>
                    <a class="facebook" href="https://www.facebook.com/luisguti919/" target="_blank" title="Sígueme en Facebook"></a>
                </div> 
            </li>
        </ul>
	</div>
</div>
</footer>
<!-- ------------------------------------------------------------------------------------------------------ -->	
</body>
</html>

<?php 
		} 
	}
} else { 
		$mensaje = "Acceso Denegado.";
		echo "<script>";
		echo "alert('$mensaje');";
		//echo "history.back();";
		echo "window.location='index';";
		echo "</script>";
}
}
?>