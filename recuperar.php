<?php
include("includes/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accion = $_POST["accion"] ?? '';

    if ($accion == "buscar") {
        $email = $_POST["email_reset"] ?? '';
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        echo ($result->num_rows > 0) ? "OK" : "ERROR";
        exit;
    }

    if ($accion == "actualizar") {
        $email = $_POST["email"] ?? '';
        $nueva = md5($_POST["nueva_pass"] ?? '');
        $stmt = $conn->prepare("UPDATE usuarios SET password=? WHERE email=?");
        $stmt->bind_param("ss", $nueva, $email);
        echo ($stmt->execute()) ? "OK" : "ERROR";
        exit;
    }
}
?>
