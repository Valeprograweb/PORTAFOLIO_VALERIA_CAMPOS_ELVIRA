<?php
session_start();
unset($_SESSION['contador']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reinicio</title>
</head>
<body>
    <h1>Reiniciando Contador...</h1>
    <p>El contador ha sido reiniciado.</p>
    <br>
    <a href="ejercicio6.php">Volver al contador de sesiones</a>
</body>
</html>
