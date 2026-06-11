<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú Principal</title>
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = $_POST["usuario"];
        $password = $_POST["password"];

        if ($usuario === "admin" && $password === "admin123") {
            echo "<h2>Bienvenido, $usuario</h2>";
            echo "<ul>
                    <li><a href=http://186831cno2.atwebpages.com/Parcial2/practica12.html>Ejercicio 12</a></li>
                    <li><a href=http://186831cno2.atwebpages.com/Parcial2/ejercicio13.php>Ejercicio 13</a></li>
                    <li><a href=http://186831cno2.atwebpages.com/Parcial2/practica14.html>Ejercicio 14</a></li>
                    <li><a href=http://186831cno2.atwebpages.com/Parcial2/practica15.html>Ejercicio 15</a></li>
                    <li><a href=http://186831cno2.atwebpages.com/Parcial2/tarea3.html>Tarea 3</a></li>
                  </ul>";
        } else {
            echo "<p class='error'>Acceso denegado. Usuario o contraseña incorrectos.</p>";
        }
    } else {
        echo "<p class='error'>Acceso no autorizado.</p>";
    }
    echo '<a href="tarea4.html"><button>Regresar</button></a>';
    ?>
</body>
</html>


