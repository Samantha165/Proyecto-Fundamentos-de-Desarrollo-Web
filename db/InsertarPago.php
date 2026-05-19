<?php

require "db.php";
session_start();


if(isset($_SESSION['username'])){
  $username = $_SESSION['username'];
  $role = $_SESSION['role'];
  $user_id= $_SESSION['id'];
}else{

header("Location: ../login.php?error=Inicia sesion");
return;

}


$membresia_id = $_POST['membresia_id'];

if (!$membresia_id) {
    header("Location: ../membresias.php?error=No se seleccionó una membresía");
    exit();
}

$fecha_inicio = date('Y-m-d');
$fecha_fin = date('Y-m-d', strtotime('+1 month'));

$stmt = $con->prepare("INSERT INTO user_membresias (user_id, membresia_id, fecha_inicio, fecha_fin) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiss", $user_id, $membresia_id, $fecha_inicio, $fecha_fin);

try {
    $stmt->execute();
    header("Location: ../membresias.php?success=Membresía activada correctamente");
    exit();
} catch (Exception $e) {
    header("Location: ../PruebaCheckout.php?error=Hubo un error");
    
}
?>