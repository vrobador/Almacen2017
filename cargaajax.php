<?php require("general/session.php");?>
<?php verificar_sesion(); ?>
<!DOCTYPE html>
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
</style>
<script type="text/javascript">
var READY_STATE_COMPLETE=4;
var peticion_http = null;

function inicializa_xhr(){
	if (window.XMLHttpRequest) 	return new XMLHttpRequest(); 
	if (window.ActiveXObject) return new ActiveXObject("Microsoft.XMLHTTP"); 
}
function cargaCliente() {
  var lista = document.getElementById("clientes");
  var cliente = lista.options[lista.selectedIndex].value;
    peticion = inicializa_xhr();
    if (peticion) {
	
      peticion.onreadystatechange = muestraCliente;
      peticion.open("POST", "includes/carro/cargaCliente.php?nocache=" + Math.random(), true);
      peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      peticion.send("CLIID=" + cliente);
    }

}
function muestraCliente() {
	if (peticion.readyState==4 && peticion.status==200){
	   var matriz = eval('(' + peticion.responseText + ')');
	   var o=["nombre","nombre_contacto","cargo_contacto","direccion","ciudad","region","codigo_postal","pais","telefono","fax"];
		   for(var i in matriz) {
		   	 var otra=eval(matriz[i]);
		   	 
			 for(k=0;k<o.length;k++)  	 
			 document.getElementById(o[k]).value=otra[k];
		   }
	}else{ 
		document.getElementById("myDiv").innerHTML='<img src="images/load.gif" width="50" height="50" />'; 
	}
	}

function muestraClientes() {
  if (peticion.readyState == 4) {
    if (peticion.status == 200) {
      var lista = document.getElementById("clientes");
      var clientes = eval('(' + peticion.responseText + ')');

      var i=0;
      lista.options[i++] = new Option("- selecciona -");
      for(var codigo in clientes) {
        lista.options[i++] = new Option(clientes[codigo], codigo);
      }
    }
  }
}

window.onload = function() {
  peticion = inicializa_xhr();
  if(peticion) {
    peticion.onreadystatechange = muestraClientes;
    peticion.open("POST", "includes/carro/cargaClientes.php?nocache="+Math.random(), true);
    peticion.send(null);
  }

  document.getElementById("clientes").onchange = cargaCliente;
} 


</script>
<link rel="stylesheet" type="text/css" href="estilos.css" />

</head>

<body>

<?php require_once("general/connection_db.php"); ?>
<?php require_once("general/funciones.php"); ?>
<?php require_once("includes/carro/gestion_carro_compra.php"); ?>
<?php include("general/header.php"); ?>

<?php

if (isset($_POST['destinatario'])){
   $mensaje=respuesta_a_pedido($_SESSION['carro']);
}
?>
<div id="tabla_resultados">

<?php if(isset($mensaje)) { echo "<p style='color:red;font-size=24px'>" . $mensaje . "</p>"; } ?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

   <table width="100%">
   <tr>
   <td width="50%">
   <?php boton("mostrar_carro.php","shopping_cart_up.png","Hacer el Pedido","left"); ?>
   </td>
   <td width="50%">
   <?php boton("#","shopping_cart_accept.png","Confirmar el pedido","right",false);?>
   </td>
   </tr>
   </table>

  <fieldset>
  <legend>Cliente  
  <select id="clientes" name="clientes">
          <option>Cargando...</option>
    	</select>
  </legend>
  
  <table width="80%" border="0" align="center">
      <tr>
	      <th width="33%" scope="col">NOMBRE</th>  
	      <th>NOMBRE CONTACTO</th> 
	      <th >CARGO CONTACTO</th>
	  </tr>
      <tr>
      <td align="center"><input name="nombre"          type="text" disabled="disabled" id="nombre"          size="30" maxlength="40"></td>
      <td align="center"><input name="nombre_contacto" type="text" disabled="disabled" id="nombre_contacto" size="30" maxlength="30"></td>
      <td align="center"><input name="cargo_contacto"  type="text" disabled="disabled" id="cargo_contacto"  size="30" maxlength="30"></td>
     </tr> 
    <tr>  
   		 <th >PAIS</th>  
         <th >REGION</th>
         <th width="33%" scope="col">CIUDAD</th>
        
    </tr>  
     <tr>
   <td align="center"><input name="pais"     id="pais"     type="text" disabled="disabled" size="30" maxlength="15"></td>
   <td align="center"><input name="region"   id="region"   type="text" disabled="disabled" size="30" maxlength="15"></td>
   <td align="center"><input name="ciudad"   id="ciudad"       type="text" disabled="disabled" size="30" maxlength="15"></td>	
     </tr>
    <tr>  
      <th >DIRECCION</th>
      <th >CP</th>
      <th >TELEFONO</th>
    </tr>
     <tr>
   <td align="center"><input name="direccion"     id="direccion"    type="text" disabled="disabled" size="30" maxlength="60"></td>
   <td align="center"><input name="codigo_postal" id="codigo_postal"type="text" disabled="disabled" size="30" maxlength="10"></td>
   <td align="center"><input name="telefono" id="telefono" type="text" disabled="disabled" size="30" maxlength="24"></td>
    </tr> 
    <tr>    
       <th>&nbsp;</th>
       <th>FAX</th>
       <th>&nbsp;</th>
    </tr>
     <tr>
      <td>&nbsp;</td>
      <td align="center"><input name="fax"      id="fax"      type="text" disabled="disabled" size="30" maxlength="24"></td>
      <td>&nbsp;</td>
     </tr> 
 
  
  </table>
  </fieldset>
  <br/> 
  <fieldset><legend>Datos Pedido</legend>
  <table width="80" border="0" align="center">
    <tr>
      <th width="33%" scope="col">DESTINATARIO</th>
      <th >PAIS</th> 
      <th width="33%" scope="col">REGION</th>
    </tr>
    <tr>
      <td align="center"><input name="destinatario" type="text"  id="destinatario"  size="30" maxlength="40"></td>
      <td align="center"><input name="pais_desti"    type="text"  id="pais_desti"   size="30" maxlength="15"></td>
      <td align="center"><input name="regio_desti"  type="text"  id="regio_desti"   size="30" maxlength="15"></td>
    </tr>
    
    <tr>  
      <th width="10%" scope="col">CIUDAD</th>
      <th width="45%" scope="col">DIRECCION</th> 
      <th >C.P.</th>
    </tr>
    <tr>
      <td align="center"><input name="ciuda_desti" type="text"  id="ciuda_desti"  size="30" maxlength="15"></td>
      <td align="center"><input name="direc_desti"  type="text"  id="direc_desti"   size="30" maxlength="60"></td>
      <td align="center"><input name="cod_pos_desti" type="text"  id="cod_pos_desti"  size="30" maxlength="10"></td>
    </tr>
    <tr>
      <th >&nbsp;</th>
      <th >GASTOS ENVIO</th>
      <th >&nbsp;</th>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="center"><input name="gastos_envio"  type="text"  id="gastos_envio"   size="30" maxlength="10"></td>
      <td>&nbsp;</td>
	 </tr>  </table></fieldset>
  
</form>
</br>

<div id='tabla_carro'>
<p><H1>Productos Solicitados</H1></p>
<?php

 mostrar_carro_compra($_SESSION['carro'],false); 
 
 ?>
</div>

</div>
<?php require_once("general/footer.php"); ?>
</body>

</html>