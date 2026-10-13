<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM student WHERE student_id=$id");
$student = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="beauty/style.css">
</head>
<body>
<div class="container">
<h2>Edit Student</h2>

<form method="POST" action="update_student.php">
    <input type="hidden" name="student_id" value="<?php echo $student['student_id']; ?>">

    <label>Name:</label><br>
    <input type="text" name="name" value="<?php echo $student['name']; ?>" required><br><br>

    <label>Class:</label><br>
    <input type="text" name="class" value="<?php echo $student['class']; ?>" required><br><br>

    <button type="submit" name="update_student">Update</button>
</form>
</div>
</body>
</html>