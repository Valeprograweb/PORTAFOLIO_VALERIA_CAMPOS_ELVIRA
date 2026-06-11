<html>
<head>
<title>Reto 2</title>
<meta charset="UTF-8"> 
</head>
<body>
<h1>Reto 2</h1>
<?php
include 'conn.php';
// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['identi'];
$opc = $_POST['opcion'];

echo "ID ingresado: " . $id . "<br>";
echo "Opción seleccionada: " . $opc . "<br>";


switch ($opc) {
    case 1:
        echo "Seleccionaste: Alta";
       $sql = "INSERT INTO MyGuests (id, firstname, lastname, email)
                VALUES ('$id', 'John', 'Doe', 'john@example.com')";

        if ($conn->query($sql) === TRUE) {
            echo "<br>Registro insertado correctamente. <br>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        break;
        
    case 2:
        echo "Seleccionaste: Baja<br>";
        $sql = "DELETE FROM MyGuests WHERE id=".$id;
        if ($conn->query($sql) === TRUE) {
            echo "<br>Registro dado de baja correctamente. <br>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        break;
    case 3:
        echo "Seleccionaste: Consulta";

        $sql = "SELECT id, firstname, lastname FROM MyGuests WHERE id=".$id;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Apellido</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["firstname"] . "</td>";
        echo "<td>" . $row["lastname"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo " Registro no encontrado";
}

        break;
case 4:
    echo "Seleccionaste: Modificación<br>";

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];

    // Verificamos qué campos fueron enviados y actualizamos solo esos
    if (!empty($firstname)) {
        $sql1 = "UPDATE MyGuests SET firstname='$firstname' WHERE id='$id'";
        if ($conn->query($sql1) === TRUE) {
            echo "Nombre actualizado.<br>";
        } else {
            echo "Error al actualizar nombre: " . $conn->error . "<br>";
        }
    }

    if (!empty($lastname)) {
        $sql2 = "UPDATE MyGuests SET lastname='$lastname' WHERE id='$id'";
        if ($conn->query($sql2) === TRUE) {
            echo "Apellido actualizado.<br>";
        } else {
            echo "Error al actualizar apellido: " . $conn->error . "<br>";
        }
    }

    if (!empty($email)) {
        $sql3 = "UPDATE MyGuests SET email='$email' WHERE id='$id'";
        if ($conn->query($sql3) === TRUE) {
            echo "Email actualizado.<br>";
        } else {
            echo "Error al actualizar email: " . $conn->error . "<br>";
        }
    }

    // Mostrar el registro actualizado
    $sql4 = "SELECT id, firstname, lastname, email FROM MyGuests WHERE id='$id'";
    $result = $conn->query($sql4);

    if ($result->num_rows > 0) {
        echo "<h3>Datos actualizados:</h3>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>Email</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["firstname"] . "</td>";
            echo "<td>" . $row["lastname"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontró el email";
}}
?>
</body>
</html>