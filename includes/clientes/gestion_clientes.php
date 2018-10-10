<?php
require_once("includes/combobox.php");

function formulario_editar(){
	global $cadenita;
	$cliente=obtener_cliente_por_id($_GET['CLIID']);

	echo "<fieldset style='width:300px;margin=auto;'>";
	echo "<legend>Editar Cliente</legend>";


	echo sprintf("<form method='post' action='%s?respuesta=3&CLIID=%s&%s' >",$_SERVER['PHP_SELF'],$_GET['CLIID'],$cadenita);
	echo "<table align=center>";
	
	echo fila("Cliente","text","CLIID",5,5,$cliente["CLIID"]);
	echo fila("Empresa","text","EMPRESA",40,40,$cliente["EMPRESA"]);
	echo fila("Nombre Contacto","text","NOMBRE_CONTACTO",30,30,$cliente["NOMBRE_CONTACTO"]);
	echo fila("Cargo Contacto","text","CARGO_CONTACTO",30,30,$cliente["CARGO_CONTACTO"]);
	echo fila("Dirección","text","DIRECCION",30,30,$cliente["DIRECCION"]);
	echo fila("Ciudad","text","CIUDAD",15,15,$cliente["CIUDAD"]);
	echo fila("Region","text","REGION",15,15,$cliente["REGION"]);
	echo fila("CP","text","CODIGO_POSTAL",10,10,$cliente["CODIGO_POSTAL"]);
	echo fila("Pais","text","PAIS",15,15,$cliente["PAIS"]);
	echo fila("Telefono","text","TELEFONO",24,24,$cliente["TELEFONO"]);
	echo fila("Fax","text","FAX",24,24,$cliente["FAX"]);
	echo fila_pie("Actualizar",$cadenita);
	echo "</table></form></fieldset>";

}

function formulario_insertar(){
global $cadenita;
echo "<fieldset style='width:300px;margin=auto;'>";
echo "<legend>Insertar Cliente</legend>";

echo sprintf("<form method='post' action='%s?respuesta=1&%s' >",$_SERVER['PHP_SELF'],$cadenita);
echo "<table align=center>";
echo fila("Cliente","text","CLIID",5,5,""); 
echo fila("Empresa","text","EMPRESA",40,40,"");
echo fila("Nombre Contacto","text","NOMBRE_CONTACTO",30,30,""); 
echo fila("Cargo Contacto","text","CARGO_CONTACTO",30,30,""); 
echo fila("Dirección","text","DIRECCION",30,30,""); 
echo fila("Ciudad","text","CIUDAD",15,15,""); 
echo fila("Region","text","REGION",15,15,""); 
echo fila("CP","text","CODIGO_POSTAL",10,10,"");
echo fila("Pais","text","PAIS",15,15,""); 
echo fila("Telefono","text","TELEFONO",24,24,""); 
echo fila("Fax","text","FAX",24,24,""); 
echo fila_pie("Crear Cliente",$cadenita); 
echo "</table></form></fieldset>";
}
function obtener_cliente_por_id($cliente){
	global $conexion;
	$consulta = "SELECT * FROM clientes WHERE CLIID='$cliente' LIMIT 1";
	$respuesta = $conexion->query($consulta);

	if($fila = $respuesta->fetch_array(MYSQLI_BOTH))return $fila;
	return NULL;
}

function respuesta_a_editar(){
		global $conexion;
		$errores = validar_campos_obligatorios(array("CLIID"));
		
	if(!empty($errores)) return "No se han podido validar los datos";
	
	$ma=array("CLIID","EMPRESA","NOMBRE_CONTACTO","CARGO_CONTACTO","DIRECCION","CIUDAD","REGION","CODIGO_POSTAL","PAIS","TELEFONO","FAX");
	
	foreach($ma as $e)	
	$$e = preparar_consulta(htmlentities($_POST[$e],ENT_QUOTES,"UTF-8"));
		
		$consulta = sprintf("UPDATE clientes 
		SET CLIID='%s',EMPRESA='%s',NOMBRE_CONTACTO='%s',
		CARGO_CONTACTO='%s',DIRECCION='%s',CIUDAD='%s',
		REGION='%s',CODIGO_POSTAL='%s',PAIS='%s',
		TELEFONO='%s',FAX='%s' WHERE CLIID='%s'",
		$CLIID,$EMPRESA,$NOMBRE_CONTACTO,$CARGO_CONTACTO,$DIRECCION,
		$CIUDAD,$REGION,$CODIGO_POSTAL,$PAIS,$TELEFONO,$FAX,
		$_GET["CLIID"]	);
	
	$_GET=array();
	$_POST=array();
		if($conexion->query($consulta))  return "Actualizaci�n exitosa";
		return "No se ha podido actualizar el Cliente" . $conexion->connect_error;	
}
function respuesta_a_insertar(){
	global $conexion;
	if(!isset($_POST["CLIID"])) return "No esta definido El cliente";

		$errores = validar_campos_obligatorios(array("CLIID"));
		
		if(!empty($errores)) return "No se han podido validar los datos";
	
		$ma=array("CLIID","EMPRESA","NOMBRE_CONTACTO","CARGO_CONTACTO","DIRECCION","CIUDAD","REGION","CODIGO_POSTAL","PAIS","TELEFONO","FAX");
		
		foreach($ma as $e)	
			$$e = preparar_consulta(htmlentities($_POST[$e],ENT_QUOTES,"UTF-8"));
			
		$consulta=sprintf("INSERT INTO clientes VALUES(
			'%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
			$CLIID,$EMPRESA,$NOMBRE_CONTACTO,$CARGO_CONTACTO,$DIRECCION,
			$CIUDAD,$REGION,$CODIGO_POSTAL,$PAIS,$TELEFONO,$FAX);

			if($conexion->query($consulta))  return "Inserción exitosa";
			return "No se ha podido crear el Cliente" . $conexion->connect_error;
		
}

function respuesta_a_borrar(){
global $conexion;
$consulta = sprintf("DELETE FROM clientes WHERE CLIID='%s'",	$_GET["CLIID"]);
$conexion->query($consulta);

if(mysqli_affected_rows($conexion) == 1) return "Borrado exitoso";
return "<p>Se ha producido un error al	intentar eliminar un departamento: " . mysql_error() ."</p>";
}
function mostrar_tabla(){
	global $conexion;
	global $pages;
	global $cadenita;

	echo "<div class='nuevo'>";
	echo $pages->display_pages();
	echo"<br/><br/>";
	echo "<span class=\"\">".$pages->display_jump_menu().$pages->display_items_por_pagina()."</span>";
	echo "</div>";

	$consulta="SELECT * FROM clientes ";
	if ($_SESSION['txcaja']!='') $consulta .=" WHERE ".$_SESSION['cbcaja']." like '".$_SESSION['txcaja']."%'";
	$consulta .=" ORDER BY EMPRESA ASC LIMIT ";
	$consulta .=$pages->limite_inicial.",".$pages->limite_final;

	$resultado = $conexion->query($consulta);
	
	echo utf8_encode("<table id='rejilla' width='70%'>");
			
	$m=array("CLIID","EMPRESA","NOMBRE_CONTACTO","CARGO_CONTACTO","DIRECCION","CIUDAD","REGION","CODIGO_POSTAL","PAIS","TELEFONO","FAX","ACCION");
	
	$salida="<tr>";
	foreach($m as $e) $salida .="<th>".utf8_encode($e)."</th>";	
	echo $salida."</tr>";		
	
	echo utf8_encode("<caption  onclick=\"window.location='$_SERVER[PHP_SELF]?op=1&$cadenita' \">Nuevo Cliente</caption>");
	
	while($f=$resultado->fetch_array(MYSQLI_BOTH)){
		$z=sprintf("%s",$f["CLIID"]);
		$salida=sprintf("<tr 
				onmouseover=\"hilite(this)\" onmouseout=\"lowlite(this)\">
				<td>%s</td><td>%s</td><td>%s</td><td>%s</td>
				<td>%s</td><td>%s</td><td>%s</td><td>%s</td>
				<td>%s</td><td>%s</td><td>%s</td>
				",
				poner("CLIID_$z",5,5,$f["CLIID"]),
				poner("EMPRESA_$z",10,40,$f["EMPRESA"]),
				poner("NOMBRE_CONTACTO_$z",10,30,$f["NOMBRE_CONTACTO"]),
				poner("CARGO_CONTACTO_$z",10,30,$f["CARGO_CONTACTO"]),
				poner("DIRECCION_$z",10,30,$f["DIRECCION"]),
				poner("CIUDAD_$z",10,15,$f["CIUDAD"]),
				poner("REGION_$z",10,15,$f["REGION"]),
				poner("CODIGO_POSTAL_$z",10,10,$f["CODIGO_POSTAL"]),
				poner("PAIS_$z",10,15,$f["PAIS"]),
				poner("TELEFONO_$z",10,24,$f["TELEFONO"]),
				poner("FAX_$z",10,24,$f["FAX"])
				);
		$salida.=sprintf("<td align='center'><a href='?op=3&CLIID=%s&%s'>Editar</a>&nbsp;&nbsp;", $f['CLIID'],$cadenita);
		$salida.=sprintf("<a id='clientes_%s'  href='#' onClick='poner(this);' >Actualizar</a>&nbsp;&nbsp;", $f['CLIID']);
		$salida.=sprintf("<a href='?op=2&CLIID=%s&%s'>Borrar</a></td>", $f['CLIID'],$cadenita);
		echo $salida."</tr>\n";
	}
	echo "</table>\n";

	echo "<div class='nuevo'>";
	echo $pages->display_pages();
	echo "</div>";


}

?>