<?php
session_start();
include('conn.php');

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) { die("Conexión fallida: " . $conn->connect_error); }
$conn->set_charset("utf8mb4");

$usuario = isset($_POST['campousuario']) ? trim($_POST['campousuario']) : '';
$claveIngresada = isset($_POST['campoclave']) ? trim($_POST['campoclave']) : '';

$mensaje = "";
$tipo_mensaje = ""; // 'success' o 'error'
$redireccion = "";  // URL a donde ir

// Agregué 'id_usuario' a la consulta para usarlo en el admin panel
$stmt = $conn->prepare("SELECT id_usuario, pass, rol, nom, app FROM usuarios WHERE matricula = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $hashGuardado = $row['pass'];
    $rol = $row['rol'];

    $esHash = (strlen($hashGuardado) === 60 && str_starts_with($hashGuardado, '$2y$'));
    $ok = false;

    if ($esHash) {
        $ok = password_verify($claveIngresada, $hashGuardado);
    } else {
        $ok = hash_equals($hashGuardado, $claveIngresada);
        if ($ok) {
            $nuevoHash = password_hash($claveIngresada, PASSWORD_DEFAULT);
            $upd = $conn->prepare("UPDATE usuarios SET pass = ? WHERE matricula = ?");
            $upd->bind_param("ss", $nuevoHash, $usuario);
            $upd->execute();
            $upd->close();
        }
    }

    if ($ok) {
        $_SESSION['id_usuario'] = $row['id_usuario']; // Guardamos el ID para validaciones futuras
        $_SESSION['usuario'] = $usuario;
        $_SESSION['rol'] = $rol;
        $_SESSION['nombre'] = $row['nom'] . " " . $row['app'];
            
        if ($rol === 'estudiante') {
            $redireccion = "estudiante.php";
        } elseif ($rol === 'admin') {
            $redireccion = "admin.php";
        } else {
            $mensaje = "Rol desconocido detectado.";
            $tipo_mensaje = "error";
        }
    } else {
        $mensaje = "La contraseña ingresada es incorrecta.";
        $tipo_mensaje = "error";
    }
} else {
    $mensaje = "El usuario no fue encontrado.";
    $tipo_mensaje = "error";
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Iniciando Sesión...</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png" />
    <?php if(!empty($redireccion)): ?>
        <meta http-equiv="refresh" content="0;url=<?php echo $redireccion; ?>">
    <?php endif; ?>
    <style>
        body { 
            font-family: 'Segoe UI', sans-serif; 
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
        
        .card { 
            background: white; 
            padding: 40px; 
            border-radius: 8px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.1); 
            text-align: center; 
            width: 100%; 
            max-width: 400px; 
        }

        h2 { margin-top: 0; color: #333; }

        .error-box { 
            color: #721c24; 
            background-color: #f8d7da; 
            padding: 15px; 
            border-radius: 5px; 
            margin-bottom: 20px; 
            border: 1px solid #f5c6cb; 
        }

        .success-box {
            color: #155724; 
            background-color: #d4edda; 
            padding: 15px; 
            border-radius: 5px; 
            margin-bottom: 20px; 
            border: 1px solid #c3e6cb;
        }

        .btn-back { 
            display: inline-block; 
            text-decoration: none; 
            color: white; 
            background-color: #007bff; 
            padding: 10px 20px; 
            border-radius: 4px; 
            font-weight: bold; 
            transition: background 0.3s;
        }
        
        .btn-back:hover { 
            background-color: #0056b3; 
        }

        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

    <div class="card">
        <?php if (!empty($redireccion)): ?>
            <div class="loader"></div>
            <div class="success-box">
                ¡Bienvenido! Redirigiendo...
            </div>
            <p style="color:#666; font-size:0.9em;">Si no eres redirigido, <a href="login.html">haz clic aquí</a>.</p>
        
        <?php else: ?>
            <h2 style="color: #dc3545;">Error de Acceso</h2>
            
            <div class="error-box">
                <?php echo $mensaje; ?>
            </div>

            <a href="login.html" class="btn-back">← Regresar al Login</a>
        <?php endif; ?>
    </div>

</body>
</html>
