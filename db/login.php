<?php

require "db.php";
session_start();


if (!isset($_POST["username"]) || !isset($_POST["password"]) )
{
header("Location: ../login.php?error=Login incorrecto");
return;
}


$username = $_POST["username"];
$password = $_POST["password"];


$sql = "SELECT id, role FROM users WHERE username = '$username' AND password = '$password'";
$query = mysqli_query($con, $sql);


if(mysqli_num_rows($query) > 0){
    $result = mysqli_fetch_assoc($query);

    $_SESSION['username'] = $username;
    $_SESSION['role'] = $result['role'];
    $_SESSION['id'] = $result['id'];

    header("Location: ../membresias.php");
}else{
    
header("Location: ../login.php?error=Login incorrecto");
return;

}

?>