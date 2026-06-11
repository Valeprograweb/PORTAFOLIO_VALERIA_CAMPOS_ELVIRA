<?php
session_start();

$colorFondo = $_COOKIE['colorFondo'] ?? "#ffffff";
$colorTexto = $_COOKIE['colorTexto'] ?? "#000000";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            background-color: black;
            font-family: Arial, sans-serif;
            color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h2 {
            text-align: center;
            color:  #27EBF5;
        }

        form {
            background-color: #2E27F5;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.2);
            width: 300px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #27EBF5;
        }

        input[type="text"],
        input[type="password"],
        input[type="submit"],
        input[type="hidden"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="text"],
        input[type="password"],
        select {
            background-color: #2c2c2c;
            color: #ffffff;
        }

        input[type="text"]:focus,
        input[type="password"]:focus,
        select:focus {
            outline: none;
            border: 2px solid  #27EBF5;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color:  #27EBF5;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #7EF2EC;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            color:  #27EBF5;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        img {
            display: block;
            margin: 10px auto;
            border: 2px solid  #27EBF5;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div>
        <h2>Login</h2>
        <form action="validar.php" method="POST">
            <input type="hidden" name="accion" value="login">

            <label>Usuario:</label>
            <input type="text" name="user" required>

            <label>Contraseña:</label>
            <input type="password" name="pass" required>

            <label>Captcha:</label>
            <img src="validar.php?generate=1" alt="CAPTCHA">
            <input type="text" name="captcha_usuario" required>

            <label>Color de fondo:</label>
            <select name="colorFondo">
                <option value="#ffffff">Blanco</option>
                <option value="#e6f7ff">Azul claro</option>
                <option value="#fce4ec">Rosa pastel</option>
                <option value="#e8f5e9">Verde claro</option>
                <option value="#f3e5f5">Morado suave</option>
            </select>

            <label>Color del texto de la tabla:</label>
            <select name="colorTexto">
                <option value="#000000">Negro</option>
                <option value="#1a237e">Azul oscuro</option>
                <option value="#b71c1c">Rojo</option>
                <option value="#1b5e20">Verde</option>
                <option value="#4a148c">Morado</option>
            </select>

            <button type="submit">Iniciar sesión</button>
        </form>
        <a href="registro.php">Registrarte aquí</a>
    </div>
</body>
</html>

