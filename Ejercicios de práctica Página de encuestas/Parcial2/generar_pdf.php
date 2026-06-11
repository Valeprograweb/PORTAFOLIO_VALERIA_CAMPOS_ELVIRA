<?php

ob_start(); // Inicia el buffer de salida
require('fpdf183/fpdf.php');
include('conn2.php');

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo 1 - izquierda (COMENTADO PARA EVITAR ERROR)
        $this->Image('logo1.jpg',10,8,30);
        // Logo 2 - derecha (COMENTADO PARA EVITAR ERROR)  
        $this->Image('logo2.jpg',170,8,30);
        $this->SetY(40); // Posición después de los logos
    }

    // Cargar los datos
    function LoadData($file)
    {
        $lines = file($file);
        $data = array();
        foreach($lines as $line)
            $data[] = explode(';',trim($line));
        return $data;
    }

    // Tabla simple
    function BasicTable($header, $data)
    {
        // Cabecera
        foreach($header as $col)
            $this->Cell(60,7,$col,1,0,'C');
        $this->Ln();

        // Datos
        while($row = $data->fetch_assoc()) {
            $this->Cell(60,6,$row["materia"],1);
            $this->Cell(60,6,$row["tipo"],1);
            $this->Cell(60,6,$row["semestre_destino"],1);
            $this->Ln();
        }
    }

    // Tabla coloreada
    function FancyTable($header, $data)
    {
        // Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(41,128,185); // azul
        $this->SetTextColor(255);
        $this->SetDrawColor(32,74,135);
        $this->SetLineWidth(.3);
        $this->SetFont('','B');
        // Cabecera
        $w = array(60, 60, 60);
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        $this->Ln();
        // Restauración de colores y fuentes
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Datos
        $fill = false;
        while($row = $data->fetch_assoc()) {
            $this->Cell($w[0],7,$row["materia"],'LR',0,'L',$fill);
            $this->Cell($w[1],7,$row["tipo"],'LR',0,'C',$fill);
            $this->Cell($w[2],7,$row["semestre_destino"],'LR',0,'C',$fill);
            $this->Ln();
            $fill = !$fill;
        }
        $this->Cell(array_sum($w),0,'','T');
    }
}

// Crear conexión
$matricula = $_GET['matricula'];
$sql_alumno = "SELECT * FROM alumnos WHERE matricula = '$matricula'";
$alumno = $conn->query($sql_alumno)->fetch_assoc();

$sql_materias = "SELECT materia, tipo, semestre_destino FROM seleccion WHERE matricula = '$matricula'";
$result = $conn->query($sql_materias);

// Generar PDF
if ($result->num_rows > 0){
    $pdf = new PDF();
    $header = array('MATERIA', 'TIPO', 'SEMESTRE DESTINO');
    $pdf->SetFont('Arial','',12);
    $pdf->AddPage();

    // Datos del alumno
    $pdf->Cell(0,10,'Matricula: '.$alumno['matricula'],0,1);
    $pdf->Cell(0,10,'Nombre: '.$alumno['nombre'],0,1);
    $pdf->Cell(0,10,'Promedio: '.$alumno['promedio'].'   Condicionado: '.$alumno['condicionado'],0,1);
    $pdf->Ln(5);

    // Tabla de materias
    $pdf->FancyTable($header,$result);

    $pdf->Output();
}
ob_end_flush(); // Limpia el buffer y envía el PDF correctamente

?>

