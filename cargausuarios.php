<?php require("general/session.php");?>
<?php verificar_sesion(); ?>
<html>
<head><title>Buscador</title>
<link rel="stylesheet" type="text/css" href="styles/basic.css">
<meta charset="utf-8">
<style type="text/css">
#rejilla{
	margin: 10px auto;
	width: 95%;
	text-align: center;
	border-radius: 20px;
	-webkit-box-shadow: 10px 10px 10px #666666;
	box-shadow: 10px 10px 10px #666666;
	background: rgb(207,231,250); /* Old browsers */
	background: -moz-linear-gradient(top, rgba(207,231,250,1) 0%, rgba(99,147,193,1) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(207,231,250,1)), color-stop(100%,rgba(99,147,193,1))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, rgba(207,231,250,1) 0%,rgba(99,147,193,1) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, rgba(207,231,250,1) 0%,rgba(99,147,193,1) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, rgba(207,231,250,1) 0%,rgba(99,147,193,1) 100%); /* IE10+ */
	background-position: bottom;
	background-color: #6495ED; /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cfe7fa', endColorstr='#6393c1',GradientType=0 ); /* IE6-9 */
	padding-top: 10px;
	padding-right: 10px;
	padding-bottom: 10px;
	padding-left: 10px;
}
#tabla_cliente,#tabla_pedido,#tabla_carro{
	margin: auto;
	min-width:800px;
	max-width:1000px;
	width: 95%;
	text-align: center;
	border-radius: 20px;
	-webkit-box-shadow: 10px 10px 10px #666666;
	box-shadow: 10px 10px 10px #666666;
	background-color: #CCCCCC;
}
legend{
	background-color: #5A97D1;
	padding-top: 5px;
	padding-right: 10px;
	padding-left: 10px;
	padding-bottom: 5px;
	border-radius: 25px;
	color: #FFFFFF;
	border:	solid #FFFFFF 3px;
}

fieldset{
	width: 400px;
	margin: auto;
	margin-bottom: 20px;
	border-radius: 20px;
	padding-top: 20px;
	padding-right: 20px;
	padding-bottom: 20px;
	padding-left: 20px;
	box-shadow: 10px 10px 10px #666666;
	background: rgb(207,231,250); /* Old browsers */
	background: -moz-linear-gradient(top, rgba(207,231,250,1) 0%, rgba(99,147,193,1) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(207,231,250,1)), color-stop(100%,rgba(99,147,193,1))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, rgba(207,231,250,1) 0%,rgba(99,147,193,1) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, rgba(207,231,250,1) 0%,rgba(99,147,193,1) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, rgba(207,231,250,1) 0%,rgba(99,147,193,1) 100%); /* IE10+ */
	background-position: bottom;
	background-color: #6495ED; /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cfe7fa', endColorstr='#6393c1',GradientType=0 ); /* IE6-9 */
}
 

#tabla_resultados{
	font-size: smaller;
	margin: auto;
	width: 100%;
	height: 100%;
	text-align: center;
	border: dotted 1px black;
	overflow: auto;
	background: rgb(207,231,250); /* Old browsers */
	background: -moz-linear-gradient(top, rgba(207,231,250,1) 0%, rgba(99,147,193,1) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(207,231,250,1)), color-stop(100%,rgba(99,147,193,1))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, rgba(207,231,250,1) 0%,rgba(99,147,193,1) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, rgba(207,231,250,1) 0%,rgba(99,147,193,1) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, rgba(207,231,250,1) 0%,rgba(99,147,193,1) 100%); /* IE10+ */
	background-position: bottom;
	background-color: #6495ED; /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cfe7fa', endColorstr='#6393c1',GradientType=0 ); /* IE6-9 */
	padding-bottom: 200px;
}

#cuerpo #tabla_resultados form input ,select{
	color: #6495ED;
	padding-top: 5px;
	padding-right: 5px;
	padding-bottom: 5px;
	padding-left: 5px;
	border-radius: 25px;
	border:trasparent;
}
input:-moz-read-only { /* For Firefox */
    background-color: #98FB98;
}
input:read-only {
    background-color: #98FB98;
}
</style>
<script type="text/javascript">
var READY_STATE_COMPLETE=4;
var peticion = null;

function inicializa_xhr(){
	if (window.XMLHttpRequest) 	return new XMLHttpRequest(); 
	if (window.ActiveXObject) return new ActiveXObject("Microsoft.XMLHTTP"); 
}
function borrarUsuario() {
	 var lista = document.getElementById("usuarios");
	 if (lista.selectedIndex<0)return;
	 var cliente = lista.options[lista.selectedIndex].value;

	  peticion = inicializa_xhr();
	  peticion.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("mensaje").innerHTML = this.responseText;
					lista.remove(lista.selectedIndex);
					 document.getElementById("usuario").value="";
					 document.getElementById("password1").value="";
					 document.getElementById("password2").value="";
			}else{
				document.getElementById("mensaje").innerHTML = "no paso "+this.readyState+" "+this.status;
			}	
		};
		  peticion.open("POST", "includes/usuarios/borrarUsuario.php?nocache=" + Math.random(), true);
	      peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	      peticion.send("usuario=" + cliente);
}

function cargaUsuario() {
  var lista = document.getElementById("usuarios");
  var cliente = lista.options[lista.selectedIndex].value;
    peticion = inicializa_xhr();
    if (peticion) {
      peticion.onreadystatechange = muestraUsuario;
      peticion.open("POST", "includes/usuarios/cargaUsuario.php?nocache=" + Math.random(), true);
      peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      peticion.send("usuario=" + cliente);
    }
}
function muestraUsuario() {
if (peticion.readyState==4 && peticion.status==200){
   var matriz = eval('(' + peticion.responseText + ')');
  	   for(var i in matriz) {
		 document.getElementById("usuario").value=i;
		 document.getElementById("password1").value=eval(matriz[i]);
		 document.getElementById("password2").value=eval(matriz[i]);
	   } 
}else{ 
	document.getElementById("myDiv").innerHTML='<img src="images/load.gif" width="50" height="50" />'; 
}
}

</script>
<link rel="stylesheet" type="text/css" href="estilos.css" />

</head>

<body>

<?php require_once("general/connection_db.php"); ?>
<?php require_once("general/funciones.php"); ?>
<?php require_once("includes/combobox.php"); ?>
<?php include("general/header.php"); ?>

<div id="tabla_resultados">
<div id='mensaje'></div>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  <?php
  $a=isset($_POST["usuarios"]) ? $_POST["usuarios"] : 'NULL';
  echo mostrar_usuarios($a,"usuarios",'si');
  ?>
</form>
  <div id="divusuario">
    <label for="usuario">Nombre de usuario</label>
	<input name="usuario" id="usuario" type="text" /> 
	<label for="password1">Contraseña</label>
	<input name="password1" id="password1" type="password" value="" />
	<label for="password2">Repetir Contraseña</label>
    <input name="password2" id="password2" type="password" value="" />
	
  <div>
		<button onclick="borrarUsuario()">Borrar</button>
  </div>
  </div>


</div>
<?php require_once("general/footer.php"); ?>
</body>

</html>