<?php require_once("../../general/connection_db.php"); ?>
<?php
global $conexion;

$sql="select * from usuarios where id =".$_POST['usuario'];
$res=$conexion->query($sql);
$matriz=array();

if($res->num_rows ==0){

 echo '<b>No hay sugerencias</b>';

}else{
 

while($fila=$res->fetch_array(MYSQLI_BOTH)){
  $salida="[ ";
  $salida .="'".$fila['password']."'";
  $salida .=" ]";
  $salida =sprintf("\"%s\":\"%s\"",$fila['username'],$salida);
$matriz[] =$salida;
}


echo "{".implode(",", $matriz)."}";

}
mysqli_close($conexion);
?>