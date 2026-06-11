<?php
include 'conn.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
// sql to delete a record
$buscar = $_POST['id'];
$sql = "DELETE FROM MyGuests WHERE id=" . $buscar;
if ($conn->query($sql) === TRUE) {
echo "Record deleted successfully";
} else {
echo "Error deleting record: " . $conn->error;
}
$conn->close();
?>
