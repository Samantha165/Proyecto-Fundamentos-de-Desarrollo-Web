<?php

require "./db/db.php";
session_start();

$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

$sql    = "SELECT * FROM membresias ORDER BY id ASC";
$result = mysqli_query($con, $sql);

$success = $_GET['success'] ?? null;

?>

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
    <button class="menu-toggle" onclick="toogle()">☰</button>
  </nav>
  <div class="red-bar"></div>
</header>

<div class="main">

    <div class="Texto_Arriba">
        <h1>Nuestras membresías</h1>
        <h2>Escoge la que mejor se ajuste a ti</h2>

        <?php if ($role == 'admin'){ ?>
             <div class="Tabs_Membresia" style="margin-top: 25px; margin-bottom: 0px">
    <a href="./adminMembresias.php"><button class="Btn_Admin">Administrar membresías</button></a>
    <a href="./adminUsuarios.php"><button class="Btn_Admin">Usuarios</button></a>
  </div>
        <?php } ?>
    </div>

    <div class="Contenedor_Membresias">

        <?php while ($mem = mysqli_fetch_assoc($result)): ?>

            <div class="Membresia">

                <h1><?php echo $mem['nombre']; ?></h1>
                <p><?php echo $mem['descripcion']; ?></p>

                <div class="Precio">
                    <h1>$<?php echo number_format($mem['precio'], 2); ?> </h1><h2>/mes</h2>
                </div>

                <a href="./PruebaCheckout.php?membresia_id=<?= $mem['id'] ?>">
                    <button>¡Adquierela ya!</button>
                </a>

                <div class="Contenedor_Beneficios">
                    <?php
                    // Traer beneficios de esta membresía
                    $query_b = "SELECT b.texto, mb.incluido
                                FROM beneficios b
                                JOIN membresias_beneficios mb ON b.id = mb.beneficio_id
                                WHERE mb.membresia_id = " . $mem['id'] . "
                                ORDER BY mb.orden ASC";
                    $res_b = mysqli_query($con, $query_b);

                    while ($b = mysqli_fetch_assoc($res_b)):
                    ?>
                        <?php if ($b['incluido']): ?>
                            <div class="Beneficio">
                                <img src="./recursos/check.png" alt="" class="Palomita">
                                <p><?php echo $b['texto']; ?></p>
                            </div>
                        <?php else: ?>
                            <div class="No_Beneficio">
                                <img src="./recursos/cruz.png" alt="" class="Cruz">
                                <p><?php echo $b['texto']; ?></p>
                            </div>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </div>

            </div>

        <?php endwhile; ?>

    </div>


    
</div>

<script src="./script.js"></script>


<?php if ($success): ?>
<script>
    alert("<?= htmlspecialchars($success) ?>");
</script>
<?php endif; ?>

</body>
</html>