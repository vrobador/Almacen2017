<?php 
if($_GET) {
	$args = explode("&",$_SERVER["QUERY_STRING"]);
	foreach($args as $arg) {
		$keyval = explode("=",$arg);
		if($keyval[0] == "page" || $keyval[0] == "ipp" || $keyval[0] == "tipo") $cadenita .= "&" . $arg;
	}
	$cadenita=ltrim($cadenita,"&");
}
if(isset($_GET['respuesta'])) {
	switch($_GET['respuesta']){
		case 1:
		 $mensaje=respuesta_a_insertar();
		 break;
		case 3:
			$mensaje=respuesta_a_editar();
			break;
	}
}

if(isset($_GET['op'])) {
	switch($_GET['op']){
		case 1:
			formulario_insertar();
			$mostrar_tabla=false;
			break;
		case 2:
			$mensaje=respuesta_a_borrar();
			break;
		case 3:
			formulario_editar();
			$mostrar_tabla=false;
			break;
	}
}
?>