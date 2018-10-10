<?php
if( isset($_GET['cliid']) ) {
    get_datos($_GET['cliid']);
} else {
    die("Solicitud no válida.");
}

function get_datos( $id ) {
    
	require_once("../general/connection_db.php");
	
    if($conexion->connect_errno) {
        die("No se pudo conectar a la base de datos");
    }
   
	$sql=sprintf("SELECT P.PEDID,MIN(P.CLIID) CLIENTE,
	MIN(DATE_FORMAT(FECHA_PEDI,'%s')) FECHA,
	ROUND(SUM(CANTIDAD*PRECIO*(1-DESCUENTO))+MIN(GASTOS_ENVIO),2) FACTU
	FROM pedidos P,desglose D,precios R
	WHERE P.PEDID=D.PEDID
	AND R.PROID=D.PROID AND FECHA_PEDI BETWEEN F_INICIO AND IFNULL(F_FINAL,NOW()) ",
	'%d-%m-%Y');
	
	$sql .=($id =='NULL' ? '' : " AND CLIID='".$id ."'");

	$sql .=" GROUP BY P.PEDID ";
	$sql .=" ORDER BY FACTU DESC ";


    $jsondata = array();
    
    if ( $result = $conexion->query( $sql) ) {
        if( $result->num_rows > 0 ) {
            $jsondata["success"] = true;
            $jsondata["data"]["message"] = sprintf("Se han encontrado %d pedidos", $result->num_rows);
            $jsondata["data"]["pedidos"] = array();
            while( $row = $result->fetch_object() ) {
                $jsondata["data"]["pedidos"][] = $row;
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