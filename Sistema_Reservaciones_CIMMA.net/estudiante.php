<?php
// Evitar caché
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

session_start();

// --- 1. AUTENTICACIÓN ---
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'estudiante') {
    header("Location: login.html");
    exit;
}

include('conn.php');

// --- 2. CONEXIÓN ROBUSTA ---
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($servername, $username, $password, $database);
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    die("Error crítico de conexión: " . $e->getMessage());
}

// --- 3. CONFIGURACIÓN / REGLAS ---
define('MAX_MINUTOS_DIA', 180);

define('HORARIOS', [
    1 => ['inicio_h' => 8, 'fin_h' => 18], 
    2 => ['inicio_h' => 8, 'fin_h' => 18], 
    3 => ['inicio_h' => 8, 'fin_h' => 18], 
    4 => ['inicio_h' => 8, 'fin_h' => 18], 
    5 => ['inicio_h' => 8, 'fin_h' => 18], 
    6 => ['inicio_h' => 8, 'fin_h' => 14], 
    0 => ['inicio_h' => 0, 'fin_h' => 0]  
]);

// --- 4. PROCESAR RESERVA (POST) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset(
    $_POST['hora_in'], $_POST['hora_fin'], $_POST['titulo'],
    $_POST['fecha'], $_POST['cantidad_usuarios']
)) {
    // Limpieza de datos
    $usuario = $_SESSION['usuario'];
    $hora_in = $_POST['hora_in'];
    $hora_fin = $_POST['hora_fin'];
    $titulo = trim($_POST['titulo']); 
    $fecha = $_POST['fecha'];
    $num_us = $_POST['cantidad_usuarios'];

    try {
        $dt_inicio = new DateTime($hora_in);
        $dt_fin = new DateTime($hora_fin);
        $fecha_res = $dt_inicio->format('Y-m-d');

        // Validaciones básicas
        if ($dt_inicio >= $dt_fin) exit("Error: La hora de inicio debe ser menor que la de fin.");

        $dia_sem = (int)$dt_inicio->format('w');
        if ($dia_sem === 0) exit("Error: No hay reservas los domingos.");

        $hora_ini_h = (int)$dt_inicio->format('H');
        $hora_fin_h = (int)$dt_fin->format('H');
        $minutos_fin = (int)$dt_fin->format('i');
        
        $horario = HORARIOS[$dia_sem];

        if ($hora_ini_h < $horario['inicio_h'] || $hora_ini_h >= $horario['fin_h']) {
             exit("Error: Hora de inicio fuera del horario permitido.");
        }

        if ($hora_fin_h > $horario['fin_h'] || ($hora_fin_h === $horario['fin_h'] && $minutos_fin > 0)) {
            exit("Error: La hora de fin excede el horario de cierre.");
        }

        // =================================================================
        // BLOQUE 0: VALIDACIÓN DE BLOQUEO ADMINISTRATIVO
        // =================================================================
        $stmt_admin = $conn->prepare("
            SELECT lugar FROM reservas 
            WHERE usuario = 'BLOQUEO ADMIN' 
            AND fecha = ? 
            AND (
                (hora_in < ? AND hora_fin > ?)
            )
            LIMIT 1
        ");
        $stmt_admin->bind_param("sss", $fecha, $hora_fin, $hora_in);
        $stmt_admin->execute();
        $stmt_admin->store_result();
        
        if ($stmt_admin->num_rows > 0) {
            $stmt_admin->bind_result($motivo_bloqueo);
            $stmt_admin->fetch();
            exit("Error: No se puede reservar. Bloqueo administrativo: " . $motivo_bloqueo);
        }
        $stmt_admin->close();


        // Límite de 3 horas diarias
        $intervalo = $dt_inicio->diff($dt_fin);
        $duracion = ($intervalo->h * 60) + $intervalo->i;

        $stmt_total = $conn->prepare("SELECT SUM(TIMESTAMPDIFF(MINUTE, hora_in, hora_fin)) AS total_minutos FROM reservas WHERE usuario = ? AND DATE(hora_in) = ?");
        $stmt_total->bind_param("ss", $usuario, $fecha_res);
        $stmt_total->execute();
        $min_res = (int)$stmt_total->get_result()->fetch_assoc()['total_minutos'];

        if ($min_res + $duracion > MAX_MINUTOS_DIA) {
            exit("Error: Excedes el límite de 3 horas diarias.");
        }

        // =================================================================
        // BLOQUE 1: VALIDACIÓN DE USUARIO OCUPADO (CORREGIDO)
        // Agregamos "AND fecha = ?" para que solo busque conflictos HOY
        // =================================================================
        $stmt_user_check = $conn->prepare("
            SELECT lugar, hora_in, hora_fin FROM reservas 
            WHERE usuario = ? 
            AND fecha = ? 
            AND (
                (hora_in < ? AND hora_fin > ?)
            )
            LIMIT 1
        ");
        
        // ¡OJO AQUI! Agregamos $fecha a los parámetros (ssss)
        $stmt_user_check->bind_param("ssss", $usuario, $fecha, $hora_fin, $hora_in);
        $stmt_user_check->execute();
        $stmt_user_check->store_result();

        if ($stmt_user_check->num_rows > 0) {
            $stmt_user_check->bind_result($lugar_ocupado, $hi, $hf);
            $stmt_user_check->fetch();
            $h_inicio_formato = date('H:i', strtotime($hi));
            $h_fin_formato = date('H:i', strtotime($hf));
            
            exit("Error: Ya tienes una reserva activa en '$lugar_ocupado' de $h_inicio_formato a $h_fin_formato para este día.");
        }
        $stmt_user_check->close();

        // =================================================================
        // BLOQUE 2: ANTI-CHOQUE DE RECURSOS (CORREGIDO)
        // Agregamos "AND fecha = ?" para que solo busque conflictos HOY
        // =================================================================
        $stmt_check = $conn->prepare("
            SELECT usuario, hora_in, hora_fin FROM reservas 
            WHERE lugar = ? 
            AND fecha = ?
            AND (
                (hora_in < ? AND hora_fin > ?)
            )
            LIMIT 1
        ");
        
        // ¡OJO AQUI! Agregamos $fecha a los parámetros (ssss)
        $stmt_check->bind_param("ssss", $titulo, $fecha, $hora_fin, $hora_in);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $stmt_check->bind_result($us_ocupante, $hin, $hfin);
            $stmt_check->fetch();
            $h_inicio_ocupado = date('H:i', strtotime($hin));
            $h_fin_ocupado = date('H:i', strtotime($hfin));
            
            exit("Error: El recurso '$titulo' ya está ocupado de $h_inicio_ocupado a $h_fin_ocupado en esta fecha.");
        }
        $stmt_check->close();

        // Insertar
        $stmt_insert = $conn->prepare("INSERT INTO reservas (usuario, hora_in, hora_fin, fecha, num_us, lugar) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt_insert->bind_param("ssssss", $usuario, $hora_in, $hora_fin, $fecha, $num_us, $titulo);

        if ($stmt_insert->execute()) {
            echo "Reserva guardada correctamente.";
        } else {
            echo "Error SQL: " . $stmt_insert->error;
        }

    } catch (Exception $e) {
        echo "Error del Sistema: " . $e->getMessage();
    }
    exit;
}

// --- 5. CARGAR RESERVAS DEL USUARIO Y BLOQUEOS ---
$reservas = [];
try {
    $stmt = $conn->prepare("SELECT id_reserva, usuario, hora_in, hora_fin, fecha, lugar, num_us FROM reservas WHERE usuario = ? OR usuario = 'BLOQUEO ADMIN'");
    $stmt->bind_param("s", $_SESSION['usuario']);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_assoc()) {
        $esBloqueo = ($row['usuario'] === 'BLOQUEO ADMIN');
        
        $evento = [
            'id'    => $row['id_reserva'],
            'start' => $row['hora_in'],
            'end'   => $row['hora_fin']
        ];

        if ($esBloqueo) {
            $evento['display'] = 'background'; 
            $evento['color'] = '#ffcccc';      
            $evento['title'] = $row['lugar'];  
            $evento['extendedProps'] = [
                'esBloqueo' => true,
                'motivo' => $row['lugar']
            ];
        } else {
            $evento['title'] = $row['lugar'] . " (" . $row['num_us'] . " p.)";
            $evento['extendedProps'] = ['esBloqueo' => false];
        }

        $reservas[] = $evento;
    }
} catch (Exception $e) {
    $reservas = [];
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Panel de Reservas - Cimma</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="img/logo.png" />
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px; background-color: #03045e; }
        
        .header-container { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .user-actions { display: flex; gap: 15px; align-items: center; }

        .container { display: flex; gap: 20px; flex-wrap: wrap; }
        #calendar { flex: 1; min-width: 300px; max-width: 900px; background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        #reserva-form-container { flex: 0 0 320px; padding: 20px; border-radius: 8px; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.1); height: fit-content; }
        
        h3 { margin-top: 0; color: #333; }
        label { display: block; margin-top: 12px; font-weight: 600; font-size: 0.9em; color: #555; }
        input, select { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        select option:disabled { background-color: #e9ecef; color: #adb5bd; }
        
        input[type="submit"] { margin-top: 25px; background-color: #5F0F40; color: white; border: none; font-weight: bold; cursor: pointer; transition: background 0.3s; }
        input[type="submit"]:hover { background-color: #310A4F; }
        input[type="submit"]:disabled { background-color: #ccc; cursor: not-allowed; }
        
        /* Estilos de mensajes */
        .error { color: #721c24; font-weight: bold; margin-top: 15px; padding: 10px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px; font-size: 0.9em; display:block; }
        .success { color: #155724; font-weight: bold; margin-top: 15px; padding: 10px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 4px; font-size: 0.9em; display:block; }
        
        a.logout { text-decoration: none; color: #dc3545; font-weight: bold; padding: 8px 12px; border: 1px solid #dc3545; border-radius: 4px; transition: 0.3s; }
        a.logout:hover { background-color: #dc3545; color: white; }
        a.btn-mis-reservas { text-decoration: none; color: white; background-color: #007bff; font-weight: bold; padding: 8px 12px; border-radius: 4px; transition: 0.3s; }
        a.btn-mis-reservas:hover { background-color: #0056b3; }
    </style>
</head>
<body>

    <div class="header-container">
        <div>
            <h1 style="color: #FFFFFF">Bienvenido, <?php echo isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : 'Estudiante'; ?></h1>
            <small style="color: #FFFFFF">Gestiona tus recursos multimedia</small>
        </div>
        <div class="user-actions">
            <a href="misreservas.php" class="btn-mis-reservas">Mis Reservas</a>
            <a href="login.html" class="logout">Cerrar Sesión</a>
        </div>
    </div>

    <div class="container">
        <div id="calendar"></div>

        <div id="reserva-form-container">
            <h3>Nueva Reserva</h3>

            <form id="reserva-form">
                <label>Fecha Seleccionada:</label>
                <input type="text" id="fecha" name="fecha" readonly required style="background-color: #EBEBEB;">

                <input type="hidden" id="hora_in_full" name="hora_in">
                <input type="hidden" id="hora_fin_full" name="hora_fin">

                <label>Recurso:</label>
                <select id="titulo_base" required>
                    <option value="" disabled selected>Seleccione...</option>
                    <option value="Pantalla Verde">Pantalla Verde</option>
                    <option value="Radio">Radio</option>
                    <option value="Foto">Foto</option>
                    <option value="Mac_Selector">Mac (Elegir número)</option>
                </select>

                <div id="mac-options-container" style="display:none;">
                    <label>Número de Mac:</label>
                    <select id="mac_numero"></select>
                </div>

                <input type="hidden" id="titulo_final" name="titulo">

                <label>Cantidad de Personas (1-6):</label>
                <input type="number" id="cantidad_usuarios" name="cantidad_usuarios" min="1" max="6" value="1" required>

                <label>Hora Inicio:</label>
                <select id="hora_inicio" required></select>

                <label>Hora Fin:</label>
                <select id="hora_fin" required></select>

                <div id="mensaje-reserva"></div>
                <input type="submit" id="btn-submit" value="Confirmar Reserva">
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>

    <script>
        const HORARIOS_PHP = <?php echo json_encode(HORARIOS); ?>;
        const reservas = <?php echo json_encode($reservas) ?: '[]'; ?>;

        function obtenerTramosOcupados(fechaStr) {
            const ocupadas = new Set();
            const targetDate = fechaStr.split(" ")[0]; 
            reservas.forEach(r => {
                if (r.extendedProps && !r.extendedProps.esBloqueo) {
                    const rFecha = r.start.split(" ")[0];
                    if (rFecha === targetDate) {
                        const start = new Date(r.start.replace(" ", "T"));
                        const end = new Date(r.end.replace(" ", "T"));
                        let current = new Date(start);
                        while (current < end) {
                            const hh = String(current.getHours()).padStart(2, "0");
                            const mm = String(current.getMinutes()).padStart(2, "0");
                            ocupadas.add(`${hh}:${mm}`);
                            current.setMinutes(current.getMinutes() + 30);
                        }
                    }
                }
            });
            return ocupadas;
        }

        function generateTimeOptions(selectElement, minHour, maxHour, fechaStr) {
            selectElement.innerHTML = '<option value="" disabled selected>--:--</option>';
            const ocupados = obtenerTramosOcupados(fechaStr);
            for (let h = minHour; h <= maxHour; h++) {
                const minutos = (h === maxHour) ? ["00"] : ["00", "30"]; 
                for (let m of minutos) {
                    if (h === maxHour && m === "30") continue; 
                    const val = `${String(h).padStart(2, "0")}:${m}`;
                    const temp = new Date(`2000-01-01T${val}:00`);
                    const label = temp.toLocaleTimeString("es-ES", { hour: "numeric", minute: "2-digit", hour12: true });
                    const op = document.createElement("option");
                    op.value = val;
                    const isOccupied = ocupados.has(val);
                    op.textContent = label + (isOccupied ? " (Tu otra reserva)" : "");
                    if (selectElement.id === "hora_inicio" && isOccupied) {
                        op.disabled = true;
                    }
                    selectElement.appendChild(op);
                }
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            const calendarEl = document.getElementById("calendar");
            const formEl = document.getElementById("reserva-form");
            const mensajeEl = document.getElementById("mensaje-reserva");
            const btnSubmit = document.getElementById("btn-submit");
            
            const inputFecha = document.getElementById("fecha");
            const inputHoraInicio = document.getElementById("hora_inicio");
            const inputHoraFin = document.getElementById("hora_fin");
            
            const selectTituloBase = document.getElementById("titulo_base");
            const macContainer = document.getElementById("mac-options-container");
            const selectMacNumero = document.getElementById("mac_numero");
            const tituloFinal = document.getElementById("titulo_final");

            let selectedDate = null;

            for (let i = 1; i <= 42; i++) {
                selectMacNumero.innerHTML += `<option value="${String(i).padStart(2, "0")}">Mac ${String(i).padStart(2, "0")}</option>`;
            }

            selectTituloBase.addEventListener("change", function () {
                if (this.value === "Mac_Selector") {
                    macContainer.style.display = "block";
                    tituloFinal.value = "Mac " + selectMacNumero.value;
                } else {
                    macContainer.style.display = "none";
                    tituloFinal.value = this.value;
                }
            });

            selectMacNumero.addEventListener("change", function () {
                tituloFinal.value = "Mac " + this.value;
            });

            const calendar = new FullCalendar.Calendar(calendarEl, {
                locale: "es",
                initialView: "dayGridMonth",
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                selectable: true,
                events: reservas, 
                dateClick(info) {
                    mensajeEl.textContent = "";
                    mensajeEl.className = "";
                    inputHoraInicio.innerHTML = "";
                    inputHoraFin.innerHTML = "";
                    btnSubmit.disabled = false;

                    const dia = info.date.getDay(); 
                    if (dia === 0) {
                        mensajeEl.textContent = "Lo sentimos, no abrimos los domingos.";
                        mensajeEl.className = "error";
                        btnSubmit.disabled = true;
                        return;
                    }

                    const fechaClicStr = info.dateStr; 
                    const bloqueoEncontrado = reservas.find(r => {
                        return r.extendedProps && 
                               r.extendedProps.esBloqueo && 
                               r.start.includes(fechaClicStr); 
                    });

                    if (bloqueoEncontrado) {
                        inputFecha.value = fechaClicStr;
                        mensajeEl.textContent = "FECHA BLOQUEADA: " + bloqueoEncontrado.extendedProps.motivo;
                        mensajeEl.className = "error";
                        btnSubmit.disabled = true; 
                        return;
                    }

                    const hoy = new Date();
                    hoy.setHours(0, 0, 0, 0);
                    const fechaClic = new Date(info.dateStr + "T00:00:00");
                    if (fechaClic < hoy) {
                        mensajeEl.textContent = "No puedes reservar en el pasado.";
                        mensajeEl.className = "error";
                        return;
                    }

                    selectedDate = info.dateStr;
                    inputFecha.value = selectedDate;

                    const horarioDia = HORARIOS_PHP[dia];
                    generateTimeOptions(inputHoraInicio, horarioDia.inicio_h, horarioDia.fin_h, selectedDate);
                    generateTimeOptions(inputHoraFin, horarioDia.inicio_h, horarioDia.fin_h, selectedDate);
                }
            });
            calendar.render();

            formEl.addEventListener("submit", function (e) {
                e.preventDefault();

                if (!selectedDate) {
                    mensajeEl.textContent = "Selecciona un día en el calendario.";
                    mensajeEl.className = "error";
                    return;
                }
                
                if(!tituloFinal.value && selectTituloBase.value !== "Mac_Selector") {
                      tituloFinal.value = selectTituloBase.value;
                }

                document.getElementById("hora_in_full").value = `${selectedDate} ${inputHoraInicio.value}:00`;
                document.getElementById("hora_fin_full").value = `${selectedDate} ${inputHoraFin.value}:00`;

                mensajeEl.textContent = "Verificando...";
                mensajeEl.className = "";

                const formData = new FormData(formEl);

                fetch("", { method: "POST", body: formData })
                    .then(res => res.text())
                    .then(text => {
                        if (text.includes("Error")) {
                            mensajeEl.textContent = text;
                            mensajeEl.className = "error";
                        } else {
                            mensajeEl.textContent = "¡Reserva Exitosa! Recargando...";
                            mensajeEl.className = "success";
                            setTimeout(() => {
                                window.location.href = window.location.href;
                            }, 1500);
                        }
                    })
                    .catch(err => {
                        mensajeEl.textContent = "Error de conexión con el servidor.";
                        mensajeEl.className = "error";
                        console.error(err);
                    });
            });
        });
    </script>
</body>
</html>