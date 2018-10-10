<?php
session_start();
$nuevo=$_POST['PROID'];
$precio=$_POST['PRECIO'];
$nombre=$_POST['NOMBRE'];

if(!isset($_SESSION['carro'])) {
      $_SESSION['carro'] = array();
      $_SESSION['elementos'] = 0;
      $_SESSION['total_compra'] ='0.00';
}
if(isset($_SESSION['carro'][$nuevo])) {
      $_SESSION['carro'][$nuevo]["CANTIDAD"]++;
} else {
      $_SESSION['carro'][$nuevo] = ["CANTIDAD"=>1,"PRECIO"=>$precio,"NOMBRE"=>$nombre];
}
	$_SESSION['total_compra'] +=$precio;
	$_SESSION['elementos']++;

$salida=$_SESSION['elementos']."#".number_format($_SESSION['total_compra'],2);

echo $salida;
?>