<?php
include 'conn.php';

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_errno) {
    die("No se pudo conectar con la base de datos. Inténtalo más tarde.");
}

// Preguntas
$preguntas = [
    "Me siento ansioso si no tengo mi teléfono cerca.",
    "Reviso constantemente si tengo mensajes o notificaciones.",
    "Uso el teléfono mientras como o estudio.",
    "Me cuesta concentrarme sin revisar el celular.",
    "Siento miedo de perder mi celular.",
    "Reviso el celular inmediatamente al despertar.",
    "Me distraigo fácilmente con el teléfono.",
    "Uso el teléfono aun cuando estoy con otras personas.",
    "Siento estrés si no tengo señal o batería.",
    "Prefiero hablar por mensajes que cara a cara.",
    "Llevo el celular a todos lados, incluso al baño.",
    "Me cuesta dormir por usar el teléfono antes de acostarme."
];

// Recuperar nombre y respuestas
$nombre = $_POST['nombre'] ?? '';
$q = [];
for ($i = 0; $i < 12; $i++) {
    $q[$i] = (int)($_POST['q' . ($i + 1)] ?? 0);
}

// Calcular total
$total = array_sum($q);

// Interpretación del resultado
if ($total > 31) {
    $interp = "Eres altamente nomofóbico";
} else {
    $interp = "No eres nomofóbico";
}

// Fecha y hora actual (zona horaria México)
date_default_timezone_set('America/Mexico_City');
$fechaHora = date('Y-m-d H:i:s');

// Guardar en base de datos
$sql = "INSERT INTO resultados 
(nombre, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, total, interp, fecha_hora)
VALUES 
('$nombre', '$q[0]', '$q[1]', '$q[2]', '$q[3]', '$q[4]', '$q[5]', '$q[6]', '$q[7]', '$q[8]', '$q[9]', '$q[10]', '$q[11]', '$total', '$interp', '$fechaHora')";

$conn->query($sql);
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados del Test de Nomofobia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8fafc;
            color: #333;
            margin: 30px;
        }
        table {
            width: 90%;
            border-collapse: collapse;
            margin: 20px 0;
            background: #fff;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background: #0066cc;
            color: white;
        }
        h1 {
            color: #0066cc;
        }
        .resumen {
            background: #eaf3ff;
            border: 1px solid #bcd;
            padding: 15px;
            width: fit-content;
            border-radius: 8px;
        }
        .boton-regresar {
            display: inline-block;
            margin-top: 25px;
            padding: 10px 20px;
            background-color: #0066cc;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background 0.3s;
        }
        .boton-regresar:hover {
            background-color: #004c99;
        }
    </style>
</head>
<body>

<h1>Resultados del Test de Nomofobia</h1>
<p><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre); ?></p>
<p><strong>Fecha y hora de respuesta:</strong> <?php echo $fechaHora; ?></p>

<table>
    <tr>
        <th>#</th>
        <th>Pregunta</th>
        <th>Respuesta Seleccionada</th>
        <th>Puntaje</th>
    </tr>
    <?php
    for ($i = 0; $i < 12; $i++) {
        echo "<tr>";
        echo "<td>" . ($i + 1) . "</td>";
        echo "<td>" . htmlspecialchars($preguntas[$i]) . "</td>";
        echo "<td>Opción " . htmlspecialchars($q[$i]) . "</td>";
        echo "<td>" . htmlspecialchars($q[$i]) . "</td>";
        echo "</tr>";
    }
    ?>
</table>

<div class="resumen">
    <p><strong>Puntaje total:</strong> <?php echo $total; ?> puntos</p>
    <p><strong>Interpretación:</strong> <?php echo $interp; ?></p>
</div>

<a href="test.php" class="boton-regresar">Regresar al Test</a>
<a href="LISTADOREGISTROS.php" class="boton-regresar">Imprimir resultados</a>

</body>
</html>

