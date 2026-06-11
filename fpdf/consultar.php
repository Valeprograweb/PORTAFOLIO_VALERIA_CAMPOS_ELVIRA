<?php
// Iniciar buffer de salida para evitar errores de "Some data has already been output"
ob_start();

// Configuración de errores: ocultar deprecated y warnings
error_reporting(E_ALL & ~E_DEPRECATED & ~E_WARNING & ~E_NOTICE);

require('fpdf.php');

// Conexión a la base de datos
$servername = "fdb1031.runhosting.com";
$username = "4687073_basededatos";
$password = "tuzymR+8AN}DQ/o";
$database = "4687073_basededatos";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Captura de datos del formulario
$matricula = $_POST['matricula'] ?? '';
if(empty($matricula)){
    die("No se proporcionó matrícula.");
}

// Consulta SQL
$sql = "SELECT nombre, matricula, semestre, mat1, mat2, mat3, mat4, mat5, mat6, mat7, mat8 
        FROM primaveraiti WHERE matricula = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $matricula);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombre = $row['nombre'];
    $semestre = $row['semestre'];
    
    // Guardamos las materias en un arreglo
    $materias = [];
    for ($i = 1; $i <= 8; $i++) {
        if (!empty($row["mat$i"])) {
            $materias[] = [
                'codigo' => "MAT$i",
                'nombre' => $row["mat$i"]
            ];
        }
    }
} else {
    die("No se encontró la matrícula ingresada.");
}

// Clase PDF
class PDF extends FPDF {
    function Header() {
        $this->Image('logo.png',10,8,33);
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Reporte de Materias Inscritas', 0, 1, 'C');
        $this->Ln(10);
        $this->Image('logo-ITI.jpg',165,8,33);
    }

    function DatosAlumno($nombre, $matricula, $semestre) {
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 8, "Nombre: $nombre", 0, 1);
        $this->Cell(0, 8, "Matrícula: $matricula", 0, 1);
        $this->Cell(0, 8, "Semestre: $semestre", 0, 1);
        $this->Ln(5);
    }

    function TablaMaterias($materias) {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(40, 10, 'Materia', 1, 0, 'C');
        $this->Cell(150, 10, 'Nombre de la Materia', 1, 1, 'C');

        $this->SetFont('Arial', '', 12);
        $i = 1;
        foreach ($materias as $mat) {
            $this->Cell(40, 8, $i, 1, 0, 'C');
            $this->Cell(150, 8, $mat['nombre'], 1);
            $this->Ln();
            $i++;
        }
    }
}

// Crear PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->DatosAlumno($nombre, $matricula, $semestre);
$pdf->TablaMaterias($materias);

// Limpiar cualquier salida accidental y enviar PDF
ob_end_clean();
$pdf->Output('I', "Reporte_$matricula.pdf"); // 'I' abre en navegador, se puede cambiar a 'D' para descargar

$conn->close();
?>
