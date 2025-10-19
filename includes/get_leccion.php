<?php
include("../includes/db.php");
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT titulo, teoria, ejercicio FROM lecciones WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
echo json_encode($result);
?>
