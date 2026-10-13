<?php
include("db.php");

$message = "";

if (isset($_POST['signup'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO admin (username, email, password)
              VALUES ('$username', '$email', '$hashed_password')";

    if (mysqli_query($conn, $query)) {
        header("Location: login.php");
exit();
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Signup</title>
    <link rel="stylesheet" href="beauty/style.css">
</head>
<body>
<div class="container">
<h2>Admin Registration</h2>

<form method="POST">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="signup">Sign Up</button>
</form>

<p><?php echo $message; ?></p>
</div>
</body>
</html>