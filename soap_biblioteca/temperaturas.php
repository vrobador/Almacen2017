<?php
function GRADOS_C_F($n){
	return ((9/5)*$n)+32;
}
function GRADOS_F_C($n){
	return   (($n-32)*5)/9;
}
function GRADOS_K_C($n){
	return   $n-273.15;
}
function GRADOS_C_K($n){
	return   $n+273.15;
}
function GRADOS_K_F($n){
	return   (($n-273.15)*9/5)+32;
}
function GRADOS_F_K($n){
	return  (($n-32)*5/9)+273.15;
}
?>