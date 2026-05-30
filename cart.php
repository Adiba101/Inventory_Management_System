<?php
session_start();
include "db.php";

$uid = $_SESSION['id'];

if (isset($_GET['add'])) {
    $pid = $_GET['add'];
    $conn->query("INSERT INTO cart (user_id,product_id) VALUES ($uid,$pid)");
}

if (isset($_GET['remove'])) {
    $pid = $_GET['remove'];
    $conn->query("DELETE FROM cart WHERE product_id=$pid AND user_id=$uid");
}

$res = $conn->query("SELECT p.* FROM cart c JOIN products p ON c.product_id=p.id WHERE c.user_id=$uid");

while($row = $res->fetch_assoc()) {
    echo $row['name']." ₹".$row['price']." ";
    echo "<a href='cart.php?remove=".$row['id']."'>Remove</a><br>";
}