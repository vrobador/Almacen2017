function cambio(){
	var v=document.getElementById("txcaja").value;
	var c=document.getElementById("cbcaja").value;
    
	if (window.XMLHttpRequest) {
		a = new XMLHttpRequest();
	} else {
		a = new ActiveXObject("Microsoft.XMLHTTP");
	}
	if(a) {
	    a.open("POST", "includes/cargar.php?", false);  
	    /* importante false =>sincrono */
	    a.setRequestHeader('content-type', 'application/x-www-form-urlencoded;charset=UTF-8');
	    a.send("VALOR="+encodeURI(v)+"&CAMPO="+encodeURI(c)+"&nocache="+Math.random());
	}
}	
window.onload = function(){ 
	document.getElementById("cbcaja").onchange=cambio;
	document.getElementById("txcaja").onchange=cambio;
}
