<?php
session_start();
include("../includes/db.php");

$id_usuario = $_SESSION['id_usuario'];
$id_leccion = $_POST['id'];

$stmt = $conn->prepare("INSERT INTO progreso_leccion (id_usuario, id_leccion, completado)
                        VALUES (?, ?, 1)
                        ON DUPLICATE KEY UPDATE completado=1");
$stmt->bind_param("ii", $id_usuario, $id_leccion);
$stmt->execute();

echo "OK";
?>
