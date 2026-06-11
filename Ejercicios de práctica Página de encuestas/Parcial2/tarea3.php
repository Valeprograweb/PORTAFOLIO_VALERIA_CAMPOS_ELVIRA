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
     if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["numero"])) {
        $numero = $_POST["numero"];

        if ($numero >= 1 && $numero <= 20) {
            echo "<h3 style='text-align:center;'>Tabla del $numero</h3>";
            echo "<table>";
            echo "<tr><th>Multiplicación</th><th>Resultado</th></tr>";
            for ($i = 1; $i <= 10; $i++) {
                echo "<tr><td>$numero x $i</td><td>" . ($numero * $i) . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='error'>Número inválido.</p>";
        }
    }
    echo '<a href="tarea3.html"><button>Regresar</button></a>';
    ?>
</body>
</html>



    

