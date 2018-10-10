<?php
require_once("includes/combobox.php");
/****************************************************************************************************************************/
function formulario_editar(){
	global $cadenita;
	$cliente=obtener_categoria_por_id($_GET['CATID']);

	echo "<fieldset style='width:300px;margin=auto;'>";
	echo "<legend>Editar Categoria</legend>";
	echo sprintf("<form method='post' action='%s?respuesta=3&CATID=%s&%s' >",$_SERVER['PHP_SELF'],$_GET['CATID'],$cadenita);
	echo "<table align=center>";
	echo fila("CATID","text","CATID",11,11,$cliente["CATID"]);
	echo fila("Categoria","text","NOMBRE_CATE",10,20,$cliente["NOMBRE_CATE"]);
	echo fila("Descripci�n","text","DESCRIPCION",10,20,$cliente["DESCRIPCION"]);
	echo fila_pie("Actualizar",$cadenita);
	echo "</table></form></fieldset>";
}
/****************************************************************************************************************************/
function formulario_insertar(){
global $cadenita;
echo "<fieldset style='width:300px;margin=auto;'>";
echo "<legend>Insertar Categoria</legend>";

echo sprintf("<form method='post' action='%s?respuesta=1&%s' >",$_SERVER['PHP_SELF'],$cadenita);
echo "<table align=center>";

echo fila("CATID","text","CATID",11,11,"");
echo fila("Categoria","text","NOMBRE_CATE",10,20,"");
echo fila("Descripci�n","text","DESCRIPCION",10,20,"");

echo fila_pie("Crear Categoria",$cadenita); 
echo "</table></form></fieldset>";
}
/****************************************************************************************************************************/
function respuesta_a_editar(){
		global $conexion;
		$errores = validar_campos_obligatorios(array("CATID"));
		
	if(!empty($errores)) return "No se han podido validar los datos";
	
	$ma=array("CATID","NOMBRE_CATE","DESCRIPCION");
	
	foreach($ma as $e)	
	$$e = preparar_consulta(htmlentities($_POST[$e],ENT_QUOTES,"UTF-8"));
		
		$consulta = sprintf("UPDATE categorias 
		SET CATID='%s',NOMBRE_CATE='%s',DESCRIPCION='%s'
	    WHERE CATID='%s'",
		$CATID,$NOMBRE_CATE,$DESCRIPCION,
		$_GET["CATID"]	);
	
	$_GET=array();
	$_POST=array();
		if($conexion->query($consulta))  return "Actualizaci�n exitosa";
		return "No se ha podido actualizar el Categoria" . $conexion->connect_error;	
}
/****************************************************************************************************************************/
function respuesta_a_insertar(){
	global $conexion;
	if(!isset($_POST["CATID"])) return "No esta definido El cliente";

		$errores = validar_campos_obligatorios(array("CATID"));
		
		if(!empty($errores)) return "No se han podido validar los datos";
	
		$ma=array("CATID","NOMBRE_CATE","DESCRIPCION");
		
		foreach($ma as $e)	
			$$e = preparar_consulta(htmlentities($_POST[$e],ENT_QUOTES,"UTF-8"));
			
		$consulta=sprintf("INSERT INTO categorias VALUES(
			'%s','%s','%s')",
			$CATID,$NOMBRE_CATE,$DESCRIPCION);

			if($conexion->query($consulta))  return "Inserción exitosa";
			return "No se ha podido crear el Categoria" . $conexion->connect_error;
}
/****************************************************************************************************************************/
function respuesta_a_borrar(){
global $conexion;
$consulta = sprintf("DELETE FROM categorias WHERE CATID='%s'",	$_GET["CATID"]);
$conexion->query($consulta);

if(mysqli_affected_rows($conexion) == 1) return "Borrado exitoso";
return "<p>Se ha producido un error al	intentar eliminar un Categoria: " . mysql_error() ."</p>";
}
/****************************************************************************************************************************/
function mostrar_tabla(){
	global $conexion;
	global $pages;
	global $cadenita;

	$m=array("CATID","NOMBRE_CATE","DESCRIPCION","ACCION");
		
	echo "<div class='nuevo'>";
	echo $pages->display_pages();
	echo"<br/><br/>";
	echo "<span class=\"\">".$pages->display_jump_menu().$pages->display_items_por_pagina()."</span>";
	echo "</div>";

	
	$consulta="SELECT * FROM categorias ";
	
	if ($_SESSION['txcaja']!='') 
	$consulta .=" WHERE ".$_SESSION['cbcaja']." like '".$_SESSION['txcaja']."%'";
	
	$consulta .=" ORDER BY NOMBRE_CATE ASC LIMIT ";
	$consulta .=$pages->limite_inicial.",".$pages->limite_final;
	
    $resultado = $conexion->query($consulta);
	
	echo utf8_encode("<table id='rejilla' width='70%'>");
	$salida="<tr>";
	foreach($m as $e) $salida .="<th>".utf8_encode($e)."</th>";	
	echo $salida."</tr>";		
	
	echo utf8_encode("<caption  onclick=\"window.location='$_SERVER[PHP_SELF]?op=1&$cadenita' \">Nuevo Categoria</caption>");
	
	while($f=$resultado->fetch_array(MYSQLI_BOTH)){
		$z=sprintf("%s",$f["CATID"]);
		$salida=sprintf("<tr 
				onmouseover=\"hilite(this)\" onmouseout=\"lowlite(this)\">
				<td>%s</td><td>%s</td><td>%s</td>
				",
				poner("CATID_$z",11,11,$f["CATID"]),
				poner("NOMBRE_CATE_$z",20,20,$f["NOMBRE_CATE"]),
				poner("DESCRIPCION_$z",10,20,$f["DESCRIPCION"])
				);
		$salida.=sprintf("<td align='center'>
				<a title='Editar' href='?op=3&CATID=%s&%s'>
				Editar</a>&nbsp;&nbsp;", $f['CATID'],$cadenita);
		
	    /********************************************/
		$salida.=sprintf("<a id='categorias_%s'  href='#' onClick='poner(this);'>
		Actualizar</a>&nbsp;&nbsp;", $f['CATID']);
		//$salida.=sprintf("<input type='button' id='categorias_%s' onClick='poner(this);' value='Poner'>",$f['CATID']);
		/********************************************/

		$salida.=sprintf("<a title='Borrar' href='?op=2&CATID=%s&%s'>
		Borrar </a></td>", $f['CATID'],$cadenita);
		echo $salida."</tr>\n";
	}
	echo "</table>\n";

	echo "<div class='nuevo'>";
	echo $pages->display_pages();
	echo "</div>";


}
/****************************************************************************************************************************/
function obtener_categoria_por_id($c){
	global $conexion;
	$consulta = "SELECT * FROM categorias WHERE CATID='$c' LIMIT 1";
	$respuesta = $conexion->query($consulta);

	if($fila = $respuesta->fetch_array(MYSQLI_BOTH))return $fila;
	return NULL;
}
/****************************************************************************************************************************/
?>