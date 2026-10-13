<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="beauty/style.css">
</head>
<body>
<div class="container">
<h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>

<p>You are logged in successfully.</p>

<a href="add_student.php">Register Student</a><br><br>
<a href="add_teacher.php">Manage Teachers</a><br><br>
<a href="add_course.php">Manage Courses</a><br><br>
<a href="assign_teacher.php">Assign Teacher</a><br><br>
<a href="enroll_student.php">Enroll Student</a><br><br>
<a href="fee_management.php">Fee Management</a><br><br>
<a href="timetable.php">Class Timetable</a><br><br>
<a href="logout.php">Logout</a>
</div>
</body>
</html>