<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

// Add fee record
if (isset($_POST['add_fee'])) {

    $student_id = $_POST['student_id'];
    $amount = $_POST['amount'];
    $payment_status = $_POST['payment_status'];
    $payment_date = $_POST['payment_date'];

    $query = "INSERT INTO fee (student_id, amount, payment_status, payment_date)
              VALUES ('$student_id', '$amount', '$payment_status', '$payment_date')";

    if (mysqli_query($conn, $query)) {
        $message = "Fee record added successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

$students = mysqli_query($conn, "SELECT * FROM student");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Fee Management</title>
    <link rel="stylesheet" href="beauty/style.css">
</head>
<body>
<div class="container">
<h2>Fee Management</h2>

<form method="POST">

    <label>Select Student:</label><br>
    <select name="student_id">
        <?php while ($s = mysqli_fetch_assoc($students)) { ?>
            <option value="<?php echo $s['student_id']; ?>">
                <?php echo $s['name']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <label>Amount:</label><br>
    <input type="number" name="amount" required><br><br>

    <label>Payment Status:</label><br>
    <select name="payment_status">
        <option value="Paid">Paid</option>
        <option value="Unpaid">Unpaid</option>
    </select><br><br>

    <label>Payment Date:</label><br>
    <input type="date" name="payment_date"><br><br>

    <button type="submit" name="add_fee">Add Fee Record</button>
</form>

<p><?php echo $message; ?></p>

<hr>

<h3>Fee Records</h3>

<table border="1" cellpadding="10">

<tr>
    <th>Student</th>
    <th>Amount</th>
    <th>Status</th>
    <th>Date</th>
    <th>Receipt</th>
</tr>

<?php
$result = mysqli_query($conn, "
    SELECT fee.*, student.name
    FROM fee
    JOIN student ON student.student_id = fee.student_id
");

while ($row = mysqli_fetch_assoc($result)) {
?>

<tr>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['amount']; ?></td>
    <td><?php echo $row['payment_status']; ?></td>
    <td><?php echo $row['payment_date']; ?></td>
    <td>
        <a href="receipt.php?id=<?php echo $row['fee_id']; ?>">
            Generate Receipt
        </a>
    </td>
</tr>

<?php } ?>

</table>

<hr>

<h3>Financial Report</h3>

<?php

$paid = mysqli_query($conn, "
    SELECT SUM(amount) AS total_paid
    FROM fee
    WHERE payment_status='Paid'
");

$unpaid = mysqli_query($conn, "
    SELECT SUM(amount) AS total_unpaid
    FROM fee
    WHERE payment_status='Unpaid'
");

$paid_row = mysqli_fetch_assoc($paid);
$unpaid_row = mysqli_fetch_assoc($unpaid);

?>

<p>Total Paid Amount: <?php echo $paid_row['total_paid']; ?></p>
<p>Total Unpaid Amount: <?php echo $unpaid_row['total_unpaid']; ?></p>

<br>
<a href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>