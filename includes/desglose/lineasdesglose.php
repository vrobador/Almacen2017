<?php 
require_once("../../general/connection_db.php"); 
global $conexion;

$sql="SELECT A.PROID,NOMBRE_ESPA,PRECIO_UNI,CANTIDAD,DESCUENTO,TOTAL
	  FROM desglose A ,productos P 
	  WHERE A.PROID=P.PROID AND PEDID=".$_POST['PEDID'];

$res=$conexion->query($sql);
$matriz=array();
if($res->num_rows ==0){
	echo '<b>No hay sugerencias</b>';
}else{
	while($fila=$res->fetch_array(MYSQLI_BOTH)){
		$salida="[ ";
		$salida .="'".$fila['NOMBRE_ESPA']."'";
		$salida .=",'".$fila['PRECIO_UNI']."'";
		$salida .=",'".$fila['CANTIDAD']."'";
		$salida .=",'".$fila['DESCUENTO']."'";
		$salida .=",'".$fila['TOTAL']."'";
		$salida .=" ]";
		$salida =sprintf("\"%s\":\"%s\"",$fila['PROID'],$salida);
		$matriz[] =$salida;
	}
	echo "{".implode(",", $matriz)."}";
	
}
mysqli_close($conexion);
?>