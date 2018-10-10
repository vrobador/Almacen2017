<?php require_once("../../general/connection_db.php"); ?>
<?php
global $conexion;

$sql="select * from clientes where CLIID LIKE '".$_POST['CLIID']."'";
$res=$conexion->query($sql);
$matriz=array();

if($res->num_rows ==0){

 echo '<b>No hay sugerencias</b>';

}else{
 

while($fila=$res->fetch_array(MYSQLI_BOTH)){
  $salida="[ ";
  $salida .="'".$fila['EMPRESA']."'";
  $salida .=",'".$fila['NOMBRE_CONTACTO']."'";
  $salida .=",'".$fila['CARGO_CONTACTO']."'";
  $salida .=",'".$fila['DIRECCION']."'";
  $salida .=",'".$fila['CIUDAD']."'";
  $salida .=",'".$fila['REGION']."'";
  $salida .=",'".$fila['CODIGO_POSTAL']."'";
  $salida .=",'".$fila['PAIS']."'";
  $salida .=",'".$fila['TELEFONO']."'";
  $salida .=",'".$fila['FAX']."'";
  $salida .=" ]";
  $salida =sprintf("\"%s\":\"%s\"",$fila['CLIID'],$salida);
$matriz[] =$salida;
}


echo "{".implode(",", $matriz)."}";

}
mysqli_close($conexion);
?>