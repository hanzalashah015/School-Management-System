<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $query = "DELETE FROM teacher WHERE teacher_id=$id";

    if (mysqli_query($conn, $query)) {
        header("Location: add_teacher.php");
        exit();
    } else {
        echo "Error deleting teacher.";
    }
}
?>