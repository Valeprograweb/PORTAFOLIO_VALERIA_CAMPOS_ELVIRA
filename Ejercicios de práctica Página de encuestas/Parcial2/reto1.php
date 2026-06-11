<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado de la Tabla</title>
</head>
<style>
        table {
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
        }
    </style>
<body>
    <?php
        $filas = isset($_POST['filas']) ? intval($_POST['filas']) : 0;
        $columnas = isset($_POST['columnas']) ? intval($_POST['columnas']) : 0;

        if ($filas < 1 || $filas > 10 || $columnas < 1 || $columnas > 10) {
            echo "<h3>No se puede realizar la matriz. El número de filas y columnas debe estar entre 1 y 10.</h3>";
            exit;
        }

        for ($i = 0; $i < $filas; $i++) {
            for ($j = 0; $j < $columnas; $j++) {
                $matriz[$i][$j] = rand(1, 100);
            }
        }

        echo "<h2>Matriz generada:</h2>";
        echo "<table border='1' cellpadding='10'>";
        foreach ($matriz as $fila) {
            echo "<tr>";
            foreach ($fila as $valor) {
                echo "<td>$valor</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
?>
</body>
</html>

