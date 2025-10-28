<?php
include("includes/db.php");
session_start();

if (!isset($_SESSION['id_usuario'])) {
    echo "error_sesion";
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$id_leccion = $_POST['id_leccion'] ?? null;

if (!$id_leccion) {
    echo "error_parametros";
    exit;
}

// Marcar lección como completada
$stmt = $conn->prepare("
    INSERT INTO progreso_leccion (id_usuario, id_leccion, completado)
    VALUES (?, ?, 1)
    ON DUPLICATE KEY UPDATE completado = 1
");
$stmt->bind_param("ii", $id_usuario, $id_leccion);

if ($stmt->execute()) {
    echo "ok";
} else {
    echo "error_bd";
}
?>
