<?php
include('conn2.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seleccionar Materias</title>
</head>
<style>
    .btn-regresar {
            display: inline-block;
            background: #f7b731;
            color: #000;
            padding: 10px 20px;
            margin: 10px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }

    .btn-regresar:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

    .btn-regresar:active {
            transform: translateY(0);
            box-shadow: none;
        }
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    text-align: center;
}
.contenedor {
    width: 60%;
    margin: auto;
    background: #fff;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 0 10px #999;
}
.btn {
    display: inline-block;
    background: #f7b731;
    color: #000;
    padding: 10px 20px;
    margin: 10px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
}
select, input {
    width: 70%;
    padding: 5px;
    margin: 5px;
}
table {
    width: 100%;
    border-collapse: collapse;
}
th, td {
    border: 1px solid #999;
    padding: 8px;
}
th {
    background: #f7b731;
}

</style>
<body>
<div class="contenedor">
    <h2>Selección de Materias Primavera 2026</h2>

    <form action="guardar.php" method="post">
        <label>Matrícula:</label>
        <input type="text" name="matricula" required>
        </br><label>Nombre:</label>
        <input type="text" name="nombre" required>
        </br><label>Promedio:</label>
        <input type="number" step="0.1" name="promedio" min="0" max="10" required>
        </br><label>¿Está condicionado?</label>
        <select name="condicionado">
            <option value="No">No</option>
            <option value="Si">Sí</option>
        </select>

        <hr>
        <h3>Seleción de materias (elige 6)</h3>
        <?php
        $materias = $conn->query("SELECT * FROM materias ORDER BY semestre, nombre");
        for ($i = 1; $i <= 6; $i++) {
            echo "<select name='materia_regular_$i' required>";
            echo "<option value=''>-- Selecciona materia --</option>";
            mysqli_data_seek($materias, 0);
            while ($row = $materias->fetch_assoc()) {
                echo "<option value='{$row['nombre']}'>{$row['nombre']}</option>";
            }
            echo "</select><br>";
        }
        ?>
        <hr>
        <h3>Materias adicionales</h3>
        <?php
        for ($i = 1; $i <= 2; $i++) {
            echo "<select name='materia_extra_$i'>";
            echo "<option value=''>-- Opcional --</option>";
            mysqli_data_seek($materias, 0);
            while ($row = $materias->fetch_assoc()) {
                echo "<option value='{$row['nombre']}'>{$row['nombre']}</option>";
            }
            echo "</select><br>";
        }
        ?>

        <button type="submit" class="btn">Enviar</button>
                     
		<a href='exam.html' class="btn">Regresar</a>
    </form>
</div>
</body>
</html>
