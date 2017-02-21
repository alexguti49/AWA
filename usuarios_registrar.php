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
		
		$sql_user = "SELECT * FROM usuarios WHERE usuarios.idusuario = $sesion_idusuario";
		$rs_user = $mysqli->query($sql_user);
		$row_user = $rs_user->fetch_assoc();
									
		$sql_Tipo 	= "SELECT * FROM usuarios_tipos";
		$rs_Tipo 	= $mysqli->query($sql_Tipo);
	
	if(!empty($_POST))
	{
		$nombre 	= ucwords(strtolower(mysqli_real_escape_string($mysqli,$_POST['_nombre'])));
		$apellido	= ucwords(strtolower(mysqli_real_escape_string($mysqli,$_POST['_apellido'])));
		$usuario 	= strtoupper(mysqli_real_escape_string($mysqli,$_POST['_usuario']));
		$email		= strtolower(mysqli_real_escape_string($mysqli,$_POST['_email']));
		$clave	 	= mysqli_real_escape_string($mysqli,$_POST['_clave']);
		$sexo		= $mysqli->real_escape_string($_POST['_sexo']);
		$estado		= $mysqli->real_escape_string($_POST['_estado']);
		$idtipo 	= $_POST['_idtipo'];
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
			
			if($rows_Usuario_val > 0) 
			{ 
				$nick = encrypt_decrypt('decrypt', $row_Usuario_val['usuario']);
				$mensaje = "Error al registrar informacion del usuario. El nombre de usuario: $nick ya existe.";
				echo "<script>";
				echo "alert('$mensaje');";
				echo "history.back();";
				echo "</script>";
			} 
			else 
			{
				$sql_Usuario_add = 	"INSERT INTO usuarios (nombre, apellido, usuario, email, clave, idtipo, sexo, estado)
									VALUES ('$nombre_cifrado',
											'$apellido_cifrado',
											'$usuario_cifrado',
											'$email_cifrado',
											'$clave_encriptada',
											'$idtipo', 
											'$sexo',
											'$estado')";
				$rs_Usuario_add	 = $mysqli->query($sql_Usuario_add);
				
				$nick = encrypt_decrypt('decrypt', $usuario_cifrado);
				
				if($rs_Usuario_add > 0) {
					//$bandera = true;
					echo "<script>alert(\"Usuario: $nick, registrado correctamente\");</script>";
				} else {
					//$error = "Error al Registrar";
					echo "<script>alert(\"Error al registrar usuario: $nick.\");</script>";
				}
			}
	}
?>

<?php if($_SESSION['sesion_idtipo']==1) { ?>
<html>
<head>
	<title>Registrar Usuario</title>  
    
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
//****************************************************************************************************** 
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
		 $("#resultado").delay(3000).queue(function(n)
		 {      
			$("#resultado").html('<img src=""/>');
			$.ajax
			({
			  	type: "POST",
			  	url: "comprobar_usuarios_add.php",
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
	$('#_nombre').validarCaracteres('abcdefghijklmnñopqrstuvwxyz');
	$('#_apellido').validarCaracteres(' abcdefghijklmnñopqrstuvwxyz');
	$('#_usuario').validarCaracteres('abcdefghijklmnñopqrstuvwxyz0123456789');
	$('#_email').validarCaracteres('_-.@abcdefghijklmnñopqrstuvwxyz0123456789');
	$('#_clave').validarCaracteres('abcdefghijklmnñopqrstuvwxyz0123456789');
	$('#_clave2').validarCaracteres('abcdefghijklmnñopqrstuvwxyz0123456789');
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
			_idtipo:	
			{
                validators: 
				{
                   notEmpty: { message: 'El campo es obligatorio' },
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
			_estado: 
			{
                validators:	
				{
                    notEmpty: { message: 'El campo es obligatorio' },
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
	//----------------------------------------------------------------------------
//----------------------------------------------------------------------------
		}
//*********************************************************************************	
    });
});
//*******************************************************************************************************
function validar() //VALIDA LOS CAMPOS DEL FORMULARIO
{	
	/*if(	validarNombre()	&& validarApellido() && validarTipoUsuario() && validarUsuario() && validarClave() ) 
		{	
			document.RegistrarDatos.submit();	
		}*/
}
//*******************************************************************************************************		
</script> 

<style>

</style>

</head>

<body>
<!-- ------------------------------------------------------------------------------------------------------ -->
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
      			<a class="navbar-brand" href="inicio" style="font-size:36px"> AWA</a>
    		</div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="font-size:18px">
              	<ul class="nav navbar-nav">
                    <li><a href="mensajeria"><span class="fa fa-whatsapp" aria-hidden="true"></span> Mensajeria
                    <span class="sr-only">(current)</span></a></li>
                    <?php if($_SESSION['sesion_idtipo']==1) { ?>
                    	<li><a href="usuarios"><span class="fa fa-user-secret" aria-hidden="true"></span> Usuarios</a></li>
                    <?php } ?>
                    <li><a href="grupos"><span class="fa fa-users" aria-hidden="true"></span> Grupos</a></li>
                    <li><a href="contactos"><span class="fa fa-user" aria-hidden="true"></span> Contactos</a></li>
              	</ul>
              	<ul class="nav navbar-nav navbar-right">
                	<li style="background-color:#000">
                    
                    	<?php if($row_user['foto']==NULL) { ?>
                        <?php if($row_user['sexo']==1) { ?>
                            <img class="img-responsive-header" src="images/um.png"/>
                            <?php } else { ?>
                            <img class="img-responsive-header" src="images/uf.png"/>
                        <?php } } else { ?>
                       	<img class="img-responsive-header" src="data:image/jpg;base64,<?php echo base64_encode($row_user['foto']); ?>"/>
                        <?php } ?>
                        
                        <a data-toggle="modal" data-target="#loginModal" class="user" style="display: inline-flex;"><?php echo encrypt_decrypt('decrypt', $row_user['usuario']);?></a>
                        
                        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                         <h3 class="modal-title">PERFIL DE USUARIO</h3>
                                     </div>
                             
                                     <div class="modal-body" style="height:430px">
                             
                                        <form id="loginModal" method="post" class="form-horizontal" action="none">
                                        	<div class="form-group">
                                            
											<?php if($rs_user) { ?>
                                             
                                             <table class="table-modal" height="400px">
                                                <tbody>
                                                	<tr>
                                                        <td class="td-modal-imagen" colspan="2">
														<?php if($row_user['foto']==NULL) { ?>
                                                        	<?php if($row_user['sexo']==1) { ?>
                                                        	<img src="images/masculino.png" class="img-responsive-modal"/>
                                                        	<?php } else { ?>
                                                            <img src="images/femenino.png" class="img-responsive-modal"/>
														<?php } } else { ?>
                                                        <img src="data:image/jpg;base64,<?php echo base64_encode($row_user['foto']);?>"class="img-responsive-modal"/>
                                                        <?php } ?>
                                                        </td>
                                                 	</tr>
                                                	<tr>
                                                        <td class="td-modal-titulos">Usuario:</td>
                                                        <td class="td-modal-info"><?php echo $usuario = encrypt_decrypt('decrypt', $row_user['usuario']); ?></td>
                                                 	</tr>
                                                    <tr>
                                                        <td class="td-modal-titulos">Nombre:</td>
                                                        <td class="td-modal-info"><?php echo encrypt_decrypt('decrypt', $row_user['nombre']); ?></td>
                                                 	</tr>
                                                        <tr>
                                                        <td class="td-modal-titulos">Apellido:</td>
                                                        <td class="td-modal-info"><?php echo encrypt_decrypt('decrypt', $row_user['apellido']); ?></td>
                                                 	</tr>
                                                    <tr>
                                                        <td class="td-modal-titulos">Email:</td>
                                                        <td class="td-modal-info"><?php echo encrypt_decrypt('decrypt', $row_user['email']); ?></td>
                                                 	</tr>
                                                        <tr>
                                                        <td class="td-modal-titulos">Sexo:</td>
                                                        <?php 
															if ($row_user['sexo'] == 1) { $sex = "Masculino"; } 
															else { $sex = "Femenino"; } 
														?>
                                                        <td class="td-modal-info"><?php echo $sex; ?></td>
                                                 	</tr>
                                               	</tbody>
                                          	</table>
                                          
											<?php } else { ?>
                                                <h1>No se encontro informacion del usuario</h1>
                                            <?php } ?>
                                                                                 
                                             </div>
                                             
                                         </form>
                                     </div>
                                     
                                     <div class="modal-footer">
                                         <div align="center" class="panel-negro">
                                            <button class="btn btn-default" type="button" style="margin:0px 15px; width:125px">
                                            <a class="fa-editar fa fa-pencil-square-o" aria-hidden="true" title="Modificar" href="usuarios_modificar?_id=<?php echo encrypt_decrypt('encrypt', $row_user['idusuario']);?>"> Modificar</a>
                                            </button>
        
                                            <button class="btn btn-default" type="button" style="margin: 0px 15px; width:125px">
                                            <a class="fa-eliminar fa fa-trash" aria-hidden="true" title="Eliminar" href="usuarios_eliminar?_id=<?php echo encrypt_decrypt('encrypt',$row_user['idusuario']);?>" onclick="return confirm('¿Está seguro de eliminar el usuario: <?php echo $usuario ?>? ¡Si acepta perdera toda su informacion!');"> Eliminar</a>
                                            </button>
                                         </div>
                                     </div>
                                             
                                 </div>
                            </div>
                        </div>
                    </li>
                	<li><a href="salir"><span class="fa fa-sign-out" aria-hidden="true"></span> Salir</a></li>
              	</ul>
           	</div><!-- /.navbar-collapse -->
  		</div><!-- /.container-fluid -->
	</nav>
</div>
</header>
<!-- ------------------------------------------------------------------------------------------------------ -->
<main>
<div class="container">
	<div class="row">
		<div class="col-sm-offset-2 col-sm-8   col-md-offset-3 col-md-6    col-lg-offset-3 col-lg-6    col-xs-12">
        	<div class="panel panel-primary"> 
          		
                <div class="panel-heading">
					<h3 align="center">REGISTRAR USUARIOS</h3>
				</div>
          	
            <div class="panel-body">
      	    	<form id="RegistrarDatos" name="RegistrarDatos" class="form-horizontal" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
              		
                    
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
                                <label class="span-titulos" control-label>Usuario:</label>
                                <span id="resultado"></span>
                            </div>
                            <span class="input-group-addon"><i class="fa fa-user-secret"></i></span>
                            <input class="form-control" id="_usuario" name="_usuario" type="text" maxlength="10" style="text-transform:uppercase">						
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <div class="input-group">
                            <div class="div-titulos">
                                <label class="span-titulos" control-label>Email:</label>
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
                                <table style="color:#FFF">
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
                    
                    
					<?php if($_SESSION['sesion_idtipo']==1) { ?>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="div-titulos">
                                <label class="span-titulos control-label">Estado:</label>
                            </div>
                            <span class="input-group-addon"><i class="fa fa-user-secret"></i></span>
                            <div class="form-control" style="display:inherit;">
                                <table style="color:#FFF">
                                    <tr>
                                        <td><input type="radio" id="_estado" name="_estado" value="1"> Activo</td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" id="_estado" name="_estado" value="0"> Inactivo</td>
                                    </tr>
                                </table>
                            </div>						
                        </div>
                    </div>

   
                    <div class="form-group">
                        <div class="input-group">
                            <div class="div-titulos">
                                <label class="span-titulos control-label">Tipo Usuario:</label>
                            </div>
                            <span class="input-group-addon"><i class="fa fa-user-secret"></i></span>
                                <select class="form-control" id="_idtipo" name="_idtipo">
                                    <option value="">-- Seleccione uno --</option>
                                    <?php while($row_Tipo = $rs_Tipo->fetch_assoc()){ ?>
                                        <option value="<?php echo $row_Tipo['idtipo']; ?>">
                                            <?php echo encrypt_decrypt('decrypt', $row_Tipo['tipo']); ?>
                                        </option>
                                    <?php }?>
                                </select>
                        </div>
                    </div>
                    <?php } ?>
                    
                      
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
                        <div align="center" class="panel-negro">
                            <input type="submit" class="btn btn-primary" value="Registrar" onClick="validar();">
                       	</div>
                    </div>
                    
            	</form>

						<?php /*?><?php if($bandera) { ?>
							<script type="text/javascript">alert("Usuario Registrado");</script>
						<?php }else{ ?>
							<!--<h2> Usuario NO Registrado </h2>-->
                        	<script type="text/javascript">alert("Usuario NO Registrado");</script>
						<?php } ?><?php */?> 
              
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
<?php } else { header("Location:salir"); } ?>