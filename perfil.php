<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil</title>
    <link rel="stylesheet" href="css/perfil.css">
</head>
<body>
    <h2 class="banner">Bienvenido, <?php echo $_SESSION["nombre"]; ?> 👋</h2>
    <p><a href="ejercicio.php?id=1">Ir a la lección 1</a></p>
    <p><a href="logout.php">Cerrar sesión</a></p>
</body>
</html>
