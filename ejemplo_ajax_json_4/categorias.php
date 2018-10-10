<?php
require_once("../general/connection_db.php");

    if($conexion->connect_errno) {
        die("No se pudo conectar a la base de datos");
    }
    $jsondata = array();
    if ( $result = $conexion->query( "select catid,nombre_cate from categorias order by 2 asc" ) ) {
        if( $result->num_rows > 0 ) {
            $jsondata["success"] = true;
            $jsondata["data"]["message"] = sprintf("Se han encontrado %d clientes", $result->num_rows);
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
    
