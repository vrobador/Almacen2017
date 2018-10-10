<?php
	require_once('lib/nusoap.php');
    require_once('temperaturas.php');
      
    $server = new nusoap_server();
    $server->register('calculadora');
    $server->register('GRADOS_C_F');
    $server->register('GRADOS_F_C');
   
    $server->register('GRADOS_K_C');
    $server->register('GRADOS_C_K');
    $server->register('GRADOS_K_F');
    $server->register('GRADOS_F_K');
    
      
    $HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
    $server->service($HTTP_RAW_POST_DATA);
?>