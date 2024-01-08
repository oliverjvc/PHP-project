<?php

$host = "localhost";
$username = "root";
$password = "root";
$database = "online_bookstore";

// Kreiranje konekcije
$connection = mysqli_connect($host, $username, $password, $database);

// Provera konekcije
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($connection, "utf8");

?>
