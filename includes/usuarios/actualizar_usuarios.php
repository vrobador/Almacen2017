<?php
require_once("../../general/connection_db.php");
require_once("../../general/funciones.php");
global $conexion;
$ma=array("id","username","password","numero");

foreach($ma as $e)	$$e = preparar_consulta(htmlentities($_GET[$e],ENT_QUOTES,"UTF-8"));

$consulta = sprintf("UPDATE usuarios
		SET id='%s',username='%s',password='%s'
		WHERE id='%s'",
		$id,
		strlen(trim($username))==0 ? "NULL" : $username,
		strlen(trim($password))==0 ? "NULL" : sha1(trim($password)),
		$numero	);
unset($_GET);

if($conexion->query($consulta)){
	echo "Actualización exitosa";
}else{
	echo "No se ha podido actualizar el eL Usuarios" . $conexion->connect_error;
}