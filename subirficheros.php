<?php require("general/session.php");?>
<?php require_once("general/funciones.php"); ?>
<!DOCTYPE html>
<html lang="es-ES">
   <head>
    <title></title>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript" src="subirficheros/functions.js"></script>

<style type="text/css">
    .messages{
        float: left;
        font-family: sans-serif;
        display: none;
    }
    .info{
        padding: 10px;
        border-radius: 10px;
        background: orange;
        color: #fff;
        font-size: 18px;
        text-align: center;
    }
    .before{
        padding: 10px;
        border-radius: 10px;
        background: blue;
        color: #fff;
        font-size: 18px;
        text-align: center;
    }
    .success{
        padding: 10px;
        border-radius: 10px;
        background: green;
        color: #fff;
        font-size: 18px;
        text-align: center;
    }
    .error{
        padding: 10px;
        border-radius: 10px;
        background: red;
        color: #fff;
        font-size: 18px;
        text-align: center;
    }
</style>
</head>
    <body>
	<?php include("general/header.php"); ?>
  
  <table id="estructura">
    <tr>
      <td id="pagina">
      
      <!--  lo relativo al ejercicio -->
      <!--el enctype debe soportar subida de archivos con multipart/form-data-->
    <form enctype="multipart/form-data" class="formulario">
        <label>Subir un archivo</label><br />
        <input name="archivo" type="file" id="imagen" /><br /><br />
        <input type="button" value="Subir imagen" /><br />
    </form>
    <!--div para visualizar mensajes-->
    <div class="messages"></div><br /><br />
    <!--div para visualizar en el caso de imagen-->
    <div class="showImage"></div>
      <!--  lo relativo al ejercicio -->
     </td>
    </tr>
  </table>
  
<?php require_once("general/footer.php"); ?>
</body>
</html>
