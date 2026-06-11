<?php
session_start();

// Configuración de la base de datos
include('conn.php');

// Clave secreta para encriptación - CÁMBIALA POR UNA CLAVE ÚNICA
define('ENCRYPTION_KEY', 'mi_clave_secreta_2024');

// Función para encriptar
function encrypt_password($password) {
    return openssl_encrypt($password, 'AES-128-ECB', ENCRYPTION_KEY);
}

// Función para desencriptar
function decrypt_password($encrypted_password) {
    return openssl_decrypt($encrypted_password, 'AES-128-ECB', ENCRYPTION_KEY);
}

// FUNCIÓN AGREGADA: Validación de seguridad robusta contra comandos SQL
function validarEntradaSegura($input) {
    // Validar longitud máxima (ajusta según tus necesidades)
    if (strlen($input) > 50) {
        return false;
    }
    
    // Validar solo caracteres alfanuméricos y algunos especiales básicos permitidos
    if (!preg_match('/^[a-zA-Z0-9@\.\-_]+$/', $input)) {
        return false;
    }
    
    // Patrones de comandos SQL y caracteres peligrosos
    $patrones_peligrosos = [
        '/\b(SELECT|INSERT|UPDATE|DELETE|DROP|CREATE|ALTER|EXEC|UNION|FROM|WHERE|OR|AND|HAVING|GROUP|ORDER|LIMIT|OFFSET)\b/i',
        '/[\*\'\";\-\-\/\\\=\<\>\(\)]/'
    ];
    
    foreach ($patrones_peligrosos as $patron) {
        if (preg_match($patron, $input)) {
            return false;
        }
    }
    
    return true;
}

// Procesar login si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    
    // VALIDACIÓN AGREGADA: Verificar entradas seguras
    $user = trim($_POST['user']);
    $pass = trim($_POST['pass']);
    
    // Validar que no estén vacíos después del trim
    if (empty($user) || empty($pass)) {
        $error = "Usuario y contraseña son requeridos";
    } elseif (!validarEntradaSegura($user) || !validarEntradaSegura($pass)) {
        $error = "Entrada no válida. Caracteres o comandos sospechosos detectados.";
    } else {
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }
        
        $sql = "SELECT * FROM usuarios WHERE user = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $usuario = $result->fetch_assoc();
            
            // CAMBIO: Desencriptar y comparar
            $decrypted_pass = decrypt_password($usuario['pass']);
            
            if ($pass === $decrypted_pass) {
                $_SESSION['user_id'] = $usuario['id'];
                $_SESSION['user_name'] = $usuario['user'];
                $_SESSION['nom'] = $usuario['nom'];
                header("Location: registros.php");
                exit();
            } else {
                $error = "Este usuario ya existe - verifique la contraseña nuevamente";
            }
        } else {
            $error = "Usuario no encontrado";
        }
        
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body { 
            font-family: Arial; 
            background: black; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; margin: 0; 
        }

        .container { 
            background: white; 
            padding: 30px; 
            box-shadow: 0 0 10px rgba(0,0,0,0.1); 
            text-align: center; width: 300px; 
        }

        h2 { 
            color: #2c3e50; 
            margin-bottom: 20px; 
        }

        input { width: 100%; 
            padding: 10px; 
            margin: 10px 0; 
            border: 2px solid black; 
            border-radius: 5px; 
            box-sizing: border-box; 
        }

        button { 
            width: 100%; 
            padding: 10px; 
            color: white; 
            border: none; 
            border-radius: 1px solid black;
            cursor: pointer; 
            margin: 5px 0; 
        }

        .login-btn { 
            background: #3498db; 
        }
        .login-btn:hover { 
            background: #2980b9; 
        }
        .register-btn { 
            background: #27ae60;
         }
        .register-btn:hover { 
            background: #219652; 
        }
        .error { 
            background: #f8d7da; 
            color: red;
            padding: 10px; 
            margin: 10px 0; 
            border-radius: 5px; 
        }
        
        .security-info {
            background: #d1ecf1;
            color: #0c5460;
            padding: 8px;
            margin: 10px 0;
            border-radius: 5px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Formulario Login</h2>
        <h3>Login</h3>
        
        <?php if (isset($error)) echo '<div class="error">' . $error . '</div>'; ?>
            
        <div class="security-info">
            🔒 Caracteres permitidos: letras, números, @ . - _
        </div>
        
        <form method="POST">
            <input type="text" name="user" placeholder="Usuario" required maxlength="50">
            <input type="password" name="pass" placeholder="Contraseña" required maxlength="50">
            <button type="submit" name="login" class="login-btn">Login</button>
        </form>
        
        <button class="register-btn" onclick="window.location.href='registros.php?register=1'">Nuevo Usuario</button>
    </div>
</body>
</html>                   