<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Assign teacher
if (isset($_POST['assign'])) {

    $teacher_id = $_POST['teacher_id'];
    $course_id = $_POST['course_id'];

    $query = "INSERT INTO teacher_course (teacher_id, course_id)
              VALUES ('$teacher_id', '$course_id')";

    mysqli_query($conn, $query);
}

// Fetch teachers & courses
$teachers = mysqli_query($conn, "SELECT * FROM teacher");
$courses = mysqli_query($conn, "SELECT * FROM course");
?>

<h2>Assign Teacher to Course</h2>

<form method="POST">
    <label>Select Teacher:</label><br>
    <select name="teacher_id">
        <?php while ($t = mysqli_fetch_assoc($teachers)) { ?>
            <option value="<?php echo $t['teacher_id']; ?>">
                <?php echo $t['name']; ?>
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

    <button type="submit" name="assign">Assign</button>
</form>

<hr>

<h3>Teaching Load</h3>

<table border="1" cellpadding="10">
<tr>
    <th>Teacher</th>
    <th>Course</th>
</tr>

<?php
$result = mysqli_query($conn, "
    SELECT teacher.name, course.course_name
    FROM teacher_course
    JOIN teacher ON teacher.teacher_id = teacher_course.teacher_id
    JOIN course ON course.course_id = teacher_course.course_id
");

while ($row = mysqli_fetch_assoc($result)) {
?>
<tr>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['course_name']; ?></td>
</tr>
<?php } ?>
</table>