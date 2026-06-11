<?php
session_start();
include("conn.php");

// Crear conexión segura a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (!isset($_SESSION['user'])) {
    echo "<script>alert('Debes iniciar sesión');window.location='login2.php';</script>";
    exit;
}

$colorFondo = $_COOKIE['colorFondo'] ?? "#ffffff";
$colorTexto = $_COOKIE['colorTexto'] ?? "#000000";

// Obtener datos de tabla olimpiadas2024
$sql = "SELECT * FROM olimpiadas2024";
$result = mysqli_query($conexion, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>

<body style="background-color: <?= $colorFondo ?>;">

<h2>Bienvenido <?= $_SESSION['nom'] ?></h2>

<table border="1" style="color: <?= $colorTexto ?>;">
    <tr>
        <th>Rango</th>
        <th>Pais</th>
        <th>Code</th>
        <th>Oro</th>
        <th>Plata</th>
        <th>Bronce</th>
        <th>Total</th>
        <th>Continente</th>
    </tr>

    <?php while ($fila = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= $fila['Rango'] ?></td>
        <td><?= $fila['Pais'] ?></td>
        <td><?= $fila['Code'] ?></td>
        <td><?= $fila['Oro'] ?></td>
        <td><?= $fila['Plata'] ?></td>
        <td><?= $fila['Bronce'] ?></td>
        <td><?= $fila['Total'] ?></td>
        <td><?= $fila['Continente'] ?></td>
    </tr>
    <?php } ?>
</table>

<br>
<a href="logout.php">Cerrar sesión</a>

</body>
</html>
