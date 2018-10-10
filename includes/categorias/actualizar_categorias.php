<?php
require_once("../../general/connection_db.php");
require_once("../../general/funciones.php");
global $conexion;
//$errores = validar_campos_obligatorios(array("EMPNO"));

//if(!empty($errores)) return "No se han podido validar los datos";
$ma=array("NUMERO","CATID","NOMBRE_CATE","DESCRIPCION");

foreach($ma as $e)	$$e = preparar_consulta(htmlentities($_GET[$e],ENT_QUOTES,"UTF-8"));

$consulta = sprintf("UPDATE categorias
		SET CATID='%s',NOMBRE_CATE='%s',DESCRIPCION='%s' WHERE CATID='%s'",
		$CATID,
		strlen(trim($NOMBRE_CATE))==0 ? "NULL" : $NOMBRE_CATE,
		strlen(trim($DESCRIPCION))==0 ? "NULL" : $DESCRIPCION,
		$NUMERO	);

$_GET=array();

if($conexion->query($consulta)){
   echo "Actualización exitosa";
}else{
   echo "No se ha podido actualizar la Categorias" . $conexion->connect_error;
}