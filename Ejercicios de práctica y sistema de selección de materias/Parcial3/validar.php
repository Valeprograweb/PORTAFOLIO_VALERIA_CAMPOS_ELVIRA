<?php
session_start();
include("conn.php");

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// ===================================
// ========== GENERAR CAPTCHA ========
// ===================================
if (isset($_GET['generate'])) {

    header("Content-type: image/jpeg");

    function texto($tam){
        $cadena = "123456789abcdefghijkmnopqrstuvwxyz";
        $resultado = "";
        for($i = 0; $i < $tam; $i++){
            $resultado .= $cadena[rand(0, strlen($cadena)-1)];
        }
        return $resultado;
    }

    $ancho = 120;
    $alto  = 40;
    $mensaje = texto(5);

    $imagen = imageCreate($ancho, $alto);
    $colfondo = ImageColorAllocate($imagen, 0, 0, 0);
    $coltexto = ImageColorAllocate($imagen, 255, 255, 255);

    $_SESSION['code'] = md5($mensaje);

    ImageString($imagen, 5, 40, 12, $mensaje, $coltexto);

    imagejpeg($imagen);
    imagedestroy($imagen);
    exit;
}

// ===================================
// ========== PROCESAR LOGIN =========
// ===================================
$accion = $_POST['accion'] ?? '';

if ($accion === "login") {

    $user = trim($_POST['user']);
    $pass = trim($_POST['pass']);
    $captcha_usuario = trim($_POST['captcha_usuario']);

    if (!isset($_SESSION['code']) || md5($captcha_usuario) !== $_SESSION['code']) {
        echo "<script>alert('Captcha incorrecto');window.location='login2.php';</script>";
        exit;
    }

    // NO se compara con MD5 porque tú dijiste:
    // "el usuario siempre seguirá escribiendo su contraseña normal"
    $passEnc = md5($pass);

    $sql = "SELECT * FROM usuarios WHERE user = ? AND pass = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $passEnc);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {

        $_SESSION['usuario'] = $user;

        // Guardar cookies de colores
        if (isset($_POST['colorFondo'])) {
            setcookie("colorFondo", $_POST['colorFondo'], time() + 604800, "/");
        }
        if (isset($_POST['colorTexto'])) {
            setcookie("colorTexto", $_POST['colorTexto'], time() + 604800, "/");
        }

        header("Location: dashboard.php");
        exit;
    }

    echo "<script>alert('Usuario o contraseña incorrectos');window.location='login2.php';</script>";
    exit;
}

// ===================================
// ========= PROCESAR REGISTRO =======
// ===================================
if ($accion === "registrar") {

    $nom  = trim($_POST['nom']);
    $user = trim($_POST['user']);
    $pass = trim($_POST['pass']);

    $passEnc = md5($pass);

    // Username único
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE user = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        echo "<script>alert('El username ya existe');window.location='registro.php';</script>";
        exit;
    }

    // Contraseña única
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE pass = ?");
    $stmt->bind_param("s", $passEnc);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        echo "<script>alert('La contraseña ya es usada por otro usuario');window.location='registro.php';</script>";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO usuarios (nom, user, pass) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nom, $user, $passEnc);

    if ($stmt->execute()) {
        echo "<script>alert('Registro exitoso');window.location='login2.php';</script>";
        exit;
    }

    echo "<script>alert('Error al registrar');window.location='registro.php';</script>";
    exit;
}

// Si no viene acción, regresar al login
header("Location: login2.php");
exit;
?>
