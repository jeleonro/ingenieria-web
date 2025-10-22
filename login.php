<!-- Jala los usuarios de la bs de datos para comprobar si existe -->
<?php
session_start();
include("includes/db.php");
// INICIAR SESIÓN
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = md5($_POST["password"]);

    $sql = "SELECT * FROM usuarios WHERE email=? AND password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION["id_usuario"] = $user["id"];
        $_SESSION["nombre"] = $user["nombre"];
        header("Location: main.php");
        exit;
    } else {
        $error = "❌ Usuario o contraseña incorrectos";
    }
}

// REGISTRAR USUARIO
if (isset($_POST["register"])) {
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $password = md5($_POST["password"]);

    // Verificar si el correo ya está registrado
    $check = $conn->prepare("SELECT * FROM usuarios WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $error = "⚠️ Ya existe una cuenta con este correo.";
    } else {
        $sql = "INSERT INTO usuarios (nombre, email, password) VALUES (?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nombre, $email, $password);
        if ($stmt->execute()) {
            $success = "✅ Cuenta creada exitosamente. Ahora puedes iniciar sesión.";
        } else {
            $error = "❌ Error al registrar el usuario.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/styleloginv3.css">
    <title>Login</title>
</head>

<body>
    <div class="login-letra">
        <h2>Bienvenido a <strong>PSEUDOLEARNING</strong></h2>
    </div>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="" method="post">
                <h1>Crear Cuenta</h1>
                <?php
                if (isset($error))
                    echo "<p style='color:red;'>$error</p>";
                if (isset($success))
                    echo "<p style='color:rgb(98, 0, 255);'>$success</p>";
                ?>
                <span>o usa tu correo para registrarte</span>
                <input type="text" name="nombre" placeholder="Nombre completo" required />
                <input type="email" name="email" placeholder="Correo electrónico" required />
                <input type="password" name="password" placeholder="Contraseña" required />
                <button type="submit" name="register">Registrarse</button>
            </form>
        </div>


        <div class="form-container sign-in-container">
            <form action="#" method="post">
                <h1>Iniciar Sesión</h1>
                <?php if (isset($error))
                    echo "<p>$error</p>"; ?>
                <input type="email" name="email" placeholder="Correo" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <a href="javascript:void(0)" id="openModal">¿Olvidaste tu contraseña?</a>
                <button type="submit" name="login">Ingresar</button>
            </form>
        </div>
        <!-- Modal Recuperar Contraseña -->
        <div id="modal-reset" class="modal" aria-hidden="true">
            <div class="modal-backdrop" id="modal-backdrop"></div>
            <div class="modal-dialog" role="dialog" aria-modal="true" aria-labelledby="modal-title">
                <button class="modal-close" id="closeModal" aria-label="Cerrar">x</button>
                <h2 id="modal-title">Recuperar Contraseña</h2>
                <p id="modal-sub">Ingresa tu correo para buscar la cuenta.</p>
                <!-- Paso 1: buscar correo -->
                <form id="modal-form-buscar" class="modal-form">
                    <input type="email" id="modal-email" name="email_reset" placeholder="Correo electrónico" required>
                    <div class="modal-actions">
                        <button type="submit" id="modal-btn-buscar">Buscar cuenta</button>
                    </div>
                    <p id="modal-msg" class="modal-msg"></p>
                </form>
                <!-- Paso 2: actualizar contraseña (oculto inicialmente) -->
                <form id="modal-form-reset" class="modal-form" style="display:none;">
                    <input type="password" id="modal-pass" name="nueva_pass" placeholder="Nueva contraseña" required>
                    <input type="password" id="modal-pass-confirm" placeholder="Confirmar contraseña" required>
                    <div class="modal-actions">
                        <button type="submit" id="modal-btn-guardar">Actualizar contraseña</button>
                    </div>
                    <p id="modal-msg-2" class="modal-msg"></p>
                </form>
            </div>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Bienvenido De Nuevo!</h1>
                    <p>Si ya tiene una cuenta, inicie sesión con su información personal.</p>
                    <button class="ghost" id="signIn">INGRESAR</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hola, Programador!</h1>
                    <p>✨ Ingresa y comienza la aventura codificando ✨</p>
                    <button class="ghost" id="signUp">REGISTRARSE</button>
                </div>
            </div>
        </div>
    </div>
    <script src="./js/login.js"></script>
    <script src="./js/recuperar.js"></script>
</body>
</html>
