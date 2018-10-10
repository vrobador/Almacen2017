<?php 
require_once("../../general/connection_db.php"); 
global $conexion;
$consulta="delete from usuarios where id=".ltrim($_POST['usuario']);

$conexion->query($consulta);

if(mysqli_affected_rows($conexion) == 1){
	echo "Borrado exitoso";
}else{
    echo "Error al intentar eliminar un Usuario: " . mysql_error();
}
mysqli_close($conexion);
?>