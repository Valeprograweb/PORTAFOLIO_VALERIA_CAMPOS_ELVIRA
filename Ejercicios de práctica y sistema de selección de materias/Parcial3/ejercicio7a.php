<?php
if(isset($_GET['nombre']) && $_GET['nombre']!="" ){
$user=$_GET['nombre'];
if(isset($_COOKIE[$user]))
{
// Caduca en un año 60*60*24*365 (60 seg * 60 min*24hr*365 dias)
setcookie($user, $_COOKIE[$user]+1, time()+120);
$mensaje = 'Número de visitas: ' . $_COOKIE[$user];
}
else{
// Caduca en un año 60*60*24*365
setcookie($user, 1, time()+120); //caduca en 2 minutos
$mensaje = 'Bienvenido a nuestra página web<br>';
}
print_r ($_COOKIE);
echo $mensaje;
echo "contadores...";
}
else {
echo "No defino";
}
?>
<html>
<head>
<title>Ejemplo de PHP</title>
</head>
<body>
<H1>Ejemplo de uso de cookie...</H1>
<?php
if(isset($_GET['nombre']) && $_GET['nombre']!="" ){
$datos=$user;
echo $datos;
echo "<br>...Se ha establecido una cookie de nombre <b>";
echo $_GET['nombre'];
echo "</b> que será válida durante 2 min";
}
else echo "No defino";
?>
</body>
</html>