<html>
    <meta charset="UTF-8">
<head>
    <title>Ejemplo de operaciones</title>
</head>
<body>
    <h1>Ejemplo de operadores en PHP</h1>
    <?php
    $a = 8;
    $b = 3;

    echo "Suma: " . ($a + $b) . "<br>";
    echo "Resta: " . ($a - $b) . "<br>";
    echo "Multiplicación: " . ($a * $b) . "<br>";
    echo "División: " . ($a / $b) . "<br>";
    $a++;
    echo "Incremento de a: " . $a . "<br>";
    $b--;
    echo "Decremento de b: " . $b . "<br>";
    $a = 8;
    $b = 3;
    $c = 3;

    echo "a y b es igual: " , $a == $b, "<br>";
    echo "a y b es diferente: " , $a != $b, "<br>";
    echo "a es menor que b: " , $a < $b, "<br>";
    echo "a es mayor que b: " , $a > $b, "<br>";
    echo "a es mayor - igual que c: ", $a >= $c, "<br>";
    echo "a es menor igual que c: " , $a <= $c, "<br>";
    $a = 8;
    $b = 3;
    $c = 3;

    echo "operador and: " , ($a == $b) && ($c > $b), "<br>";
    echo "operador or: " ,($a == $b) || ($b == $c), "<br>";
    echo "operador negación: " , !($b <= $c) , "<br>";
    ?>
</body>
</html>
