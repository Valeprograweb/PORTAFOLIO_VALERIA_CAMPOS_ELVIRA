<?php 
session_start(); 
$_SESSION['usuario']=$_REQUEST['campousuario']; 
$_SESSION['clave']=$_REQUEST['campoclave']; 
?> 
<html>
<meta charset="UTF-8">
<head> 
<title>Problema</title> 
</head> 
<body> 
Se almacenaron dos variables de sesión.<br><br> 
<a href="ejercicio2b.php">Ir a la tercer página donde se recuperarán 
las variables de sesión</a> 
</body> 
</html>