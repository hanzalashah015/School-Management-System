<?php
session_start();
include("db.php");

// Protect page
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if (isset($_POST['add_student'])) {

    $name = $_POST['name'];
    $class = $_POST['class'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $query = "INSERT INTO student (name, class, email, phone)
              VALUES ('$name', '$class', '$email', '$phone')";

    if (mysqli_query($conn, $query)) {
        $message = "Student registered successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link rel="stylesheet" href="beauty/style.css">
</head>
<body>
<div class="container">
<h2>Register Student</h2>

<form method="POST">
    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Class:</label><br>
    <input type="text" name="class" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email"><br><br>

    <label>Phone:</label><br>
    <input type="text" name="phone"><br><br>

    <button type="submit" name="add_student">Register</button>
</form>

<p><?php echo $message; ?></p>
<h3>Student List</h3>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Class</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Action</th>
</tr>

<?php
$result = mysqli_query($conn, "SELECT * FROM student");

while ($row = mysqli_fetch_assoc($result)) {
?>
<tr>
    <td><?php echo $row['student_id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['class']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['phone']; ?></td>
    <td>
    <a href="edit_student.php?id=<?php echo $row['student_id']; ?>">Edit</a> |
    <a href="delete_student.php?id=<?php echo $row['student_id']; ?>" 
       onclick="return confirm('Are you sure you want to delete this student?');">
       Delete
    </a>
</td>
</tr>
<?php } ?>
</table>
<br>
<a href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>