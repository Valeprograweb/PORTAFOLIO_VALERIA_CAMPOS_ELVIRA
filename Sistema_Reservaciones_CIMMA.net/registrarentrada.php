<?php
// OBUFER: Activa el búfer de salida
ob_start();

// Anti-caché para asegurar que siempre cargue el estado real
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

session_start();

// Verificar admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.html");
    exit;
}

include('conn.php');

// Habilitar reporte de errores
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($servername, $username, $password, $database);
    $conn->set_charset("utf8mb4");

    // --- 1. CONFIGURACIÓN CRÍTICA DE ZONA HORARIA ---
    // Esto alinea a PHP y MySQL con tu hora local para que la cancelación funcione exacto.
    date_default_timezone_set('America/Mexico_City'); 
    $ahora_mysql = (new DateTime())->format("P"); 
    $conn->query("SET time_zone = '$ahora_mysql'");

} catch (mysqli_sql_exception $e) {
    die("Error de conexión: " . $e->getMessage());
}

$mensaje = "";
$hoy = date('Y-m-d');

// ==========================================
// 2. AUTO-CANCELACIÓN AUTOMÁTICA
// ==========================================
// Esta consulta se ejecuta SIEMPRE al abrir la página.
// Busca reservas de HOY que sigan "Pendientes" y cuya hora de inicio + 10 min ya pasó.
// Les cambia el estado a "Cancelada (No asistió)" permanentemente en la BD.

$sql_auto_cancel = "UPDATE reservas 
                    SET estado = 'Cancelada (No asistió)' 
                    WHERE fecha = ? 
                    AND (estado = 'Ninguna' OR estado IS NULL OR estado = 'Pendiente' OR estado = '') 
                    AND usuario != 'BLOQUEO ADMIN'
                    AND ADDTIME(hora_in, '00:10:00') < CURTIME()";

$stmt_auto = $conn->prepare($sql_auto_cancel);
$stmt_auto->bind_param("s", $hoy);
$stmt_auto->execute();
$stmt_auto->close();


// ==========================================
// 3. PROCESAR EL BOTÓN (Si el admin confirma a tiempo)
// ==========================================
if (isset($_POST['procesar_entrada'])) {
    $id_reserva = $_POST['id_reserva'];
    
    // Verificamos una última vez la hora exacta del clic
    $stmt = $conn->prepare("SELECT fecha, hora_in FROM reservas WHERE id_reserva = ?");
    $stmt->bind_param("i", $id_reserva);
    $stmt->execute();
    $reserva = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($reserva) {
        $fechaHoraReserva = new DateTime($reserva['fecha'] . ' ' . $reserva['hora_in']);
        $ahora = new DateTime(); 
        
        $limiteTolerancia = clone $fechaHoraReserva;
        $limiteTolerancia->modify('+10 minutes');

        if ($ahora > $limiteTolerancia) {
            // Si por alguna razón dio clic tarde
            $nuevo_estado = "Cancelada (Retardo)";
            $tipo_clase = "error"; 
            $texto_msg = "Tiempo agotado. La reserva se ha cancelado.";
        } else {
            // Si está a tiempo
            $nuevo_estado = "Activa";
            $tipo_clase = "success";
            $texto_msg = "Entrada registrada. Reserva Activa.";
        }

        $update = $conn->prepare("UPDATE reservas SET estado = ? WHERE id_reserva = ?");
        $update->bind_param("si", $nuevo_estado, $id_reserva);
        
        if ($update->execute()) {
            // Recargamos para ver el cambio en la tabla
            header("Location: registrarentrada.php");
            exit;
        } else {
            $mensaje = "<p class='error'>Error al actualizar: " . $conn->error . "</p>";
        }
        $update->close();
    }
}

// ==========================================
// 4. OBTENER LISTA PARA LA TABLA
// ==========================================
// Traemos TODAS las de hoy. Como el UPDATE de arriba ya corrió, 
// las vencidas vendrán ya con el estado "Cancelada (No asistió)".
$sql_lista = "SELECT * FROM reservas 
              WHERE fecha = '$hoy' 
              AND usuario != 'BLOQUEO ADMIN'
              ORDER BY hora_in ASC";

$reservas_hoy = $conn->query($sql_lista);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Registrar Entrada - Cimma</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png" />
    <style>
        body { font-family: 'Segoe UI', sans-serif; padding: 20px; background-color: #03045E; }
        h1 { color: #FFF; } 
        
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); max-width: 1100px; margin: 0 auto; }
        
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #007bff; color: white; }
        tr:hover { background-color: #f1f1f1; }
        
        .btn { padding: 8px 15px; border-radius: 4px; text-decoration: none; color: white; font-weight: bold; border: none; cursor: pointer; display: inline-block;}
        .btn-checkin { background-color: #28a745; }
        .btn-checkin:hover { background-color: #218838; }
        
        .btn-back { background-color: #6c757d; margin-bottom: 20px; }
        .btn-back:hover { background-color: #5a6268; }

        .success { color: #155724; background-color: #d4edda; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; }
        .error { color: #721c24; background-color: #f8d7da; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; }
        
        .time-tag { background: #eee; padding: 2px 6px; border-radius: 4px; font-weight: bold; color: #333; }
        
        /* Colores de estado */
        .estado-activa { color: green; font-weight: bold; }
        .estado-cancelada { color: red; font-weight: bold; }
        .estado-pendiente { color: #ffc107; font-weight: bold; }
    </style>
</head>
<body>

    <div style="max-width: 1100px; margin: 0 auto;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <a href="admin.php" class="btn btn-back">← Volver al Panel</a>
            <span style="color:white; opacity:0.8; font-size:0.9em;">
                Hora Sistema: <?php echo date('H:i'); ?>
            </span>
        </div>
        
        <h1 style="text-align:center; margin-bottom: 20px;">Registro de Entradas (Hoy)</h1>
        
        <?php echo $mensaje; ?>

        <div class="card">
            <?php if ($reservas_hoy->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Horario</th>
                            <th>Usuario / Matrícula</th>
                            <th>Lugar / Recurso</th>
                            <th>Estado Actual</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $reservas_hoy->fetch_assoc()): 
                            // Determinamos qué texto mostrar en "Estado"
                            $estado_db = !empty($row['estado']) ? $row['estado'] : 'Pendiente';
                            
                            // Asignamos color según el estado
                            $clase_estado = "";
                            if(strpos($estado_db, 'Activa') !== false) {
                                $clase_estado = "estado-activa";
                            } elseif(strpos($estado_db, 'Cancelada') !== false) {
                                $clase_estado = "estado-cancelada";
                            } else {
                                $clase_estado = "estado-pendiente";
                            }
                        ?>
                        <tr>
                            <td>
                                <span class="time-tag">
                                    <?php echo date('H:i', strtotime($row['hora_in'])); ?> - 
                                    <?php echo date('H:i', strtotime($row['hora_fin'])); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($row['usuario']); ?></td>
                            <td><?php echo htmlspecialchars($row['lugar']); ?></td>
                            
                            <td class="<?php echo $clase_estado; ?>">
                                <?php echo htmlspecialchars($estado_db); ?>
                            </td>
                            
                            <td>
                                <?php if($estado_db == 'Pendiente' || $estado_db == 'Ninguna' || $estado_db == ''): ?>
                                    <form method="POST">
                                        <input type="hidden" name="id_reserva" value="<?php echo $row['id_reserva']; ?>">
                                        <button type="submit" name="procesar_entrada" class="btn btn-checkin">
                                            Confirmar Entrada
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span style="color:#999; font-size:0.9em;">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div style="text-align:center; padding: 40px; color: #666;">
                    <h3>No hay reservas para el día de hoy.</h3>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
<?php
$conn->close();
ob_end_flush();
?>