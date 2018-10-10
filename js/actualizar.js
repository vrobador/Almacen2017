function hilite(elem){	elem.style.background = 'red';}
function lowlite(elem){	elem.style.background = '';}
function a(str,tipo) {
	if (str == "") {
		document.getElementById("prueba").innerHTML = "";
		return;
	} else {
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
					document.getElementById("prueba").innerHTML = this.responseText;
			}
		};
		
	    var pasar="includes/"+tipo+"/actualizar_"+tipo+".php?"+str;
	    
		xmlhttp.open("GET",pasar,true);
		xmlhttp.send();
	}
}
function poner(ele){
   //EJEMPLO ELE--->productos_3578
	var id=ele.id;
	var posi=id.indexOf("_");
	var numero=id.substring(posi+1);
	var tipo=id.substring(0,posi);

	switch(tipo){
		case "productos":
			var m=["NUMERO","PROID","PROVID","CATID","NOMBRE","NOMBRE_ESPA","CANTIDAD_UNIDAD",
				"PRECIO_UNIDAD","UNIDADES_EXIS","UNIDADES_PED"];
			break;
		case "usuarios":
		    var m=["numero","id","username","password"];	
		    break;
		case "categorias":
		    var m=["NUMERO","CATID","NOMBRE_CATE","DESCRIPCION"];
     	    break;
		case "empleados":
			var m=["NUMERO","EMPID","APELLIDOS","NOMBRE","CARGO","FECHA_NACIMIENTO","FECHA_CONTRATACION","DIRECCION","CIUDAD","REGION","COD_POSTAL","PAIS","TELEF_DOMICILIO","NOTAS","JEFE"];
            break;
		case "proveedores":
			var m=["NUMERO","PROVID","NOMBRE","NOMBRE_CONTACTO","CARGO_CONTACTO","DIRECCION","CIUDAD","REGION","COD_POSTAL","PAIS","TELEFONO","FAX"];
            break;
		case "clientes":
			var m=["NUMERO","CLIID","EMPRESA","NOMBRE_CONTACTO","CARGO_CONTACTO","DIRECCION","CIUDAD","REGION","CODIGO_POSTAL","PAIS","TELEFONO","FAX"];
			break;
	}
	

	var c=[numero];

	for (i = 1; i < m.length; i++)	
	c.push(document.getElementById(m[i]+'_'+numero).value);
	
	var cadena="";
	for (i = 0; i < m.length; i++) cadena +="&"+m[i]+"="+c[i];
	
	a(cadena.substr(1),tipo);

}


