//******************************** VALIDA APELLIDO				
			function validarApellido()
			{
				valor = document.getElementById("_apellido").value;
				if(valor == null || valor.length == 0 || /^\s+$/.test(valor)) 
				{
					$("#_apellido").focus();
					alert('Ingrese el Apellido');
					return false;
				} 
				else 
				{ 
					return true;
				}
			}
//******************************** VALIDA NOMBRE			
			function validarNombre()
			{
				valor = document.getElementById("_nombre").value;
				if(valor == null || valor.length == 0 || /^\s+$/.test(valor))
				{
					$("#_nombre").focus();
					alert('Ingrese el Nombre');
					return false;
				} 
				else 
				{ 
					return true;
				}
			}
//******************************** VALIDA USUARIO			
			function validarUsuario()
			{
				valor = document.getElementById("_usuario_mod").value;
				if(valor == null || valor.length == 0 || /^\s+$/.test(valor)) 
				{
					$("#_nombre_mod").focus();
					alert('Ingrese el Usuario');
					return false;
				} 
				else 
				{ 
					return true;
				}
			}
//******************************** VALIDA TIPO USUARIO
			function validarTipoUsuario()
			{
				indice = document.getElementById("_idtipo").selectedIndex;
				if(indice == null || indice=="") 
				{
					$("#_idtipo").focus();
					alert('Seleccione el tipo de Usuario');
					return false;
				} 
				else 
				{ 
					return true;
				}
			}			
//******************************** VALIDA CLAVE
			function validarClave()
			{
				valor = document.getElementById("_clave").value;
				if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) 
				{
					$("#_clave").focus();
					alert('Ingrese la Clave');
					return false;
				} 
				else 
				{ 
					valor2 = document.getElementById("_clave2").value;
					if(valor == valor2) 
					{ 
						return true; 
					}
					else 
					{ 
						$("#_clave2").focus();
						alert('Las Claves no coinciden'); 
						return false;
					}
				}
			}
//******************************** VALIDA CELULAR			
			function validarCelular()
			{
				valor = document.getElementById("_celular").value;
				if(valor == null || valor.length == 0 || /^\s+$/.test(valor)) 
				{
					$("#_celular").focus();
					alert('Ingrese el Celular');
					return false;
				} 
				else 
				{ 
					return true;
				}
			}
//******************************** VALIDA ID GRUPO
			function validarIdgrupo()
			{
				indice = document.getElementById("_idgrupo").selectedIndex;
				if( indice == null || indice=="" ) 
				{
					$("#_idgrupo").focus();
					alert('Seleccione un Grupo');
					return false;
				} 
				else 
				{ 
					return true;
				}
			}
//******************************** VALIDA EL ESTADO (ACTIVO/INACTIVO)
			function validarEstado()
			{
				indice = document.getElementById("_estado").checked;
				if( indice == null || indice=="" ) 
				{
					$("#_estado").focus();
					alert('Seleccione el Estado');
					return false;
				} 
				else 
				{ 
					return true;
				}
			}	
			
			/*var seleccionado = false;
			for(var i=0; i<opciones.length; i++) {    
			  if(opciones[i].checked) {
				seleccionado = true;
				break;
			  }
			}
			 
			if(!seleccionado) {
			  return false;
			}*/