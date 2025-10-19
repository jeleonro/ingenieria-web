<?php
session_start();
include("includes/db.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$id_tema = $_GET['id'] ?? null;

if (!$id_tema) {
    header("Location: perfil.php");
    exit();
}

// Obtener nombre del tema
$stmt = $conn->prepare("SELECT nombre FROM temas WHERE id=?");
$stmt->bind_param("i", $id_tema);
$stmt->execute();
$tema = $stmt->get_result()->fetch_assoc();

// Obtener lecciones y progreso
$sql = "SELECT l.id, l.titulo, l.teoria, l.ejercicio,
        IFNULL(p.completado, 0) AS completado
        FROM lecciones l
        LEFT JOIN progreso_leccion p 
        ON l.id = p.id_leccion AND p.id_usuario = ?
        WHERE l.id_tema = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_usuario, $id_tema);
$stmt->execute();
$lecciones = $stmt->get_result();

$total = $lecciones->num_rows;
$completadas = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($tema['nombre']); ?></title>
    <link rel="stylesheet" href="css/tema.css">
</head>
<body>
    <header>
        <h1><?php echo htmlspecialchars($tema['nombre']); ?></h1>
        <div class="progreso-tema">
            <?php
            $porcentaje = $total ? round(($completadas / $total) * 100) : 0;
            ?>
            <p>Progreso: <?php echo "$completadas / $total lecciones ($porcentaje%)"; ?></p>
            <div class="barra">
                <div class="relleno" style="width:<?php echo $porcentaje; ?>%;"></div>
            </div>
        </div>
        <a href="perfil.php" class="volver">⬅ Volver</a>
    </header>

    <main class="contenedor-lecciones">
        <?php while ($l = $lecciones->fetch_assoc()):
            if ($l['completado']) $completadas++;
        ?>
        <div class="tarjeta-leccion <?php echo $l['completado'] ? 'completada' : ''; ?>">
            <h2><?php echo htmlspecialchars($l['titulo']); ?></h2>
            <button class="btn-ver" data-id="<?php echo $l['id']; ?>">Ver lección</button>
            <div class="barra-progreso">
                <?php echo $l['completado'] ? "✅ Completada" : "⏳ Pendiente"; ?>
            </div>
        </div>
        <?php endwhile; ?>

        
    </main>

    <!-- Modal -->
    <div id="modal-leccion" class="modal">
        <div class="modal-content">
            <h2 id="titulo-leccion"></h2>
            <p id="teoria-leccion"></p>
            <textarea id="editor" placeholder="Escribe tu pseudocódigo aquí..."></textarea>
            <button id="btn-ejecutar">Ejecutar</button>
            <button id="btn-completar">Marcar como completada</button>
            <button id="cerrar-modal">Cerrar</button>
            <pre id="salida"></pre>
        </div>
    </div>

    <script src="js/tema.js"></script>
</body>
</html>
