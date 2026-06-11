<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login2.php");
    exit;
}

include("conn.php");

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <style>
        body {
            background-color: <?php echo $_COOKIE["colorFondo"] ?? "#ffffff"; ?>;
            color: <?php echo $_COOKIE["colorTexto"] ?? "#000000"; ?>;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        table {
            width: 95%;
            margin: auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #555;
            padding: 9px;
        }
        th {
            background-color: #ddd;
        }
    </style>

</head>
<body>

<h2>Bienvenido, <?php echo $_SESSION['usuario']; ?></h2>
<h3>Dashboard – Tabla de Medallas de las Olimpiadas 2024</h3>

<table>
    <tr>
        <th>Id</th>
        <th>Rango</th>
        <th>País</th>
        <th>Code</th>
        <th>Oro</th>
        <th>Plata</th>
        <th>Bronce</th>
        <th>Total</th>
        <th>Continente</th>
    </tr>

    <?php
    $sql = "SELECT * FROM olimpiadas2024";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>". $row["Id"] ."</td>";
                echo "<td>". $row["Rango"] ."</td>";
                echo "<td>". $row["Pais"] ."</td>";
                echo "<td>". $row["Code"] ."</td>";
                echo "<td>". $row["Oro"] ."</td>";
                echo "<td>". $row["Plata"] ."</td>";
                echo "<td>". $row["Bronce"] ."</td>";
                echo "<td>". $row["Total"] ."</td>";
                echo "<td>". $row["Continente"] ."</td>";
                echo "</tr>";
            }

        } else {
            echo "<tr><td colspan='7'>No hay registros</td></tr>";
        }
    ?>
</table>

<div class="logout">
    <a href="salir.php">Cerrar sesión</a>
</div>

</body>
</html>

