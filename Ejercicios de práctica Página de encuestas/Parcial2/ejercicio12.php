<html>
<head>
    <title>Bucle While</title>
</head>
<body>
    <h1>Bucle While</h1>
    <?php
        if ( isset( $_POST['number'] )) { //verifica que no está vacía la variable
            $number = $_POST['number'];//llama a la variable
            $counter = 1;

            while ($counter <= $number) {
                echo " $counter.- Los bucles son faciles!<br>\n";//imprime en forma de bucle
                $counter++;
            }
        echo "Se acabo.\n";
        }
        echo "<a href='practica12.html'>Regresar</a>";
    ?>
</p>
</body>
</html>