<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="styles/paginacion.css">
<link rel="stylesheet" type="text/css" href="styles/comunes.css">
<script type="text/javascript" src="js/actualizar.js"></script>
<script type="text/javascript" src="js/filtro.js"></script>
</head>
<body>
<?php 

require("general/session.php");
verificar_sesion(); 
require_once("general/connection_db.php");

$cual=$_GET['tipo'];
$fichero="includes/".$cual."/gestion_".$cual.".php";
include($fichero);

require_once("general/funciones.php");
include('general/Clase_paginador.php');
include("general/header.php");

$cadenita=NULL;
$mostrar_tabla=true;
echo "<div id='tabla_resultados'>";

include("general/comunes.php");

echo "<div id='prueba'></div>";
if ($mostrar_tabla){
	if(isset($mensaje)) { echo "<p style='color:red;text-align:center;font-size:1.5em;'>" . htmlentities($mensaje,ENT_QUOTES,"UTF-8") . "</p>"; }
	
	switch($cual){
		case "categorias":
		$m=["CATID","NOMBRE_CATE","DESCRIPCION"];
	    break;
		case "productos":
		$m=array("PROID","PROVID","CATID","NOMBRE","NOMBRE_ESPA","CANTIDAD_UNIDAD","PRECIO_UNIDAD","UNIDADES_EXIS","UNIDADES_PED");
		break;
		case "clientes":
		$m=array("CLIENTE","EMPRESA","NOMBRE_CONTACTO","CARGO_CONTACTO","DIRECCION","CIUDAD","REGION","CODIGO_POSTAL","PAIS","TELEFONO","FAX");
		break;		
		case "proveedores":
		$m=array("PROVEEDOR","NOMBRE","NOMBRE_CONTACTO","CARGO_CONTACTO","DIRECCION","CIUDAD","REGION","COD_POSTAL","PAIS","TELEFONO","FAX");
		break;		
		case "empleados":
		$m=array("EMPID","APELLIDOS","NOMBRE","CARGO","FECHA_NACIMIENTO","FECHA_CONTRATACION","DIRECCION","CIUDAD","REGION","COD_POSTAL","PAIS","TELEF_DOMICILIO","EXTENSION_TELEF_","NOTAS","JEFE");
		break;
		case "usuarios":
		$m=array("id","username");
		break;
	}
	if (!isset($_SESSION['tipo']) ||(isset($_SESSION['tipo']) && $_SESSION['tipo']!=$cual) ){
			$_SESSION['tipo']=$cual;
			$_SESSION['cbcaja']='';
			$_SESSION['txcaja']='';
		}
?>
<fieldset>
<legend>Filtrar</legend>
 <form method="post" action="<?php echo $_SERVER['PHP_SELF'].'?tipo='.$cual;?>">
	<?php echo comboycaja($m);?>
</form>
</fieldset> 
	<?php 
$num_rows=numero($cual,$_SESSION['cbcaja'],$_SESSION['txcaja']);

$pages = new Clase_paginador(true,$num_rows,4);
mostrar_tabla();
}


echo "</div>";
 
require_once("general/footer.php"); 
?>
</body>
</html>


