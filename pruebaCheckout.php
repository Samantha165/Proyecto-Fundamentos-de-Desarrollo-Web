<?php
require "./db/db.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ./login.php?error=Inicia sesion");
    exit();
}

$membresia_id = $_GET['membresia_id'] ?? null;
$error        = $_GET['error'] ?? null;


$sql = "SELECT nombre, precio FROM membresias WHERE id = '$membresia_id'";
$query = mysqli_query($con, $sql);
$membresia = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
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
    <button class="menu-toggle" onclick="toogle()">☰</button>
  </nav>
  <div class="red-bar"></div>
</header>
<script src="./script.js"></script>

<div class="main">

  <div class="Texto_Arriba">
    <h1>Checkout</h1>
  </div>



  <div class="Contenedor_Checkout">

    <div class="Tarjeta_Resumen">
      <h3>Resumen de compra</h3>
      <div class="Fila_Resumen">
<p><?php echo $membresia['nombre']; ?></p>
<p>$<?php echo number_format($membresia['precio'], 2); ?> MXN</p>
      </div>
      <hr class="Divisor">
      <div class="Fila_Resumen Total">
        <p>Total</p>
<p>$<?php echo number_format($membresia['precio'], 2); ?> MXN</p>
      </div>
    </div>

    <div class="Tarjeta_Pago">
      <h3>Datos de pago</h3>

      <form action="./db/InsertarPago.php" method="POST" onsubmit="verificarMembresia()">

      <input type="hidden" name="membresia_id" value="<?= htmlspecialchars($membresia_id) ?>">

        <div class="Input_Checkout">
          <label for="titular">Titular de la tarjeta</label>
          <input type="text" id="titular" name="titular" placeholder="Como aparece en la tarjeta" >
        </div>
        <br>

        <div class="Input_Checkout">
          <label for="numero">Número de tarjeta</label>
          <input type="text" id="numero" name="numero" placeholder="1234 5678 9012 3456" >
        </div>
        <br>

        <div class="Fila_Inputs">
          <div class="Input_Checkout">
            <label for="fecha">Fecha de vencimiento</label>
            <input type="text" id="fecha" name="fecha" placeholder="MM/AA" >
          </div>
          <br>
          <div class="Input_Checkout">
            <label for="cvv">CVV</label>
            <input type="text" id="cvv" name="cvv" placeholder="***" >
          </div>
        </div>
        <br>

        <button type="submit" id="IS">Pagar ahora</button>
        

      </form>

        <?php

    if(isset($_GET['error'])){
    echo "<span> $error </span>";
    header("Location: ./membresias.php");
    }
    ?>
    </div>

  </div>
</div>

<script src="./script.js"></script>

</body>
</html>