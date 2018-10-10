<?php
require_once("../general/connection_db.php");

    if($conexion->connect_errno) {
        die("No se pudo conectar a la base de datos");
    }
    
    $jsondata = array();
    if ( $result = $conexion->query( "SELECT * FROM categorias order by nombre_cate" ) ) {
        if( $result->num_rows > 0 ) {
            $jsondata["success"] = true;
            $jsondata["data"]["message"] = sprintf("Se han encontrado %d categorias", $result->num_rows);
            $jsondata["data"]["categorias"] = array();
            while( $row = $result->fetch_object() ) {
                $jsondata["data"]["categorias"][] = $row;
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
    
