<?php
session_start();
include("includes/db.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$usuario = $_SESSION['nombre'];

// Obtener los temas
$sql = "SELECT t.id, t.nombre, t.descripcion, t.imagen,
        IFNULL(p.completado, 0) AS completado
        FROM temas t
        LEFT JOIN progreso p ON t.id = p.id_tema AND p.id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - PseudoLearning</title>
    <link rel="stylesheet" href="css/perfilv2.css">
</head>
<body>
    
    <header>
        <h1>PSeudoLearning - Inicio🐾</h1>
        <a href="main.php" class="volver">⬅Volver</a>
    </header>

    <main class="contenedor-lecciones">
        <?php
        $bloquear = false;
        while ($tema = $result->fetch_assoc()):
            $id_tema = $tema['id'];
            $completado = $tema['completado'];

            // Si el tema anterior no fue completado, se bloquea el siguiente
            if ($bloquear) {
                $bloqueado = true;
            } else {
                $bloqueado = false;
            }

            if (!$completado) $bloquear = true;
        ?>
        <div class="tarjeta <?php echo $bloqueado ? 'bloqueado' : ''; ?>">
            <img src="<?php echo htmlspecialchars($tema["imagen"]); ?>" alt="imagen">    
        <h2><?php echo htmlspecialchars($tema['nombre']); ?></h2>
            <p><?php echo htmlspecialchars($tema['descripcion']); ?></p>
            
            <?php if ($bloqueado): ?>
                <button class="btn bloqueado" disabled>🔒 Bloqueado</button>
            <?php else: ?>
                <a href="tema.php?id=<?php echo $id_tema; ?>" class="btn">Empezar</a>
            <?php endif; ?>
        </div>
        <?php endwhile; ?>
    </main>

  <footer class="footer">
    <p> @2025 Pseudocodigo-con-profe-andre - Todos los derechos reservados</p>
  </footer>
</body>
</html>
