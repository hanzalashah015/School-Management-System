<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if (isset($_POST['add_course'])) {

    $course_name = $_POST['course_name'];
    $department = $_POST['department'];

    $query = "INSERT INTO course (course_name, department)
              VALUES ('$course_name', '$department')";

    if (mysqli_query($conn, $query)) {
        $message = "Course added successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Course</title>
    <link rel="stylesheet" href="beauty/style.css">
</head>
<body>
<div class="container">
<h2>Course Management</h2>

<form method="POST">
    <label>Course Name:</label><br>
    <input type="text" name="course_name" required><br><br>

    <label>Department:</label><br>
    <input type="text" name="department"><br><br>

    <button type="submit" name="add_course">Add Course</button>
</form>

<p><?php echo $message; ?></p>

<hr>

<h3>Course List</h3>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Course Name</th>
    <th>Department</th>
    <th>Action</th>
</tr>

<?php
$result = mysqli_query($conn, "SELECT * FROM course");

while ($row = mysqli_fetch_assoc($result)) {
?>
<tr>
    <td><?php echo $row['course_id']; ?></td>
    <td><?php echo $row['course_name']; ?></td>
    <td><?php echo $row['department']; ?></td>
    <td>
        <a href="delete_course.php?id=<?php echo $row['course_id']; ?>"
           onclick="return confirm('Delete this course?');">
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