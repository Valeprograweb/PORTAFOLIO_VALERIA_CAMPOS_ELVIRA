<html>
<head>
    <title>Tabla condicional</title>
</head>
<body>
    <h1>Tabla condicional 1</h1>
<?php
    function muestra($valor) {
        if ($valor < 0.5)
            $color = "red";
        else
            $color = "blue";

        echo "<td><font color='$color'>$valor</font></td>\n";
    }
?>
    <table border="1">
        <tr>
            <th>X</th>
            <th>SENO</th>
            <th>COSENO</th>
</tr>
<?php
    for ($x=0; $x<=2; $x+=0.01){
        echo "<tr>";
        muestra($x);
        muestra(sin($x));
        muestra(cos($x));
        echo "</tr>";
    }
?>
</table>
</body>
</html>
