<?php
    session_start();
    
    $codigo = $_POST['codigo'];
    if($_SESSION['code'] == md5($codigo)){
        echo "Captcha correcto";
    }
    else{
        echo "Captcha incorrecto";
    }
?>