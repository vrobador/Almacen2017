<?php
require_once("../../general/connection_db.php");
require_once("../../general/funciones.php");
global $conexion;
//$errores = validar_campos_obligatorios(array("EMPNO"));

//if(!empty($errores)) return "No se han podido validar los datos";
$ma=array("NUMERO","PROVID","NOMBRE","NOMBRE_CONTACTO","CARGO_CONTACTO","DIRECCION","CIUDAD","REGION","CODIGO_POSTAL","PAIS","TELEFONO","FAX");
foreach($ma as $e)	$$e = preparar_consulta(htmlentities($_GET[$e],ENT_QUOTES,"UTF-8"));


$consulta = sprintf("UPDATE proveedores
		SET PROVID='%s',NOMBRE='%s',NOMBRE_CONTACTO='%s',
		CARGO_CONTACTO='%s',DIRECCION='%s',CIUDAD='%s',REGION='%s',CODIGO_POSTAL='%s',
		PAIS='%s',TELEFONO='%s',FAX='%s' WHERE PROVID='%s'",
		$PROVID,
		strlen(trim($NOMBRE))==0 ? "NULL" : $NOMBRE,
		strlen(trim($NOMBRE_CONTACTO))==0 ? "NULL" : $NOMBRE_CONTACTO,
		strlen(trim($CARGO_CONTACTO))==0 ? "NULL" : $CARGO_CONTACTO,
		strlen(trim($DIRECCION))==0 ? "NULL" : $DIRECCION,
		strlen(trim($CIUDAD))==0 ? "NULL" : $CIUDAD,
		strlen(trim($REGION))==0 ? "NULL" : $REGION,
		strlen(trim($CODIGO_POSTAL))==0 ? "NULL" : $CODIGO_POSTAL,
		strlen(trim($PAIS))==0 ? "NULL" : $PAIS,
		strlen(trim($TELEFONO))==0 ? "NULL" : $TELEFONO,
		strlen(trim($FAX))==0 ? "NULL" : $FAX,
		$NUMERO	);
unset($_GET);

if($conexion->query($consulta)){
   echo "Actualización exitosa";
}else{
   echo "No se ha podido actualizar el eL Proveedor" . $conexion->connect_error;
}