<?php
require "./db/db.php";
session_start();

if (isset($_SESSION['username'])) {
     header("Location: ./registrado.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="./styles.css">
</head>
<body>

<header>
  <nav>
  
  
<?php if (!isset($_SESSION['username'])) { ?>
    <a href="./login.php" class="login">Iniciar sesión</a>
<?php } else { ?>
    <div class="login" style="visibility:hidden;">Iniciar sesión</div>
<?php } ?>

    <div class="nav_links">
      <a href="./index.php">Home</a>
      <a href="./membresias.php">Membresías</a>
      <a href="./registro.php">Registro</a>
    </div>
     <button class = "menu-toggle" onclick="toogle()">☰</button>
  </nav>
  <div class="red-bar"></div>
</header>


<div class="main">

  <div class="Texto_Arriba">
    <h1>Regístrate</h1>
    <h2>Queremos que formes parte de esta comunidad</h2>
  </div>

  <form action="./db/insertUser.php" method="POST"  onsubmit="return verificarContra()">

  <div class="Contenedor_Registro">

    <div class="Tarjeta_Registro">
      <h3>Datos personales</h3>

      <div class="Input">
        <label for="nombre">Nombre(s)</label>
        <input type="text" id="nombre" name="name" placeholder="Juan" required>
      </div>

      <div class="Input">
        <label for="apellidos">Apellidos</label>
        <input type="text" id="apellidos" name="apellidos" placeholder="Pérez" required>
      </div>

      <div class="Input">
        <label for="fecha">Fecha de nacimiento</label>
        <input type="date" id="fecha" name="fecha_nac" required>
      </div>

      <div class="Input">
        <label for="tel">Teléfono</label>
        <input type="tel" id="tel" name = "phone" placeholder="333-456-7211" required>
      </div>

      <div class="Input">
        <label for="correo">Correo</label>
        <input type="email" id="correo" name="username" onblur="verificarCorreo()" placeholder="Ejemplo@correo.com" required>
      </div>
         <p id="mensajeCorreo"></p>
     

      <div class="Input">
        <label for="pass">Contraseña</label>
        <input type="password" id="pass" name ="password" minlength="8" required onkeyup="validarPass()">
      </div>

      <div class="Input">
        <label for="pass2">Confirmación de contraseña</label>
        <input type="password" id="pass2" name="pass2" minlength="8" required onkeyup="validarPass()">

        
    
      </div>
      <p id="mensaje"></p>
    
        <?php

    if(isset($_GET['error'])){

    $error = ($_GET['error']);
    echo "<span> $error </span>";

    }
    ?>
    
    </div>

    <div class="Columna_Derecha">

      <div class="Tarjeta_Registro">
        <h3>Datos de tu contacto de emergencia</h3>

        <div class="Input">
          <label for="nom_em">Nombre(s)</label>
          <input type="text" id="nom_em" name ="name_em" placeholder="Ana" required>
        </div>

        <div class="Input">
          <label for="ap_em">Apellidos</label>
          <input type="text" id="ap_em" name="apellidos_em" placeholder="Martínez" required>
        </div>

        <div class="Input">
          <label for="tel_em">Teléfono</label>
          <input type="tel" id="tel_em" name="phone_em" placeholder="333-456-7223" required>
        </div>
      </div>

      <button  type="submit" class="Registro">Registrarme</button>

    </div>

  </div>
</form>
</div>
 <script src = "script.js"></script>

 <script>

if(window.location.search.includes("ok=1")){
    alert("Hiciste tu registro con éxito");
}

</script>
</body>
</html>