<?php
$servername = "localhost";
$username = "root";
$password = "chontech2023!";
$dbname = "overtime";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");
?>