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
	
	$id = "0";
	if (isset($_GET['_id'])){ $id = encrypt_decrypt('decrypt', $_GET['_id']); }
	
	$sql_Usuarios_mod=	"SELECT usuarios.usuario, 
								usuarios.clave, 
								usuarios.nombre, 
								usuarios.apellido,
								usuarios.email,
								usuarios.idtipo,
								usuarios.foto,
								usuarios.sexo,
								usuarios.estado, 
								usuarios_tipos.tipo 
						FROM 	usuarios, usuarios_tipos 
						WHERE 	idusuario='$id' 
						AND 	usuarios.idtipo=usuarios_tipos.idtipo";
	
	$rs_Usuarios_mod 	= $mysqli->query($sql_Usuarios_mod);
	$row_Usuarios_mod 	= $rs_Usuarios_mod->fetch_assoc();
	
	$sql_Tipo = "SELECT * FROM usuarios_tipos";
	$rs_Tipo = $mysqli->query($sql_Tipo);
	$row_Tipo = $rs_Tipo->fetch_assoc();
	
	$sql_user = "SELECT * FROM usuarios WHERE idusuario = $sesion_idusuario";
	$rs_user = $mysqli->query($sql_user);
	$row_user = $rs_user->fetch_assoc();
	
	/*-----------------------------------------------------------*/
	$sql_usuario = "SELECT * FROM usuarios WHERE idusuario = '$id'";
	$rs_usuario = $mysqli->query($sql_usuario);
	$row_usuario = $rs_usuario->fetch_assoc();
	$rows_usuario = $rs_usuario->num_rows;
	/*-----------------------------------------------------------*/
	
	//echo($row_usuario['idusuario']." ".$row_user['idusuario'])." ".$sesion_idtipo;
?>
<?php if($row_usuario['idusuario']==$row_user['idusuario'] || $sesion_idtipo==1){ ?>
<!DOCTYPE html>
<html>
<head>
	<title>Modificar Usuario</title>
 	
    <!--	METAS		-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
	<meta name="autor" content="">
    
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
$(document).ready(function() //VALIDA SI USUARIO EXISTE AL MODIFICAR
{
    var usuario, id;
	//hacemos focus
	// $("#_usuario_mod").focus();
	//comprobamos si se pulsa una tecla
 	$("#_usuario").keyup(function(e)
	{      //obtenemos el texto introducido en el campo
		idusuario = $("#_id").val();
        usuario = $("#_usuario").val();
	 	//hace la búsqueda
	 	$("#resultado").delay(3000).queue(function(n) 
		{      
		  	$("#resultado").html('<img src=""/>');
			$.ajax
			({
				type: "POST",
				url: "comprobar_usuarios_mod.php",
				data: "idusuario="+idusuario+"&usuario="+usuario.toUpperCase(), 
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
	$('#_nombre').validarCaracteres(' abcdefghijklmnñopqrstuvwxyz');
	$('#_apellido').validarCaracteres(' abcdefghijklmnñopqrstuvwxyz');
	$('#_usuario').validarCaracteres('abcdefghijklmnñopqrstuvwxyz0123456789');
	$('#_email').validarCaracteres('_-.@abcdefghijklmnñopqrstuvwxyz0123456789');
	$('#_clave').validarCaracteres('abcdefghijklmnñopqrstuvwxyz0123456789');
	$('#_clave2').validarCaracteres('abcdefghijklmnñopqrstuvwxyz0123456789');
});
//*******************************************************************************************************
$(document).ready(function() // BOOTSTRAP VALIDATOR
{ 
    $('#ModificarFoto').bootstrapValidator
	({
//-------------------------------------------------------------------------------------------------------
       <!-- container: '#messages',-->
	   	message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
//-------------------------------------------------------------------------------------------------------
        fields: 
		{
	//----------------------------------------------------------------------------		
        	_foto: 
			{
                validators:	
				{
                    notEmpty: { message: 'El campo es obligatorio' },
					file: 
					{	
						extension: 'jpeg,jpg,png',
						type: 'image/jpeg,image/png',
						maxSize: 1048576,   // 2048 * 1024
						message: 'El archivo seleccionado es invalido'
                    }
             	}
            },
	//----------------------------------------------------------------------------
		}
//-------------------------------------------------------------------------------------------------------	
    });
});
//*******************************************************************************************************
$(document).ready(function() // BOOTSTRAP VALIDATOR
{ 
    $('#ModificarDatos').bootstrapValidator
	({
//*********************************************************************************
       <!-- container: '#messages',-->
	   	message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
//*********************************************************************************
        fields: {
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
                    stringLength:	{ min: 4, max: 10, message: 'Debe tener entre 4 a 10 caracteres' }
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
		}
//*********************************************************************************	
    });
});
//*******************************************************************************************************
$(document).ready(function() // BOOTSTRAP VALIDATOR
{ 
    $('#ModificarClave').bootstrapValidator
	({
//-------------------------------------------------------------------------------------------------------
       <!-- container: '#messages',-->
	   	message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
//-------------------------------------------------------------------------------------------------------
        fields: {
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
            }
//----------------------------------------------------------------------------
		}
//-------------------------------------------------------------------------------------------------------	
    });
});
//*******************************************************************************************************
function validar_datos() //VALIDAR LETRAS Y NUMEROS
{	
		/*if(	validarNombre() && validarApellido() &&	validarUsuario()) 
		{	
			document.ModificarDatos.submit();	
		}*/
}
//*******************************************************************************************************
function validar_clave()
{	
	/*if(	validarClave())
	{	
		document.ModificarClave.submit();	
	}*/
}
</script>

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
    		<!--**************************** MODIFICAR FOTO ******************************************--> 
    		<div class="col-sm-offset-2 col-sm-8   col-md-offset-3 col-md-6    col-lg-offset-3 col-lg-6    col-xs-12">
        	<div class="panel panel-primary">
          		
                <div class="panel-heading">
					<h3 align="center">MODIFICAR FOTO DE PERFIL</h3>
				</div>
          	
            <div class="panel-body">
           
            	<!-- foto -->
                <div class="form-group" align="center">
                    <div class="input-group" style="width:200px; border:2px solid #000;">
                        <span class="input-group-addon"><i class="fa fa-user-secret"></i></span>
                        
                        <?php if($row_Usuarios_mod['foto']==NULL) { ?>
							<?php if($row_Usuarios_mod['sexo']==1) { ?>
                            <img src="images/masculino.png" class="img-responsive-modal"/>
                            <?php } else { ?>
                            <img src="images/femenino.png" class="img-responsive-modal"/>
                    	<?php } } else { ?>
                    	<img src="data:image/jpg;base64,<?php echo base64_encode($row_Usuarios_mod['foto']);?>"class="img-responsive-modal"/>
                    	<?php } ?>
                        
                    </div>
                </div>
                <!-- foto -->
                
            	<form id="ModificarFoto" name="ModificarFoto" method="POST" action="usuarios_mod_foto" enctype="multipart/form-data">
            	<input type="hidden" id="_id" name="_id" value="<?php echo encrypt_decrypt('encrypt',$id);?>">
                
                	<div class="form-group">
                        <div class="input-group">
                            <div class="div-titulos">
                                <label class="span-titulos" control-label>Foto de Perfil:</label>
                            </div>
                            <span class="input-group-addon"><i class="fa fa-user-secret"></i></span>
                            <input type="file" class="form-control" id="_foto" name="_foto">						
                        </div>
                    </div>
          	
            		<div class="linea-celeste"></div>
                
                    <div class="form-group">
                        <div align="center" class="panel-negro">
                            <input type="submit" class="btn btn-primary" value="Modificar" onClick="">
                        </div>
                    </div>
               	</form>    
               	
				<?php if($row_Usuarios_mod['foto'] != NULL) { ?>
                <form id="EliminarFoto" name="EliminarFoto" method="POST" action="usuarios_eli_foto" enctype="multipart/form-data">
                <input type="hidden" id="_id" name="_id" value="<?php echo encrypt_decrypt('encrypt',$id);?>">
                	                        
                    <div class="form-group">
                        <div align="center" class="panel-negro">
                            <input type="submit" class="btn btn-danger" formaction="usuarios_eli_foto" value="Eliminar" onClick="">
                        </div>    
                    </div>
                </form>
                <?php } ?>
               	
                </div> <!--panel-body-->   
          	</div> <!--panel panel-primary-->
       	</div> <!--col-->
        
    
    	<!--**************************** MODIFICAR INFO ******************************************--> 
		<div class="col-sm-offset-2 col-sm-8   col-md-offset-3 col-md-6    col-lg-offset-3 col-lg-6    col-xs-12">
        	<div class="panel panel-primary">
          		
                <div class="panel-heading">
					<h3 align="center">MODIFICAR INFORMACION PERSONAL</h3>
				</div>
          	
            <div class="panel-body">
      	    <form id="ModificarDatos" name="ModificarDatos" method="POST" action="usuarios_mod_info">
              	
                <input type="hidden" id="_id" name="_id" value="<?php echo encrypt_decrypt('encrypt',$id);?>">
              
              		<div class="form-group">
				        <div class="input-group">
                          	<div class="div-titulos">
                            	<label class="span-titulos control-label">Nombre:</label>
                           	</div>
					          <span class="input-group-addon"><i class="fa fa-user-secret"></i></span>
					          <input class="form-control" id="_nombre" name="_nombre" type="text" value="<?php echo encrypt_decrypt('decrypt', $row_Usuarios_mod['nombre']); ?>">						
                 		</div>
			       	</div>
		          
              
                  	<div class="form-group">
        				<div class="input-group">
                        	<div class="div-titulos">
                            	<label class="span-titulos control-label">Apellido:</label>
                           	</div>
        						<span class="input-group-addon"><i class="fa fa-user-secret"></i></span>
        						<input class="form-control" id="_apellido" name="_apellido" type="text" value="<?php echo encrypt_decrypt('decrypt', $row_Usuarios_mod['apellido']); ?>">						
                  		</div>
        			</div>
        			
              	
                    <div class="form-group">
                        <div class="input-group">
                            <div class="div-titulos">
                                <label class="span-titulos control-label">Usuario:</label>
                                <span id="resultado"></span>
                           	</div>
                                <span class="input-group-addon"><i class="fa fa-user-secret"></i></span>
                                <input class="form-control" id="_usuario" name="_usuario" type="text" style="text-transform:uppercase" value="<?php echo encrypt_decrypt('decrypt', $row_Usuarios_mod['usuario']); ?>"> 							
                 		</div>
          			</div>
                    
                    
                    <div class="form-group">
        				<div class="input-group">
                        	<div class="div-titulos">
                            	<label class="span-titulos control-label">Email:</label>
                           	</div>
        						<span class="input-group-addon"><i class="fa fa-user-secret"></i></span>
        						<input class="form-control" id="_email" name="_email" type="text" value="<?php echo encrypt_decrypt('decrypt', $row_Usuarios_mod['email']); ?>">						
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
                                    	<td><input type="radio" id="_sexo" name="_sexo" value="0" <?php if (!(strcmp(htmlentities($row_Usuarios_mod['sexo'], ENT_COMPAT, ''),0))) {echo "checked=\"checked\"";} ?>> Femenino</td>
                                    </tr>
                                    <tr>
                                    	<td><input type="radio" id="_sexo" name="_sexo" value="1" <?php if (!(strcmp(htmlentities($row_Usuarios_mod['sexo'], ENT_COMPAT, ''),1))) {echo "checked=\"checked\"";} ?>> Masculino</td>
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
                                    	<td><input type="radio" id="_estado" name="_estado" value="1" <?php if (!(strcmp(htmlentities($row_Usuarios_mod['estado'], ENT_COMPAT, ''),1))) {echo "checked=\"checked\"";} ?>> Activo</td>
                                    </tr>
                                    <tr>
                                    	<td><input type="radio" id="_estado" name="_estado" value="0" <?php if (!(strcmp(htmlentities($row_Usuarios_mod['estado'], ENT_COMPAT, ''),0))) {echo "checked=\"checked\"";} ?>> Inactivo</td>
                                    </tr>
                                </table>
                            </div>						
                        </div>
                    </div>


              		<div class="form-group">
      				  	<div class="input-group">
                        	<div class="div-titulos">
                                <label class="span-titulos control-label">Tipo de Usuario:</label>
                            </div>
                                <span class="input-group-addon"><i class="fa fa-user-secret"></i></span>
                                <select class="form-control" id="_idtipo" name="_idtipo">
                                    <?php do { ?>
                                    <option value="<?php echo $row_Tipo['idtipo']?>" 
                                    <?php if (!(strcmp($row_Tipo['idtipo'], 
                                    htmlentities($row_Usuarios_mod['idtipo'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>
                                    <?php echo encrypt_decrypt('decrypt', $row_Tipo['tipo'])?>
                                    </option>
                                    <?php } while ($row_Tipo = $rs_Tipo->fetch_assoc());?>
                                </select>
                    	</div>
      				</div>
                    <?php } ?>
                    
					      			  
                    <div class="linea-celeste"></div>
                    
                    <div class="form-group">
                        <div align="center" class="panel-negro">
                            <input type="submit" class="btn btn-primary" value="Modificar" onClick="validar_datos();">
                       	</div>
                    </div>                    
                    
       			</form>
                </div> <!--panel-body-->   
          	</div> <!--panel panel-primary-->
       	</div> <!--col-->

		
		<!--**************************** MODIFICAR CLAVE ******************************************-->      
        <div class="col-sm-offset-2 col-sm-8   col-md-offset-3 col-md-6    col-lg-offset-3 col-lg-6    col-xs-12">    
        	<div class="panel panel-primary">
          		
                <div class="panel-heading">
					<h3 align="center">MODIFICAR CLAVE DE ACCESO</h3>
				</div>
          	
            	<div class="panel-body">
            	<form id="ModificarClave" name="ModificarClave" method="POST" action="usuarios_mod_clave">
		        
        			<input type="hidden" name="_id" value="<?php echo encrypt_decrypt('encrypt',$id);?>">
        		
              	
		       	    <div class="form-group">
				    	<div class="input-group">
                        	<div class="div-titulos">
                                <label class="span-titulos control-label">Clave:</label>
                            </div>
								<span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
						        <input class="form-control" id="_clave" name="_clave" type="password" value="" placeholder="**********">						
                 		</div>
				   	</div>
			        
          			<div class="form-group">
          		  		<div class="input-group">
          					<div class="div-titulos">
                                <label class="span-titulos control-label">Confirmar Clave:</label>
                            </div>
                                <span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
                                <input class="form-control" id="_clave2" name="_clave2" type="password" value="" placeholder="**********"> 							
                 		</div>
          			</div>
          		    
                    <div class="linea-celeste"></div>
                    
                    <div class="form-group">
                        <div align="center" class="panel-negro">
                            <input type="submit" class="btn btn-primary" value="Modificar" onClick="validar_clave();">
                       	</div>
                    </div>  
                     
	          	</form>  
          	
            	</div> <!--panel-body-->
        	</div> <!--panel panel-primary-->
        </div> <!--col-->
		<!--**************************** MODIFICAR CLAVE ******************************************-->
        
    </div> <!--row-->
</div> <!--container-->
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
<?php } else { 
$mensaje = "Acceso denegado.";
echo "<script>";
echo "alert('$mensaje');";
//echo "window.location='grupos';"; echo "history.back();";
echo "history.go(-1);";
echo "</script>";
} ?>