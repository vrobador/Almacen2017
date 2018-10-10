<?php
	session_start();	
	$_SESSION = array();	
	setcookie(session_name(),'',time()-56000);	
	session_destroy();
	die(header("Location: index.php"));
?>