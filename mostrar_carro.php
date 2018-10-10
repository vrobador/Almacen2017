<?php require_once("general/session.php");?>
<?php verificar_sesion(); ?>
<?php require_once("general/connection_db.php"); ?>
<?php require_once("general/funciones.php"); ?>
<?php require_once("includes/carro/gestion_carro_compra.php"); ?>

<?php
	 if(isset($_POST['oculto'])) {
    
	 foreach ($_SESSION['carro'] as $proid => $cantidad) {
      if($_POST[$proid] == '0') {
        unset($_SESSION['carro'][$proid]);
      } else {
        $_SESSION['carro'][$proid]["CANTIDAD"] = $_POST[$proid];
      }
    }

    $ma=calcular($_SESSION['carro']);
    $_SESSION['total_compra'] = $ma[1];
    $_SESSION['elementos'] = $ma[0];
  }

?>
<?php include("general/header.php"); ?>
          <table width="100%">
     	    <tr>
     	    <td width="50%">
     	    <?php boton("carro_compra.php","shopping_cart.png","Ir al carro de la compra","left"); ?>
     	    </td>
     	    <td width="50%">
     	    <?php boton("cargaajax2.php","shopping_cart_accept.png","Hacer el Pedido","right"); ?>
     	    </td>
            </tr>
           </table>
            <?php if(isset($mensaje)) { echo "<p style=\"color:red;font-size=24px\">" . $mensaje . "</p>"; } ?>
           <form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
          <?php 
           if(isset($_SESSION['carro']) && count($_SESSION['carro'])>=1) {
             mostrar_carro_compra($_SESSION['carro']);
           } else {
		    echo "<p>No hay productos solicitados </p><hr/>";
  		   }
	       ?>
             
          </form> 

<?php require_once("general/footer.php"); ?>