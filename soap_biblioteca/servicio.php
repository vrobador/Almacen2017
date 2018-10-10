<?php
require_once('lib/nusoap.php');

function mostrar($id=NULL){
/*	
    define("DB_SERVER","mysql.hostinger.es");
	define("DB_NAME","u555860293_alma");
	define("DB_USERNAME","u555860293_root");
	define("DB_PASSWORD","rootroot");
	
	$conexion = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
*/	
require_once("../general/connection_db.php"); 
	if ($conexion->connect_error) {
		die('Fallo al conectar con MySQL (' . $conexion->connect_errno . ') ' . $conexion->connect_error);
	}
	IF ($id==NULL){
		$resultado=$conexion->query(" select * from catalogo");
	}ELSE{
		if ($id=="NULL"){
			$resultado=$conexion->query(" select * from recursos");
		}else{
			$resultado=$conexion->query(" select * from recursos where catid=".$id);
		}
	}

	while($row=$resultado->fetch_array(MYSQLI_BOTH))$tb[]=$row;

	return $tb;
}
    $server = new soap_server();

    $server->register('mostrar');
        
    $HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
    $server->service($HTTP_RAW_POST_DATA);
?>