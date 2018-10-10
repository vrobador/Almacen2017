<?php 
	require_once("constants.php");
	$conexion = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conexion->connect_error) {
    die('Fallo al conectar con MySQL (' . $conexion->connect_errno . ') ' . $conexion->connect_error);    
}
?>

 
    

