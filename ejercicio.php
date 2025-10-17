<?php
session_start();
include("includes/db.php");

if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION["id_usuario"];
$id_leccion = isset($_GET["id"]) ? intval($_GET["id"]) : 1;

// Obtener lección
$sql = "SELECT * FROM lecciones WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_leccion);
$stmt->execute();
$leccion = $stmt->get_result()->fetch_assoc();

// Procesar envío
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST["codigo"];

    // Ejemplo de validación simple para condicionales
    if (strpos($codigo, "SI") !== false && strpos($codigo, "FIN_SI") !== false) {
        $sql = "INSERT INTO progreso (id_usuario, id_leccion, completado) 
                VALUES (?,?,1)
                ON DUPLICATE KEY UPDATE completado=1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $id_usuario, $id_leccion);
        $stmt->execute();

        $mensaje = "✅ Bien hecho, resolviste el ejercicio.";
    } else {
        $mensaje = "❌ Tu pseudocódigo no contiene la estructura correcta.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lección <?php echo $id_leccion; ?></title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.3/ace.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <style>
        #editor {
            height: 300px;
            width: 100%;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        .console {
            background: #111;
            color: #0f0;
            padding: 10px;
            margin-top: 10px;
            font-family: monospace;
            height: 120px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <h2><?php echo $leccion["titulo"]; ?></h2>
    <p><?php echo nl2br($leccion["contenido"]); ?></p>

    <h3>Escribe tu pseudocódigo</h3>

    <?php if (isset($mensaje)) echo "<div class='console'>$mensaje</div>"; ?>

    <form method="post">
        <div id="editor"></div>
        <textarea name="codigo" id="codigo" hidden></textarea>
        <button type="submit" onclick="saveCode()">Ejecutar</button>
    </form>

    <script>
        let editor = ace.edit("editor");
        editor.setTheme("ace/theme/monokai");
        editor.session.setMode("ace/mode/plain_text");

        function saveCode() {
            document.getElementById("codigo").value = editor.getValue();
        }
    </script>

    <br>
    <a href="perfil.php">← Volver al perfil</a>
</body>
</html>
