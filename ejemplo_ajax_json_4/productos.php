<?php
if( isset($_GET['catid']) ) {
    get_datos($_GET['catid']);
} else {
    die("Solicitud no válida.");
}

function get_datos( $id ) {
    
	require_once("../general/connection_db.php");
	
    if($conexion->connect_errno) {
        die("No se pudo conectar a la base de datos");
    }

	$sql="select a.catid,a.nombre_cate,b.nombre_espa
		  from categorias a,productos b where a.catid=b.catid ";
		  
    $sql .=($id =='NULL' ? '' : " and a.catid='".$id ."'");

	$sql .=" order by 1,2 ";


    $jsondata = array();
    
    if ( $result = $conexion->query( $sql) ) {
        if( $result->num_rows > 0 ) {
            $jsondata["success"] = true;
            $jsondata["data"]["message"] = sprintf("Se han encontrado %d pedidos", $result->num_rows);
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