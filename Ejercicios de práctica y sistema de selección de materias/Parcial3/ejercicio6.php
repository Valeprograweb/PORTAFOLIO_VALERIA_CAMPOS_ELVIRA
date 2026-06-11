<?php
session_start();

if (!isset($_SESSION['contador'])) {
    $_SESSION['contador'] = 1;
} else {
    $_SESSION['contador']++;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>HOME</title>
</head>
<body>
    <h1>Contador con Sesiones</h1>
    <p>Visitas: <?php echo $_SESSION['contador']; ?></p>
    <br>
    <a href="ejercicio6a.php">Reiniciar contador</a>
</body>
</html>

