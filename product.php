<?php
include "db.php";

$id = $_GET['id'];

$res = $conn->query("SELECT * FROM products WHERE id=$id");
$row = $res->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $row['name']; ?></title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="form-container">

    <h2><?php echo $row['name']; ?></h2>

    <img src="images/<?php echo $row['image']; ?>" width="200">

    <p>Price: ₹<?php echo $row['price']; ?></p>
    <p>Stock: <?php echo $row['quantity']; ?></p>
    <p>Category: <?php echo $row['category']; ?></p>
    <p>Section: <?php echo $row['gender']; ?></p>

    <a href="cart.php?add=<?php echo $row['id']; ?>">Add to Cart</a>
    <a href="wishlist.php?add=<?php echo $row['id']; ?>">Wishlist</a>

</div>

</body>
</html>