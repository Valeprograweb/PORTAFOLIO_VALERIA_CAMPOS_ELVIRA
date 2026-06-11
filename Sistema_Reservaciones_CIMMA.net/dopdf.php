<?php
// ==========================================
// 1. CONFIGURACIÓN Y SEGURIDAD
// ==========================================
ob_start();
session_start();

// Verificar si es admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: admin.php");
    exit;
}

require('fpdf/fpdf.php'); 
include('conn.php');

// Habilitar reporte de errores de MySQL
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($servername, $username, $password, $database);
    // Usamos latin1 en la conexión para compatibilidad con FPDF
    $conn->set_charset("latin1"); 
} catch (mysqli_sql_exception $e) {
    die("Error de conexión: " . $e->getMessage());
}

// ==========================================
// 2. OBTENCIÓN DE DATOS
// ==========================================

$stats = [
    'Mac' => 0,
    'Foto' => 0,
    'Radio' => 0,
    'Pantalla Verde' => 0
];

$sql = "SELECT lugar, COUNT(*) as total FROM reservas GROUP BY lugar";
$result = $conn->query($sql);

$max_valor = 0;

while ($row = $result->fetch_assoc()) {
    $lugar_bd = $row['lugar'];
    
    foreach ($stats as $key => $val) {
        // Conexión en latin1 -> comparación directa
        if (stripos($lugar_bd, $key) !== false) {
            $stats[$key] += $row['total'];
        }
    }
}

$max_valor = max($stats);
if ($max_valor == 0) $max_valor = 1;

// ==========================================
// 3. GENERACIÓN DEL PDF
// ==========================================

class PDF extends FPDF {
    function Header() {
        // $this->Image('img/logo.png',10,6,30);
        $this->SetFont('Arial','B',15);
        $this->Cell(80);
        
        // CORRECCIÓN: Usamos mb_convert_encoding en lugar de utf8_decode
        $titulo = mb_convert_encoding('Reporte de Uso de Recursos', 'ISO-8859-1', 'UTF-8');
        $this->Cell(30,10,$titulo,0,0,'C');
        $this->Ln(20);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        // CORRECCIÓN:
        $txt_pag = mb_convert_encoding('Página ', 'ISO-8859-1', 'UTF-8');
        $this->Cell(0,10,$txt_pag.$this->PageNo().'/{nb}',0,0,'C');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

// Título
$pdf->SetFont('Arial','B',14);
// CORRECCIÓN:
$titulo_seccion = mb_convert_encoding('Estadísticas de Reservas', 'ISO-8859-1', 'UTF-8');
$pdf->Cell(0, 10, $titulo_seccion, 0, 1);
$pdf->Ln(5);

// Texto descriptivo
$pdf->SetFont('Arial','',12);
// CORRECCIÓN:
$descripcion = "A continuación se muestra la frecuencia de uso de los recursos del laboratorio (Mac, Foto, Radio, Pantalla Verde) basado en los registros del ultimo mes";
$descripcion_limpia = mb_convert_encoding($descripcion, 'ISO-8859-1', 'UTF-8');

$pdf->MultiCell(0, 5, $descripcion_limpia);
$pdf->Ln(15);

// ==========================================
// 4. GRÁFICA DE BARRAS
// ==========================================

$ancho_max_barra = 120;
$alto_barra = 10;
$espacio = 5;
$x_inicio = 40;

$pdf->SetFont('Arial','B',11);

foreach ($stats as $recurso => $cantidad) {
    // Aquí NO convertimos porque la base de datos ya está en latin1
    $pdf->Cell($x_inicio, $alto_barra, $recurso, 0, 0, 'R');
    
    $ancho_barra = ($cantidad / $max_valor) * $ancho_max_barra;
    
    switch ($recurso) {
        case 'Mac': $pdf->SetFillColor(54, 162, 235); break;
        case 'Foto': $pdf->SetFillColor(255, 99, 132); break;
        case 'Radio': $pdf->SetFillColor(255, 206, 86); break;
        case 'Pantalla Verde': $pdf->SetFillColor(75, 192, 192); break;
        default: $pdf->SetFillColor(100, 100, 100);
    }
    
    if($ancho_barra == 0) $ancho_barra = 0.5; 

    $pdf->Cell($ancho_barra, $alto_barra, '', 0, 0, 'L', true);
    
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(15, $alto_barra, "  " . $cantidad, 0, 1, 'L');
    
    $pdf->Ln($espacio);
}

$pdf->Output();
ob_end_flush();
?>