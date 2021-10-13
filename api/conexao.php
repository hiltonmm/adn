<?php
date_default_timezone_set("America/Sao_Paulo");

$servername = "localhost";
$username = "adn";
$password = "123";
$database = "adn";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>