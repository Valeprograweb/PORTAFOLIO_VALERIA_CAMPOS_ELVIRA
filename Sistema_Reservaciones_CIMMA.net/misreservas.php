<?php
// OBUFER: Activa el búfer de salida
ob_start();

// Anti-caché
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

session_start();

// 1. VERIFICACIÓN: Que sea estudiante
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'estudiante') {
    header("Location: login.html"); // Asegúrate que sea .html o .php según tu archivo real
    exit;
}

include('conn.php');

// Habilitar reporte de errores
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($servername, $username, $password, $database);
    $conn->set_charset("utf8mb4");

    // --- 2. ZONA HORARIA (CRÍTICO) ---
    date_default_timezone_set('America/Mexico_City'); 
    $ahora_mysql = (new DateTime())->format("P"); 
    $conn->query("SET time_zone = '$ahora_mysql'");

} catch (mysqli_sql_exception $e) {
    die("Error de conexión: " . $e->getMessage());
}

$mensaje = "";
$usuario_actual = $_SESSION['usuario'];
$hoy = date('Y-m-d');

// ==========================================
// 3. AUTO-CANCELACIÓN (Mantenimiento Automático)
// ==========================================
// Si el alumno entra y tiene una reserva vencida de hoy, se marca como No Asistió.
$sql_auto_cancel = "UPDATE reservas 
                    SET estado = 'Cancelada (No asistió)' 
                    WHERE fecha = ? 
                    AND (estado = 'Ninguna' OR estado IS NULL OR estado = 'Pendiente' OR estado = '') 
                    AND usuario = ? 
                    AND ADDTIME(hora_in, '00:10:00') < CURTIME()";

$stmt_auto = $conn->prepare($sql_auto_cancel);
$stmt_auto->bind_param("ss", $hoy, $usuario_actual);
$stmt_auto->execute();
$stmt_auto->close();

// ==========================================
// 4. LÓGICA DE ELIMINAR (Cancelar Manualmente)
// ==========================================
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    
    try {
        // Solo permitimos borrar si es SU reserva
        // Nota: Al borrar, se libera el espacio para otro alumno.
        $stmt = $conn->prepare("DELETE FROM reservas WHERE id_reserva = ? AND usuario = ?");
        $stmt->bind_param("is", $id, $usuario_actual);
        
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            header("Location: misreservas.php?status=success");
            exit; 
        } else {
            $mensaje = "<p class='error'>No se pudo eliminar la reserva (Quizás ya fue procesada).</p>";
        }
        $stmt->close();
    } catch (Exception $e) {
        $mensaje = "<p class='error'>Error al eliminar: " . $e->getMessage() . "</p>";
    }
}

if (isset($_GET['status']) && $_GET['status'] == 'success') {
    $mensaje = "<p class='success'>Reserva cancelada y espacio liberado.</p>";
}

// ==========================================
// 5. OBTENER MIS RESERVAS (Con Estado)
// ==========================================
$stmt_list = $conn->prepare("SELECT id_reserva, fecha, hora_in, hora_fin, lugar, num_us, estado FROM reservas WHERE usuario = ? ORDER BY fecha DESC, hora_in DESC");
$stmt_list->bind_param("s", $usuario_actual);
$stmt_list->execute();
$result = $stmt_list->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Mis Reservas - Cimma</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png" />
    <style>
        body { font-family: 'Segoe UI', sans-serif; padding: 20px; background-color: #03045E; }
        
        .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        h1 { color: #FFF; margin: 0; }
        
        table { border-collapse: collapse; width: 100%; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #007bff; color: white; }
        tr:hover { background-color: #f1f1f1; }
        
        /* Botones */
        a.btn-delete { text-decoration: none; color: white; background-color: #dc3545; padding: 6px 12px; border-radius: 4px; font-size: 0.9em; transition: 0.2s; display:inline-block;}
        a.btn-delete:hover { background-color: #c82333; }
        
        a.btn-back { text-decoration: none; color: white; background-color: #6c757d; padding: 8px 15px; border-radius: 4px; font-weight: bold; margin-right: 10px; }
        a.btn-back:hover { background-color: #5a6268; }

        .success { color: #155724; background-color: #d4edda; padding: 10px; border-radius: 5px; margin-bottom: 15px; }
        .error { color: #721c24; background-color: #f8d7da; padding: 10px; border-radius: 5px; margin-bottom: 15px; }
        .empty { text-align: center; padding: 20px; color: #777; font-style: italic; }

        /* Colores de Estado */
        .estado-activa { color: green; font-weight: bold; background-color: #d4edda; padding: 2px 6px; border-radius: 4px; }
        .estado-cancelada { color: #721c24; font-weight: bold; background-color: #f8d7da; padding: 2px 6px; border-radius: 4px; }
        .estado-pendiente { color: #856404; font-weight: bold; background-color: #fff3cd; padding: 2px 6px; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="header-flex">
        <h1>Mis Reservas</h1>
        <div>
            <a href="estudiante.php" class="btn-back">Volver al Calendario</a>
        </div>
    </div>

    <?php echo $mensaje; ?>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Inicio</th>
                <th>Final</th>
                <th>Recurso</th>
                <th>Estado</th> <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): 
                    // Lógica visual del Estado
                    $estado_db = !empty($row['estado']) ? $row['estado'] : 'Pendiente';
                    $clase_estado = "estado-pendiente";

                    if (strpos($estado_db, 'Activa') !== false) {
                        $clase_estado = "estado-activa";
                    } elseif (strpos($estado_db, 'Cancelada') !== false) {
                        $clase_estado = "estado-cancelada";
                    }

                    // Lógica para permitir cancelar
                    // Solo puede cancelar si NO está cancelada y si la fecha es futura (o presente no vencida)
                    $puede_cancelar = false;
                    $inicio_reserva = new DateTime($row['fecha'] . ' ' . $row['hora_in']);
                    $ahora = new DateTime();
                    
                    // Si el estado es "Pendiente" o "Ninguna" y aun no ha pasado la hora de inicio
                    if (($estado_db == 'Pendiente' || $estado_db == 'Ninguna') && $inicio_reserva > $ahora) {
                        $puede_cancelar = true;
                    }
                ?>
                <tr>
                    <td><?php echo date('d/m/Y', strtotime($row['fecha'])); ?></td>
                    <td><?php echo date('H:i', strtotime($row['hora_in'])); ?></td>
                    <td><?php echo date('H:i', strtotime($row['hora_fin'])); ?></td>      
                    <td><?php echo htmlspecialchars($row['lugar']); ?></td>
                    
                    <td>
                        <span class="<?php echo $clase_estado; ?>">
                            <?php echo htmlspecialchars($estado_db); ?>
                        </span>
                    </td>

                    <td>
                        <?php if($puede_cancelar): ?>
                            <a href="misreservas.php?eliminar=<?php echo $row['id_reserva']; ?>" 
                               class="btn-delete"
                               onclick="return confirm('¿Seguro que deseas cancelar tu reserva? Esto liberará el espacio.');">
                               Cancelar
                            </a>
                        <?php else: ?>
                            <span style="color:#999; font-size:0.8em;">-</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="empty">No tienes reservas registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
<?php
// Limpieza final
$stmt_list->close();
$conn->close();
ob_end_flush();
?>