<?php
if( isset($_GET['catid']) ) {
    get_productos($_GET['catid']);
} else {
    die("Solicitud no válida.");
}

function get_productos( $id ) {
    
	require_once("../general/connection_db.php");
    
    if($conexion->connect_errno) {
        die("No se pudo conectar a la base de datos");
    }
    
    $jsondata = array();
    
	$sql="SELECT * FROM productos ";
	if ($id !="NULL") $sql .=" where catid= ".$id; 
	$sql .=" order by nombre_espa";     

    if ( $result = $conexion->query( $sql) ) {
        if( $result->num_rows > 0 ) {
            $jsondata["success"] = true;
            $jsondata["data"]["message"] = sprintf("Se han encontrado %d productos", $result->num_rows);
            $jsondata["data"]["productos"] = array();
            while( $row = $result->fetch_object() ) {
                $jsondata["data"]["productos"][] = $row;
            }
        } else {
            $jsondata["success"] = false;
            $jsondata["data"] = array('message' => 'No se encontró ningún resultado.');
        }
        $result->close();
    } else {
        $jsondata["success"] = false;
        $jsondata["data"] = array('message' => $conexion->error);
    }
    
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($jsondata, JSON_FORCE_OBJECT);
    
    $conexion->close();
}

exit();                            