<?php
session_start();
include "db.php";

$id = $_SESSION['id'];

$res = $conn->query("SELECT * FROM users WHERE id=$id");
$user = $res->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h2>My Profile 👤</h2>

    <img src="images/<?php echo $user['profile_pic'] ?? 'default.png'; ?>" width="120">

    <form action="update_profile.php" method="POST" enctype="multipart/form-data">

        <input type="text" name="username" value="<?php echo $user['username']; ?>"><br>

        <input type="email" name="email" value="<?php echo $user['email']; ?>"><br>

        <input type="text" name="mobile" value="<?php echo $user['mobile']; ?>"><br>

        <select name="gender">
            <option value="male" <?php if($user['gender']=="male") echo "selected"; ?>>Male</option>
            <option value="female" <?php if($user['gender']=="female") echo "selected"; ?>>Female</option>
        </select><br>

        <input type="file" name="image"><br>

        <button>Update Profile</button>

    </form>

</div>

</body>
</html>