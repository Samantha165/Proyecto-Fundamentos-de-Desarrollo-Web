<?php

require "./db/db.php";
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $role     = $_SESSION['role'];

    if ($role != 'admin') {
        header("Location: ./login.php");
        return;
    }
} else {
    header("Location: ./login.php?error=Inicia sesion");
    return;
}

$slug = isset($_GET['tipo']) ? $_GET['tipo'] : 'Diamante';

$stmt = mysqli_prepare($con, "SELECT * FROM membresias WHERE slug = ?");
mysqli_stmt_bind_param($stmt, "s", $slug);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$m = mysqli_fetch_assoc($resultado);

$query_b = "SELECT b.id as ben_id, b.texto, mb.incluido, mb.id as pivot_id
            FROM beneficios b 
            JOIN membresias_beneficios mb 
            ON b.id = mb.beneficio_id 
            WHERE mb.membresia_id = " . $m['id'] . " 
            ORDER BY mb.orden";

$res_b = mysqli_query($con, $query_b);
$beneficios = [];
while ($b = mysqli_fetch_assoc($res_b)) {
    $beneficios[] = $b;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
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
    <h1>Panel de administración</h1>
  </div>
    <div class="Tabs_Membresia" >
    <a href="./adminMembresias.php"><button class="Btn_Admin">Administrar membresías</button></a>
    <a href="./adminUsuarios.php"><button class="Btn_Admin ">Usuarios</button></a>
  </div>


  <div class="Panel_Admin">

    <div class="Tarjeta_Admin">

      <div class="Tabs_Membresia">
        <a href="adminMembresias.php?tipo=Diamante"><button class="Tab <?php echo $slug == 'Diamante' ? 'active' : ''; ?>">Diamante</button></a>
        <a href="adminMembresias.php?tipo=Oro"><button class="Tab <?php echo $slug == 'Oro' ? 'active' : ''; ?>">Oro</button></a>
        <a href="adminMembresias.php?tipo=Platino"><button class="Tab <?php echo $slug == 'Platino' ? 'active' : ''; ?>">Platino</button></a>
      </div>

      <form action="./db/guardarMembresia.php" method="POST">

        <input type="hidden" name="membresia_id" value="<?php echo $m['id']; ?>">
        <input type="hidden" name="slug" value="<?php echo $slug; ?>">

        <div class="label_admin">Precio (MXN)</div>
        <input class="Input_Admin" id="precio" name="precio" type="text"
               value="<?php echo $m['precio']; ?>"
               oninput="updatePreview()">

        <div class="label_admin">Descripción</div>
        <input class="Input_Admin" id="desc" name="descripcion" type="text"
               value="<?php echo $m['descripcion']; ?>"
               oninput="updatePreview()">

        <div class="label_admin" style="margin-top: 16px;">Beneficios</div>

        <div id="benefits-list">
          <?php foreach ($beneficios as $b): ?>
            <div class="Benefit_Row">
              <input type="hidden" name="pivot_id[]"     value="<?php echo $b['pivot_id']; ?>">
              <input type="hidden" name="beneficio_id[]" value="<?php echo $b['ben_id']; ?>">
               <input type="hidden" name="eliminar[]" value="" class="eliminar-id">

              <?php if ($b['incluido']): ?>
                <button type="button" class="Toggle_Benefit on" onclick="toggleBenefit(this)">✓</button>
              <?php else: ?>
                <button type="button" class="Toggle_Benefit off" onclick="toggleBenefit(this)">✗</button>
              <?php endif; ?>

              <input type="hidden" name="incluido[]" value="<?php echo $b['incluido']; ?>">

              <input class="Input_Benefit" name="texto[]" type="text"
                     value="<?php echo $b['texto']; ?>"
                     oninput="updatePreview()">

              <button type="button" class="Remove_Btn" onclick="marcarEliminar(this)">x</button>
              
            </div>
          <?php endforeach; ?>
        </div>

        <p id="mensaje"></p>
        <button type="submit" class="Btn_Guardar">Guardar cambios</button>

<?php if (isset($_GET['success'])): ?>
    <span class="success"><?php echo $_GET['success']; ?></span>
<?php endif; ?>
<?php if (isset($_GET['error'])): ?>
    <span class="error">Error: <?php echo $_GET['error']; ?></span>
<?php endif; ?>

      </form>

        <button type="button" class="Btn_Agregar" onclick="addBenefit()"> + Agregar beneficio</button>

    </div>

    <div class="Columna_Preview">
      <p class="label_admin">Vista previa</p>
      <div class="Membresia">
        <h1 id="prev-name"><?php echo $m['nombre']; ?></h1>
        <p id="prev-desc"><?php echo $m['descripcion']; ?></p>
        <div class="Precio">
  <h1>$<?php echo number_format($m['precio'], 2); ?></h1><h2>/mes</h2>
</div>
        <button>¡Adquierela ya!</button>
        <div class="Contenedor_Beneficios" id="prev-benefits">
          <?php foreach ($beneficios as $b): ?>
            <div class="<?php echo $b['incluido'] ? 'Beneficio' : 'No_Beneficio'; ?>">
              <img src="<?php echo $b['incluido'] ? './recursos/check.png' : './recursos/cruz.png'; ?>"
                   class="<?php echo $b['incluido'] ? 'Palomita' : 'Cruz'; ?>">
              <p><?php echo $b['texto']; ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

  </div>
</div>

<script src="./script.js"></script>

</body>
</html>