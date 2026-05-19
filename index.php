<?php

require "./db/db.php";
session_start();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
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

<script src = "./script.js"></script>

<div class = "main">


            
            <div class="Publicidad">

                <div class = "TextoPublicidad">
                <h1>INSCRIPCION GRATIS +  KIT BIENVENIDA</h1>
                <P>*Aplican términos y condiciones</P>                           
                </div>

               <a href="./membresias.php"><button>Obtener más información</button></a>
            </div>


            <div class= "Div_btn_membresias">
                

                <a href="./membresias.php"><button class = "Btn_Membresia">Membresía Diamante</button></a>
                <a href="./membresias.php"><button class = "Btn_Membresia">Membresía Oro</button></a>

            </div>
           
           <div class="Text_instalaciones">
            <h1>Conoce nuestras instalaciones</h1>
           </div>
            
       <div class="Imgs_instalaciones">

  <div class="Instalacion">
    <p>Área de pesas</p>
    <a href="./membresias.php"><img src="./recursos/image_edited.png" alt="Instalaciones 1"></a>
  </div>

  <div class="Instalacion">
    <p>Cardio</p>
    <a href="./membresias.php"><img src="./recursos/cardio.png" alt="Cardio"></a>
  </div>

  <div class="Instalacion">
    <p>Sala Multiusos</p>
    <a href="./membresias.php"><img src="./recursos/sala.png" alt="Sala"></a>
  </div>

  <div class="Instalacion">
    <p>Baños</p>
    <a href="./membresias.php"><img src="./recursos/baños.png" alt="Baños"></a>
  </div>

  <div class="Instalacion">
    <p>Regaderas</p>
    <a href="./membresias.php"><img src="./recursos/regaderas.png" alt="Regaderas"></a>
  </div>

  <div class="Instalacion">
    <p>Vestidores</p>
    <a href="./membresias.php"><img src="./recursos/vestidores.png" alt="Vestidores"></a>
  </div>

</div>



</div>

 <script src = "./script.js"></script>

 <?php
 if(isset($_SESSION['username'])){

?>

 <div class="logout"> 
   <a href="./db/logout.php"><button class ="Registro">Cerrar sesión</button></a>

 </div>

 <?php
 }
 ?>

</body>
</html>