<?php
header('Content-type:application/json');


function mostrar($id=NULL){
require_once("../general/connection_db.php"); 
	if ($conexion->connect_error) {
		die('Fallo al conectar con MySQL (' . $conexion->connect_errno . ') ' .
				$conexion->connect_error);
	}
	IF ($id==NULL){
		$resultado=$conexion->query("select * from catalogo");
	}ELSE{
		if ($id=="NULL"){
			$resultado=$conexion->query("select * from recursos");
		}else{
			$resultado=$conexion->query(" select * from recursos where catid=".$id);
		}
	}
	while($row=$resultado->fetch_array(MYSQLI_BOTH))$tb[]=$row;
	return $tb;
}

if ($_GET['peticion']=='categorias'){
		$resultados=mostrar();
}else if ($_GET['peticion']=='recursos'){
			$resultados=mostrar($_GET['id']);
}else{
	header('HTTP/1.1 405 Method Not Allowed');
	exit;
}
echo json_encode($resultados);
	?>