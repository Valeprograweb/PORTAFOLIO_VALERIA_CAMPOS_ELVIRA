<?php 
session_start(); 
?> 
<html> 
<meta charset="UTF-8">
<head> 
	<title>Problema</title> 
</head> 
	<body> 
        <?php 
            echo "Nombre de usuario recuperado de la variable de sesión:".$_SESSION['usuario']; 
            echo "<br><br>"; 
            echo "La clave recuperada de la variable de sesión:".$_SESSION['clave'];
            //remover toda la sesión
            session_unset();
            //destruir la sesión
            session_destroy();  
        ?> 
   	<br><br><a href="ejercicio2.php">Cerrar sesión</a>
	</body> 
</html> 
