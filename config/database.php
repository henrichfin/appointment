<?php
$host = 'localhost';
$dbname = 'guidance_system';
$username = 'root'; // usually 'root' for local development
$password = '' ; // blank for local development often

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>