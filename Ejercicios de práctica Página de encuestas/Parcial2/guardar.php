<?php
include('conn2.php');

$matricula = $_POST['matricula'];
$nombre = $_POST['nombre'];
$promedio = $_POST['promedio'];
$condicionado = $_POST['condicionado'];

$conn->query("INSERT INTO alumnos (matricula, nombre, promedio, condicionado)
VALUES ('$matricula','$nombre','$promedio','$condicionado')");

for ($i = 1; $i <= 6; $i++) {
    $materia = $_POST["materia_regular_$i"];
    if (!empty($materia)) {
        $conn->query("INSERT INTO seleccion (matricula, materia, tipo, semestre_destino)
                          VALUES ('$matricula','$materia','Regular','Primavera 2026')");
    }
}

if ($promedio >= 8 && $condicionado == 'No') {
    for ($i = 1; $i <= 2; $i++) {
        $extra = $_POST["materia_extra_$i"];
        if (!empty($extra)) {
            $conn->query("INSERT INTO seleccion (matricula, materia, tipo, semestre_destino)
                              VALUES ('$matricula','$extra','Adicional','Primavera 2026')");
        }
    }
} else {
    echo "<script>alert('No cumple los requisitos para materias adicionales.Se Eliminarrán las materias adicionales');</script>";
}

echo "<script>window.location.href='generar_pdf.php?matricula=$matricula';</script>";
exit;

?>
