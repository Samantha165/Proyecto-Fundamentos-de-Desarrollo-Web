<?php

require "db.php";
session_start();

if (!isset($_SESSION['id'])) {
    exit();
}

$user_id = $_SESSION['id'];
$hoy = date('Y-m-d');

$sql = "SELECT * FROM user_membresias WHERE user_id = '$user_id'";
$query = mysqli_query($con, $sql);

if (mysqli_num_rows($query) > 0) {
    echo "existe";
} else {
    echo "no";
}
?>