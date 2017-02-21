<!------------------------ INCLUDE PHP ------------------------>
<?php

session_start();
	
	require 'conexion.php';
	require 'cifrado.php';
	
		if(isset($_SESSION["sesion_idusuario"]))
		{
			header('Location:inicio');
		} else {
		
if(!empty($_POST)) { 
	$usuario = strtoupper($mysqli->real_escape_string($_POST['_usuario']));
	$clave	 = $mysqli->real_escape_string($_POST['_clave']);
	
	$usuario_cifrado = encrypt_decrypt('encrypt', $usuario);
	$salt = ('$a*l#e%x|');
 	$clave_encriptada = sha1(md5($salt.$clave));

	$sql_validacion1 = "SELECT * FROM usuarios WHERE usuario ='$usuario_cifrado' AND clave ='$clave_encriptada' AND estado=0";
	$rs_validacion1 = $mysqli->query($sql_validacion1);
	$rows_validacion1 = $rs_validacion1->num_rows;
	
	$sql_validacion = "SELECT * FROM usuarios WHERE usuario ='$usuario_cifrado' AND clave ='$clave_encriptada' AND estado=1";
	$rs_validacion = $mysqli->query($sql_validacion);
	$rows_validacion = $rs_validacion->num_rows;
	
		if($rows_validacion1 > 0) { 
			$mensaje = "El usuario: $usuario, aun no ha sido activado.";
			echo "<script>";
			echo "alert('$mensaje');";
			echo "history.back();";
			echo "</script>";
		}
		
		else if($rows_validacion > 0) {
			
			$row_validacion = $rs_validacion->fetch_assoc();
			
			$_SESSION['sesion_idusuario'] = $row_validacion['idusuario'];
			$_SESSION['sesion_idtipo'] = $row_validacion['idtipo'];
			$_SESSION['sesion_usuario'] = encrypt_decrypt('decrypt',$row_validacion['usuario']);
			$_SESSION['sesion_nombre'] = encrypt_decrypt('decrypt',$row_validacion['nombre']);
			$_SESSION['sesion_apellido'] = encrypt_decrypt('decrypt',$row_validacion['apellido']);
			
			$sesion_nombre = $_SESSION['sesion_nombre'];
			$sesion_apellido = $_SESSION['sesion_apellido'];
			$sesion_nick = $_SESSION['sesion_usuario'];
			$sesion_idusuario = $_SESSION['sesion_idusuario'];
			$sesion_idtipo = $_SESSION['sesion_idtipo'];
			
			$mensaje = "Te damos la bienvenida, $sesion_nombre $sesion_apellido.";
			echo "<script>";
			echo "window.location = 'inicio';";
			echo "alert('$mensaje');";
			echo "</script>";
		}
		else {
			$mensaje = "El usuario o la clave de acceso son incorrectos.";
			echo "<script>";
			echo "alert('$mensaje');";
			echo "history.back();";
			echo "</script>";
		}
}}
?>
<!------------------------------------------------------------->
<!DOCTYPE html>
<html>
<head>
	<title>Index</title>
    
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
//*******************************************************************************************************
$(document).ready(function() //VALIDA SI USUARIO EXISTE AL REGISTRAR
{
	var consulta;
    //hacemos focus
    //$("#_usuario").focus();
    //comprobamos si se pulsa una tecla
    $("#_usuario").keyup(function(e)
	{
    	//obtenemos el texto introducido en el campo
        usuario = $("#_usuario").val();
        //hace la búsqueda
		 $("#resultado").delay(1000).queue(function(n)
		 {      
			$("#resultado").html('<img src=""/>');
			$.ajax
			({
			  	type: "POST",
			  	url: "comprobar_usuarios_reg.php",
			  	data: "usuario="+usuario.toUpperCase(),
			  	dataType: "html",
			  	error: function()
				{ /*alert("error petición ajax");*/ },
			  	success: function(data)
				{                                                      
					$("#resultado").html(data);
					n();
			  	}
			});
        });
   	});                    
});
//*******************************************************************************************************	
$(function() //VALIDA EL INGRESO DE LETRAS Y NUMEROS
{ 	
	$('#_usuario').validarCaracteres('abcdefghijklmnñopqrstuvwxyz0123456789');
	$('#_clave').validarCaracteres('abcdefghijklmnñopqrstuvwxyz0123456789');
});
//*******************************************************************************************************
$(document).ready(function()
{ // BOOTSTRAP VALIDATOR
	$('#Login').bootstrapValidator
	({
//*********************************************************************************
       <!-- container: '#messages',-->
	   	message: 'This value is not valid',
        feedbackIcons: 
		{
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
//*********************************************************************************
        fields: 
		{
	//----------------------------------------------------------------------------			
			_usuario: 
			{
                validators: 
				{
                    notEmpty: { message: 'Campo vacio' },
                    stringLength:	{ min: 4, max: 10, message: 'Debe tener entre 4 a 10 caracteres' }
				}
			},
	//----------------------------------------------------------------------------
			_clave: 
			{
                validators:	
				{
                    notEmpty: { message: 'Campo vacio' },
					 stringLength:	{ min: 4, max: 10, message: 'Debe tener entre 4 a 10 caracteres' }
                 }
            },
	//----------------------------------------------------------------------------
		}
//*********************************************************************************	
    });
});
//*******************************************************************************************************
$(document).ready(function()
{ // BOOTSTRAP VALIDATOR
	$('#RegistrarDatos').bootstrapValidator
	({
//*********************************************************************************
       <!-- container: '#messages',-->
	   	message: 'This value is not valid',
        feedbackIcons: 
		{
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
//*********************************************************************************
        fields: 
		{
	//----------------------------------------------------------------------------			
            _nombre:
			{
                validators:	
				{
                    notEmpty: { message: 'El campo es obligatorio' },
					stringLength: { max: 20, message: 'Puede tener hasta 20 caracteres' }
				}
            },
	//----------------------------------------------------------------------------            
			_apellido: 
			{
                validators: 
				{
                    notEmpty: { message: 'El campo es obligatorio' },
					stringLength: { max: 20, message: 'Puede tener hasta 20 caracteres' }
				}
            },
	//----------------------------------------------------------------------------
			_usuario: 
			{
                validators: 
				{
                    notEmpty: { message: 'El campo es obligatorio' },
                    stringLength: { min: 4, max: 10, message: 'Debe tener entre 4 a 10 caracteres' }
				}
			},
	//----------------------------------------------------------------------------
			_email: 
			{
                validators: 
				{
                    notEmpty: { message: 'El campo es obligatorio' },
					emailAddress: { message: 'El email no es valido' },
					stringLength: { min: 7, max: 50, message: 'Debe tener entre 7 a 50 caracteres' }
				}
			},		
	//----------------------------------------------------------------------------		
        	_clave: 
			{
                validators:	
				{
                    notEmpty: { message: 'El campo es obligatorio' },
					stringLength:	{ min: 4, max: 10, message: 'Debe tener entre 4 a 10 caracteres' },
					identical: { field: '_clave2', message: 'La contraseñas no coinciden' }
                 }
            },
	//----------------------------------------------------------------------------				
            _clave2: 
			{
                validators: 
				{
                    notEmpty: {	message: 'El campo es obligatorio'	},
                    identical: { field: '_clave', message: 'La contraseñas no coinciden' },
					stringLength: { min: 4, max: 10, message: 'Debe tener entre 4 a 10 caracteres' }
                 }
            },
	//----------------------------------------------------------------------------
			_sexo: 
			{
                validators:	
				{
                    notEmpty: { message: 'El campo es obligatorio' },
                }
            }
	//----------------------------------------------------------------------------
//--------------------------------------------------------------------------------
		}
//*********************************************************************************	
    });
});
//*******************************************************************************************************
function validar() //VALIDA LOS CAMPOS DEL FORMULARIO
{	
	/*if(	validarNombre()	&& validarApellido() && validarTipoUsuario() && validarUsuarioAdd() && validarClave() ) 
		{	
			document.RegistrarDatos.submit();	
		}*/
}
//*******************************************************************************************************		
</script>

<style type="text/css">
.panel{
	background-color: rgba(0,0,0,.5);
	border: 1px solid #0CD1D4;
}

</style>

</head>

<body>
<!----------------------------------------------------------------------------------------------------------->
<header class="clase-general">
<div class="container">
	<nav class="navbar navbar-default">
  		<div class="container-fluid">
    	<!-- Brand and toggle get grouped for better mobile display -->
    		<div class="navbar-header">
      			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
      			</button>
      			<a class="navbar-brand" href="#" style="font-size:36px"> AWA</a>
    		</div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="font-size:18px">
              	<ul class="nav navbar-nav">
                    <li><a href="#"><span class="fa fa-whatsapp" aria-hidden="true"></span> Mensajeria
                    <span class="sr-only">(current)</span></a></li>
                    <li><a href="#"><span class="fa fa-user-secret" aria-hidden="true"></span> Usuarios</a></li>
                    <li><a href="#"><span class="fa fa-users" aria-hidden="true"></span> Grupos</a></li>
                    <li><a href="#"><span class="fa fa-user" aria-hidden="true"></span> Contactos</a></li>
              	</ul>
              	<ul class="nav navbar-nav navbar-right">
                	<li style="background-color:#000">
                    	<img class="img-responsive-header" src="images/um.png"/>
                        <a data-toggle="modal" data-target="#loginModal" class="user" style="display:inline-flex;">Registrarse</a>
                        
                        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                         		<div class="modal-content">
                                 	<div class="modal-header">
                                         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                         <h3 class="modal-title">REGISTRAR USUARIO</h3>
									</div>
                             
                             	    
                                    <div class="modal-body">
                                    
                            
<form id="RegistrarDatos" name="RegistrarDatos" class="form-horizontal" action="usuario" method="POST">


    <div class="form-group">
        <div class="input-group">
            <div class="div-titulos">
                <label class="span-titulos control-label">Nombre:</label>
            </div>
            <span class="input-group-addon"><i class="fa fa-user-secret"></i></span>
            <input type="text" class="form-control" id="_nombre" name="_nombre" maxlength="20">
        </div>
    </div>

   
    <div class="form-group">
        <div class="input-group">
            <div class="div-titulos">
                <label class="span-titulos control-label">Apellido:</label>
            </div> 
            <span class="input-group-addon"><i class="fa fa-user-secret"></i></span>
            <input class="form-control" id="_apellido" name="_apellido" type="text" maxlength="20">
        </div>
    </div>
    
    
    <div class="form-group">
        <div class="input-group">
            <div class="div-titulos">
                <label class="span-titulos control-label">Usuario:</label>
                <span id="resultado"></span>
            </div>
            <span class="input-group-addon"><i class="fa fa-user-secret"></i></span>
            <input class="form-control" id="_usuario" name="_usuario" type="text" maxlength="10" style="text-transform:uppercase">						
        </div>
    </div>
    
    
    <div class="form-group">
        <div class="input-group">
            <div class="div-titulos">
                <label class="span-titulos control-label">Email:</label>
            </div>
            <span class="input-group-addon"><i class="fa fa-user-secret"></i></span>
            <input class="form-control" id="_email" name="_email" type="text" maxlength="50" style="text-transform:lowercase">						
        </div>
    </div>
    
    
   <div class="form-group">
        <div class="input-group">
            <div class="div-titulos">
                <label class="span-titulos control-label">Sexo:</label>
            </div>
            <span class="input-group-addon"><i class="fa fa-user-secret"></i></span>
            <div class="form-control" style="display:inherit;">
                <table style="color:#FFF" align="left">
                    <tr>
                        <td><input type="radio" id="_sexo" name="_sexo" value="0"> Femenino</td>
                    </tr>
                    <tr>
                        <td><input type="radio" id="_sexo" name="_sexo" value="1"> Masculino</td>
                    </tr>
                </table>
            </div>						
        </div>
    </div>
    
    
    <div class="form-group">
        <div class="input-group">
            <div class="div-titulos">
                <label class="span-titulos control-label">Clave:</label>
            </div>
            <span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
            <input class="form-control" id="_clave" name="_clave" type="password" maxlength="10">						
        </div>
    </div>
    

    <div class="form-group">
        <div class="input-group">
            <div class="div-titulos">
                <label class="span-titulos control-label">Confirmar Clave:</label>
            </div>
            <span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
            <input class="form-control" id="_clave2" name="_clave2" type="password" maxlength="10"> 							
        </div>
    </div>

    
    <!------------------LINEA CELESTE-------------->
    <div class="linea-celeste"></div>
  
    <div class="form-group">
        <div align="center" class="panel-negro" style="margin-bottom:-30px">
            <input type="submit" class="btn btn-primary" value="Registrar" onClick="validar();">
        </div>
    </div>
    
    
</form>
                             		      	
                                        
                              		</div>
                            	</div>
                          	</div>
                    	</div>
                	</li>
                	<li><a href="#"><span class="fa fa-sign-out" aria-hidden="true"></span> Salir</a></li>
              	</ul>
           	</div><!-- /.navbar-collapse -->
  		</div><!-- /.container-fluid -->
	</nav>
</div>
</header>
<!----------------------------------------------------------------------------------------------------------->
<main>
<div class="container">
    <div class="row">
		<div class="col-sm-offset-3 col-sm-6   col-md-offset-3 col-md-6    col-lg-offset-4 col-lg-4   col-xs-offset-0 col-xs-12">
			<div class="panel panel-primary">
              	<div class="panel-heading">
					<h2><center>Login</center></h2>
				</div>
                    
          	<div class="panel-body">
                <div class="col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1 col-xs-10">
                    <center>
                    	<img src="images/awa_logo.png" class="img-responsive" alt="Placeholder image" height="200px" width="200px">
                    </center>
      		    </div>
          	</div>

            <div class="panel-body">    
            	
                <form id="Login" name="Login" class="form-horizontal" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                
                <!------------------LINEA CELESTE-------------->
            	<div class="linea-celeste"></div><br>
                
                <div class="form-group">
				        <div class="input-group">
                           	<div class="div-titulos" align="center">
                            	<label class="span-titulos control-label">Usuario:</label>
                           	</div>
					        <span class="input-group-addon"><i class="fa fa-user-secret"></i></span>
					        <input id="_usuario" name="_usuario" type="text" class="form-control" placeholder="Usuario" onfocus="this.value=''" maxlength="10">
					  	</div>
			     	</div>
                    
                    
                    <div class="form-group">
				        <div class="input-group">
                           	<div class="div-titulos" align="center">
                            	<label class="span-titulos control-label">Clave:</label>
                           	</div>
					        <span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
					        <input id="_clave" name="_clave" type="password" class="form-control" placeholder="Clave" onfocus="this.value=''" maxlength="10">
					  	</div>
			     	</div>
                    
                    
                    <!------------------LINEA CELESTE-------------->
                	<div class="linea-celeste"></div>
					<table width="100%">
                    	<tr>
                        	<td>                
                                <div class="form-group">
                                    <div align="center" class="panel-negro">
                                        <input type="submit" class="btn btn-primary" value="Enviar" style="width:120px">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div align="center" class="panel-negro">
                                        <input type="button" class="btn btn-success" data-toggle="modal" data-target="#loginModal" value="Registrar" style="width:120px">
                                    </div>
                                </div>
                          	</td>
                    	</tr>
                    </table>
              	</form>
                
               	</div> <!-- /.panel-body-->
          	</div> <!-- /.panel-primary-->
		</div> <!-- /.col -->
	</div> <!-- /.row -->
</div> <!-- /.container-->
</main> 
<!-----------------------------------------------------------------------------------------------------------> 
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
<!----------------------------------------------------------------------------------------------------------->
</body>
</html>
