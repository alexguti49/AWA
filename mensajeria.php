<?php

//session_start();

	include'mensajeria_grupos.php';
	
		if(!isset($_SESSION["sesion_idusuario"]))
		{
			header('Location:index');
		}
		
		$sesion_idusuario = $_SESSION['sesion_idusuario'];
		$sesion_idtipo = $_SESSION['sesion_idtipo'];
		
	$sql_user = "SELECT * FROM usuarios WHERE usuarios.idusuario = $sesion_idusuario";
	$rs_user = $mysqli->query($sql_user); 
	$row_user = $rs_user->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Mensajeria</title>
    
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

<style type="text/css">
	.panel {
		background-color: rgba(0,0,0,0.7);
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
<!----------------------------------------------------------------------------------------------------------->
<main>
<div class="container">
    <div class="row">
        <div class="col-sm-offset-2 col-sm-8   col-md-offset-3 col-md-6    col-lg-offset-3 col-lg-6   col-xs-12">
            <div class="panel panel-primary">
                
                <div class="panel-heading">
                    <h2 align="center">AWA Messenger</h2>
                </div>
                
                <div class="panel-body">
               	<form class="form-horizontal" id="" role="form" action="mensajeria_envio" method="post">
                	<input type="hidden" name="message" id="message">
                        
                    <label style="margin-top:-5px">Destinatarios</label>								
                    <div class="form-group">
                        <div class="input-group1">
                            <span class="input-group-addon1">
                            	<i class="fa fa-users"></i>
                            	<span class="span-grupo">Grupo</span>
                            </span>
                            <select class="form-control" name="grupos" id="grupos" style="color:#fff" onfocus="this.value=''">
                                <option style="color:#0CD1D4">Selecciones un Grupo:</option><?php ListarGrupos(); ?>
                            </select>
                        </div>
                    </div>
                    
                                          
                  	<div class="form-group">
                    	<div class="input-group1">
                            <span class="input-group-addon1" style="text-align:left;padding-left:20px">
                                <i class="fa fa-phone-square"></i>
                                <span class="span-celular">Celular</span>
                                <i class="fa fa-user-plus"></i>
                                <span class="span-contacto">Contacto</span>
                            </span>
                            <select id="contactos" name="numero[]" class="form-control" style="color:#fff" onfocus="this.value=''" multiple>  
                                <script>
                                $( "#grupos" ).change(function() 
                                {
                                    var contacto = $("select#grupos option:selected").val();
                                    var datastring = 'contacto='+contacto;
                                
                                        $.ajax
                                        ({
                                            type: 'POST',
                                            url: 'mensajeria_contactos.php',
                                            data: datastring,
                                            success: function(data)
                                            {
                                                $('#contactos').html('');
                                                $('#contactos').html(data);
                                            }
                                        });
                                });
                                </script>
                                    
                            </select>
                        </div>
                    </div>
                        
                    <!------------------LINEA CELESTE-------------->
                    <div class="linea-celeste"></div>		
                    
                    <label>Texto</label>
                    <div class="form-group">
                    	<div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
                            <textarea name="texto" type="text" class="form-control" placeholder="Escriba su mensaje aquí..." onfocus="this.value=''"></textarea>                       	</div>
                    </div>

                    <!------------------LINEA CELESTE-------------->
                    <div class="linea-celeste"></div>			

                    <label>Multimedia</label>
                    <div class="form-group">
                        <!-- <label class="control-label hidden-xs col-sm-2" for="image">Image</label> -->
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-file-image-o"></i></span>
                            <input name="urlimagen" type="url" class="form-control" placeholder="Ingrese URL de la Imagen... " onfocus="this.value=''">
                        </div>
                    </div>
                    
                    <div class="form-group">
                    	<div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-file-audio-o"></i></span>
                            <input name="urlaudio" type="url" class="form-control"   placeholder="Ingrese URL del Audio..." onfocus="this.value=''">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-file-video-o"></i></span>
                            <input name="urlvideo" type="url" class="form-control" placeholder="Ingrese URL del Video..." onfocus="this.value=''">
                        </div>
                    </div>
            
                    <!------------------LINEA CELESTE-------------->
                    <div class="linea-celeste"></div>	
                    
                    <div class="form-group">
                        <div align="center" class="panel-negro">
                            <input id="submit" type="submit" class="btn btn-primary" value="Enviar" onClick="">
                        </div>
                    </div>
                    		

            		<!--<div id="formcontrols" class="col-sm-push-1 col-md-push-2 col-lg-push-1 col-xs-6 col-sm-5">
                            <button id="submit" type="submit" class="btn btn-primary btn-block">Enviar</button>
                        </div>
                        <div class="col-sm-push-1 col-md-push-2 col-lg-push-1 col-xs-6 col-sm-5">
                            <button id="logout" type="button" class="btn btn-danger btn-block">Salir</button>
                        </div>-->	
                    
                </form>
                    
                </div> <!-- /.panel panel-body -->
            </div> <!-- /.panel panel-default -->
        </div> <!-- /.col -->
    </div> <!-- /.row -->
</div> <!-- /.container -->
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
