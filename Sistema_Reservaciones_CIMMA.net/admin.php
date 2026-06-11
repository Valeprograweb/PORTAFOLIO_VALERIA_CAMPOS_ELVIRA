<?php
// OBUFER: Activa el búfer de salida
ob_start();

// Anti-caché
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
} catch (mysqli_sql_exception $e) {
    die("Error de conexión: " . $e->getMessage());
}

$mensaje = "";

// ==========================================
// 1. LÓGICA DE USUARIOS
// ==========================================

// Eliminar Usuario
if (isset($_GET['eliminar_usuario'])) {
    $id_user = intval($_GET['eliminar_usuario']);
    if (isset($_SESSION['id_usuario']) && $id_user == $_SESSION['id_usuario']) {
        $mensaje = "<p class='error'>No puedes eliminar tu propia cuenta mientras está activa.</p>";
    } else {
        try {
            $stmt = $conn->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
            $stmt->bind_param("i", $id_user);
            if ($stmt->execute()) {
                header("Location: admin.php?status=user_deleted");
                exit;
            }
        } catch (Exception $e) {
            $mensaje = "<p class='error'>Error al eliminar usuario: " . $e->getMessage() . "</p>";
        }
    }
}

// Guardar Usuario
if (isset($_POST['guardar_usuario'])) {
    $id_user = isset($_POST['id_user']) ? intval($_POST['id_user']) : 0;
    $matricula = trim($_POST['matricula']);
    $nom = trim($_POST['nom']);
    $app = trim($_POST['app']);
    $rol_user = $_POST['rol_usuario'];
    $pass_user = $_POST['password_usuario'];
    $incidencia = trim($_POST['incidencia']);

    if (!empty($matricula) && !empty($nom)) {
        try {
            if ($id_user > 0) {
                // --- MODIFICAR ---
                if (!empty($pass_user)) {
                    $hash = password_hash($pass_user, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("UPDATE usuarios SET matricula = ?, nom = ?, app = ?, pass = ?, rol = ?, incidencia = ? WHERE id_usuario = ?");
                    $stmt->bind_param("ssssssi", $matricula, $nom, $app, $hash, $rol_user, $incidencia, $id_user);
                } else {
                    $stmt = $conn->prepare("UPDATE usuarios SET matricula = ?, nom = ?, app = ?, rol = ?, incidencia = ? WHERE id_usuario = ?");
                    $stmt->bind_param("sssssi", $matricula, $nom, $app, $rol_user, $incidencia, $id_user);
                }
                $accion = "modificado";
            } else {
                // --- CREAR ---
                if (!empty($pass_user)) {
                    $hash = password_hash($pass_user, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO usuarios (matricula, nom, app, pass, rol, incidencia) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssssss", $matricula, $nom, $app, $hash, $rol_user, $incidencia);
                    $accion = "creado";
                } else {
                    throw new Exception("La contraseña es obligatoria para nuevos usuarios.");
                }
            }
            if ($stmt->execute()) {
                header("Location: admin.php?status=user_saved&accion=" . $accion);
                exit;
            }
            $stmt->close();
        } catch (Exception $e) {
            if ($conn->errno == 1062) {
                $mensaje = "<p class='error'>Error: Esa matrícula ya está registrada.</p>";
            } else {
                $mensaje = "<p class='error'>Error al guardar usuario: " . $e->getMessage() . "</p>";
            }
        }
    } else {
        $mensaje = "<p class='error'>Faltan datos obligatorios.</p>";
    }
}

// Cargar datos para editar usuario
$usuario_editar = null;
if (isset($_GET['editar_usuario'])) {
    $id_edit = intval($_GET['editar_usuario']);
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
    $stmt->bind_param("i", $id_edit);
    $stmt->execute();
    $res_edit = $stmt->get_result();
    $usuario_editar = $res_edit->fetch_assoc();
    $stmt->close();
}

// ==========================================
// 2. LÓGICA DE BLOQUEO DE FECHAS
// ==========================================

if (isset($_POST['bloquear_fecha'])) {
    $fecha_bloqueo = $_POST['fecha_bloqueo'];
    $hora_in_bloqueo = $_POST['hora_in_bloqueo'];
    $hora_fin_bloqueo = $_POST['hora_fin_bloqueo'];
    $motivo = trim($_POST['motivo_bloqueo']); 
    
    if ($hora_fin_bloqueo <= $hora_in_bloqueo) {
        $mensaje = "<p class='error'>La hora final debe ser posterior a la inicial.</p>";
    } else {
        try {
            // 1. Eliminar reservas de usuarios normales
            $stmt_del = $conn->prepare("DELETE FROM reservas WHERE fecha = ? AND usuario != 'BLOQUEO ADMIN'");
            $stmt_del->bind_param("s", $fecha_bloqueo);
            $stmt_del->execute();
            $stmt_del->close();

            // 2. Insertar el bloqueo
            $usuario_bloqueo = "BLOQUEO ADMIN";
            $num_us_bloqueo = 0;
            
            $stmt = $conn->prepare("INSERT INTO reservas (usuario, fecha, hora_in, hora_fin, lugar, num_us) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssi", $usuario_bloqueo, $fecha_bloqueo, $hora_in_bloqueo, $hora_fin_bloqueo, $motivo, $num_us_bloqueo);
            
            if ($stmt->execute()) {
                header("Location: admin.php?status=date_blocked");
                exit;
            }
            $stmt->close();
        } catch (Exception $e) {
            $mensaje = "<p class='error'>Error al bloquear fecha: " . $e->getMessage() . "</p>";
        }
    }
}

// ==========================================
// 3. LÓGICA DE ELIMINAR RESERVAS
// ==========================================
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    try {
        $stmt = $conn->prepare("DELETE FROM reservas WHERE id_reserva = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header("Location: admin.php?status=success");
            exit; 
        }
        $stmt->close();
    } catch (Exception $e) {
        $mensaje = "<p class='error'>Error al eliminar: " . $e->getMessage() . "</p>";
    }
}

// MENSAJES DE ESTADO
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'success') $mensaje = "<p class='success'>Registro eliminado correctamente.</p>";
    if ($_GET['status'] == 'user_deleted') $mensaje = "<p class='success'>Usuario eliminado correctamente.</p>";
    if ($_GET['status'] == 'user_saved') $mensaje = "<p class='success'>Usuario guardado correctamente.</p>";
    if ($_GET['status'] == 'date_blocked') $mensaje = "<p class='success' style='background-color:#ffeeba; color:#856404;'>Fecha bloqueada. Se han cancelado las reservas de alumnos para ese día.</p>";
}

// OBTENER DATOS (SE AGREGÓ 'estado' A LA CONSULTA)
$reservas = $conn->query("SELECT id_reserva, usuario, fecha, hora_in, hora_fin, lugar, num_us, estado FROM reservas ORDER BY fecha DESC, hora_in ASC");
$lista_usuarios = $conn->query("SELECT * FROM usuarios ORDER BY id_usuario ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Panel de Administración - Cimma</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png" />
    <style>
        body { font-family: 'Segoe UI', sans-serif; padding: 20px; background-color: #03045E; }
        h1 { color: #FFF; } 
        h2, h3 { color: #333; }
        
        /* Tablas */
        table { border-collapse: collapse; width: 100%; margin: 20px 0; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #007bff; color: white; }
        tr:hover { background-color: #f1f1f1; }
        
        /* Estilo especial para filas bloqueadas */
        tr.bloqueado { background-color: #ffe6e6; border-left: 5px solid #dc3545; }
        tr.bloqueado td { color: #721c24; font-weight: bold; }
        
        /* Botones */
        .btn { padding: 5px 10px; border-radius: 4px; text-decoration: none; color: white; font-size: 0.9em; display: inline-block; cursor:pointer; border:none;}
        .btn-delete { background-color: #dc3545; }
        .btn-delete:hover { background-color: #c82333; }
        .btn-edit { background-color: #ffc107; color: #333; }
        .btn-edit:hover { background-color: #e0a800; }
        .btn-save { background-color: #2975AB; padding: 10px 20px; font-size: 1em; }
        .btn-block { background-color: #6c757d; padding: 10px 20px; font-size: 1em; }
        .btn-block:hover { background-color: #5a6268; }

        /* Mensajes */
        .success { color: #155724; background-color: #d4edda; padding: 10px; border-radius: 5px; margin-bottom: 15px; }
        .error { color: #721c24; background-color: #f8d7da; padding: 10px; border-radius: 5px; margin-bottom: 15px; }

        /* Contenedores de Formularios */
        .admin-panel { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        
        @media(max-width: 900px) { .admin-panel { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h1>Panel de Administración</h1>
        <div>
            <a href="registrarentrada.php" class="btn" style="background-color: #007bff; margin-right: 15px; font-weight:bold;">
                Registrar Entrada
            </a>
            
            <a href="dopdf.php" target="_blank" class="btn" style="background-color: #17a2b8; margin-right: 15px; font-weight:bold;">
                Mostrar Estadísticas
            </a>
            <a href="login.html" style="color:red; font-weight:bold; text-decoration:none;">Cerrar sesión</a>
        </div>
    </div>

    <?php echo $mensaje; ?>

    <div class="admin-panel">
        
        <div class="card">
            <h2><?php echo $usuario_editar ? 'Editar Usuario' : 'Gestión de Usuarios'; ?></h2>
            <form method="POST" action="admin.php">
                <input type="hidden" name="id_user" value="<?php echo $usuario_editar ? $usuario_editar['id_usuario'] : ''; ?>">
                
                <div class="form-group">
                    <label>Matrícula:</label>
                    <input type="text" name="matricula" value="<?php echo $usuario_editar ? htmlspecialchars($usuario_editar['matricula']) : ''; ?>" required placeholder="Ej: 186719">
                </div>
                
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                    <div class="form-group">
                        <label>Nombre:</label>
                        <input type="text" name="nom" value="<?php echo $usuario_editar ? htmlspecialchars($usuario_editar['nom']) : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Apellido:</label>
                        <input type="text" name="app" value="<?php echo $usuario_editar ? htmlspecialchars($usuario_editar['app']) : ''; ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Rol:</label>
                    <select name="rol_usuario">
                        <option value="estudiante" <?php echo ($usuario_editar && $usuario_editar['rol'] == 'estudiante') ? 'selected' : ''; ?>>Estudiante</option>
                        <option value="admin" <?php echo ($usuario_editar && $usuario_editar['rol'] == 'admin') ? 'selected' : ''; ?>>Administrador</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Incidencia / Reporte (Opcional):</label>
                    <textarea name="incidencia" rows="3" placeholder="Ej: Entregó material tarde, Mal comportamiento..."><?php echo $usuario_editar ? htmlspecialchars($usuario_editar['incidencia']) : ''; ?></textarea>
                </div>

                <div class="form-group">
                    <label>Contraseña <?php echo $usuario_editar ? '(Opcional)' : ''; ?>:</label>
                    <input type="password" name="password_usuario" <?php echo $usuario_editar ? '' : 'required'; ?> placeholder="********">
                </div>
                
                <button type="submit" name="guardar_usuario" class="btn btn-save" style="width:100%">
                    <?php echo $usuario_editar ? 'Actualizar Usuario' : 'Registrar Usuario'; ?>
                </button>
                <?php if($usuario_editar): ?>
                    <a href="admin.php" style="display:block; text-align:center; margin-top:10px; color:#666;">Cancelar edición</a>
                <?php endif; ?>
            </form>
            
            <h3 style="margin-top:20px; border-top:1px solid #eee; padding-top:10px;">Usuarios Registrados</h3>
            <div style="max-height: 200px; overflow-y: auto;">
                <table style="margin:0;">
                    <thead>
                        <tr>
                            <th>Matrícula</th>
                            <th>Nombre</th>
                            <th>Incidencias</th> <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($u = $lista_usuarios->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($u['matricula']); ?></td>
                            <td><?php echo htmlspecialchars($u['nom']); ?></td>
                            <td style="font-size:0.85em; color:<?php echo !empty($u['incidencia']) ? 'red' : '#999'; ?>;">
                                <?php echo !empty($u['incidencia']) ? htmlspecialchars($u['incidencia']) : 'Ninguna'; ?>
                            </td>
                            <td>
                                <a href="admin.php?editar_usuario=<?php echo $u['id_usuario']; ?>" class="btn btn-edit" style="padding:2px 5px;">✎</a>
                                <a href="admin.php?eliminar_usuario=<?php echo $u['id_usuario']; ?>" 
                                   class="btn btn-delete" style="padding:2px 5px;"
                                   onclick="return confirm('¿Borrar a <?php echo $u['nom']; ?>?');">✖</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card" style="background-color: #fdfdfe; border-left: 4px solid #6c757d;">
            <h2> Bloquear Horario / Fecha</h2>
            <p style="font-size:0.9em; color:#666;">Utilice esto para cerrar el laboratorio por mantenimiento o días festivos. <b>Al aplicar, se cancelarán todas las reservas existentes de ese día.</b></p>
            
            <form method="POST" action="admin.php">
                <div class="form-group">
                    <label>Fecha a bloquear:</label>
                    <input type="date" name="fecha_bloqueo" required min="<?php echo date('Y-m-d'); ?>">
                </div>
                
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                    <div class="form-group">
                        <label>Desde:</label>
                        <input type="time" name="hora_in_bloqueo" required value="07:00">
                    </div>
                    <div class="form-group">
                        <label>Hasta:</label>
                        <input type="time" name="hora_fin_bloqueo" required value="20:00">
                    </div>
                </div>

                <div class="form-group">
                    <label>Motivo (Aparecerá en la lista):</label>
                    <input type="text" name="motivo_bloqueo" required placeholder="Ej: Mantenimiento, Día Festivo, Inventario...">
                </div>

                <button type="submit" name="bloquear_fecha" class="btn btn-block" style="width:100%" onclick="return confirm('ATENCIÓN: Esto borrará todas las reservas de alumnos en esa fecha. ¿Continuar?');">
                     Aplicar Bloqueo y Limpiar Día
                </button>
            </form>
        </div>

    </div>

    <h2 style="color: #FFF;">Calendario de Actividades y Reservas</h2>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Horario</th>
                <th>Tipo</th>
                <th>Usuario / Matrícula</th>
                <th>Lugar / Motivo</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $reservas->fetch_assoc()): 
                // Detectar si es un bloqueo administrativo
                $es_bloqueo = ($row['usuario'] == 'BLOQUEO ADMIN');
                $clase_fila = $es_bloqueo ? 'bloqueado' : '';
                
                // Lógica de color para el estado
                $estado_texto = !empty($row['estado']) ? $row['estado'] : 'Pendiente';
                $estilo_estado = "font-weight:bold; color:#f0ad4e;"; // Amarillo/Naranja por defecto
                
                if (strpos($estado_texto, 'Activa') !== false) {
                    $estilo_estado = "font-weight:bold; color:green;";
                } elseif (strpos($estado_texto, 'Cancelada') !== false) {
                    $estilo_estado = "font-weight:bold; color:red;";
                }
                
                if($es_bloqueo) {
                    $estado_texto = "N/A";
                    $estilo_estado = "color:#666;";
                }
            ?>
            <tr class="<?php echo $clase_fila; ?>">
                <td><?php echo date('d/m/Y', strtotime($row['fecha'])); ?></td>
                <td>
                    <?php echo date('H:i', strtotime($row['hora_in'])) . ' - ' . date('H:i', strtotime($row['hora_fin'])); ?>
                </td>
                <td>
                    <?php if($es_bloqueo): ?>
                        <span style="background:black; color:white; padding:2px 6px; border-radius:4px; font-size:0.8em;">BLOQUEO</span>
                    <?php else: ?>
                        <span style="background:#28a745; color:white; padding:2px 6px; border-radius:4px; font-size:0.8em;">RESERVA</span>
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($row['usuario']); ?></td>       
                <td><?php echo htmlspecialchars($row['lugar']); ?></td>
                
                <td style="<?php echo $estilo_estado; ?>">
                    <?php echo htmlspecialchars($estado_texto); ?>
                </td>
                
                <td>
                    <a href="admin.php?eliminar=<?php echo $row['id_reserva']; ?>" 
                       class="btn btn-delete"
                       onclick="return confirm('¿Seguro que desea eliminar <?php echo $es_bloqueo ? "este bloqueo" : "esta reserva"; ?>?');">
                       Eliminar
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
<?php
// Limpieza final
$conn->close();
ob_end_flush();
?>