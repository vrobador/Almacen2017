<?php
require_once("includes/combobox.php");
function respuestaainsertar(){
	global $conexion;
	
		$ma=array("id","username","password1");
		
		foreach($ma as $e)	
			$$e = preparar_consulta(htmlentities($_POST[$e],ENT_QUOTES,"UTF-8"));
			
		$consulta=sprintf("INSERT INTO usuarios VALUES('%s','%s','%s')",
			$id,$username,sha1(ltrim($password1)));

			if($conexion->query($consulta))  return "Inserción exitosa";
			return "No se ha podido insertar el Usuario." . $conexion->connect_error;
}
function respuestaaeditar(){
	global $conexion;
	$errores = validar_campos_obligatorios(array("id"));

	if(!empty($errores)) return "No se han podido validar los datos";

	$ma=array("id","username","password1","id_old");

	foreach($ma as $e)
		$$e = preparar_consulta(htmlentities($_POST[$e],ENT_QUOTES,"UTF-8"));

		$consulta = sprintf("UPDATE usuarios
		SET id=%s ,username='%s',password='%s'
	    WHERE id='%s'",$id,$username,sha1(ltrim($password1)),$id_old	);

		$_GET=array();
		$_POST=array();
		if($conexion->query($consulta))  return "Actualización exitosa";
		return "No se ha podido actualizar el Usuario" . $conexion->connect_error;
}

function formulario_editar(){
	global $cadenita;
	header("Location: nuevousuario.php?id=".$_GET['id']."&".$cadenita);
}
function formulario_insertar(){
	global $cadenita;
header("Location: nuevousuario.php?".$cadenita);
}

function respuesta_a_borrar(){
global $conexion;
$consulta = sprintf("DELETE FROM usuarios WHERE id='%s'",	$_GET["id"]);
$conexion->query($consulta);

if(mysqli_affected_rows($conexion) == 1) return "Borrado exitoso";
return "Se ha producido un error al	intentar eliminar un Categoria: " . mysql_error();
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

	$consulta="SELECT * FROM usuarios ";
	if ($_SESSION['txcaja']!='') $consulta .=" WHERE ".$_SESSION['cbcaja']." like '".$_SESSION['txcaja']."%'";
	$consulta .=" ORDER BY username ASC LIMIT ";
	$consulta .=$pages->limite_inicial.",".$pages->limite_final;

	$resultado = $conexion->query($consulta);
	
	echo utf8_encode("<table id='rejilla' width='70%'>");
			
	$m=array("id","username","password","ACCION");
	
	$salida="<tr>";
	foreach($m as $e) $salida .="<th>".utf8_encode($e)."</th>";	
	echo $salida."</tr>";		
	
	echo utf8_encode("<caption style='cursor:pointer;'  onclick=\"window.location='$_SERVER[PHP_SELF]?op=1&$cadenita' \">Nuevo Usuario</caption>");
	
	while($f=$resultado->fetch_array(MYSQLI_BOTH)){
		$z=sprintf("%s",$f["id"]);
		$salida=sprintf("<tr 
				onmouseover=\"hilite(this)\" onmouseout=\"lowlite(this)\">
				<td>%s</td><td>%s</td><td>%s</td>
				",
				poner("id_$z",11,11,$f["id"]),
				poner("username_$z",20,20,$f["username"]),
				poner("password_$z",10,50,$f["password"])
				);
		$salida.=sprintf("<td align='center'>
				<a title='Editar' href='?op=3&id=%s&%s'>
				Editar</a>&nbsp;&nbsp;", $f['id'],$cadenita);
	    /********************************************/
		$salida.=sprintf("<a id='usuarios_%s'  href='#' onClick='poner(this);' >
		Actualizar</a>&nbsp;&nbsp;", $f['id']);
		/********************************************/

		$salida.=sprintf("<a title='Borrar' href='?op=2&id=%s&%s'>
		Borrar </a></td>", $f['id'],$cadenita);
		echo $salida."</tr>\n";
	}
	echo "</table>\n";

	echo "<div class='nuevo'>";
	echo $pages->display_pages();
	echo "</div>";


}
function obtener_usuario_por_id($c){
	global $conexion;
	$consulta = "SELECT * FROM usuarios WHERE id='$c' LIMIT 1";
	$respuesta = $conexion->query($consulta);

	if($fila = $respuesta->fetch_array(MYSQLI_BOTH))return $fila;
	return NULL;
}
?>