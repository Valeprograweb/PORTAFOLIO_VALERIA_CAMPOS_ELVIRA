<?php
    session_start();
?>
<html> 
<head> 
<meta charset="utf-8">
<title>Login</title>
<link rel="icon" type="image/x-icon" href="img/logo.png" />
<style>
    /* 1. Fondo gris y centrado vertical/horizontal */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-image: url("img/fondoinicio.png");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    /* 2. La tarjeta blanca (el recuadro) */
    .card {
        background-color: #ffffff;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 400px;
        text-align: center; /* Centra el texto y el botón */
    }

    /* 3. Estilo para el botón "Regresar" */
    input[type="submit"] {
        width: 100%;
        padding: 12px;
        background-color: #00B4D8;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        margin-top: 20px;
    }

    input[type="submit"]:hover {
        background-color: #03045E;
    }
    
    /* Clase extra para mensajes de error */
    .mensaje-error {
        color: #dc3545; /* Rojo */
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 10px;
        font-weight: 500;
    }
</style>
  
</head> 
<body>

<div class="card">
    
    <h2 style="color:#333; margin-top:0;">Estado del Registro</h2>

<?php

    $nuevoMatt = $_POST['matt'] ?? '';
    $nuevoPass = $_POST['pass'] ?? '';
    $nuevoNom  = $_POST['nom'] ?? '';
    $nuevoApp  = $_POST['app'] ?? '';
    
    include('conn.php');

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar conexión
    if ($conn->connect_error) {
        die("<div style='color:red;'>Conexión fallida: " . $conn->connect_error . "</div>");
    }
    
    // --- PASO 1: VERIFICAR SI YA EXISTE ---
    $checkStmt = $conn->prepare("SELECT matricula FROM usuarios WHERE matricula = ?");
    $checkStmt->bind_param("s", $nuevoMatt);
    $checkStmt->execute();
    $checkStmt->store_result(); // Almacenar resultado para contar filas

    if ($checkStmt->num_rows > 0) {
        // --- CASO: USUARIO YA EXISTE ---
        echo "<div class='mensaje-error'> Error: La matrícula <b>" . htmlspecialchars($nuevoMatt) . "</b> ya se encuentra registrada.</div>";
    } else {
        // --- CASO: USUARIO NUEVO (PROCEDER AL REGISTRO) ---
        
        // Encriptar la contraseña
        $encriptPass = password_hash($nuevoPass, PASSWORD_DEFAULT);
        $rol = "estudiante";      

        $stmt = $conn->prepare("INSERT INTO usuarios (matricula, pass, nom, app, rol) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nuevoMatt, $encriptPass, $nuevoNom, $nuevoApp, $rol);

        if ($stmt->execute()) {
            echo "<div style='color:green; font-size:18px; font-weight:500;'> Datos guardados correctamente.</div>";
        } else {
            echo "<div style='color:red; font-size:18px; font-weight:500;'>Error al guardar: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }

    $checkStmt->close();
    $conn->close();

    // Botón de regresar
    echo '<form action="login.html"><input type="submit" name="accion" value="Regresar"></form>';
?>

</div> </body>
</html>