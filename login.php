
<?php
require "./db/db.php";
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="./styles.css">
</head>

<body>

<header>
  <nav>
    <a href="./login.php" class="login">Iniciar sesión</a>
    <div class="nav_links">
      <a href="./index.php">Home</a>
      <a href="./membresias.php">Membresías</a>
      <a href="./registro.php">Registro</a>
    </div>
    <button class="menu-toggle" onclick="toogle()">☰</button>
  </nav>
  <div class="red-bar"></div>
</header>

<div class="main">

    <div class="Texto_Arriba">
        <h1>Iniciar sesión</h1>
        <h2>Bienvenido</h2>
    </div>

    <div class="Formulario_IS">

        <form action="./db/login.php" method="POST">

            <div class="Input_IS">
                <label for="correo">Correo</label>
                <input type="email" id="correo" name="username" required>
            </div>
            <br>

            <div class="Input_IS">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" minlength="8" required>
            </div>
            <br>

            <button id="IS" type="submit">Iniciar sesión</button>


               

        </form>
         <?php

    if(isset($_GET['error'])){

    $error = ($_GET['error']);
    echo "<span class'error' > $error </span>";

    }

    ?>
    </div>

    <div class="IS_Registro">
        <p>¿Aún no tienes una cuenta?</p>
        <a href="./registro.php"><button>Registrarme</button></a>
    </div>

</div>

<script src="./script.js"></script>

</body>
</html>