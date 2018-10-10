<?php 
require_once("../../general/connection_db.php"); 
global $conexion;

$sql="select * from CLIENTES order by EMPRESA ";
$res=$conexion->query($sql);
$matriz=array();
if($res->num_rows ==0){
	echo '<b>No hay sugerencias</b>';
}else{
	while($fila=$res->fetch_array(MYSQLI_BOTH)){
		$matriz[] = "\"$fila[CLIID]\": \"$fila[EMPRESA]\"";
		           
	}
	echo "{".implode(",", $matriz)."}";
}
mysqli_close($conexion);
?>