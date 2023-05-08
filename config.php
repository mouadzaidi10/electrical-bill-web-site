<?php 

//POD
$server = "localhost";
$user = "root";
$pass = "";
$database = "programmation_web_tp2";

$conn = mysqli_connect($server, $user, $pass, $database);

if (!$conn) {
    die("<script>alert('Connection Failed.')</script>");
}
?>