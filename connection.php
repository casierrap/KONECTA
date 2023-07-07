<?php
    $servername = "localhost";
    $database = "konecta";
    $username = "root";
    $password = "12345678";
 
    $conn = mysqli_connect($servername, $username, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>