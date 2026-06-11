<html>
<head>
<title>Introduccion a los arrays, metodo largo</title>
</head>
<body>
<h1> Introduccion a los arrays, metodo largo </h1>
<p> A continuacion escribiremos los arrays de acuerdo al metodo largo </p>
<p>
<?php
$dia[0] = "domingo";
$dia[1] = "lunes";
$dia[2] = "martes";
$dia[3] = "miercoles";
$dia[4] = "jueves";
$dia[5] = "viernes";
$dia[6] = "sabado";
echo "Imprime el cuarto elemento: ". $dia[3]. "</br>";
$dia2 = array( "domingo", "lunes", "martes", "miercoles", "jueves", "viernes", "sabado");
echo "Imprime el primer elemento: ". $dia2[0]. "</br>". "</br>";
echo "ARREGLO ORIGINAL"."</br>"."</br>";
for ($i=0;$i<7;$i++)
{
    echo "Elemento ".$i." = ".$dia2[$i]."</br>";
}

echo "</br>"."ARREGLO ORDEN INVERSO"."</br>"."</br>";
for ($i=6;$i>0;$i--)
{
    echo "Elemento ".$i." = ".$dia2[$i]."</br>";
}
?>
</p>
</body>
</html>