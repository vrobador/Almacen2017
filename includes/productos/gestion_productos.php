<?php
require_once("includes/combobox.php");

function formulario_editar(){
	global $cadenita;
	$cliente=obtener_producto_por_id($_GET['PROID']);

	echo "<fieldset style='width:300px;margin=auto;'>";
	echo "<legend>Editar Producto</legend>";
	echo sprintf("<form method='post' action='%s?respuesta=3&PROID=%s&%s' >",$_SERVER['PHP_SELF'],$_GET['PROID'],$cadenita);
	echo "<table align=center>";

	echo fila("PROID","text","PROID",11,11,$cliente["PROID"]);
	echo fila_combo("PROVID",mostrar_proveedores($cliente["PROVID"]));
	echo fila_combo("CATID",mostrar_categorias($cliente["CATID"]));
	echo fila("NOMBRE","text","NOMBRE",10,40,$cliente["NOMBRE"]);
	echo fila("NOMBRE_ESPA","text","NOMBRE_ESPA",10,40,$cliente["NOMBRE_ESPA"]);
	echo fila("CANTIDAD_UNIDAD","text","CANTIDAD_UNIDAD",10,20,$cliente["CANTIDAD_UNIDAD"]);
	echo fila("PRECIO_UNIDAD","text","PRECIO_UNIDAD",10,10,$cliente["PRECIO_UNIDAD"]);
	echo fila("UNIDADES_EXIS","text","UNIDADES_EXIS",11,11,$cliente["UNIDADES_EXIS"]);
	echo fila("UNIDADES_PED","text","UNIDADES_PED",11,1,$cliente["UNIDADES_PED"]);
	
	echo fila_pie("Actualizar",$cadenita);
	echo "</table></form></fieldset>";
}
function formulario_insertar(){
global $cadenita;
echo "<fieldset style='width:300px;margin=auto;'>";
echo "<legend>Insertar Producto</legend>";

echo sprintf("<form method='post' action='%s?respuesta=1&%s' >",$_SERVER['PHP_SELF'],$cadenita);
echo "<table align=center>";

echo fila("PROID","text","PROID",11,11,"");
echo fila_combo("PROVID",mostrar_proveedores());
echo fila_combo("CATID",mostrar_categorias());
echo fila("NOMBRE","text","NOMBRE",10,40,"");
echo fila("NOMBRE_ESPA","text","NOMBRE_ESPA",10,40,"");
echo fila("CANTIDAD_UNIDAD","text","CANTIDAD_UNIDAD",10,20,"");
echo fila("PRECIO_UNIDAD","text","PRECIO_UNIDAD",10,10,"");
echo fila("UNIDADES_EXIS","text","UNIDADES_EXIS",11,11,"");
echo fila("UNIDADES_PED","text","UNIDADES_PED",11,1,"");

echo fila_pie("Crear Producto",$cadenita); 
echo "</table></form></fieldset>";
}

function respuesta_a_editar(){
		global $conexion;
		$errores = validar_campos_obligatorios(array("PROID"));
		
	if(!empty($errores)) return "No se han podido validar los datos";
	
	$ma=array("PROID","PROVID","CATID","NOMBRE","NOMBRE_ESPA","CANTIDAD_UNIDAD",
		"PRECIO_UNIDAD","UNIDADES_EXIS","UNIDADES_PED");
	
	foreach($ma as $e)	
	$$e = preparar_consulta(htmlentities($_POST[$e],ENT_QUOTES,"UTF-8"));
		
		$consulta = sprintf("UPDATE productos 
		SET PROID='%s',PROVID='%s',CATID='%s',
		NOMBRE='%s',NOMBRE_ESPA='%s',CANTIDAD_UNIDAD='%s',
		PRECIO_UNIDAD='%s',UNIDADES_EXIS='%s',UNIDADES_PED='%s'		
	    WHERE PROID='%s'",
		$PROID,$PROVID,$CATID,$NOMBRE,$NOMBRE_ESPA,$CANTIDAD_UNIDAD,
		$PRECIO_UNIDAD,$UNIDADES_EXIS,$UNIDADES_PED,
		$_GET["PROID"]	);
	
	$_GET=array();
	$_POST=array();
		if($conexion->query($consulta))  return "Actualizaci�n exitosa";
		return "No se ha podido actualizar el Producto" . $conexion->connect_error;	
}
function respuesta_a_insertar(){
	global $conexion;
	if(!isset($_POST["PROID"])) return "No esta definido El Producto";

		$errores = validar_campos_obligatorios(array("PROID"));
		
		if(!empty($errores)) return "No se han podido validar los datos";
	
		$ma=array("PROID","PROVID","CATID","NOMBRE","NOMBRE_ESPA","CANTIDAD_UNIDAD",
				"PRECIO_UNIDAD","UNIDADES_EXIS","UNIDADES_PED");
		
		foreach($ma as $e)	
			$$e = preparar_consulta(htmlentities($_POST[$e],ENT_QUOTES,"UTF-8"));
			
		$consulta=sprintf("INSERT INTO productos VALUES(
		'%s','%s','%s','%s','%s','%s','%s','%s','%s')",
		$PROID,$PROVID,$CATID,$NOMBRE,$NOMBRE_ESPA,$CANTIDAD_UNIDAD,
		$PRECIO_UNIDAD,$UNIDADES_EXIS,$UNIDADES_PED);

			if($conexion->query($consulta))  return "Inserción exitosa";
			return "No se ha podido crear el Producto" . $conexion->connect_error;
}

function respuesta_a_borrar(){
global $conexion;
$consulta = sprintf("DELETE FROM productos WHERE PROID='%s'",	$_GET["PROID"]);
$conexion->query($consulta);

if(mysqli_affected_rows($conexion) == 1) return "Borrado exitoso";
return "Se ha producido un error al	intentar eliminar un Producto: ". mysql_error() ;
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

	$consulta="SELECT * FROM productos ";
	if ($_SESSION['txcaja']!='') $consulta .=" WHERE ".$_SESSION['cbcaja']." like '".$_SESSION['txcaja']."%'";
	$consulta .=" ORDER BY NOMBRE_ESPA ASC LIMIT ";
	$consulta .=$pages->limite_inicial.",".$pages->limite_final;

	$resultado = $conexion->query($consulta);
	
	echo utf8_encode("<table id='rejilla' width='70%'>");
			
	$m=array("PROID","PROVID","CATID","NOMBRE","NOMBRE_ESPA","CANTIDAD_UNIDAD",
			"PRECIO_UNIDAD","UNIDADES_EXIS","UNIDADES_PED","ACCION");
	
	$salida="<tr>";
	foreach($m as $e) $salida .="<th>".utf8_encode($e)."</th>";	
	echo $salida."</tr>";		
	
	echo utf8_encode("<caption  onclick=\"window.location='$_SERVER[PHP_SELF]?op=1&$cadenita' \">Nuevo Producto</caption>");
	
	while($f=$resultado->fetch_array(MYSQLI_BOTH)){
		$z=sprintf("%s",$f["PROID"]);
		$salida=sprintf("<tr 
				onmouseover=\"hilite(this)\" onmouseout=\"lowlite(this)\">
				<td>%s</td><td>%s</td><td>%s</td>
				<td>%s</td><td>%s</td><td>%s</td>
				<td>%s</td><td>%s</td><td>%s</td>
				",
				poner("PROID_$z",11,11,$f["PROID"]),
				mostrar_proveedores($f["PROVID"],"PROVID_$z"),
				mostrar_categorias($f["CATID"],"CATID_$z"),
				poner("NOMBRE_$z",10,40,$f["NOMBRE"]),
				poner("NOMBRE_ESPA_$z",10,40,$f["NOMBRE_ESPA"]),
				poner("CANTIDAD_UNIDAD_$z",10,20,$f["CANTIDAD_UNIDAD"]),
				poner("PRECIO_UNIDAD_$z",10,10,$f["PRECIO_UNIDAD"]),
				poner("UNIDADES_EXIS_$z",11,11,$f["UNIDADES_EXIS"]),
				poner("UNIDADES_PED_$z",11,1,$f["UNIDADES_PED"])
				);
		$salida.=sprintf("<td align='center'><a href='?op=3&PROID=%s&%s'>Editar</a>&nbsp;&nbsp;", $f['PROID'],$cadenita);
		//$salida.=sprintf("<input type='button' id='productos_%s' onClick='poner(this);' value='Poner'>",$f['PROID']);
		$salida.=sprintf("<a id='productos_%s'  href='#' onClick='poner(this);' >Actualizar</a>&nbsp;&nbsp;", $f['PROID']);
		$salida.=sprintf("<a href='?op=2&PROID=%s&%s'>Borrar</a></td>", $f['PROID'],$cadenita);
		echo $salida."</tr>\n";
	}
	echo "</table>\n";

	echo "<div class='nuevo'>";
	echo $pages->display_pages();
	echo "</div>";


}
function obtener_producto_por_id($c){
	global $conexion;
	$consulta = "SELECT * FROM productos WHERE PROID='$c' LIMIT 1";
	$respuesta = $conexion->query($consulta);

	if($fila = $respuesta->fetch_array(MYSQLI_BOTH))return $fila;
	return NULL;
}
?>