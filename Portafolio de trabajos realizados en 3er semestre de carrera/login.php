<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: Portafolio_evidencias_186831.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Credenciales válidas (cambia estos valores)
    $valid_username = "186831";
    $valid_password = "vale123";
    
    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: Portafolio_evidencias_186831.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-body">
    <div class="neon-glow"></div>
    <div class="login-container neon-border">
        <h1 class="neon-title">Login</h1>
        <?php if ($error): ?>
            <div class="error neon-error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username" class="neon-label">Usuario:</label>
                <input type="text" id="username" name="username" required class="neon-input">
            </div>
            <div class="form-group">
                <label for="password" class="neon-label">Contraseña:</label>
                <input type="password" id="password" name="password" required class="neon-input">
            </div>
            <button type="submit" class="neon-button">Ingresar</button>
        </form>
    </div>
</body>
</html>