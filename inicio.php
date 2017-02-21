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
?>
<!DOCTYPE html>
<html>
<head>
	<title>Inicio</title>

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
    <link rel="stylesheet" href="css/inicio.css">
    <link rel="stylesheet" href="css/fuentes.css">
    <link rel="stylesheet" href="css/jquery.dataTables.min.css">

  	<!--	SCRIPTS		-->
	<script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <!--<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>-->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

<style type="text/css">
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
    
        <div class="col-xs-offset-0 col-xs-12">
          
          	<div class="col-xs-offset-0 col-xs-12">
            	<div class="row-mensajeria" align="left">
                	<img src="images/mensajeria.jpg" class="img-rounded img-responsive" alt="Placeholder image">
                    <div class="botones-inicio">
                        <div align="center">
                    	    <a a class="a-inicio" href="mensajeria"><span class="fa-inicio fa-whatsapp" aria-hidden="true"></span> Mensajeria</a>
                       	</div>             
                    </div>	
                 </div>
            </div>
    
          	<div class="col-xs-offset-0 col-xs-12">
              	<div class="row-grupos" align="center">
                    <img src="images/grupos.jpg" class="img-rounded img-responsive" alt="Placeholder image">
                    <div class="botones-inicio">
                        <div align="center">
                            <a a class="a-inicio" href="grupos"><span class="fa-inicio fa-group" aria-hidden="true"></span> Grupos</a>
                        </div>             
                    </div>
              	</div>
			</div>
          
          	<div class="col-xs-offset-0 col-xs-12">
                <div class="row-contactos" align="right">
                    <img src="images/contactos.jpg" class="img-rounded img-responsive" alt="Placeholder image">
                    <div class="botones-inicio">
                        <div align="center">
                        	<a a class="a-inicio" href="contactos"><span class="fa-inicio fa-user" aria-hidden="true"></span> Contactos</a>
                       </div>             
                    </div>	
              	</div>
            </div>
            
        </div> <!-- /.col -->
   	</div> <!-- /.row -->
</div>	<!-- /.container -->
</main>
<!-----------------------------------------------------------------------------------------------------------> 
<footer class="clase-general">
<div class="panel-footer">
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
