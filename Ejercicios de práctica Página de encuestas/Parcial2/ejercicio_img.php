<html>
<head>
<title>Mi álbum de fotografías</title>
<style>
    body {
        font-family: Arial, sans-serif;
        text-align: center;
        background: #27C2F5;
    }
    h1, h3{
        color: white;
    }

    }
    form {
        margin: 20px auto;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        display: inline-block;
    }

    /* Estilo input de archivo */
    input[type="file"] {
        display: none;
    }
    .custom-file-upload {
        background: #0B74F4;
        color: white;
        padding: 10px 15px;
        border-radius: 8px;
        cursor: pointer;
        margin-right: 10px;
        transition: 0.3s;
        display: inline-block;
    }
    .custom-file-upload:hover {
        background: #0056b3;
    }

    /* Estilo botón submit */
    input[type="submit"] {
        background: #0B74F4;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.3s;
        font-size: 14px;
    }
    input[type="submit"]:hover {
        background: #0056b3;
    }

    /* Galería */
    .galeria {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin-top: 30px;
        padding: 10px;
    }
    .galeria img {
        width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        transition: transform 0.3s;
    }
    .galeria img:hover {
        transform: scale(1.05);
    }
</style>
</head>
<body>
<h1>Mi álbum de fotos en línea</h1>
<h3>Cargar archivo</h3>

<form method="post" enctype="multipart/form-data">
    <label for="archivo" class="custom-file-upload">Seleccionar archivo</label>
    <input id="archivo" type="file" name="archivo">
    <input type="submit" name="submit" value="Cargar archivo">
</form>

<?php
$ruta = "img/"; // Carpeta de imágenes

if (isset($_FILES['archivo']) && $_FILES['archivo']['size'] > 0) {
    $tamanyomax = 200000; // Tamaño máximo en bytes
    $nombretemp = $_FILES['archivo']['tmp_name'];
    $nombrearchivo = $_FILES['archivo']['name'];
    $tamanyoarchivo = $_FILES['archivo']['size'];
    $tipoarchivo = getimagesize($nombretemp);

    if ($tipoarchivo[2] == 1 || $tipoarchivo[2] == 2) { // GIF o JPG
        if ($tamanyoarchivo <= $tamanyomax) {
            if (move_uploaded_file($nombretemp, $ruta . $nombrearchivo)) {
                echo "<p>El archivo se ha cargado <b>con éxito</b>.<br>
                Tamaño: <b>$tamanyoarchivo</b> bytes<br>
                Nombre: <b>$nombrearchivo</b></p>";
            } else {
                echo "<p>No se ha podido cargar el archivo.</p>";
            }
        } else {
            echo "<p>El archivo tiene más de <b>$tamanyomax bytes</b> y es demasiado grande.</p>";
        }
    } else {
        echo "<p>No es un archivo GIF o JPG válido.</p>";
    }
}

// Mostrar galería
echo "<div class='galeria'>";
$filehandle = opendir($ruta);
while ($file = readdir($filehandle)) {
    if ($file != "." && $file != "..") {
        echo "<div><img src='$ruta$file'></div>";
    }
}
closedir($filehandle);
echo "</div>";
?>

</body>
</html>
