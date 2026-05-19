<?php  

    $host= "localhost";
    $user= "root";
    $password = "";
    $dbname= "proyecto";

    $con = mysqli_connect($host, $user, $password, $dbname);

    $con = mysqli_connect($host, $user, $password, $dbname);

if (!$con) {
    die("Error de conexión: " . mysqli_connect_error());
}

?>