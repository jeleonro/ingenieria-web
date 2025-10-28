<?php
session_start();
include("includes/db.php");
include("includes/funciones.php"); // Asegúrate de tener aquí las funciones actualizadas

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$usuario = $_SESSION['nombre'];

// Obtener todos los temas
$sql = "SELECT * FROM temas ORDER BY id ASC";
$result = $conn->query($sql);
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
        <h1>PSeudoLearning - Inicio</h1>
        <a href="main.php" class="volver">Volver</a>
    </header>

    <main class="contenedor-lecciones">
        <?php
        while ($tema = $result->fetch_assoc()):
            $id_tema = $tema['id'];
            $progreso = progresoTema($id_usuario, $id_tema);
            $desbloqueado = temaDesbloqueado($id_usuario, $id_tema);
        ?>
        <div class="tarjeta <?php echo $desbloqueado ? '' : 'bloqueado'; ?>">
            <img src="<?php echo htmlspecialchars($tema['imagen']); ?>" alt="imagen">    
            <h2><?php echo htmlspecialchars($tema['nombre']); ?></h2>
            <p><?php echo htmlspecialchars($tema['descripcion']); ?></p>

            <div class="barra-progreso">
                <div class="progreso" style="width: <?php echo $progreso; ?>%;"></div>
            </div>
            <p><?php echo $progreso; ?>% completado</p>

            <?php if ($desbloqueado): ?>
                <a href="tema.php?id=<?php echo $id_tema; ?>" class="btn">Empezar</a>
            <?php else: ?>
                <button class="btn bloqueado" disabled>🔒 Bloqueado</button>
            <?php endif; ?>
        </div>
        <?php endwhile; ?>
    </main>

    <footer class="footer">
        <p>@2025 Pseudolearning - Todos los derechos reservados</p>
    </footer>
</body>
</html>
