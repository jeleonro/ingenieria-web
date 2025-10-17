<?php
$host = "localhost:3309";
$user = "root";   // usuario por defecto de XAMPP
$pass = "";       // sin contraseña por defecto
$db   = "pseudocodigo";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}
?>
