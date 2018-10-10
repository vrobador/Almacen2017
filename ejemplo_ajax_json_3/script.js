 /*************************************************************************************/ 
var poner = function(cliid){ 

$.ajax({
    // En data puedes utilizar un objeto JSON, un array o un query string
    data: {"cliid" : cliid},
    //Cambiar a type: POST si necesario
    type: "GET",
    // Formato de datos que se espera en la respuesta
    dataType: "json",
    // URL a la que se enviará la solicitud Ajax
    url: "ejemplo_ajax_json_3/desglose.php"
})
 .done(function( response, textStatus, jqXHR ) {
    if( response.success ) {
				var salida = "<table border=1>";
				
		if (cliid==="NULL"){	
		salida +="<tr><th>PEDID</th><th>CLIENTE</th><th>FECHA</th><th>FACTURACION</td></tr>"; 	
		}else{
		salida +="<tr><th>PEDID</th><th>FECHA</th><th>FACTURACION</td></tr>" ;		
		}
		  $.each(response.data.pedidos, function( k, v ) {
			  salida += "<tr><td> "+ v['PEDID']+" </td>";
			  if (cliid==="NULL")salida += "<td>"+(v['CLIENTE']===null ? "" :v['CLIENTE'])+"</td>";
  			  salida += "<td> "+ v['FECHA']+" </td><td align='right'>"+v['FACTU']+"</td></tr>";
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
    url: "ejemplo_ajax_json_3/clientes.php",
	async: false
}).done( function( response ) {
		if( response.success ) {
						
          var output = "<h1>" + response.data.message + "</h1>";
						
		  $.each(response.data.clientes, function( k, v ) {
		   $("#clientes").append("<option value= "+v['CLIID']+" > "+v['EMPRESA']+" </option>");
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
$('#clientes').on('change', function() {
  poner($(this).val());
});
});        