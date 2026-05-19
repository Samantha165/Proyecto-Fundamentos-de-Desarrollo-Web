<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membresías</title>
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

<div class = "main">


    <div class="Texto_Arriba">
        <h1>Ya te encuentras registrado!</h1>
    </div>

    <div class="Div_btn_membresias">

  <a href="./index.php"><button class ="Registro">Home</button></a>
         <a href="./membresias.php"><button class ="Registro">Membresías</button></a>
          <a href="./db/logout.php"><button class ="Registro">Cerrar sesión</button></a>
    </div>
      

    

    
 <script src = "./script.js"></script>
</body>
</html>