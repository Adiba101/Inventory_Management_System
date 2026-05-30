<?php
session_start();
include "db.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];
    $gender = $_POST['gender'];

    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "images/".$image);

    $conn->query("INSERT INTO products 
    (name, quantity, price, image, category, gender, user_id)
    VALUES 
    ('$name','$quantity','$price','$image','$category','$gender','$user_id')");

    echo "<script>alert('Product Added Successfully');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
</head>

<body>

<h2>Add Product</h2>

<form method="POST" enctype="multipart/form-data">

    <input type="text" name="name" placeholder="Product Name" required><br><br>

    <input type="number" name="price" placeholder="Price" required><br><br>

    <input type="number" name="quantity" placeholder="Quantity" required><br><br>

    <label>Category</label>
        <select name="category" required>
            <option value="">Select Category</option>
            <option value="stationery">Stationery</option>
            <option value="jewellery">Jewellery</option>
            <option value="undergarments">Undergarments</option>
            <option value="Garments">Garments</option>
            <option value="makeup">Makeup</option>
            <option value="medicines">Medicines</option>
            <option value="accessories">Accessories</option>
            <option value="skincare">Skincare</option>
            <option value="grocery">Grocery</option>
            <option value="sports">Sports</option>
    </select><br><br>


    <select name="gender" required>
        <option value="">Select Section</option>
        <option value="all">All</option>
        <option value="men">Men</option>
        <option value="female">Female</option>
        <option value="children">Children</option>
    </select><br><br>

    <input type="file" name="image" required><br><br>

    <button type="submit">Add Product</button>

</form>

</body>
</html>