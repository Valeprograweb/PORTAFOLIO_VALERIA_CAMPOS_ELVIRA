<?php
session_start();

// Configuración de la base de datos
include('conn.php');

// Clave secreta para encriptación - DEBE SER LA MISMA QUE EN login.php
define('ENCRYPTION_KEY', 'mi_clave_secreta_2024');

// Función para encriptar
function encrypt_password($password) {
    return openssl_encrypt($password, 'AES-128-ECB', ENCRYPTION_KEY);
}

// Procesar registro si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $nom = $_POST['nom'];
    
    // Verificar si el usuario ya existe
    $check_sql = "SELECT id FROM usuarios WHERE user = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $user);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        $error = "Este usuario ya existe - verifique la contraseña nuevamente";
    } else {
        // CAMBIO: Encriptar contraseña (siempre genera el mismo resultado para la misma contraseña)
        $encrypted_pass = encrypt_password($pass);
        
        // Insertar nuevo usuario
        $insert_sql = "INSERT INTO usuarios (user, pass, nom, fec) VALUES (?, ?, ?, NOW())";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("sss", $user, $encrypted_pass, $nom);
        
        if ($insert_stmt->execute()) {
            $success = "Usuario registrado exitosamente. Ahora puedes iniciar sesión.";
        } else {
            $error = "Error al registrar el usuario";
        }
        $insert_stmt->close();
    }
    
    $check_stmt->close();
    $conn->close();
}

// Cerrar sesión
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Si no está logueado y no está en registro, redirigir al login
if (!isset($_SESSION['user_id']) && !isset($_GET['register'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php 
        if (isset($_GET['register'])) echo "Registro - Farmland Legin";
        elseif (isset($_SESSION['user_id'])) echo "Dashboard - Farmland Legin";
        ?>
    </title>
    <style>
        body { 
            font-family: Arial; 
            background: white; 
            margin: 0; 
            padding: 20px; 
        }

        .container { 
            max-width: 400px; 
            margin: 0 auto; 
            background: white; 
            padding: 30px; 
            box-shadow: 0 0 10px rgba(0,0,0,0.1); 
        }

        h2, h3{ 
            color: black; 
            text-align: center; 
        }

        input { 
            width: 100%; 
            padding: 10px; 
            margin: 10px 0; 
            border: 1px solid #ddd; 
            border-radius: 5px; 
            box-sizing: border-box; 
        }

        button { 
            width: 100%; 
            padding: 10px; 
            color: white; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            margin: 5px 0; 
        }
        
        buttonred { 
            width: 10%; 
            padding: 10px; 
            color: white; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer;  
            display: block;      /* hace que el botón use todo el ancho disponible */
    		margin: 20px auto; 
        }

        .register-btn { background: #27ae60; }
        .register-btn:hover { background: #219652; }
        .back-btn { background: #95a5a6; }
        .back-btn:hover { background: #7f8c8d; }
        .logout-btn { background: #e74c3c; }
        .logout-btn:hover { background: #c0392b; }

        .error { 
            background: #f8d7da; 
            color: red; 
            padding: 10px; 
            margin: 10px 0; 
            border-radius: 5px;
        }

        .success { 
            background: #d4edda; 
            color: #155724; 
            padding: 10px; 
            margin: 10px 0; 
            border-radius: 5px; 
        }

        .user-info { 
            background: skyblue; 
            padding: 15px; 
            border-radius: 5px; 
            margin: 15px 0; 
        }

    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($_GET['register'])): ?>
            <!-- FORMULARIO DE REGISTRO -->
            <h2>Nueva Usuario - Registro</h2>
            
            <?php 
            if (isset($error)) echo '<div class="error">' . $error . '</div>';
            if (isset($success)) echo '<div class="success">' . $success . '</div>';
            ?>
            
            <form method="POST">
                <input type="text" name="user" placeholder="Nombre de usuario" required>
                <input type="password" name="pass" placeholder="Contraseña" required>
                <input type="text" name="nom" placeholder="Nombre completo" required>
                <button type="submit" name="register" class="register-btn">Registrarse</button>
            </form>
            
            <button class="back-btn" onclick="window.location.href='login.php'">Volver al Login</button>
            
        <?php elseif (isset($_SESSION['user_id'])): ?>
            <!-- DASHBOARD -->
            <h2>¡Bienvenido, <?php echo htmlspecialchars($_SESSION['nom']); ?>!</h2>
            
            <div class="user-info">
                <h3>Información de tu cuenta:</h3>
                <p><strong>Usuario:</strong> <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
                <p><strong>Nombre completo:</strong> <?php echo htmlspecialchars($_SESSION['nom']); ?></p>
                <p><strong>Fecha de acceso:</strong> <?php echo date('d/m/Y H:i:s'); ?></p>
            </div>
         </div>
            
            <!-- Mostrar registros de la tabla medallero -->
                <h3>Listado Medallero</h3>
                <?php
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Error de conexión: " . $conn->connect_error);
                }

                $sql = "SELECT Rango, Pais, Code, Oro, Plata, Bronce, Total, Continente FROM olimpiadas2024 ORDER BY Rango ASC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<table border='1' cellpadding='8' cellspacing='0' style='width:70%; margin-top:15px; margin: 0 auto;'>";
                    echo "<tr style='background:#3498db; color:white;'>
                            <th>Rango</th>
                            <th>País</th>
                            <th>Code</th>
                            <th>Oro</th>
                            <th>Plata</th>
                            <th>Bronce</th>
                            <th>Total</th>
                            <th>Continente</th>
                          </tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr style='text-align:center;'>
                                <td>{$row['Rango']}</td>
                                <td>{$row['Pais']}</td>
                                <td>{$row['Code']}</td>
                                <td>{$row['Oro']}</td>
                                <td>{$row['Plata']}</td>
                                <td>{$row['Bronce']}</td>
                                <td>{$row['Total']}</td>
                                <td>{$row['Continente']}</td>
                              </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No hay registros en el medallero.</p>";
                }

                $conn->close();
                ?>

            
            <buttonred class="logout-btn" onclick="window.location.href='registros.php?logout=1'">Cerrar Sesión</buttonred>
            
        <?php endif; ?>
</body>
</html>