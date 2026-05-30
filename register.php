<?php
include "db.php";

if ($_POST) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $mobile = $_POST['mobile'];
    $gender = $_POST['gender'];

    $conn->query("INSERT INTO users (username,email,password,mobile,gender)
                  VALUES ('$username','$email','$password','$mobile','$gender')");

    echo "Registered successfully! <a href='login.php'>Login</a>";
}
?>

<form method="POST">
    <h2>Register</h2>
    <input name="username" placeholder="Username" required><br>
    <input name="email" placeholder="Email" required><br>
    <input name="password" placeholder="Password" required><br>
    <input name="mobile" placeholder="Mobile"><br>

    <select name="gender">
        <option>Male</option>
        <option>Female</option>
    </select><br>

    <button>Register</button>
</form>