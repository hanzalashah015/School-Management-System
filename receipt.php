<?php
include("db.php");

$id = $_GET['id'];

$query = "
    SELECT fee.*, student.name
    FROM fee
    JOIN student ON student.student_id = fee.student_id
    WHERE fee.fee_id=$id
";

$result = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);
?>

<h2>Payment Receipt</h2>

<p><strong>Student:</strong> <?php echo $row['name']; ?></p>

<p><strong>Amount:</strong> <?php echo $row['amount']; ?></p>

<p><strong>Status:</strong> <?php echo $row['payment_status']; ?></p>

<p><strong>Date:</strong> <?php echo $row['payment_date']; ?></p>

<hr>

<p>School Management System</p>