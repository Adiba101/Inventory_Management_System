<?php
session_start();
include "db.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$user_id = $_SESSION['id'];

// IMPORTANT: Only delete own product
$conn->query("DELETE FROM products WHERE id='$id' AND user_id='$user_id'");

header("Location: dashboard.php");
?>