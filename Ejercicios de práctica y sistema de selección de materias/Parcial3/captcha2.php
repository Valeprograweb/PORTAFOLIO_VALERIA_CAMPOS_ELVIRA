<?php
session_start();

class CaptchaGenerator {
    private $width = 200;
    private $height = 80;
    private $length = 6;
    
    public function __construct($width = 200, $height = 80, $length = 6) {
        $this->width = $width;
        $this->height = $height;
        $this->length = $length;
    }
    
    public function generateImage() {
        // Crear imagen
        $image = imagecreate($this->width, $this->height);
        
        // Colores
        $backgroundColor = imagecolorallocate($image, 255, 255, 255);
        $textColor = imagecolorallocate($image, 0, 0, 0);
        $noiseColor = imagecolorallocate($image, 150, 150, 150);
        $lineColor = imagecolorallocate($image, 200, 200, 200);
        
        // Rellenar fondo
        imagefill($image, 0, 0, $backgroundColor);
        
        // Generar texto aleatorio
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
        $captchaText = '';
        
        for ($i = 0; $i < $this->length; $i++) {
            $captchaText .= $chars[rand(0, strlen($chars) - 1)];
        }
        
        // Guardar en sesión
        $_SESSION['captcha'] = $captchaText;
        
        // Agregar ruido (puntos)
        for ($i = 0; $i < 100; $i++) {
            imagesetpixel($image, rand(0, $this->width), rand(0, $this->height), $noiseColor);
        }
        
        // Agregar líneas
        for ($i = 0; $i < 5; $i++) {
            imageline($image, 
                     rand(0, $this->width), rand(0, $this->height),
                     rand(0, $this->width), rand(0, $this->height),
                     $lineColor);
        }
        
        // Escribir texto
        $fontSize = 20;
        $x = 20;
        $y = 50;
        
        for ($i = 0; $i < $this->length; $i++) {
            $char = $captchaText[$i];
            $charAngle = rand(-15, 15);
            $charX = $x + ($i * 25);
            $charY = $y + rand(-5, 5);
            
            // Color aleatorio para cada carácter
            $charColor = imagecolorallocate($image, rand(0, 100), rand(0, 100), rand(0, 100));
            
            // Usar función básica de texto (no requiere fuente TTF)
            imagestring($image, 5, $charX, $charY - 20, $char, $charColor);
        }
        
        // Output como PNG
        header('Content-Type: image/png');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        imagepng($image);
        imagedestroy($image);
        exit;
    }
    
    public static function verify($userInput) {
        if (isset($_SESSION['captcha'])) {
            $captcha = $_SESSION['captcha'];
            // No limpiar inmediatamente para permitir reintentos
            return strtolower(trim($userInput)) === strtolower($captcha);
        }
        return false;
    }
}

// Procesar diferentes acciones
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'generate':
            $captcha = new CaptchaGenerator();
            $captcha->generateImage();
            break;
            
        case 'verify':
            $response = ['success' => false];
            if (isset($_POST['captcha_input'])) {
                $response['success'] = CaptchaGenerator::verify($_POST['captcha_input']);
            }
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
            break;
    }
}

// Procesar envío del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_form'])) {
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $captchaInput = htmlspecialchars(trim($_POST['captcha'] ?? ''));
    
    $errors = [];
    $success = false;
    
    // Validaciones básicas
    if (empty($name)) {
        $errors[] = "El nombre es requerido";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email válido es requerido";
    }
    
    if (empty($captchaInput)) {
        $errors[] = "El CAPTCHA es requerido";
    }
    
    // Verificar CAPTCHA
    if (!CaptchaGenerator::verify($captchaInput)) {
        $errors[] = "El CAPTCHA ingresado es incorrecto";
    }
    
    if (empty($errors)) {
        $success = true;
        // Limpiar CAPTCHA después de verificación exitosa
        unset($_SESSION['captcha']);
    }
}

// Mostrar HTML
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema CAPTCHA</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
            line-height: 1.6;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        h1, h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        
        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        input[type="text"]:focus,
        input[type="email"]:focus {
            outline: none;
            border-color: #007bff;
        }
        
        .captcha-container {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
            text-align: center;
        }
        
        .captcha-image {
            border: 1px solid #ccc;
            margin: 10px 0;
            padding: 5px;
            background: white;
        }
        
        .btn {
            background-color: #007bff;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            margin-right: 10px;
        }
        
        .btn:hover {
            background-color: #0056b3;
        }
        
        .btn-secondary {
            background-color: #6c757d;
        }
        
        .btn-secondary:hover {
            background-color: #545b62;
        }
        
        .message {
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .result-data {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        
        .refresh-btn {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #007bff;
            margin-left: 10px;
        }
        
        .button-group {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sistema CAPTCHA</h1>
        
        <?php if (isset($success) && $success): ?>
            <!-- Mostrar resultado exitoso -->
            <div class="message success">
                <h2>¡Formulario enviado correctamente!</h2>
                <p>El CAPTCHA fue verificado exitosamente.</p>
            </div>
            
            <div class="result-data">
                <h3>Datos recibidos:</h3>
                <p><strong>Nombre:</strong> <?php echo $name; ?></p>
                <p><strong>Email:</strong> <?php echo $email; ?></p>
            </div>
            
            <div class="button-group">
                <button class="btn" onclick="window.location.href='?'">↻ Enviar otro formulario</button>
            </div>
            
        <?php else: ?>
            <!-- Mostrar formulario -->
            <?php if (isset($errors) && !empty($errors)): ?>
                <div class="message error">
                    <h3>Errores:</h3>
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="?">
                <input type="hidden" name="submit_form" value="1">
                
                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" id="name" name="name" value="<?php echo $_POST['name'] ?? ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $_POST['email'] ?? ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Verificación CAPTCHA:</label>
                    <div class="captcha-container">
                        <div>
                            <img src="?action=generate" alt="CAPTCHA" id="captchaImage" class="captcha-image">
                            <button type="button" class="refresh-btn" onclick="refreshCaptcha()" title="Actualizar CAPTCHA">
                                
                            </button>
                        </div>
                        <p>Ingresa el texto que ves en la imagen:</p>
                        <input type="text" id="captcha" name="captcha" required maxlength="6">
                    </div>
                </div>
                
                <div class="button-group">
                    <button type="submit" class="btn">Enviar Formulario</button>
                    <button type="button" class="btn btn-secondary" onclick="refreshCaptcha()">Actualizar CAPTCHA</button>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <script>
        function refreshCaptcha() {
            const captchaImage = document.getElementById('captchaImage');
            // Agregar timestamp para evitar cache
            captchaImage.src = '?action=generate&t=' + new Date().getTime();
            document.getElementById('captcha').value = '';
            document.getElementById('captcha').focus();
        }
        
        // Verificación en tiempo real (opcional)
        document.getElementById('captcha')?.addEventListener('input', function(e) {
            const value = e.target.value;
            if (value.length === 6) {
                // Podrías agregar verificación AJAX aquí si quisieras
            }
        });
        
        // Prevenir envío del formulario con Enter en el campo CAPTCHA
        document.getElementById('captcha')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>