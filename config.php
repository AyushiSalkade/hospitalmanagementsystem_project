<?php
$servername = "localhost";
$username = "root"; // XAMPP में Default Username
$password = ""; // Default Password खाली छोड़ें
$dbname = "database hospital_db"; // आपने जो Database बनाया

// MySQL Connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check Connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>