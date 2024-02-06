<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "cafeteria";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
