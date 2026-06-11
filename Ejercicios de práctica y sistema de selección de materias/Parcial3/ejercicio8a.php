<?php
    session_start();
    header ("Content-type: image/jpeg");
    function texto($tam)
    {
        $cadena = "123456789abcdefghijkmnlopqrstwxyz";
        $cad2="-----";
        for($i = 0; $i < $tam; $i++)
            $cad2[$i] = $cadena[rand(0, 32)];
        return $cad2;
    }
    $ancho = 100;
    $alto = 30;
    $mensaje = texto(5);
    $imagen = imageCreate($ancho, $alto);
    $colfondo = ImageColorAllocate($imagen, 0, 0, 0);
    ImageFill($imagen, 0, 0, $colfondo);
    $coltexto = ImageColorAllocate($imagen,100,100,100);
    $_SESSION['code'] = md5($mensaje);
    ImageString($imagen, 200, 25, 5, $mensaje, $coltexto);
    for($c = 0; $c < 4; $c++)
    {
        $x1=rand(0,$ancho);
        $y1=rand(0,$alto);
        $x2=rand(0,$ancho);
        $y2=rand(0,$alto);
        ImageLine($imagen,$x1,$y1,$x2,$y2,$coltexto);
    }
    ImageJPEG ($imagen);
    ImageDestroy($imagen);
?>