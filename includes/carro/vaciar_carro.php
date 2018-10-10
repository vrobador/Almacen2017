<?php
session_start();

      $_SESSION['carro'] = array();
      $_SESSION['elementos'] = 0;
      $_SESSION['total_compra'] ='0.00';

$salida=$_SESSION['elementos']."#".number_format($_SESSION['total_compra'],2);

echo $salida;
?>