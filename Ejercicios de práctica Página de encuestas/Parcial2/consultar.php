<?php
include 'conn2.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultar Materias</title>
    <style>
      
        .btn-regresar {
            display: inline-block;
            padding: 12px 24px;
            background-color: #F5C227;
            color: black;
            text-decoration: none;
            border-radius: 6px;
            font-family: 'Arial', sans-serif;
            font-size: 14px;
            font-weight: 500;
            border: 2px solid black;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            margin: 10px;
        }

        .btn-regresar:hover {
            background-color: #F5AD27;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .btn-regresar:active {
            transform: translateY(0);
            box-shadow: none;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f3f3f3;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 60%;
            margin: 50px auto;
            background: white;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: black;
        }
        form {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="text"], input[type="submit"] {
            padding: 8px;
            margin: 5px;
            border-radius: 5px;
            border: 1px solid black;
        }
        input[type="submit"] {
            background-color: #F5BB27;
            color: white;
            cursor: pointer;
            border: black;
        }
        input[type="submit"]:hover {
            background-color: #F5A327;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 2px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #F5C227;
            color: black;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Consultar Materias Registradas</h2>

    <form method="post" action="">
        <input type="text" name="matricula" placeholder="Matrícula" required>
        <input type="submit" name="consultar" value="Consultar">
    </form>

<?php
if (isset($_POST['consultar'])) {
    $matricula = trim($_POST['matricula']);

    // Verificar si existe el alumno
    $sql = "SELECT * FROM seleccion WHERE matricula = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matricula);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        echo "<h3>Materias registradas para la matrícula: $matricula</h3>";

        // Consulta de materias
        $sqlMaterias = "SELECT materia, tipo, semestre_destino FROM seleccion WHERE matricula = ?";
        $stmt2 = $conn->prepare($sqlMaterias);
        $stmt2->bind_param("s", $matricula);
        $stmt2->execute();
        $materias = $stmt2->get_result();

        if ($materias->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Materia</th><th>Tipo</th><th>Semestre Destino</th></tr>";
            while ($row = $materias->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row['materia']."</td>";
                echo "<td>".$row['tipo']."</td>";
                echo "<td>".$row['semestre_destino']."</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No hay materias registradas para esta matrícula.</p>";
        }
    } else {
        echo "<p style='color:red;'>No se encontró ningún registro con esa matrícula.</p>";
    }
     
             
echo "<a href='exam.html' class='btn-regresar'>Regresar</a>";

    $conn->close();
}
?>
</div>

</body>
</html>

