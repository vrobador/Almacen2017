<?php
function fila_pie($literal,$cadenita=NULL){
	if ($cadenita!=NULL) $cadenita ="?".$cadenita;
	$sa="<tr><td align='center' colspan=2>";
	$sa .="<input type='submit' value='$literal' />&nbsp;&nbsp";
	$sa .="<input type='button' value='Cancelar' onclick='window.location=\"".$_SERVER['PHP_SELF']."$cadenita\"' />";
	$sa .="</td></tr>";
	return $sa;
}
function fila($literal,$tipo,$nombre,$t,$m,$v){
	$sa="<tr>";
	$sa .="<td>".utf8_encode($literal)."</td>";
	$sa .="<td>";
	$sa .="<input type='$tipo' name='$nombre' maxlength='$m' SIZE='$t' value='$v' />";
	$sa .="</td>";
    $sa .="</tr>";
    return $sa;
}
function fila_combo($literal,$se){
	$sa="<tr>";
	$sa .="<td>".utf8_encode($literal)."</td>";
	$sa .="<td>";
	$sa .=$se;
	$sa .="</td>";
	$sa .="</tr>";
	return $sa;
}
function poner($id,$t,$n,$v){return "<input type='text' id='$id' maxlength='$n' SIZE='$t' value='$v' />";}
function poner_d($id,$t,$n,$v){	return "<input type='date' id='$id' maxlength='$n' SIZE='$t' value='$v' />";}

function mostrar_categorias($n=NULL,$id=NULL,$sb=NULL){

	$salida="<option value='NULL'>Sin asignar</option>";
	$resultado=obtener("categorias","NOMBRE_CATE");
	while($fila=$resultado->fetch_array(MYSQLI_ASSOC)){
		$ca=$fila['CATID']==$n ? " selected " : "";
		$salida .=sprintf("<option %s value=%s>%s</option>",$ca,$fila['CATID'],$fila['NOMBRE_CATE']);
	}
	if($id==NULL)return "<select name='CATID' id='CATID'>".$salida."</select>";
	if($sb==NULL)return "<select id='$id'>".$salida."</select>";
	return "<select onchange='submit();' id='$id' name='$id' >".$salida."</select>";
}
function mostrar_proveedores($n=NULL,$id=NULL){
	$salida="<option value='NULL'>Sin asignar</option>";
	$resultado=obtener("proveedores","NOMBRE");
	while($fila=$resultado->fetch_array(MYSQLI_ASSOC)){
		$ca=$fila['PROVID']==$n ? " selected " : "";
		$salida .=sprintf("<option %s value=%s>%s</option>",$ca,$fila['PROVID'],$fila['NOMBRE']);
	}
	if($id==NULL)return "<select name='PROVID' id='PROVID'>".$salida."</select>";
	return "<select id='$id'>".$salida."</select>";
}
function mostrar_clientes($n=NULL,$id=NULL,$sb=NULL){
	$salida="<option value='NULL'>Sin asignar</option>";
	$resultado=obtener("clientes","EMPRESA");
	while($fila=$resultado->fetch_array(MYSQLI_ASSOC)){
		$ca=$fila['CLIID']==$n ? " selected " : "";
		$salida .=sprintf("<option %s value=%s>%s</option>",$ca,$fila['CLIID'],$fila['EMPRESA']);
	}
	if($id==NULL)return "<select name='CLIID' id='CLIID'>".$salida."</select>";
	if($sb==NULL)return "<select id='$id'>".$salida."</select>";
return "<select onchange='cargaCliente();' id='$id' name='$id' >".$salida."</select>";
}
function mostrar_usuarios($n=NULL,$id=NULL,$sb=NULL){
	$salida="";
	$resultado=obtener("usuarios","username");
	while($fila=$resultado->fetch_array(MYSQLI_ASSOC)){
		$ca=$fila['username']==$n ? " selected " : "";
		$salida .=sprintf("<option %s value='%s'>%s</option>",$ca,$fila['id'],$fila['username']);
	}
	if($id==NULL)return "<select name='username' id='username'>".$salida."</select>";
	if($sb==NULL)return "<select id='$id'>".$salida."</select>";
	return "<select size=10 onchange='cargaUsuario();' id='$id' name='$id' >".$salida."</select>";
}
function obtener($tabla,$ordenado){
	global $conexion;
	$c = $conexion->query("select * from $tabla order by $ordenado");
	verificar_consulta($c);
	return $c;
}

?>