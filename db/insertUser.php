<?php

require "./db.php";

$name = $_POST["name"];
$ap = $_POST["apellidos"];
$fecha_nac = $_POST["fecha_nac"];
$phone = $_POST["phone"];
$username = $_POST["username"];
$password = $_POST["password"];

$name_em = $_POST["name_em"];
$ap_em = $_POST["apellidos_em"];
$phone_em = $_POST["phone_em"];

$pass2 = $_POST['pass2'];




$check = $con->prepare("SELECT id FROM users WHERE username = ?");
$check->bind_param("s", $username);
$check->execute();

$result = $check->get_result();

if($result->num_rows > 0){

    header("Location: ../registro.php?error=El correo ya está registrado");
    exit();

}




$stmt = $con->prepare(
"INSERT INTO users(username, password, nombre, apellidos, fecha_nacimiento, telefono) 
VALUES (?,?,?,?,?,?)"
);

$stmt->bind_param("ssssss", $username, $password, $name, $ap, $fecha_nac, $phone);

try{

    $stmt->execute();

    $nuevo_id = $con->insert_id;

    $stmt2 = $con->prepare(
    "INSERT INTO contactos_emergencia(user_id, nombre, apellidos, telefono) 
    VALUES (?,?,?,?)"
    );

    $stmt2->bind_param("isss", $nuevo_id, $name_em, $ap_em, $phone_em);

    $stmt2->execute();

    header("Location: ../registro.php?ok=1");

}
catch(Exception $e){

    header("Location: ../registro.php?error=" . $e->getMessage());
    return;

}

?>