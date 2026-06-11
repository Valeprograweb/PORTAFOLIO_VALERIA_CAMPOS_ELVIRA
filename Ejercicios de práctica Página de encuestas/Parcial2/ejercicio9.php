<html>
    <meta charset="UTF-8">
<head>
    <title>Condicion IF</title>
</head>
<body>
    <h1>Condicional IF</h1>
<?php
        $a = 8;
        $b = 3;
        echo "Valor de a: ",$a," y el valor de b:",$b,"<br>";
        if ($a<$b)
        {
        echo "a es menor que b ", "<br>";
        }
        else
        {
        echo " a no es menor que b ","<br>";
        }

        $dia=date("d");
        if ($dia<=10)
        {
        echo "sitio activo", "<br>";
        }
        else
        {
        echo "sitio fuera de servicio";
        }

        $mes=date("m"); //mes
        echo "<br>", " El mes ", $mes, "<br>";

        $anio=date("y"); //año
        echo " El año ", $anio, "<br>";
?>
</body>
</html>