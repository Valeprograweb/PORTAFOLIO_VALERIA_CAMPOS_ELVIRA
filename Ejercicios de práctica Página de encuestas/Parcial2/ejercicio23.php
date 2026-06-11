<?php
include 'conn.php';
// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insertar 10 registros
for ($i = 1; $i <= 10; $i++) {
    $firstname = "John" . $i;
    $lastname = "Doe" . $i;
    $email = "john{$i}@example.com";

    $sql = "INSERT INTO MyGuests (firstname, lastname, email)
            VALUES ('$firstname', '$lastname', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully".  "<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>
