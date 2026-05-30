<!--combines php with html-->

<?php
session_start();
include "db.php";

if (!isset($_SESSION['id'])) {                   //user not defined then again to login page
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];                    //information about user 
$gender = $_GET['gender'] ?? '';
$category = $_GET['category'] ?? '';
$search = $_GET['search'] ?? '';

$query = "SELECT * FROM products WHERE user_id='$user_id'";     //fetch only current user products 

if ($search != '') {
    $query .= " AND name LIKE '%$search%'";
}

if ($gender != '') {
    $query .= " AND (gender='$gender' OR gender='all')";
}

if ($category != '') {
    $query .= " AND category='$category'";
}

$result = $conn->query($query);                             //execution of query

function buildLink($g, $c, $s) {                          //helper function to built links for filtering products
    $params = [];
    if ($g) $params[] = "gender=$g";
    if ($c) $params[] = "category=$c";
    if ($s) $params[] = "search=$s";
    return "dashboard.php?" . implode("&", $params);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css?v=premium">
</head>
<body>

<div class="sidebar">
    <div class="profile-section">                        <!--left side bar-->
        <img src="images/default.png" alt="Profile">
        <h3><?php echo $_SESSION['user']; ?></h3>               <!--showed logged in user --> 
    </div>

    <div class="menu">
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="add.php">➕ Add Product</a>
        <a href="profile.php">👤 Profile</a>
        <a href="cart.php">🛒 Cart</a>
        <a href="wishlist.php">❤️ Wishlist</a>
        <a href="logout.php">🚪 Logout</a>
    </div>
</div>

<div class="content">
    <div class="top-bar">
        <h2>🛍️ My Store</h2>
        <div>
            <a href="add.php" class="add-btn">+ Add</a>
            <a href="cart.php">🛒</a>
            <a href="wishlist.php">❤️</a>
            <a href="logout.php">🚪</a>
        </div>
    </div>

    <div class="category-bar">
        <a href="dashboard.php">All</a>
        <a href="<?php echo buildLink('men', $category, $search); ?>">👨 Men</a>
        <a href="<?php echo buildLink('female', $category, $search); ?>">👩 Female</a>
        <a href="<?php echo buildLink('children', $category, $search); ?>">🧒 Children</a>
    </div>

    <div class="category-bar">
        <a href="<?php echo buildLink($gender, 'stationery', $search); ?>">📒 Stationery</a>
        <a href="<?php echo buildLink($gender, 'jewellery', $search); ?>">💍 Jewellery</a>
        <a href="<?php echo buildLink($gender, 'undergarments', $search); ?>">👕 Undergarments</a>
        <a href="<?php echo buildLink($gender, 'makeup', $search); ?>">💄 Makeup</a>
        <a href="<?php echo buildLink($gender, 'Garments', $search); ?>">👕 Garments</a>
        <a href="<?php echo buildLink($gender, 'medicines', $search); ?>">💊 Medicines</a>
        <a href="<?php echo buildLink($gender, 'accessories', $search); ?>">👜 Accessories</a>
        <a href="<?php echo buildLink($gender, 'skincare', $search); ?>">🧴 Skincare</a>
        <a href="<?php echo buildLink($gender, 'grocery', $search); ?>">🛒 Grocery</a>
        <a href="<?php echo buildLink($gender, 'sports', $search); ?>">⚽ Sports</a>
    </div>

    <div class="product-grid">
        <?php while($row = $result->fetch_assoc()) { ?>                <!-- loops through each product-->
            <div class="product-card">
                <img src="images/<?php echo $row['image']; ?>" onerror="this.src='images/default.png';">
                <h3><?php echo $row['name']; ?></h3>
                <p class="price">₹<?php echo $row['price']; ?></p>
                <p>Stock: <?php echo $row['quantity']; ?></p>
                <div class="buttons">
                    <a href="cart.php?add=<?php echo $row['id']; ?>">🛒</a>
                    <a href="wishlist.php?add=<?php echo $row['id']; ?>">❤️</a>
                    <a href="delete.php?id=<?php echo $row['id']; ?>">❌</a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>