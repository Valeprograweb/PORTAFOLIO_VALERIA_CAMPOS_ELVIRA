<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <style>
        body {
            background-color: black;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        h2 {
            text-align: center;
            color: white;
        }

        form {
            background-color: #41A2F2;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            width: 320px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: white;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div>
    <h2>Registro de usuario</h2>

    <form action="validar.php" method="POST">
        <input type="hidden" name="accion" value="registrar">

        <label>Nombre completo:</label>
        <input type="text" name="nom" required>

        <label>Username:</label>
        <input type="text" name="user" required>

        <label>Contraseña:</label>
        <input type="password" name="pass" required>

        <button type="submit">Registrar</button>
    </form>

    <a href="login2.php">Volver al login</a>
</div>

</body>
</html>
