<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['enroll'])) {

    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];

    $query = "INSERT INTO enrollment (student_id, course_id, status)
              VALUES ('$student_id', '$course_id', 'Enrolled')";

    mysqli_query($conn, $query);
}

$students = mysqli_query($conn, "SELECT * FROM student");
$courses = mysqli_query($conn, "SELECT * FROM course");
?>

<h2>Enroll Student in Course</h2>

<form method="POST">
    <label>Select Student:</label><br>
    <select name="student_id">
        <?php while ($s = mysqli_fetch_assoc($students)) { ?>
            <option value="<?php echo $s['student_id']; ?>">
                <?php echo $s['name']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <label>Select Course:</label><br>
    <select name="course_id">
        <?php while ($c = mysqli_fetch_assoc($courses)) { ?>
            <option value="<?php echo $c['course_id']; ?>">
                <?php echo $c['course_name']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <button type="submit" name="enroll">Enroll</button>
</form>

<hr>

<h3>Enrollment List</h3>

<table border="1" cellpadding="10">
<tr>
    <th>Student</th>
    <th>Course</th>
    <th>Status</th>
</tr>

<?php
$result = mysqli_query($conn, "
    SELECT student.name, course.course_name, enrollment.status
    FROM enrollment
    JOIN student ON student.student_id = enrollment.student_id
    JOIN course ON course.course_id = enrollment.course_id
");

while ($row = mysqli_fetch_assoc($result)) {
?>
<tr>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['course_name']; ?></td>
    <td><?php echo $row['status']; ?></td>
</tr>
<?php } ?>
</table>