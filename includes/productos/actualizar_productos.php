<?php
require_once("../../general/connection_db.php");
require_once("../../general/funciones.php");
global $conexion;
//$errores = validar_campos_obligatorios(array("EMPNO"));

//if(!empty($errores)) return "No se han podido validar los datos";
$ma=array("NUMERO",	"PROID","PROVID","CATID","NOMBRE","NOMBRE_ESPA",
		"CANTIDAD_UNIDAD","PRECIO_UNIDAD","UNIDADES_EXIS","UNIDADES_PED");

foreach($ma as $e)	$$e = preparar_consulta(htmlentities($_GET[$e],ENT_QUOTES,"UTF-8"));

$consulta = sprintf("UPDATE productos
		SET PROID='%s',PROVID='%s',CATID='%s',NOMBRE='%s',
		NOMBRE_ESPA='%s',CANTIDAD_UNIDAD='%s',PRECIO_UNIDAD='%s',
		UNIDADES_EXIS='%s',UNIDADES_PED='%s'
		WHERE PROID='%s'",
		$PROID,
		strlen(trim($PROVID))==0 ? "NULL" : $PROVID,
		strlen(trim($CATID))==0 ? "NULL" : $CATID,
		strlen(trim($NOMBRE))==0 ? "NULL" : $NOMBRE,
		strlen(trim($NOMBRE_ESPA))==0 ? "NULL" : $NOMBRE_ESPA,
		strlen(trim($CANTIDAD_UNIDAD))==0 ? "NULL" : $CANTIDAD_UNIDAD,
		strlen(trim($PRECIO_UNIDAD))==0 ? "NULL" : $PRECIO_UNIDAD,
		strlen(trim($UNIDADES_EXIS))==0 ? "NULL" : $UNIDADES_EXIS,
		strlen(trim($UNIDADES_PED))==0 ? "NULL" : $UNIDADES_PED,
		$NUMERO	);
$_GET=array();

if($conexion->query($consulta)){
   echo "ActualizaciÓNn exitosa";
}else{
   echo "No se ha podido actualizar la Productos" . $conexion->connect_error;
}