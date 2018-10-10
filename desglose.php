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

<script>
var READY_STATE_COMPLETE=4;
var peticion_http = null;

function inicializa_xhr() {
	if (window.XMLHttpRequest) return new XMLHttpRequest(); 
	if (window.ActiveXObject) return new ActiveXObject("Microsoft.XMLHTTP"); 
}

function cargaCliente(){
	document.forms[0].submit();
}
function desglose(pedid) {

	peticion_http = inicializa_xhr();
	if(peticion_http) {
		peticion_http.onreadystatechange = procesaRespuesta;
		peticion_http.open("POST", "includes/desglose/lineasdesglose.php", true);
		peticion_http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		peticion_http.send("PEDID="+pedid+"&nocache="+Math.random());
	}
}
function procesaRespuesta() {
	if (peticion_http.readyState==4 && peticion_http.status==200){
	   var matriz = eval('(' + peticion_http.responseText + ')');
	   var salida="<table id='rejilla' align='center'>";
	       salida +="<tr>";
	       salida +="<th width='150px'>PRODUCTO</th>";
	       salida +="<th width='75px'>PRECIO</th>";
	       salida +="<th width='75px'>CANTIDAD</th>";
	       salida +="<th width='75px'>DESCUENTO</th>";
	       salida +="<th width='75px'>TOTAL</th>";
	       salida +="</tr>";
         for(var i in matriz){
		   	var otra=eval(matriz[i]);
		    salida +="<tr>";
		    salida +="<td align='left'>"+otra[0]+"</td>";
		    salida +="<td align='right'>"+otra[1]+"</td>";
		    salida +="<td align='right'>"+otra[2]+"</td>";
		    salida +="<td align='right'>"+otra[3]+"</td>";
		    salida +="<td align='right'>"+otra[4]+"</td>";
		    salida +="</tr>";
		   }
		   document.getElementById("divelementos").innerHTML =salida+"</table>";
	 
	}
}

function hilite(elem){	elem.style.background = '#FFC';}
function lowlite(elem){	elem.style.background = '';}



</script>
<script type="text/javascript" src="js/filtro.js"></script>
</head>
<body>
<?php require_once("general/connection_db.php"); ?>
<?php require_once("general/funciones.php"); ?>
<?php require_once("includes/combobox.php"); ?>
<?php require_once("includes/desglose/gestion_desglose.php"); ?>
<?php include("general/header.php"); ?>

<div id='tabla_resultados'>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>"> 
<?php	
if(!isset($_REQUEST['tb2'])) {	$_REQUEST['tb2']='NULL';}
echo "<p>Clientes: ".mostrar_clientes( $_REQUEST['tb2'],'tb2','si')."</p>"; 

$m=array("PEDID"=>"P.PEDID",
         "CLIENTE"=>"P.CLIID",
		 "FECHA PEDIDO"=>"P.FECHA_PEDI");

if (!isset($_SESSION['tipo']) ||
(isset($_SESSION['tipo']) && $_SESSION['tipo']!='desglose') ){
			$_SESSION['tipo']='desglose';
			$_SESSION['cbcaja']='';
			$_SESSION['txcaja']='';
}
?>		
<fieldset><legend>Filtrar</legend> <?php echo comboycaja($m,1);?>	</fieldset> 
</form>
<?php
if(isset($_REQUEST['tb2'])) {
	include('general/Clase_paginador.php');
	$num_rows=obtener_num_pedidos($_REQUEST['tb2']);
	$pages = new Clase_paginador(true,$num_rows,5);
	echo mostrar_tabla($_REQUEST['tb2']);
}
echo "<div id='divelementos'></div>";
echo "</div>";
?>
<?php require_once("general/footer.php"); ?>
</body>
</html>