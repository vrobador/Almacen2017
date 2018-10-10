<?php
function comboycaja($m,$Z=NULL){
	$salida="";
	foreach($m as $k=>$v){
		$ca=($v==$_SESSION['cbcaja']) ? " selected " : "" ;
		$zz=($Z==NULL) ? $v : $k ;
		$salida .=sprintf("<option %s value='%s'>%s</option>",$ca,$v,$zz);
	}
	$salida ="<select  name='cbcaja' id='cbcaja'>".$salida."</select>";
	$salida .="<input type='text' name='txcaja' id='txcaja' maxlength='20' SIZE='20' value='".$_SESSION['txcaja']."' />";
	return $salida;
}
function verificar_consulta($consulta){
	if(!$consulta){
		die("No se ha podido realizar la consulta: " . mysqli_connect_error());
	}
}

function validar_campos_obligatorios($campos_obligatorios){
	$errores = array();
	foreach($campos_obligatorios as $campo){
		if(!isset($_POST[$campo]) || (empty($_POST[$campo]) && !is_numeric($_POST[$campo]))){
			$errores[] = $campo;
		}
	}
	return $errores;
}

function preparar_consulta($consulta){
	global $conexion;
	$mq_activado = get_magic_quotes_gpc();
	if(function_exists("mysqli_real_escape_string")){
		if($mq_activado){
			$consulta = stripslashes($consulta);
		}
		$consulta=$conexion->real_escape_string($consulta);

	}else{
		if(!$mq_activado){
			$consulta = addslashes($consulta);
		}
	}
	return $consulta;
}
function boton($target, $image, $titulo,$posicion='center',$oncli=true) {
	if ($oncli){
		echo "<div align=\"".$posicion."\"><a href=\"".$target."\">
          <img src=\"images/".$image."\"
           title=\"".$titulo."\" border=\"0\" height=\"50\"
           width=\"50\"/></a></div>";
	}else{
		echo "<div onclick=\"document.forms[0].submit();\" align=\"".$posicion."\">
				<a href=\"".$target."\">
          <img  src=\"images/".$image."\"
           title=\"".$titulo."\" border=\"0\" height=\"50\"
           width=\"50\"/></a></div>";
	}
}
function numero($tb,$campo=NULL,$valor=NULL){
	global $conexion;
	if($conexion) {
		$sql="select count(*) np from $tb ";
		
		if ($valor!=NULL) $sql .=" WHERE $campo like '$valor%'";
		
		$res=$conexion->query($sql);
		$f=$res->fetch_assoc();
		$n=$f["np"];
		$res->free();
	}
	return $n;
}
function desplegable(){
	?>
	<ul class="barramenu">
    <?php	if(isset($_SESSION["usuario_id"])){ ?>
      <li><a href="logout.php">Desconectarse <?php echo $_SESSION["username"]; ?> </a></li>
     <?php }else{ ?>
          <li><a href="conectarse.php">Conectarse</a></li>
     <?php }?>
        
    <?php	if(isset($_SESSION["usuario_id"])){ 
            if ($_SESSION["username"]=="root"){?>
             <li><a href="#">Usuarios</a>
             <ul>
                <li><a href="general.php?tipo=usuarios">Usuarios</a></li>
          		<li><a href="nuevousuario.php">Alta</a></li>
          		<li><a href="cargausuarios.php">Gestión</a></li>
          	</ul>
            <?php }?>
     <li><a href="#">Mantenimiento</a>
        <ul>
            <li><a href="general.php?tipo=categorias">Categorias</a></li>
     		<li><a href="general.php?tipo=productos">Productos</a></li>
            <li><a href="general.php?tipo=proveedores">Proveedores</a></li>
            <li><a href="general.php?tipo=clientes">Clientes</a></li>
            <li><a href="general.php?tipo=empleados">Empleados</a></li>
        </ul>
    </li>
      <li><a href="carro_compra.php">Pedidos</a>
       <li><a href="desglose.php">Desglose</a>
      <li><a href="#">JQUERY</a>
        <ul>
            <li><a href="ejerJQUERY/ejercicio4.html">Ejercicio4</a></li>
            <li><a href="ejemplo_ajax_json.php">ejemplo_ajax_json</a></li>
            <li><a href="ejemplo_ajax_json_3.php">ejemplo_ajax_json_3</a></li>
			<li><a href="ejemplo_ajax_json_4.php">ejemplo_ajax_json_4</a></li>
            <li><a href="subirficheros.php">subirficheros</a></li>
        
        </ul>
        
    </li>  
     <?php	} ?>
</ul>
   <?php
	}	
?>
