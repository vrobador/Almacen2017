<?php
require_once("includes/combobox.php");

function formulario_editar(){
	global $cadenita;
	$cliente=obtener_empleado_por_id($_GET['EMPID']);

	echo "<fieldset style='width:300px;margin=auto;'>";
	echo "<legend>Editar Proveedor</legend>";
	
	echo sprintf("<form method='post' action='%s?respuesta=3&EMPID=%s&%s' >",$_SERVER['PHP_SELF'],$_GET['EMPID'],$cadenita);
	echo "<table align=center>";
	echo fila("EMPLEADO","text","EMPID",11,11,$cliente["EMPID"]);
	echo fila("APELLIDOS","text","APELLIDOS",20,20,$cliente["APELLIDOS"]);
	echo fila("NOMBRE","text","NOMBRE",10,10,$cliente["NOMBRE"]);
	echo fila("CARGO","text","CARGO",30,30,$cliente["CARGO"]);
	echo fila("FECHA_NACIMIENTO","text","FECHA_NACIMIENTO",10,10,$cliente["FECHA_NACIMIENTO"]);
	echo fila("FECHA_CONTRATACION","text","FECHA_CONTRATACION",10,10,$cliente["FECHA_CONTRATACION"]);
	echo fila("DIRECCION","text","DIRECCION",15,60,$cliente["DIRECCION"]);
	echo fila("CIUDAD","text","CIUDAD",15,15,$cliente["CIUDAD"]);
	echo fila("REGION","text","REGION",15,15,$cliente["REGION"]);
	echo fila("COD_POSTAL","text","COD_POSTAL",10,10,$cliente["COD_POSTAL"]);
	echo fila("PAIS","text","PAIS",15,15,$cliente["PAIS"]);
	echo fila("TELEF_DOMICILIO","text","TELEF_DOMICILIO",24,24,$cliente["TELEF_DOMICILIO"]);
	echo fila("EXTENSION_TELEF","text","EXTENSION_TELEF",4,4,$cliente["EXTENSION_TELEF"]);
	echo fila("NOTAS","text","NOTAS",4,4,$cliente["NOTAS"]);
	echo fila("JEFE","text","JEFE",4,4,$cliente["JEFE"]);
	echo fila_pie("Actualizar",$cadenita);
	echo "</table></form></fieldset>";

}

function formulario_insertar(){
global $cadenita;
echo "<fieldset style='width:300px;margin=auto;'>";
echo "<legend>Insertar Empleado</legend>";

echo sprintf("<form method='post' action='%s?respuesta=1&%s' >",$_SERVER['PHP_SELF'],$cadenita);
echo "<table align=center>";

echo fila("EMPLEADO","text","EMPID",11,11,"");
echo fila("APELLIDOS","text","APELLIDOS",20,20,"");
echo fila("NOMBRE","text","NOMBRE",10,10,"");
echo fila("CARGO","text","CARGO",30,30,"");
echo fila("FECHA_NACIMIENTO","text","FECHA_NACIMIENTO",10,10,"");
echo fila("FECHA_CONTRATACION","text","FECHA_CONTRATACION",10,10,"");
echo fila("DIRECCION","text","DIRECCION",15,60,"");
echo fila("CIUDAD","text","CIUDAD",15,15,"");
echo fila("REGION","text","REGION",15,15,"");
echo fila("COD_POSTAL","text","COD_POSTAL",10,10,"");
echo fila("PAIS","text","PAIS",15,15,"");
echo fila("TELEF_DOMICILIO","text","TELEF_DOMICILIO",24,24,"");
echo fila("EXTENSION_TELEF","text","EXTENSION_TELEF",4,4,"");
echo fila("NOTAS","text","NOTAS",4,4,"");
echo fila("JEFE","text","JEFE",4,4,"");

echo fila_pie("Crear Empleado",$cadenita); 
echo "</table></form></fieldset>";
}
function obtener_empleado_por_id($empleado){
	global $conexion;
	$consulta = "SELECT * FROM empleados WHERE EMPID='$empleado' LIMIT 1";
	$respuesta = $conexion->query($consulta);

	if($fila = $respuesta->fetch_array(MYSQLI_BOTH))return $fila;
	return NULL;
}

function respuesta_a_editar(){
		global $conexion;
		$errores = validar_campos_obligatorios(array("EMPID"));
		
	if(!empty($errores)) return "No se han podido validar los datos";
	
	$ma=array("EMPID","APELLIDOS","NOMBRE","CARGO","FECHA_NACIMIENTO","FECHA_CONTRATACION","DIRECCION","CIUDAD","REGION","COD_POSTAL","PAIS","TELEF_DOMICILIO","NOTAS","JEFE");
	
	foreach($ma as $e)	$$e = preparar_consulta(htmlentities($_POST[$e],ENT_QUOTES,"UTF-8"));
		
		$consulta = sprintf("UPDATE empleados 
		SET EMPID='%s',APELLIDOS='%s',NOMBRE='%s',
		CARGO='%s',FECHA_NACIMIENTO='%s',FECHA_CONTRATACION='%s',
		DIRECCION='%s',CIUDAD='%s',REGION='%s',
		COD_POSTAL='%s',PAIS='%s',TELEF_DOMICILIO='%s',NOTAS='%s',JEFE='%s', WHERE EMPID='%s'",
		$EMPID,$APELLIDOS,$NOMBRE,$CARGO,$FECHA_NACIMIENTO,$FECHA_CONTRATACION,
		$DIRECCION,$CIUDAD,$REGION,$COD_POSTAL,$PAIS,$TELEF_DOMICILIO,$NOTAS,$JEFE,
		$_GET["EMPID"]	);
	
		$_GET=array();
		$_POST=array();
		if($conexion->query($consulta))  return "Actualizaci�n exitosa";
		return "No se ha podido actualizar el Empleado" . $conexion->connect_error;	
}
function respuesta_a_insertar(){
	global $conexion;
	if(!isset($_POST["EMPID"])) return "No esta definido El Empleado";

		$errores = validar_campos_obligatorios(array("EMPID"));
		
		if(!empty($errores)) return "No se han podido validar los datos";
	
	$ma=array("EMPID","APELLIDOS","NOMBRE","CARGO","FECHA_NACIMIENTO","FECHA_CONTRATACION","DIRECCION","CIUDAD","REGION","COD_POSTAL","PAIS","TELEF_DOMICILIO","NOTAS","JEFE");
		
		foreach($ma as $e)	$$e = preparar_consulta(htmlentities($_POST[$e],ENT_QUOTES,"UTF-8"));
			
		$consulta=sprintf("INSERT INTO empleados VALUES(
			'%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
			$EMPID,$APELLIDOS,$NOMBRE,$CARGO,$FECHA_NACIMIENTO,$FECHA_CONTRATACION,
		$DIRECCION,$CIUDAD,$REGION,$COD_POSTAL,$PAIS,$TELEF_DOMICILIO,$NOTAS,$JEFE);

			if($conexion->query($consulta))  return "Inserción exitosa";
			return "No se ha podido crear el Empleado" . $conexion->connect_error;
		
}

function respuesta_a_borrar(){
global $conexion;
$consulta = sprintf("DELETE FROM empleados WHERE EMPID='%s'",	$_GET["EMPID"]);
$conexion->query($consulta);

if(mysqli_affected_rows($conexion) == 1) return "Borrado exitoso";
return "<p>Se ha producido un error al	intentar eliminar un Empleado: " . mysql_error() ."</p>";
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

	$consulta="SELECT * FROM empleados ";
	if ($_SESSION['txcaja']!='') $consulta .=" WHERE ".$_SESSION['cbcaja']." like '".$_SESSION['txcaja']."%'";
	$consulta .=" ORDER BY APELLIDOS,NOMBRE ASC LIMIT ";
	$consulta .=$pages->limite_inicial.",".$pages->limite_final;

	$resultado = $conexion->query($consulta);
	
	echo utf8_encode("<table id='rejilla' width='70%'>");
			
	$m=array("EMPID","APELLIDOS","NOMBRE","CARGO","FECHA_NACIMIENTO","FECHA_CONTRATACION","DIRECCION","CIUDAD","REGION","COD_POSTAL","PAIS","TELEF_DOMICILIO","EXTENSION_TELEF_","NOTAS","JEFE","ACCION");
	$salida="<tr>";
	foreach($m as $e) $salida .="<th>".utf8_encode($e)."</th>";	
	echo $salida."</tr>";		
	
	echo utf8_encode("<caption  onclick=\"window.location='$_SERVER[PHP_SELF]?op=1&$cadenita' \">Nuevo Empleado</caption>");
	

	while($f=$resultado->fetch_array(MYSQLI_BOTH)){
		$z=sprintf("%s",$f["EMPID"]);
		$salida=sprintf("<tr 
				onmouseover=\"hilite(this)\" onmouseout=\"lowlite(this)\">
				<td>%s</td><td>%s</td><td>%s</td><td>%s</td>
				<td>%s</td><td>%s</td><td>%s</td><td>%s</td>
	            <td>%s</td><td>%s</td><td>%s</td><td>%s</td>
				<td>%s</td><td>%s</td><td>%s</td>
				",
				poner("EMPID_$z",11,11,$f["EMPID"]),
				poner("APELLIDOS_$z",10,20,$f["APELLIDOS"]),
				poner("NOMBRE_$z",10,10,$f["NOMBRE"]),
				poner("CARGO_$z",10,30,$f["CARGO"]),
				poner("FECHA_NACIMIENTO_$z",10,30,$f["FECHA_NACIMIENTO"]),
				poner("FECHA_CONTRATACION_$z",10,30,$f["FECHA_CONTRATACION"]),
				poner("DIRECCION_$z",10,15,$f["DIRECCION"]),
				poner("CIUDAD_$z",10,15,$f["CIUDAD"]),
				poner("REGION_$z",10,15,$f["REGION"]),
				poner("COD_POSTAL_$z",10,10,$f["COD_POSTAL"]),
				poner("PAIS_$z",10,15,$f["PAIS"]),
				poner("TELEF_DOMICILIO_$z",10,24,$f["TELEF_DOMICILIO"]),
			    poner("EXTENSION_TELEF_$z",10,24,$f["EXTENSION_TELEF"]),
			    poner("NOTAS_$z",4,4,$f["NOTAS"]),
			    poner("JEFE_$z",4,4,$f["JEFE"])
				);
		$salida.=sprintf("<td align='center'><a href='?op=3&EMPID=%s&%s'>Editar</a>&nbsp;&nbsp;", $f['EMPID'],$cadenita);
		$salida.=sprintf("<a id='empleados_%s'  href='#' onClick='poner(this);' >Actualizar</a>&nbsp;&nbsp;", $f['EMPID']);
		$salida.=sprintf("<a href='?op=2&EMPID=%s&%s'>Borrar</a></td>", $f['EMPID'],$cadenita);
		echo $salida."</tr>\n";
	}
	echo "</table>\n";

	echo "<div class='nuevo'>";
	echo $pages->display_pages();
	echo "</div>";


}

?>