<?php
include 'conn.php';
// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = intval($_POST["id"]);
    $sql = "SELECT id, firstname, lastname, email FROM MyGuests WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Registro encontrado:</h2>";
        $row = $result->fetch_assoc();
        echo "ID: " . $row["id"] . "<br>";
        echo "Nombre: " . $row["firstname"] . "<br>";
        echo "Apellido: " . $row["lastname"] . "<br>";
        echo "Email: " . $row["email"] . "<br>";
    } else {
        echo "No se encontró ningún registro con ese ID.";
    }
} else {
    echo "ID no válido.";
}

$conn->close();
?>
