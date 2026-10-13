<?php
session_start();
include("db.php");

// Protect page
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if (isset($_POST['add_teacher'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];

    $query = "INSERT INTO teacher (name, email, subject)
              VALUES ('$name', '$email', '$subject')";

    if (mysqli_query($conn, $query)) {
        $message = "Teacher added successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Teacher</title>
    <link rel="stylesheet" href="beauty/style.css">
</head>
<body>
<div class="container">
<h2>Teacher Registration</h2>

<form method="POST">
    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email"><br><br>

    <label>Subject:</label><br>
    <input type="text" name="subject"><br><br>

    <button type="submit" name="add_teacher">Add Teacher</button>
</form>

<p><?php echo $message; ?></p>

<hr>

<h3>Teacher List</h3>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Subject</th>
    <th>Action</th>
</tr>

<?php
$result = mysqli_query($conn, "SELECT * FROM teacher");

while ($row = mysqli_fetch_assoc($result)) {
?>
<tr>
    <td><?php echo $row['teacher_id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['subject']; ?></td>
    <td>
        <a href="delete_teacher.php?id=<?php echo $row['teacher_id']; ?>"
           onclick="return confirm('Delete this teacher?');">
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