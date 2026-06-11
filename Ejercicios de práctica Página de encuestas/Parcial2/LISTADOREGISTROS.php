<?php
    include 'conn.php';
    require('fpdf183/fpdf.php');

    class PDF extends FPDF
    {
    // Cargar los datos
    function LoadData($file)
    {
    	// Leer las líneas del fichero
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
    		$this->Cell(47,7,$col,1);
    	$this->Ln();
    	// Datos
		while($row = $data->fetch_assoc()) {
			$this->Cell(47,6,$row["id"],1);
			$this->Cell(47,6,$row["nombre"],1);
			$this->Cell(47,6,$row["total"],1);
			$this->Cell(47,6,$row["interp"],1);
			$this->Ln();
        }
    	/*foreach($data as $row)
    	{
    		foreach($row as $col)
    			$this->Cell(40,6,$col,1);
	    	$this->Ln();
    	}*/
    }

    // Una tabla más completa
    function ImprovedTable($header, $data)
    {
    	// Anchuras de las columnas
    	$w = array(40, 35, 45, 40);
    	// Cabeceras
    	for($i=0;$i<count($header);$i++)
	    	$this->Cell($w[$i],7,$header[$i],1,0,'C');
    	$this->Ln();
    	// Datos
    	foreach($data as $row)
    	{
    		$this->Cell($w[0],6,$row[0],'LR');
	    	$this->Cell($w[1],6,$row[1],'LR');
		    $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
    		$this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
	    	$this->Ln();
    	}
    	// Línea de cierre
    	$this->Cell(array_sum($w),0,'','T');
    }

    // Tabla coloreada
    function FancyTable($header, $data)
    {
    	// Colores, ancho de línea y fuente en negrita
	    $this->SetFillColor(255,0,0);
    	$this->SetTextColor(255);
	    $this->SetDrawColor(128,0,0);
    	$this->SetLineWidth(.3);
	    $this->SetFont('','B');
    	// Cabecera
    	$w = array(40, 35, 45, 40);
    	for($i=0;$i<count($header);$i++)
    		$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
	    $this->Ln();
    	// Restauración de colores y fuentes
	    $this->SetFillColor(224,235,255);
    	$this->SetTextColor(0);
	    $this->SetFont('');
    	// Datos
	    $fill = false;
    	foreach($data as $row)
	    {
		    $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
    		$this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
	    	$this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
		    $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
    		$this->Ln();
	    	$fill = !$fill;
    	}
    	// Línea de cierre
    	$this->Cell(array_sum($w),0,'','T');
    }
    }

    //CREAR CONEXIÓN
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
	$sql = "SELECT id, nombre, total, interp FROM resultados";
	$result = $conn->query($sql);
    //GENERAR PDF
	if ($result->num_rows > 0){
		$pdf = new PDF();
		// Títulos de las columnas
		$header = array('ID', 'NOMBRE', 'TOTAL', 'INTERPRETACION');
		// Carga de datos
		//$data = $pdf->LoadData('paises.txt');
		$pdf->SetFont('Arial','',10);
		$pdf->AddPage();
		$pdf->BasicTable($header,$result);
		/*$pdf->AddPage();
		$pdf->ImprovedTable($header,$data);
		$pdf->AddPage();
		$pdf->FancyTable($header,$data);*/
		$pdf->Output();
	}
    
?>
