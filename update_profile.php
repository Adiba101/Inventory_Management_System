<?php
session_start();
include "db.php";

$id = $_SESSION['id'];

$username = $_POST['username'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$gender = $_POST['gender'];

$image = $_FILES['image']['name'];

if ($image != "") {
    move_uploaded_file($_FILES['image']['tmp_name'], "images/".$image);

    $conn->query("UPDATE users SET 
        username='$username',
        email='$email',
        mobile='$mobile',
        gender='$gender',
        profile_pic='$image'
        WHERE id=$id");
} else {
    $conn->query("UPDATE users SET 
        username='$username',
        email='$email',
        mobile='$mobile',
        gender='$gender'
        WHERE id=$id");
}

header("Location: profile.php");
?>