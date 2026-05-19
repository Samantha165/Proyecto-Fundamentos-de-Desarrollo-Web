<?php

require "./db.php";

$correo = $_GET['correo'];

$stmt = $con->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $correo);

$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows > 0){

    echo "existe";

} else {

    echo "disponible";

}