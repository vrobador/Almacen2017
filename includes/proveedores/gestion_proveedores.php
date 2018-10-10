<?php
require_once("includes/combobox.php");

function formulario_editar(){
	global $cadenita;
	$cliente=obtener_proveedor_por_id($_GET['PROVID']);

	echo "<fieldset style='width:300px;margin=auto;'>";
	echo "<legend>Editar Proveedor</legend>";
	
	echo sprintf("<form method='post' action='%s?respuesta=3&PROVID=%s&%s' >",$_SERVER['PHP_SELF'],$_GET['PROVID'],$cadenita);
	echo "<table align=center>";
	echo fila("Proveedor","text","PROVID",11,11,$cliente["PROVID"]);
	echo fila("NOMBRE","text","NOMBRE",40,40,$cliente["NOMBRE"]);
	echo fila("Nombre Contacto","text","NOMBRE_CONTACTO",30,30,$cliente["NOMBRE_CONTACTO"]);
	echo fila("Cargo Contacto","text","CARGO_CONTACTO",30,30,$cliente["CARGO_CONTACTO"]);
	echo fila("Dirección","text","DIRECCION",30,30,$cliente["DIRECCION"]);
	echo fila("Ciudad","text","CIUDAD",15,15,$cliente["CIUDAD"]);
	echo fila("Region","text","REGION",15,15,$cliente["REGION"]);
	echo fila("CP","text","COD_POSTAL",10,10,$cliente["COD_POSTAL"]);
	echo fila("Pais","text","PAIS",15,15,$cliente["PAIS"]);
	echo fila("Telefono","text","TELEFONO",24,24,$cliente["TELEFONO"]);
	echo fila("Fax","text","FAX",24,24,$cliente["FAX"]);
	echo fila_pie("Actualizar",$cadenita);
	echo "</table></form></fieldset>";

}

function formulario_insertar(){
global $cadenita;
echo "<fieldset style='width:300px;margin=auto;'>";
echo "<legend>Insertar Proveedor</legend>";

echo sprintf("<form method='post' action='%s?respuesta=1&%s' >",$_SERVER['PHP_SELF'],$cadenita);
echo "<table align=center>";

echo fila("Proveedor","text","PROVID",11,11,"");
echo fila("NOMBRE","text","NOMBRE",40,40,"");
echo fila("Nombre Contacto","text","NOMBRE_CONTACTO",30,30,"");
echo fila("Cargo Contacto","text","CARGO_CONTACTO",30,30,"");
echo fila("Dirección","text","DIRECCION",30,30,"");
echo fila("Ciudad","text","CIUDAD",15,15,"");
echo fila("Region","text","REGION",15,15,"");
echo fila("CP","text","COD_POSTAL",10,10,"");
echo fila("Pais","text","PAIS",15,15,"");
echo fila("Telefono","text","TELEFONO",24,24,"");
echo fila("Fax","text","FAX",24,24,"");

echo fila_pie("Crear Proveedor",$cadenita); 
echo "</table></form></fieldset>";
}
function obtener_proveedor_por_id($proveedor){
	global $conexion;
	$consulta = "SELECT * FROM proveedores WHERE PROVID='$proveedor' LIMIT 1";
	$respuesta = $conexion->query($consulta);

	if($fila = $respuesta->fetch_array(MYSQLI_BOTH))return $fila;
	return NULL;
}

function respuesta_a_editar(){
		global $conexion;
		$errores = validar_campos_obligatorios(array("PROVID"));
		
	if(!empty($errores)) return "No se han podido validar los datos";
	
	
	$ma=array("PROVID","NOMBRE","NOMBRE_CONTACTO","CARGO_CONTACTO","DIRECCION","CIUDAD","REGION","COD_POSTAL","PAIS","TELEFONO","FAX");
	
	foreach($ma as $e)	$$e = preparar_consulta(htmlentities($_POST[$e],ENT_QUOTES,"UTF-8"));
		
		$consulta = sprintf("UPDATE proveedores 
		SET PROVID='%s',NOMBRE='%s',NOMBRE_CONTACTO='%s',
		CARGO_CONTACTO='%s',DIRECCION='%s',CIUDAD='%s',
		REGION='%s',COD_POSTAL='%s',PAIS='%s',
		TELEFONO='%s',FAX='%s' WHERE PROVID='%s'",
		$PROVID,$NOMBRE,$NOMBRE_CONTACTO,$CARGO_CONTACTO,$DIRECCION,
		$CIUDAD,$REGION,$COD_POSTAL,$PAIS,$TELEFONO,$FAX,
		$_GET["PROVID"]	);
	
		$_GET=array();
		$_POST=array();
		if($conexion->query($consulta))  return "Actualizaci�n exitosa";
		return "No se ha podido actualizar el Proveedor" . $conexion->connect_error;	
}
function respuesta_a_insertar(){
	global $conexion;
	if(!isset($_POST["PROVID"])) return "No esta definido El Proveedor";

		$errores = validar_campos_obligatorios(array("PROVID"));
		
		if(!empty($errores)) return "No se han podido validar los datos";
	
		$ma=array("PROVID","NOMBRE","NOMBRE_CONTACTO","CARGO_CONTACTO","DIRECCION","CIUDAD","REGION","COD_POSTAL","PAIS","TELEFONO","FAX");
		
		foreach($ma as $e)	$$e = preparar_consulta(htmlentities($_POST[$e],ENT_QUOTES,"UTF-8"));
			
		$consulta=sprintf("INSERT INTO proveedores VALUES(
			'%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
			PROVID,$NOMBRE,$NOMBRE_CONTACTO,$CARGO_CONTACTO,$DIRECCION,
			$CIUDAD,$REGION,$COD_POSTAL,$PAIS,$TELEFONO,$FAX);

			if($conexion->query($consulta))  return "Inserción exitosa";
			return "No se ha podido crear el Proveedor" . $conexion->connect_error;
		
}

function respuesta_a_borrar(){
global $conexion;
$consulta = sprintf("DELETE FROM proveedores WHERE PROVID='%s'",	$_GET["PROVID"]);
$conexion->query($consulta);

if(mysqli_affected_rows($conexion) == 1) return "Borrado exitoso";
return "<p>Se ha producido un error al	intentar eliminar un Proveedor: " . mysql_error() ."</p>";
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

	$consulta="SELECT * FROM proveedores ";
	if ($_SESSION['txcaja']!='') $consulta .=" WHERE ".$_SESSION['cbcaja']." like '".$_SESSION['txcaja']."%'";
	$consulta .=" ORDER BY NOMBRE ASC LIMIT ";
	$consulta .=$pages->limite_inicial.",".$pages->limite_final;

	$resultado = $conexion->query($consulta);
	
	echo utf8_encode("<table id='rejilla' width='70%'>");
			
	$m=array("PROVEEDOR","NOMBRE","NOMBRE_CONTACTO","CARGO_CONTACTO","DIRECCION","CIUDAD","REGION","COD_POSTAL","PAIS","TELEFONO","FAX","ACCION");
	
	$salida="<tr>";
	foreach($m as $e) $salida .="<th>".utf8_encode($e)."</th>";	
	echo $salida."</tr>";		
	
	echo utf8_encode("<caption  onclick=\"window.location='$_SERVER[PHP_SELF]?op=1&$cadenita' \">Nuevo Proveedor</caption>");
	
	
	while($f=$resultado->fetch_array(MYSQLI_BOTH)){
		$z=sprintf("%s",$f["PROVID"]);
		$salida=sprintf("<tr 
				onmouseover=\"hilite(this)\" onmouseout=\"lowlite(this)\">
				<td>%s</td><td>%s</td><td>%s</td><td>%s</td>
				<td>%s</td><td>%s</td><td>%s</td><td>%s</td>
				<td>%s</td><td>%s</td><td>%s</td>
				",
				poner("PROVID_$z",11,11,$f["PROVID"]),
				poner("NOMBRE_$z",10,40,$f["NOMBRE"]),
				poner("NOMBRE_CONTACTO_$z",10,30,$f["NOMBRE_CONTACTO"]),
				poner("CARGO_CONTACTO_$z",10,30,$f["CARGO_CONTACTO"]),
				poner("DIRECCION_$z",10,30,$f["DIRECCION"]),
				poner("CIUDAD_$z",10,15,$f["CIUDAD"]),
				poner("REGION_$z",10,15,$f["REGION"]),
				poner("COD_POSTAL_$z",10,10,$f["COD_POSTAL"]),
				poner("PAIS_$z",10,15,$f["PAIS"]),
				poner("TELEFONO_$z",10,24,$f["TELEFONO"]),
				poner("FAX_$z",10,24,$f["FAX"])
				);
		$salida.=sprintf("<td align='center'><a href='?op=3&PROVID=%s&%s'>Editar</a>&nbsp;&nbsp;", $f['PROVID'],$cadenita);
		$salida.=sprintf("<a id='proveedores_%s'  href='#' onClick='poner(this);' >Actualizar</a>&nbsp;&nbsp;", $f['PROVID']);
		$salida.=sprintf("<a href='?op=2&PROVID=%s&%s'>Borrar</a></td>", $f['PROVID'],$cadenita);
		echo $salida."</tr>\n";
	}
	echo "</table>\n";

	echo "<div class='nuevo'>";
	echo $pages->display_pages();
	echo "</div>";


}

?>