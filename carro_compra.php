<?php require_once("general/session.php");?>
<?php verificar_sesion(); ?>
<!DOCTYPE html>
<html>
<head>
<title></title>
<link rel="stylesheet" type="text/css" href="styles/paginacion.css">
<link rel="stylesheet" type="text/css" href="styles/comunes.css">
<meta charset="utf-8">
<style type="text/css">
#divcarro{
	margin: auto;
	width: 100%;
	height: 70px;
	text-align: center;
	border: dotted 1px black;
} 

</style>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jqcarro_compra.js"></script>
<script type="text/javascript" src="js/filtro.js"></script>
<script>
var READY_STATE_COMPLETE=4;
var peticion_http = null;

function inicializa_xhr() {
	if (window.XMLHttpRequest) return new XMLHttpRequest(); 
	if (window.ActiveXObject) return new ActiveXObject("Microsoft.XMLHTTP"); 
}

function comprar(pro,pre,nom) {
	peticion_http = inicializa_xhr();
	if(peticion_http) {
		peticion_http.onreadystatechange = procesaRespuesta;
		peticion_http.open("POST", "includes/carro/alacesta.php", true);
		peticion_http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		peticion_http.send("PROID="+pro+"&PRECIO="+pre+"&NOMBRE="+nom+"&nocache="+Math.random());
	}
}
function vaciar_carro() {
	peticion_http = inicializa_xhr();
	if(peticion_http) {
		peticion_http.onreadystatechange = procesaRespuesta;
		peticion_http.open("POST", "includes/carro/vaciar_carro.php", true);
		peticion_http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		peticion_http.send("NULL");
	}
}

function procesaRespuesta() {
	if(peticion_http.readyState == READY_STATE_COMPLETE) {
		if (peticion_http.status == 200) {
		        var cadena=peticion_http.responseText;
				var posi=cadena.indexOf('#');
				var numero=cadena.substr(0,posi);
				var total=cadena.substr(posi+1);
				document.getElementById("divelementos").innerHTML ="Total Elementos = "+numero;
				document.getElementById("divcuantia").innerHTML ="Precio Pedido ="+total+" €";
		}
	}
}
function hilite(elem){	elem.style.background = '#FFC';}
function lowlite(elem){	elem.style.background = '';}


</script>
</head>
<body>
<?php require_once("general/connection_db.php"); ?>
<?php require_once("general/funciones.php"); ?>
<?php require_once("includes/combobox.php"); ?>
<?php require_once("includes/carro/gestion_carro_compra.php"); ?>
<?php include("general/header.php"); ?>

<div id="divcarro">
<table width="100%" cellspacing="0" bgcolor="#cccccc">
  <tr>
  <td align="right" rowspan="2" width="80">
  	<img  id="img1" style="cursor: pointer;" onClick="vaciar_carro()" src="images/shopping_cart_remove.png" width="50" height="50" title="Vaciar Carro"/>
  </td>
  <td id="divelementos" align="right" valign="bottom" height="25">
	  <?php 
	  if (isset($_SESSION['elementos'])){
	  		echo "Total Elementos = ".$_SESSION['elementos'];
	  }else{
		  	echo "Total Elementos = 0";
	  }
	   ?>
  </td>
  <td align="right" rowspan="2" width="80">
  	<a href="mostrar_carro.php">
  	<img id="img2" style="cursor: pointer;" src="images/shopping_cart.png" width="50" height="50" title="Ver Carro"/></a>
  </td>
  </tr>
  <tr>
	  <td id="divcuantia" align="right" valign="top" height="30">
  		<?php 
		if (isset($_SESSION['total_compra'])){
		  echo "Precio Pedido = ".number_format($_SESSION['total_compra'],2)." €"; 
		}else{
			echo "Precio Pedido = 0.00 €"; 
		}
		 ?>
  	  </td>
  </tr>
  </table>
</div>	
<div id='tabla_resultados'>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>"> 
<?php	
if(!isset($_REQUEST['tb1'])) {	$_REQUEST['tb1']='NULL';}
echo "<p>Categorias: ".mostrar_categorias( $_REQUEST['tb1'],'tb1','si')."</p>"; 

//$m=array("PROID","NOMBRE_ESPA");
$m=array("ID"=>"a.PROID",
         "CATEGORIA"=>"C.NOMBRE_CATE",
		 "PROVEEDOR"=>"b.NOMBRE",
		"PRODUCTO"=>"A.NOMBRE_ESPA");

if (!isset($_SESSION['tipo']) ||
(isset($_SESSION['tipo']) && $_SESSION['tipo']!='carro') ){
			$_SESSION['tipo']='carro';
			$_SESSION['cbcaja']='';
			$_SESSION['txcaja']='';
}
?>		
<fieldset><legend>Filtrar</legend> <?php echo comboycaja($m,1);?>	</fieldset> 
</form>
<?php
if(isset($_REQUEST['tb1'])) {
	include('general/Clase_paginador.php');
	$num_rows=obtener_num_prod($_REQUEST['tb1'],$_SESSION['cbcaja'],$_SESSION['txcaja']);
	$pages = new Clase_paginador(true,$num_rows,5);
	echo mostrar_tabla($_REQUEST['tb1']);
}
 echo "</div>";
?>
<?php require_once("general/footer.php"); ?>
</body>
</html>