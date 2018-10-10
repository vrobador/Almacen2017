<?php require_once("general/session.php");?>
<?php verificar_sesion(); ?>
<?php require_once("general/connection_db.php"); ?>
<?php include("general/funciones.php"); ?>
<?php include("includes/usuarios/gestion_usuarios.php"); ?>
<?php

function validateId($edad){
	if(strlen($edad) < 1 ||strlen($edad)>11)
		return false;
		//SI longitud pero NO solo caracteres A-z
		else if(!preg_match("/^[0-9]+$/", $edad))
			return false;
			else if(!( intval($edad)>=0 && intval($edad)<=100000000000))
				return false;
				// SI longitud, SI caracteres A-z
				else
					return true;
}
function validateUsername($name){
	//NO cumple longitud minima
	if(strlen($name) < 4)
		return false;
	//SI longitud pero NO solo caracteres A-z
	else if(!preg_match("/^[a-zñÑA-Z ]+$/", $name))
		return false;
	// SI longitud, SI caracteres A-z
	else
		return true;
}

function validatePassword1($password1){
	//NO tiene minimo de 5 caracteres o mas de 12 caracteres
	if(strlen($password1) < 5 || strlen($password1) > 12)
		return false;
	// SI longitud, NO VALIDO numeros y letras
	else if(!preg_match("/^[0-9a-zA-Z]+$/", $password1))
		return false;
	// SI rellenado, SI email valido
	else
		return true;
}

function validatePassword2($password1, $password2){
	//NO coinciden
	if($password1 != $password2)
		return false;
	else
		return true;
}
$id_old_Value = "";
$id="";
$idValue = "";
$username = "";
$usernameValue = "";
$password1 = "";
$password1Value="";
$password2 = "";
$password2Value="";

if(isset($_GET['id']) && !isset($_POST['send'])){
	$fi=obtener_usuario_por_id($_GET['id']);
	$idValue=$fi['id'];
	$id_old_Value=$fi['id'];
	$usernameValue=$fi['username'];
	//$password1Value=$fi['password'];
	//$password2Value=$fi['password'];
}
//Validacion de datos enviados
if(isset($_POST['send'])){
	if(!validateId($_POST['id']))$id = "error";
	if(!validateUsername($_POST['username']))$username = "error";
	if(!validatePassword1($_POST['password1']))$password1 = "error";
	if(!validatePassword2($_POST['password1'], $_POST['password2']))$password2 = "error";
	
	//Guardamos valores para que no tenga que reescribirlos
	$id_old_Value = $_POST['id_old'];
	$idValue = $_POST['id'];
	$usernameValue = $_POST['username'];
	$password1Value=$_POST['password1'];
	$password2Value=$_POST['password2'];
	
	//Comprobamos si todo ha ido bien
	if($username != "error" && $password1 != "error"&& $password2 != "error"
	&& $id != "error"  )	$status = 1;
}
$cadenita="";
if($_GET) {
	$args = explode("&",$_SERVER["QUERY_STRING"]);
	foreach($args as $arg) {
		$keyval = explode("=",$arg);
		if($keyval[0] !=  "id") $cadenita .= "&" . $arg;
	}
	$cadenita=ltrim($cadenita,"&");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="es-ES">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Inserción Usuarios</title>
	<link rel="stylesheet" href="styles/main.css" type="text/css" media="screen" />
	
</head>
<body>
<?php include("general/header.php"); ?>
	<div class="wrapper">
		<div class="section">
			<?php if(!isset($status)): ?>
			<?php if (empty($id_old_Value)){
				echo("<h1>Formulario de Alta Usuarios</h1>");
			}else{
				echo("<h1>Formulario de Modificar Usuarios</h1>");
			}
			?>
			<form method="post" id="form1" action="<?php echo $_SERVER['PHP_SELF']."?".$cadenita; ?>">
			 
	            <input type="hidden" name="id_old" id="id_old" value="<?php echo $id_old_Value ?>" >
	
				<label for="id">Id del usuario (<span id="req-id" class="requisites <?php echo $username ?>">Numero Entero entre 0-100000000000</span>):</label>
   				<input name="id" id="id" type="text" class="text <?php echo $id ?>" value="<?php echo $idValue ?>" />
   				
				<label for="username">Nombre de usuario (<span id="req-username" class="requisites <?php echo $username ?>">A-z, mínimo 4 caracteres</span>):</label>
   				<input name="username" id="username" type="text" class="text <?php echo $username ?>" value="<?php echo $usernameValue ?>" />
				<label for="password1">Contraseña (<span id="req-password1" class="requisites <?php echo $password1 ?>">Mínimo 5 caracteres, máximo 12 caracteres, letras y números</span>):</label>
				<input name="password1" id="password1" type="password" class="text <?php echo $password1 ?>" value="<?php echo $password1Value ?>" />
				<label for="password2">Repetir Contraseña (<span id="req-password2" class="requisites <?php echo $password2 ?>">Debe ser igual a la anterior</span>):</label>
				<input name="password2" id="password2" type="password" class="text <?php echo $password2 ?>" value="<?php echo $password2Value ?>" />
				
				<div>
					<input tabindex="9" name="send" id="send" type="submit" class="submit" value="Enviar formulario" />
					<button onClick="window.location='general.php?<?php echo $cadenita?>'" >Cancelar</button>
				</div>
			</form>
			
			<?php else: 
			if (empty($id_old_Value)){
				$mensaje=respuestaainsertar();
			}else{
                $mensaje=respuestaaeditar();				
			}
			echo ("<h1>$mensaje</h1>");
			?>
			<button onClick="window.location='nuevousuario.php?<?php echo $cadenita?>'" >Alta Usuario</button>
			<button onClick="window.location='general.php?<?php echo $cadenita?>'" >Cancelar</button>
			<?php 
			endif; 
			?>
		</div>
	</div>
	<script type="text/javascript" src="js/ValidacionUsuario.js"></script>
</body>
</html>
<?php require_once("general/footer.php"); ?>