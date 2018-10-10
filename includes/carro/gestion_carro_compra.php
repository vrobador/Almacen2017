<?php
function obtener_num_prod($n,$campo=NULL,$valor=NULL){
	global $conexion;
/*
	$consulta="SELECT COUNT(*) FROM productos ";

	if ($n!='NULL' && $valor!=''){
		$consulta .=" WHERE CATID='$n' AND $campo like '$valor%'";
	}else if($n!='NULL'){
		$consulta .=" WHERE CATID=".$n;
	}else if($valor!=''){
		$consulta .=" WHERE $campo like '$valor%'";
	}
*/	
	$consulta="select COUNT(*)";
	$consulta .=" FROM productos A,proveedores B,categorias C WHERE A.PROVID=B.PROVID AND A.CATID=C.CATID ";
	$consulta .=($n=='NULL' ? '' : " AND A.CATID=".$n);
	if ($_SESSION['txcaja']!='')
	$consulta .=" AND ".$_SESSION['cbcaja']." like '".$_SESSION['txcaja']."%'";
	$resultado=$conexion->query($consulta);

	$fila = $resultado->fetch_array(MYSQLI_BOTH);
	return $fila[0];
}
function mostrar_tabla($n){
	global $conexion;
	global $pages;

	echo"<br/><br/>";
	echo $pages->display_pages();
	echo"<br/><br/>";
	echo "<span class=\"\">".$pages->display_jump_menu().$pages->display_items_por_pagina()."</span>";
	echo"<br/>";
	$consulta="select A.PROID,C.NOMBRE_CATE CATEGORIA,B.NOMBRE PROVEEDOR,A.NOMBRE_ESPA PRODUCTO";
	$consulta .=",A.PRECIO_UNIDAD";
	$consulta .=" FROM productos A,proveedores B,categorias C WHERE A.PROVID=B.PROVID AND A.CATID=C.CATID ";
	$consulta .=($n=='NULL' ? '' : " AND A.CATID=".$n);
	
	if ($_SESSION['txcaja']!='') 
	$consulta .=" AND ".$_SESSION['cbcaja']." like '".$_SESSION['txcaja']."%'";
	
	$consulta .=" ORDER BY A.NOMBRE_ESPA ASC LIMIT ";
	$consulta .=$pages->limite_inicial.",".$pages->limite_final;
 
	$resultado = $conexion->query($consulta);
	echo"<br/><br/>";
	echo "<table id='rejilla'>
	<tr><th>ID</th><th>Categoria</th><th>Proveedor</th>
	<th>producto</th><th>Precio</th><th>Accion</th>	</tr>\n";
	
	while($row=$resultado->fetch_array(MYSQLI_BOTH)){
		echo "<tr onmouseover=\"hilite(this)\" onmouseout=\"lowlite(this)\">
		<td>$row[0]</td><td>$row[1]</td><td>$row[2]</td>
		<td>$row[3]</td><td>$row[4]</td>";
		
		$salida =sprintf("<td align='center'><a href='#'  OnClick='comprar(%d,%10.2f,\"%s\");' >Comprar</a></td>", $row['PROID'],$row[4],$row[3]);
		echo $salida."</tr>\n";
	}
	echo "</table>\n";
	echo"<br/>";
	echo $pages->display_pages();
	echo"<br/><br/>";
}

function respuesta_a_pedido($carro){
	global $conexion;
	
	$errores = validar_campos_obligatorios(array("clientes","destinatario",
	"direc_desti","ciuda_desti","regio_desti","cod_pos_desti","pais_desti",
	"gastos_envio"));
	
	if(!empty($errores)) return "No se han podido validar los datos";
		
	$pedid=pedido_siguiente();

	$ma=array("clientes","destinatario","direc_desti","ciuda_desti",
			"regio_desti","cod_pos_desti","pais_desti","gastos_envio");
	
	foreach($ma as $e)
	$$e = preparar_consulta(htmlentities($_POST[$e],ENT_QUOTES,"UTF-8"));

	$consulta = "INSERT INTO pedidos(PEDID,CLIID,DESTINATARIO,DIREC_DESTI,
	CIUDA_DESTI,REGIO_DESTI,COD_POS_DESTI,PAIS_DESTI,GASTOS_ENVIO,FECHA_PEDI) 
	VALUES ({$pedid},'{$clientes}','{$destinatario}','{$direc_desti}',
	'{$ciuda_desti}','{$regio_desti}',
	'{$cod_pos_desti}','{$pais_desti}','{$gastos_envio}',sysdate())";
	
	$conexion->autocommit(false);
	$conexion->begin_transaction();

	if($conexion->query($consulta)){
		
		foreach ($carro as $proid => $producto)  {
			$total=$producto['CANTIDAD']*$producto['PRECIO'];
			$consulta="INSERT INTO desglose(PEDID,PROID,CANTIDAD,PRECIO_UNI,
			DESCUENTO,TOTAL) VALUES({$pedid},{$proid},{$producto['CANTIDAD']},
			{$producto['PRECIO']},0,{$total})";
			
			if(!$conexion->query($consulta)){
				$conexion->rollback();
				$conexion->autocommit(true);
				return "No se ha podido crear el pedido " . mysqli_connect_error();
			}
		}
	}else{
		$conexion->rollback();
		$conexion->autocommit(true);
		return "No se ha podido crear el pedido " . mysqli_connect_error();
	}
	$conexion->commit();
	$conexion->autocommit(true);
	return "Inserción exitosa";
}

function mostrar_carro_compra($carro, $change = true) {
	
 	echo "<table id='rejilla' align='center'>
	<tr>
	<th width='250px'>PRODUCTO</th>
	<th width='100px'>PRECIO</th>
	<th width='100px' align='right' >UNIDADES</th>
	<th width='100px'>TOTAL</th>
	</tr>\n";
	

  foreach ($carro as $proid => $producto)  {
    echo "<tr>";
    
    echo "<td align='left'>".$producto['NOMBRE']."</td>
          <td align='center'>".number_format($producto['PRECIO'], 2)."€</td>
          <td align='center'>";

    if ($change) {
      echo "<input type='text' onchange='document.forms[0].submit()' name=\"".$proid."\" 
      		value=".$producto['CANTIDAD']." size=3>";
    } else {
      echo $producto['CANTIDAD'];
    }
    echo "</td><td align='center'>"
    		.number_format($producto['PRECIO']*$producto['CANTIDAD'],2).
    "€</td></tr>\n";
  }
  echo "<tr>
        <th colspan='2'>&nbsp;</td>
        <th align='center' bgcolor='#cccccc'>".$_SESSION['elementos']."</th>
        <th align='center' bgcolor='#cccccc'>
            ".number_format($_SESSION['total_compra'], 2)."€
        </th>
        </tr>";
  if($change) {
    echo "<tr>
          <td colspan=2 >&nbsp;</td>
          <td align='center'>
             <input type='hidden' name='oculto' value='true'/>
          </td>
          <td>&nbsp;</td>
          </tr>";
    
    //<input type='submit' value='Salvar' />
  }
  echo "</table></br>";
}
function calcular($carro) {
	$suma= 0.0;
	$elementos = 0;
	if(is_array($carro))   {
		foreach($carro as $proid => $producto){
			$suma += $producto['CANTIDAD']*$producto['PRECIO'];
			$elementos += $producto['CANTIDAD'];
		}
	}

	return [$elementos,$suma];
}
function pedido_siguiente(){
	global $conexion;
    $consulta="SELECT max(pedid)+1  FROM pedidos ";
	$resultado=$conexion->query($consulta);
    $fila = $resultado->fetch_array(MYSQLI_BOTH);
	return $fila[0];
}
?>