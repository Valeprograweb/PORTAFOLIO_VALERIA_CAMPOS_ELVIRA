<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="utf-8">
    <title>Registro de Usuario - Cimma</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png" />
    <style>
        /* Estilos globales iguales a tu sistema */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url("img/fondoinicio.png");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Ocupa toda la altura de la pantalla */
            margin: 0;
        }

        /* Caja contenedora del formulario (tipo tarjeta) */
        .register-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-top: 0;
            margin-bottom: 25px;
            font-size: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
            font-size: 0.95rem;
        }

        input[type="text"], 
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box; /* Para que el padding no rompa el ancho */
            transition: border-color 0.3s;
        }

        input[type="text"]:focus, 
        input[type="password"]:focus {
            border-color: #007bff;
            outline: none;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #5F0F40;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #03045E;
        }

        /* Enlace opcional para volver al login */
        .login-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            font-size: 0.9rem;
            color: #007bff;
            text-decoration: none;
        }
        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head> 
<body>

    <div class="register-container">
        <h2>Registro de Nuevo Usuario</h2>
        
        <form action="guardar.php" method="post">
            <label for="matt">Matrícula:</label>
            <input type="text" id="matt" name="matt" required placeholder="Ej: 123456">

            <label for="pass">Clave:</label>
            <input type="password" id="pass" name="pass" required placeholder="********">

            <label for="nom">Nombre(s):</label>
            <input type="text" id="nom" name="nom" required placeholder="Tu nombre">
                
            <label for="app">Apellidos:</label>
            <input type="text" id="app" name="app" required placeholder="Tus apellidos">    
    
            <input type="submit" name="accion" value="Registrar Usuario">      
            
            <a href="login.html" class="login-link">¿Ya tienes cuenta? Inicia Sesión</a>
        </form>
    </div>

</body>
</html>