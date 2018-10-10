	var searchBoxes =document.querySelectorAll('.text');

	var inputUsername = document.getElementById("username");
	var reqUsername = document.getElementById("req-username");
	var inputPassword1 = document.getElementById("password1");
	var reqPassword1 = document.getElementById("req-password1");
	var inputPassword2 = document.getElementById("password2");
	var reqPassword2 = document.getElementById("req-password2");
	var inputId = document.getElementById("id");
	var reqId = document.getElementById("req-id");

	function validateId(){
		if(inputId.value.length < 1 || inputId.value.length > 11){
			reqId.classList.add("error");
			inputId.classList.add("error");
				return false;
		}else if(!inputId.value.match(/^[0-9]+$/)){
			reqId.classList.add("error");
			inputId.classList.add("error");
			return false;
			
		}else if(!(parseInt(inputId.value)>=0 && parseInt(inputId.value)<=100000000000)){
			reqId.classList.add("error");
			inputId.classList.add("error");
			return false;
		}
		else{
			reqId.classList.remove("error");
			inputId.classList.remove("error");
			return true;
		}
	}
	
	function validateUsername(){
		//NO cumple longitud minima
		if(inputUsername.value.length < 4){
			reqUsername.classList.add("error");
			inputUsername.classList.add("error");
			return false;
		}
		//SI longitud pero NO solo caracteres A-z
		else if(!inputUsername.value.match(/^[a-zñÑA-Z ]+$/)){
			reqUsername.classList.add("error");
			inputUsername.classList.add("error");
			return false;
		}
		// SI longitud, SI caracteres A-z
		else{
			reqUsername.classList.remove("error");
			inputUsername.classList.remove("error");
			return true;
		}
	}
	function validatePassword1(){
		//NO tiene minimo de 5 caracteres o mas de 12 caracteres
		if(inputPassword1.value.length < 5 || inputPassword1.value.length > 12){
			reqPassword1.classList.add("error");
			inputPassword1.classList.add("error");
			return false;
		}
		// SI longitud, NO VALIDO numeros y letras
		else if(!inputPassword1.value.match(/^[0-9a-zA-Z]+$/)){
			reqPassword1.classList.add("error");
			inputPassword1.classList.add("error");
			return false;
		}
		// SI rellenado, SI email valido
		else{
			reqPassword1.classList.remove("error");
			inputPassword1.classList.remove("error");
			return true;
		}
	}
	function validatePassword2(){
		//NO son iguales las password
		if(inputPassword1.value != inputPassword2.value){
			reqPassword2.classList.add("error");
			inputPassword2.classList.add("error");
			return false;
		}
		// SI son iguales
		else{
			reqPassword2.classList.remove("error");
			inputPassword2.classList.remove("error");
			return true;
		}
	}

	
	inputUsername.addEventListener("blur", validateUsername);
	inputPassword1.addEventListener("blur",validatePassword1);  
	inputPassword2.addEventListener("blur",validatePassword2);
	inputId.addEventListener("blur",validateId);
	
	// Pulsacion de tecla
	inputUsername.addEventListener("keyup", validateUsername); 
	inputPassword1.addEventListener("keyup",validatePassword1);
	inputPassword2.addEventListener("keyup",validatePassword2);
	inputId.addEventListener("keyup",validateId);
	
	document.getElementById('form1').addEventListener('submit', function(evt){
	    
	    if(!(validateUsername() & validatePassword1() 
	    		& validatePassword2() & validateId() ))
		evt.preventDefault();
  
	})
	
	searchBoxes.addEventListener("blur", function( event ) {
		  event.target.classList.remove("active"); 
		}, true);
	
	searchBoxes.addEventListener("focus", function( event ) {
		  event.target.classList.add("active"); 
		}, true);
	
	
	