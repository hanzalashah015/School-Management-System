<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

// Add timetable
if (isset($_POST['add_schedule'])) {

    $course_id = $_POST['course_id'];
    $teacher_id = $_POST['teacher_id'];
    $class_day = $_POST['class_day'];
    $class_time = $_POST['class_time'];

    // Conflict check
    $check = mysqli_query($conn, "
        SELECT * FROM timetable
        WHERE teacher_id='$teacher_id'
        AND class_day='$class_day'
        AND class_time='$class_time'
    ");

    if (mysqli_num_rows($check) > 0) {

        $message = "Scheduling conflict! Teacher already assigned at this time.";

    } else {

        $query = "INSERT INTO timetable
                  (course_id, teacher_id, class_day, class_time)
                  VALUES
                  ('$course_id', '$teacher_id', '$class_day', '$class_time')";

        if (mysqli_query($conn, $query)) {
            $message = "Timetable created successfully!";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}

// Fetch data
$courses = mysqli_query($conn, "SELECT * FROM course");
$teachers = mysqli_query($conn, "SELECT * FROM teacher");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Class Timetable</title>
    <link rel="stylesheet" href="beauty/style.css">
</head>
<body>
<div class="container">
<h2>Class Time Schedule Module</h2>

<form method="POST">

    <label>Select Course:</label><br>
    <select name="course_id">

        <?php while ($c = mysqli_fetch_assoc($courses)) { ?>

            <option value="<?php echo $c['course_id']; ?>">
                <?php echo $c['course_name']; ?>
            </option>

        <?php } ?>

    </select><br><br>

    <label>Select Teacher:</label><br>
    <select name="teacher_id">

        <?php while ($t = mysqli_fetch_assoc($teachers)) { ?>

            <option value="<?php echo $t['teacher_id']; ?>">
                <?php echo $t['name']; ?>
            </option>

        <?php } ?>

    </select><br><br>

    <label>Class Day:</label><br>
    <input type="text" name="class_day" placeholder="Monday" required><br><br>

    <label>Class Time:</label><br>
    <input type="text" name="class_time" placeholder="10:00 AM - 11:00 AM" required><br><br>

    <button type="submit" name="add_schedule">
        Create Schedule
    </button>

</form>

<p><?php echo $message; ?></p>

<hr>

<h3>Class Timetable</h3>

<table border="1" cellpadding="10">

<tr>
    <th>Course</th>
    <th>Teacher</th>
    <th>Day</th>
    <th>Time</th>
</tr>

<?php

$result = mysqli_query($conn, "
    SELECT
        course.course_name,
        teacher.name,
        timetable.class_day,
        timetable.class_time

    FROM timetable

    JOIN course
    ON course.course_id = timetable.course_id

    JOIN teacher
    ON teacher.teacher_id = timetable.teacher_id
");

while ($row = mysqli_fetch_assoc($result)) {

?>

<tr>
    <td><?php echo $row['course_name']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['class_day']; ?></td>
    <td><?php echo $row['class_time']; ?></td>
</tr>

<?php } ?>

</table>

<br>

<a href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>