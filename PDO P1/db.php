<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "roosterwebsite";

// Database connectie maken
$conn = new mysqli($host, $user, $pass, $dbname);

// Foutmelding bij mislukte connectie
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}
?>
