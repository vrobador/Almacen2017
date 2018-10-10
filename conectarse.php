<?php require("general/session.php");?>
<?php require_once("general/connection_db.php"); ?>
<?php require_once("general/funciones.php"); ?>

<?php
$conectado=false;
	if(isset($_POST["username"])){
		$errores = array();
		$errores = array_merge($errores, validar_campos_obligatorios(array("username","password")));
		$max_caracteres = array("username" => 30,"password" => 30);
		foreach($max_caracteres as $campo => $max){
			if(strlen($_POST[$campo])>$max)	$errores[] = $campo;	
		}
		$username = trim(preparar_consulta($_POST["username"]));
		$password = sha1(trim(preparar_consulta($_POST["password"])));
		
		if(empty($errores)){
			$consulta = "SELECT * FROM usuarios	WHERE username='{$username}' 
							AND password='{$password}'	LIMIT 1";
            	$resultado = $conexion->query($consulta);
               
			if(mysqli_affected_rows($conexion)==1){
			 	$usuario = $resultado->fetch_array(MYSQLI_BOTH);
				$_SESSION["usuario_id"]=$usuario["id"];
				$_SESSION["username"] = $usuario["username"];
				$conectado=true;
				$mensaje="Se realizo la conexión con exito";
			}else{
				$mensaje = "No se ha podido acceder al módulo: " . mysql_error();
			}
		}else{
			$mensaje = "Se han encontrado " . count($errores) . " errores";
		}
	}
?>
<?php include("general/header.php"); ?>
   <?php if(isset($mensaje)) { echo "<p style='color:red;text-align:center;font-size:1.5em;'>" . $mensaje . "</p>"; } ?>
   <?php if(!$conectado){ ?>
  <table id="estructura">
    <tr>
      <td id="pagina">
      	<h2>Conectarse</h2>
        <form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
        <table>
            <tr><td>Nombre de usuario:</td>
                <td><input type="text" name="username" /></td>
            </tr>
            <tr><td>Contraseña:</td>
                <td><input type="password" name="password" /></td>
            </tr>
        </table>
        <input type="submit" value="Conectar" />
        </form>
     </td>
    </tr>
  </table>
  <?php }?>
<?php require_once("general/footer.php"); ?>