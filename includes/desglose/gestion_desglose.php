<?php
function obtener_num_pedidos($n){
	global $conexion;
	$consulta="SELECT COUNT(*) FROM ( SELECT P.PEDID
	FROM pedidos P,desglose D,precios R
	WHERE P.PEDID=D.PEDID
	AND R.PROID=D.PROID AND FECHA_PEDI BETWEEN F_INICIO AND IFNULL(F_FINAL,NOW()) ";
	$consulta .=($n=='NULL' ? '' : " AND CLIID='".$n."'");
	
	if ($_SESSION['txcaja']!=''){
	 if ($_SESSION['cbcaja']=='P.FECHA_PEDI'){
	 $g=substr_count($_SESSION['txcaja'], '-');
	 $tb=['%Y','%m-%Y','%d-%m-%Y'];
	 $consulta .=sprintf(" AND DATE_FORMAT(P.FECHA_PEDI,'%s')='".$_SESSION['txcaja']."'",$tb[$g]); 
	 }ELSE{
	 $consulta .=" AND ".$_SESSION['cbcaja']." like '".$_SESSION['txcaja']."%'";
	 }
	}
	$consulta .=" GROUP BY P.PEDID ) A";
	$resultado=$conexion->query($consulta);
	$fila = $resultado->fetch_array(MYSQLI_BOTH);
	return $fila[0];
}
function mostrar_tabla($n){
	global $conexion;
	global $pages;

	echo"<br/>";
	echo $pages->display_pages();
	echo"<br/><br/>";
	echo "<span class=\"\">".$pages->display_jump_menu().$pages->display_items_por_pagina()."</span>";
	echo"<br/>";
	
	$consulta=sprintf("SELECT P.PEDID,MIN(P.CLIID) CLIENTE,
	MIN(DATE_FORMAT(FECHA_PEDI,'%s')) FECHA,
	ROUND(SUM(CANTIDAD*PRECIO*(1-DESCUENTO))+MIN(GASTOS_ENVIO),2) FACTU
	FROM pedidos P,desglose D,precios R
	WHERE P.PEDID=D.PEDID
	AND R.PROID=D.PROID AND FECHA_PEDI BETWEEN F_INICIO AND IFNULL(F_FINAL,NOW()) ",
	'%d-%m-%Y');
	
	$consulta .=($n=='NULL' ? '' : " AND CLIID='".$n."'");
	if ($_SESSION['txcaja']!=''){
		if ($_SESSION['cbcaja']=='P.FECHA_PEDI'){
			
		 $g=substr_count($_SESSION['txcaja'], '-');
		 $tb=['%Y','%m-%Y','%d-%m-%Y'];
		 $consulta .=sprintf(" AND DATE_FORMAT(P.FECHA_PEDI,'%s')='".$_SESSION['txcaja']."'",$tb[$g]);
		}ELSE{
		 $consulta .=" AND ".$_SESSION['cbcaja']." like '".$_SESSION['txcaja']."%'";
		}
	}
	$consulta .=" GROUP BY P.PEDID ";
	$consulta .=" ORDER BY FACTU DESC LIMIT ";
	$consulta .=$pages->limite_inicial.",".$pages->limite_final;
	
	$resultado = $conexion->query($consulta);
	echo"<br/><br/>";
	echo "<table id='rejilla'>
	<tr><th>PEDID</th><th>CLIID</th><th>FECHA PEDIDO</th>
	<th>FACTURACION</th>	</tr>\n";
	
	while($row=$resultado->fetch_array(MYSQLI_BOTH)){
		
		echo sprintf("<tr style='cursor: pointer;' onmouseover=\"hilite(this)\" 
				onmouseout=\"lowlite(this)\" 
				OnClick='desglose(%d);'    >
		<td>$row[0]</td><td>$row[1]</td><td>$row[2]</td>
		<td align='right' >".number_format($row[3],2)."</td>", $row['PEDID']);
		
		//$salida =sprintf("<td align='center'><a href='#'  OnClick='desglose(%d);' >Detalle</a></td>", $row['PEDID']);
		//echo $salida."</tr>\n";
		echo "</tr>\n";
	}
	echo "</table>\n";
	echo"<br/>";
	echo $pages->display_pages();
	echo"<br/><br/>";
}


?>