<?php
session_start();
include("db.php");

if (isset($_POST['update_student'])) {

    $id = $_POST['student_id'];
    $name = $_POST['name'];
    $class = $_POST['class'];

    $query = "UPDATE student SET name='$name', class='$class'
              WHERE student_id=$id";

    if (mysqli_query($conn, $query)) {
        header("Location: add_student.php");
        exit();
    } else {
        echo "Error updating record.";
    }
}
?>