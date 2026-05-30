<?php
$conn = new mysqli("localhost", "root", "", "inventory_system");           //creates a connection using MySQLi

if ($conn->connect_error) {                                                //if connection fail immediately stop program
    die("Connection failed: " . $conn->connect_error);
}
?>

