<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portafolio de evidencias CNO II</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="neon-glow"></div>
    
    <header class="neon-header">
        <h1 class="neon-main-title">Portafolio de Evidencias CNO II</h1>
        <div class="user-info">
            Bienvenida, Valeria Campos Elvira <span class="neon-text"><?php echo $_SESSION['username']; ?></span> | 
            <a href="logout.php" class="neon-link">Cerrar Sesión</a>
        </div>
    </header>

    <main class="container">
        <!-- Parcial 1 -->
        <div class="acordeon neon-acordeon">
            <input type="checkbox" id="parcial1">
            <label for="parcial1" class="acordeon-titulo">
                Parcial 1
                <span class="acordeon-icon">▼</span>
            </label>
            <div class="acordeon-contenido">
                
                <!-- Sección 1: Ejercicios -->
                <div class="acordeon sub-acordeon">
                    <input type="checkbox" id="parcial1-seccion1">
                    <label for="parcial1-seccion1" class="acordeon-titulo sub-titulo">
                        Ejercicios
                        <span class="acordeon-icon">▼</span>
                    </label>
                    <div class="acordeon-contenido">
                        <div class="tabla-container">
                            <table class="neon-table">
                                <thead>
                                    <tr>
                                        <th>Nombre del Ejercicio</th>
                                        <th>Enlace</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Actividad 1 - Sitio Web CNO 1</td>
                                        <td><a href="https://johan410.github.io/Pogramacion_Web1/index-proyecto.html" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Actividad 2 - Google Sites</td>
                                        <td><a href="https://sites.google.com/view/zapateriabicentenariovale/home" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Actividad 3 - Bootstrap</td>
                                        <td><a href="https://valeprograweb.github.io/WEB2_2025/" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Actividad 4 - MODELADO E-R</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Portafolio/P1docs/Modelado%2BE-R%2BConsultorio%2Bdental.pdf" target="_blank" class="neon-link">Ver ejercicio</a></td><br>
                                    </tr>
                                    <tr>
                                        <td>Actividad 4a - MODELADO E-R</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Portafolio/P1docs/1000068603.pdf" target="_blank" class="neon-link">Ver ejercicio</a></td><br>
                                    </tr>
                                    <tr>
                                        <td>Actividad 5 - Modelado de base de datos de vacunación</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Portafolio/P1docs/Modelado%2Bde%2Bbase%2Bde%2Bdatos%2Bvacunaci%C3%B3n.pdf" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Actividad 6 - Diagramas a partir de .sql</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Portafolio/P1docs/DIAGRAMA%2BVENTAS.pdf" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Actividad 7 - Ejercicio Integrador SQL 1</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Portafolio/P1docs/EJERCICIO%2B%2BINTEGRADOR%2BSQL%2B-%2BValeria%2BCampos%2BElvira.pdf" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Actividad 8 - Ejercicio Integrador SQL 2</td>
                                        <td><a href="x" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Actividad 9 - Titanic</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Portafolio/P1docs/Act.-%2B9%2BEJERCICIOS%2BTITANIC.pdf" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Actividad 10 - Analisis de KARDEX</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Portafolio/P1docs/ACTIVIDAD%2B10.pdf" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Parcial 2 -->
        <div class="acordeon neon-acordeon">
            <input type="checkbox" id="parcial2">
            <label for="parcial2" class="acordeon-titulo">
                Parcial 2
                <span class="acordeon-icon">▼</span>
            </label>
            <div class="acordeon-contenido">
                
                <!-- Sección 1: Ejercicios -->
                <div class="acordeon sub-acordeon">
                    <input type="checkbox" id="parcial2-seccion1">
                    <label for="parcial2-seccion1" class="acordeon-titulo sub-titulo">
                        Ejercicios
                        <span class="acordeon-icon">▼</span>
                    </label>
                    <div class="acordeon-contenido">
                        <div class="tabla-container">
                            <table class="neon-table">
                                <thead>
                                    <tr>
                                        <th>Nombre del Ejercicio</th>
                                        <th>Enlace</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Infografía PHP</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Portafolio/P2docs/Blue%2Band%2BGreen%2BModern%2BOnline%2BPrivacy%2BTechnology%2BInfographic.pdf" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 1 - Introducción a php</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/ejercicio1.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 2 y 3 - ¡Hola mundo!</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/ejercicio2.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 4 - 6  - Primer ejemplo de variables</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/ejercicio4.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 7 - Introducción a los arrays, metodo largo</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/ejercicio7.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 8 - Operadores en PHP</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/ejercicio8.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 9 - Condicional IF</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/ejercicio9.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 10 - Condicional SWITCH</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/ejercicio10.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 11 - Tabla Condicional 1</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/ejercicio11.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 12 - Bucle WHILE</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/practica12.html" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 13 -Bucle WHILE 2 </td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/ejercicio13.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 14 - Análisis de fromulario</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/practica14.html" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 15 - Análisis de fromulario 5</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/practica15.html" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 16- Feedback</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/ejercicio16.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 17 - Contador de visitas</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/ejercicio17.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 18 - Libro de visitas</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/ejercicio18.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                  	<tr>
                                        <td>Ejercicio 19 - Encuesta a un archivo</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/ejercicio19.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 19a - Galería de fotos</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/ejercicio_img.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 20 - Mysql conection</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/ejercicio20.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 21 - Crear base de datos</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/ejercicio21.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 22 - Crear una tabla dentro de una base de datos</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/ejercicio22.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 23 - Insertar Registros dentro de la tabla</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/ejercicio23.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 24 - Consultar registros de base de datos</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/ejercicio24.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 24a - Buscar registros de base de datos</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/ejercicio24a.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 25 - Borrar registro en específico</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/ejercicio25.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 25a - Borrar Registros</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/ejercicio25a.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>   
                                    <tr>
                                        <td>Primer Avance Proyecto Final</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Portafolio/P2docs/AVANCE_UNO.pdf" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                               </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Sección 2: Tareas y Retos -->
                <div class="acordeon sub-acordeon">
                    <input type="checkbox" id="parcial2-seccion2">
                    <label for="parcial2-seccion2" class="acordeon-titulo sub-titulo">
                        Tareas y Retos
                        <span class="acordeon-icon">▼</span>
                    </label>
                    <div class="acordeon-contenido">
                        <div class="tabla-container">
                            <table class="neon-table">
                                <thead>
                                    <tr>
                                        <th>Nombre de la Tarea/Reto</th>
                                        <th>Enlace</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Tarea 1 - Canción en php</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/tarea1.php" target="_blank" class="neon-link">Ver tarea</a></td>
                                    </tr>
                                    <tr>
                                        <td>Tarea 2 - Tabla con arreglos</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/tarea2.php" target="_blank" class="neon-link">Ver tarea</a></td>
                                    </tr>
                                    <tr>
                                        <td>Tarea 3 - Tabla de multiplicar</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/tarea3.html" target="_blank" class="neon-link">Ver tarea</a></td>
                                    </tr>
                                    <tr>
                                        <td>Tarea 4 - Acceso al sistema</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/tarea4.html" target="_blank" class="neon-link">Ver tarea</a></td>
                                    </tr>
                                    <tr>
                                        <td>Reto 1 - Introducir datos</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/reto1.html" target="_blank" class="neon-link">Ver reto</a></td>
                                    </tr>
                                    <tr>
                                        <td>Reto 2 - Página de Registros</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/reto2.html" target="_blank" class="neon-link">Ver reto</a></td>
                                    </tr>
                                    <tr>
                                        <td>Reto 3 y 4 - Test de Nomofobia</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial2/test.php" target="_blank" class="neon-link">Ver reto</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Parcial 3 -->
        <div class="acordeon neon-acordeon">
            <input type="checkbox" id="parcial3">
            <label for="parcial3" class="acordeon-titulo">
                Parcial 3
                <span class="acordeon-icon">▼</span>
            </label>
            <div class="acordeon-contenido">
                
                <!-- Sección 1: Ejercicios -->
                <div class="acordeon sub-acordeon">
                    <input type="checkbox" id="parcial3-seccion1">
                    <label for="parcial3-seccion1" class="acordeon-titulo sub-titulo">
                        Ejercicios
                        <span class="acordeon-icon">▼</span>
                    </label>
                    <div class="acordeon-contenido">
                        <div class="tabla-container">
                            <table class="neon-table">
                                <thead>
                                    <tr>
                                        <th>Nombre del Ejercicio</th>
                                        <th>Enlace</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Infografía seguridad en aplicaciones php - MySQL</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Portafolio/P3docs/INFOGRAFIA%2BSEGURIDAD%2BEN%2BAPLICACIONES%2BPHP-MYSQL.pdf" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 1 - Cookies</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial3/pagina1.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 2 - Sesiones</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial3/ejercicio2.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 3 y 4 - Login de usuario y medallero olimpiadas  con validación de usuarios y encriptación</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial3/login.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                        
                                    <tr>
                                        <td>Ejercicio 5 - Avanzado captcha</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial3/cpatcha.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 6 - Contador con sesiones</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial3/ejercicio6.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 7 - Ejemplo de uso de cookies</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial3/ejercicio7.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Ejercicio 8 - Captcha</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial3/ejercicio8.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Actividad 1- Inyección SQL</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Portafolio/P3docs/Conclusi%C3%B3n%2BInyecci%C3%B3n%2BSQL%2By%2Bestrategias%2Bde%2Bprotecci%C3%B3n%2Ben%2BPHP.pdf" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Práctica integradora 1- Personalización de colores y mensaje acorde al usuario</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial3/login2.php" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                    <tr>
                                        <td>Infografía seguridad y mejores prácticas de prevención</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Portafolio/P3docs/Infograf%C3%ADa%20Criptomonedas%20Tecnol%C3%B3gico%20Lila%20y%20Rosa.pdf" target="_blank" class="neon-link">Ver ejercicio</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Sección 2: Tareas y Retos -->
                <div class="acordeon sub-acordeon">
                    <input type="checkbox" id="parcial3-seccion2">
                    <label for="parcial3-seccion2" class="acordeon-titulo sub-titulo">
                        Tareas y Retos
                        <span class="acordeon-icon">▼</span>
                    </label>
                    <div class="acordeon-contenido">
                        <div class="tabla-container">
                            <table class="neon-table">
                                <thead>
                                    <tr>
                                        <th>Nombre de la Tarea/Reto</th>
                                        <th>Enlace</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Tarea 1 - Implementar otro método de captcha para aplicaciones web</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial3/captcha2.php" target="_blank" class="neon-link">Ver tarea</a></td>
                                    </tr>
                                    <tr>
                                        <td>Tarea 1a - Investigación de otro método de captcha para aplicaciones web</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Portafolio/P3docs/M%C3%A9todos%20Alternativos%20de%20CAPTCHA%20para%20Aplicaciones%20Web.pdf" target="_blank" class="neon-link">Ver tarea</a></td>
                                    </tr>
                                    <tr>
                                        <td>Reto 1 + Ejercicio 4 - Gráficas récord medallas</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial3/phpChart_Lite/examples/pruebas.php" target="_blank" class="neon-link">Ver reto</a></td>
                                    </tr>
                                    <tr>
                                        <td>Reto 1a- Gráfica Calificaciones</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial3/phpChart_Lite/examples/calificaciones.php" target="_blank" class="neon-link">Ver reto</a></td>
                                    </tr>
                                    <tr>
                                        <td>Reto 1b- Gráfica Aleatorios</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial3/phpChart_Lite/examples/aleatorios.php" target="_blank" class="neon-link">Ver reto</a></td>
                                    </tr>
                                    <tr>
                                        <td>Reto 2 - Gráfica de los 10 mejores países del medallero</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial3/phpChart_Lite/examples/pruebas.php" target="_blank" class="neon-link">Ver reto</a></td>
                                    </tr>
                                    <tr>
                                        <td>Reto 3 - Agrupación por continentes</td>
                                        <td><a href="http://186831cno2.atwebpages.com/Parcial3/phpChart_Lite/examples/continentes.php" target="_blank" class="neon-link">Ver reto</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECCIÓN SIMPLIFICADA: Exámenes -->
        <div class="acordeon examenes-acordeon">
            <input type="checkbox" id="examenes">
            <label for="examenes" class="acordeon-titulo examenes-titulo">
                Exámenes
                <span class="acordeon-icon">▼</span>
            </label>
            <div class="acordeon-contenido">
                <div class="tabla-container">
                    <table class="neon-table">
                        <thead>
                            <tr>
                                <th>Nombre del Examen</th>
                                <th>Enlace</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Examen Parcial 1 </td>
                                <td><a href="#" target="_blank" class="neon-link">Ver examen</a></td>
                            </tr>
                            <tr>
                                <td>Examen Parcial 2 - SELECCIÓN DE MATERIAS ITI</td>
                                <td><a href="http://186831cno2.atwebpages.com/Parcial2/exam.html" target="_blank" class="neon-link">Ver examen</a></td>
                            </tr>
                            <tr>
                                <td>Examen Parcial 3 - Encuesta Sales Force Fest 2025</td>
                                <td><a href="http://186831cno2.atwebpages.com/Parcial3/phpChart_Lite/examples/examen3p/inicio.html" target="_blank" class="neon-link">Ver examen</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const title = document.querySelector('.neon-main-title');
            const text = title.textContent;
            title.textContent = '';
            
            let i = 0;
            function typeWriter() {
                if (i < text.length) {
                    title.textContent += text.charAt(i);
                    i++;
                    setTimeout(typeWriter, 100);
                }
            }
            typeWriter();
        });
    </script>
</body>
</html>