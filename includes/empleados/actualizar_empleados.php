<?php
require_once("../../general/connection_db.php");
require_once("../../general/funciones.php");
global $conexion;
//$errores = validar_campos_obligatorios(array("EMPNO"));

//if(!empty($errores)) return "No se han podido validar los datos";
$ma=array("NUMERO","EMPID","APELLIDOS","NOMBRE","CARGO","FECHA_NACIMIENTO","FECHA_CONTRATACION","DIRECCION","CIUDAD","REGION","COD_POSTAL","PAIS","TELEF_DOMICILIO","NOTAS","JEFE");

foreach($ma as $e)	$$e = preparar_consulta(htmlentities($_GET[$e],ENT_QUOTES,"UTF-8"));


$consulta = sprintf("UPDATE empleados
		SET EMPID='%s',APELLIDOS='%s',NOMBRE='%s',
		CARGO='%s',FECHA_NACIMIENTO='%s',FECHA_CONTRATACION='%s',DIRECCION='%s',CIUDAD='%s',
		REGION='%s',COD_POSTAL='%s',PAIS='%s',TELEF_DOMICILIO='%s',NOTAS='%s',JEFE='%s' WHERE EMPID='%s'",
		$EMPID,
		strlen(trim($APELLIDOS))==0 ? "NULL" : $APELLIDOS,
		strlen(trim($NOMBRE))==0 ? "NULL" : $NOMBRE,
		strlen(trim($CARGO))==0 ? "NULL" : $CARGO,
		strlen(trim($FECHA_NACIMIENTO))==0 ? "NULL" : $FECHA_NACIMIENTO,
		strlen(trim($FECHA_CONTRATACION))==0 ? "NULL" : $FECHA_CONTRATACION,
		strlen(trim($DIRECCION))==0 ? "NULL" : $DIRECCION,
		strlen(trim($CIUDAD))==0 ? "NULL" : $CIUDAD,
		strlen(trim($REGION))==0 ? "NULL" : $REGION,
		strlen(trim($COD_POSTAL))==0 ? "NULL" : $COD_POSTAL,
		strlen(trim($PAIS))==0 ? "NULL" : $PAIS,
		strlen(trim($TELEF_DOMICILIO))==0 ? "NULL" : $TELEF_DOMICILIO,
		strlen(trim($NOTAS))==0 ? "NULL" : $NOTAS,
		strlen(trim($JEFE))==0 ? "NULL" : $JEFE,
		$NUMERO	);
unset($_GET);

if($conexion->query($consulta)){
   echo "Actualización exitosa";
}else{
   echo "No se ha podido actualizar el Empleado" . $conexion->connect_error;
}