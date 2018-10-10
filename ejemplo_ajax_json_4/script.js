 /*************************************************************************************/ 
var poner = function(catid){ 

$.ajax({
    // En data puedes utilizar un objeto JSON, un array o un query string
    data: {"catid" : catid},
    //Cambiar a type: POST si necesario
    type: "GET",
    // Formato de datos que se espera en la respuesta
    dataType: "json",
    // URL a la que se enviará la solicitud Ajax
    url: "ejemplo_ajax_json_4/productos.php"
})
 .done(function( response, textStatus, jqXHR ) {
    if( response.success ) {
				var salida = "<table border=1>";
				
		if (catid==="NULL"){	
			salida +="<tr><th>CATID</th><th>CATEGORIA</th><th>PRODUCTO</th></tr>"; 		
		}else{
				salida +="<tr><th>PRODUCTO</th></tr>"; 		
		
		}
		  $.each(response.data.productos, function( k, v ) {

       	  if (catid==="NULL"){
  			  salida += "<tr> ";
			  salida += "<td> "+ v['catid']+" </td>";
			  salida += "<td> "+ v['nombre_cate']+" </td>";
			  salida += "<td> "+ v['nombre_espa']+" </td>";
			  salida += "</tr> ";
			}else{
			  salida += "<tr><td>"+v['nombre_espa']+"</td></tr>";	
			}  
		  });
			   salida +="</table>";
			
			$("#respuesta").html(salida);
		} else {
			$("#respuesta").html('Sin suerte: ' + response.data.message);
		}
 })
 .fail(function( jqXHR, textStatus, errorThrown ) {
    $("#respuesta").html("Algo ha fallado .....: " +  textStatus);
});

};
/*************************************************************************************/
var inicio = function(){ 
	$("#respuesta").html("<p>Buscando...</p>");
	
$.ajax({
    type: "GET",
    dataType: "json",
    url: "ejemplo_ajax_json_4/categorias.php",
	async: false
}).done( function( response ) {
		if( response.success ) {
						
          var output = "<h1>" + response.data.message + "</h1>";
						
		  $.each(response.data.categorias, function( k, v ) {
		   $("#categorias").append("<option value= "+v['catid']+" > "+v['nombre_cate']+" </option>");
		  });

			$("#respuesta").html(output);
		} else {
				  $("#respuesta").html('Sin suerte: ' + response.data.message);
		}
	}).fail(function( jqXHR, textStatus, errorThrown ) {
				$("#respuesta").html("Algo ha fallado: " +  textStatus);
    });
	

};
/*************************************************************************************/ 
$(document).ready(function(){
inicio();
poner("NULL");
$('#categorias').on('change', function() {
  poner($(this).val());
});
});        