<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ayuda - Cimma</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/logo.png" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Uncial+Antiqua&display=swap" rel="stylesheet">
    <style>
        /* Mismos estilos que tu login para mantener consistencia */
        body {
            background-image: url("img/fondoinicio.png");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: Arial, Helvetica, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px; /* Un poco más ancho para texto */
        }
        h1 {
            text-align: center;
            color: #333;
            font-family: 'Uncial Antiqua', system-ui;
            margin-bottom: 20px;
        }
        h3 {
            color: rgb(74, 113, 167);
            font-family: 'Montserrat', sans-serif;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            margin-top: 20px;
        }
        p, li {
            color: #555;
            line-height: 1.6;
            font-family: 'Roboto Slab', serif;
        }
        .boton-volver {
            display: block;
            margin: 30px auto 0;
            padding: 10px 20px;
            background: rgb(74, 113, 167);
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
            width: 120px;
            font-family: Arial, sans-serif;
        }
        .boton-volver:hover {
            background: rgb(62, 72, 143);
        }
        .contacto {
            background-color: #f9f9f9;
            padding: 10px;
            border-left: 4px solid rgb(74, 113, 167);
            margin-top: 15px;
        }
    </style>
</head>
<body> 
    <div class="container">
        <h1>Centro de Ayuda</h1>
        
        <h3>¿No puedes iniciar sesión?</h3>
        <p>Verifica que estés ingresando tu <strong>Matrícula</strong> correctamente sin espacios ni guiones.</p>
        
        <h3>Olvidé mi contraseña</h3>
        <p>Si has olvidado tu contraseña, por favor contacta al administrador del sistema para solicitar un restablecimiento.</p>
        
        <h3>Contacto de Soporte</h3>
        <div class="contacto">
            <p><strong>Correo:</strong> soporte@cimma.com</p>
            <p><strong>Teléfono:</strong> (555) 123-4567</p>
            <p><strong>Horario:</strong> Lunes a Viernes 9:00 - 18:00</p>
        </div>

        <a href="login.html" class="boton-volver">Volver</a>
    </div>            
</body>
</html>