<?php
require "./db/db.php";
session_start();

if (isset($_SESSION['username'])) {
    $role = $_SESSION['role'];
    if ($role != 'admin') {
        header("Location: ./login.php");
        exit();
    }
} else {
    header("Location: ./login.php?error=Inicia sesion");
    exit();
}

$sql = "SELECT 
            u.nombre,
            u.apellidos,
            m.nombre    AS membresia_nombre,
            m.id        AS membresia_id,
            um.fecha_inicio,
            um.fecha_fin
        FROM users u
        LEFT JOIN user_membresias um
            ON um.user_id = u.id
            AND um.fecha_fin = (
                SELECT MAX(um2.fecha_fin)
                FROM user_membresias um2
                WHERE um2.user_id = u.id
            )
        LEFT JOIN membresias m ON m.id = um.membresia_id
        ORDER BY u.id ASC";

$result   = mysqli_query($con, $sql);
$usuarios = [];
while ($row = mysqli_fetch_assoc($result)) $usuarios[] = $row;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Usuarios</title>
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

   </div>
    <div class="Tabs_Membresia" >
    <a href="./adminMembresias.php"><button class="Btn_Admin">Administrar membresías</button></a>
    <a href="./adminUsuarios.php"><button class="Btn_Admin ">Usuarios</button></a>
  </div>

  <div class="Contenedor_Tabla">
    <table class="Tabla_Usuarios">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Estado</th>
          <th>Membresía</th>
          <th>Inicio</th>
          <th>Fin</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($usuarios)): ?>
          <tr>
            <td colspan="5" class="Tabla_Vacia">No hay usuarios registrados.</td>
          </tr>
        <?php else: ?>
         <?php foreach ($usuarios as $u):
    if ($u['membresia_id']) {
        $badge_class = 'Estado con';
        $badge_texto = 'Con membresía';
    } else {
        $badge_class = 'Estado sin';
        $badge_texto = 'Sin membresía';
    }
?>
          <tr>
            <td><?php echo htmlspecialchars($u['nombre'] . ' ' . $u['apellidos']); ?></td>
            <td><span class="<?php echo $badge_class; ?>"><?php echo $badge_texto; ?></span></td>
            <td><?php echo $u['membresia_nombre'] ? htmlspecialchars($u['membresia_nombre']) : '—'; ?></td>
            <td><?php echo $u['fecha_inicio'] ? date('d/m/Y', strtotime($u['fecha_inicio'])) : '—'; ?></td>
            <td><?php echo $u['fecha_fin'] ? date('d/m/Y', strtotime($u['fecha_fin'])) : '—'; ?></td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</div>

<script src="./script.js"></script>
</body>
</html>