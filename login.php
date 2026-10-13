<?php
session_start();
include("db.php");

$message = "";

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admin WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {

        $admin = mysqli_fetch_assoc($result);

        // Verify hashed password
        if (password_verify($password, $admin['password'])) {

            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['username'] = $admin['username'];

            header("Location: dashboard.php");
            exit();

        } else {
            $message = "Invalid Password!";
        }

    } else {
        $message = "Username not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="beauty/style.css">
</head>
<body>
<div class="container">
<h2>Admin Login</h2>

<form method="POST">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="login">Login</button>
</form>

<p><?php echo $message; ?></p>
</div>
</body>
</html>