<?php
session_start();
include("includes/db.php");

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$usuario = $_SESSION['nombre'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pseudocodigo</title>
  <link rel="stylesheet" href="css/mainreal.css">
</head>

<body>

  <header class="header">
    <div class="container">
      <h1 class="logo">Pseudocodigo con profe andre</h1>
      <nav class="nav">
        <ul class="menu-main">
          <li><a href="#inicio">Inicio</a></li>
          <li><a href="tema.php">Lecciones</a></li>
          <li><a href="#equipo">Equipo</a></li>
          <li><a href="#">Perfil</a></li>
          <a href="logout.php" class="volver">Cerrar Sesión</a>
        </ul>
      </nav>
    </div>

      <div class="bienvenida">
      👋 ¡Bienvenido, <?php echo htmlspecialchars($usuario); ?>!
      </div>
  </header>

  <section id="inicio" class="hero">
    <div class="container">
      <h2>Aprende Pseudocodigo facil y rapido</h2>
      <p>El pseudocódigo es una forma simplificada de representar los pasos lógicos de un algoritmo utilizando palabras
        comunes y una estructura similar a la de los lenguajes de programación.</p>
      <a href="tema.php" class="btn">Comenzar</a>
    </div>
  </section>

  <section id="beneficios" class="beneficios">
    <div class="container">
      <h2>¿Por qué empezar por pseudocódigo?</h2>
      <div class="grid">
        <div class="card">
          <h3>Base esencial para la programación</h3>
          <p>El pseudocódigo enseña pensamiento lógico y estructurado, habilidades fundamentales antes de aprender
            cualquier lenguaje como Java, Python o C++.</p>
          <img src="img/thinking.jpg" alt="Icono de programación">
        </div>

        <div class="card">
          <h3>Mejora la comprensión algorítmica</h3>
          <p>Un informe de la Universidad Politécnica de Madrid (2019) señala que el uso de pseudocódigo mejora hasta en
            40 % la comprensión de algoritmos frente al aprendizaje directo de un lenguaje de programación.</p>
          <img src="img/algorithm.jpg" alt="">
        </div>

        <div class="card">
          <h3>Desarrolla habilidades transferibles</h3>
          <p>Aprender pseudocódigo fomenta habilidades útiles más allá de la programación: pensamiento lógico y
            analítico,
            solución de problemas, planificación paso a paso y claridad en la comunicación técnica.</p>
          <img src="img/skill.jpg" alt="">
        </div>
      </div>
    </div>
  </section>

  <section id="equipo" class="padded">
    <div class="container">
      <h2>Nuestro equipo</h2>

      <div class="row">
        <div class="col">
          <div class="img-circular">
            <img src="img/cont.jpg" alt="" class="img-fluid">
          </div>
          <h3>Jesús André</h3>
          <p>Leon Rodriguez</p>
        </div>

        <div class="col">
          <div class="img-circular">
            <img src="img/cont.jpg" alt="" class="img-fluid">
          </div>
          <h3>Bruno Contly</h3>
          <p>Ramos La Jara</p>
        </div>

        <div class="col">
          <div class="img-circular">
            <img src="img/cont.jpg" alt="" class="img-fluid">
          </div>
          <h3>Miguel Angel</h3>
          <p>Mory Navincolqui</p>
        </div>

        <div class="col">
          <div class="img-circular">
            <img src="img/cont.jpg" alt="" class="img-fluid">
          </div>
          <h3>Arturo Valentino</h3>
          <p>Martínez Castañeda</p>
        </div>

        <div class="col">
          <div class="img-circular">
            <img src="img/cont.jpg" alt="" class="img-fluid">
          </div>
          <h3>Leandro Joaquin</h3>
          <p>Romero Huanca</p>
        </div>

      </div>
    </div>
  </section>


  <footer class="footer">
    <p> @2025 Pseudocodigo-con-profe-andre - Todos los derechos reservados</p>
  </footer>
</body>

</html>