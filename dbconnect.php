<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lang"; // Make sure this is the correct database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
