<?php require_once("general/funciones.php"); ?>
<?php require_once("general/connection_db.php"); ?>
<?php
	        global $conexion;

        	$jsondata = array();
     		$ma=array("id","username","password1");
		
		    foreach($ma as $e)	
			$$e = preparar_consulta(htmlentities($_GET[$e],ENT_QUOTES,"UTF-8"));
			
		    $consulta=sprintf("INSERT INTO usuarios VALUES('%s','%s','%s')",
			$id,$username,sha1(ltrim($password1)));
echo "paso33;"
			if($conexion->query($consulta)){
			 	$jsondata["success"] = true;
			}else{
			 	$jsondata["success"] = false;
		    }  
		    header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata, JSON_FORCE_OBJECT);
    
?>