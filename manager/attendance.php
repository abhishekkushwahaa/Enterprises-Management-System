<?php
include '../databases/db.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM employees WHERE id=$id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
}

// Get the total number of days present
$sql = "SELECT ROUND((SELECT COUNT(*) FROM attendance WHERE status='present' AND employees_id=$id) / (SELECT COUNT(*) FROM attendance WHERE employees_id=$id) * 100) AS present_percentage FROM attendance WHERE date = date(NOW()) AND employees_id=$id";
$result_percentage = $conn->query($sql);
$present_percentage = 0;
if ($result_percentage->num_rows > 0) {
    $row_percentage = $result_percentage->fetch_assoc();
    $present_percentage = $row_percentage['present_percentage'];
}

$sql = "SELECT * FROM attendance WHERE employees_id=$id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table><tr><th>Date</th><th>CheckIn</th><th>CheckOut</th><th>Status</th><th>On Leave</th><th>Total</th></tr>";
    while ($row = $result->fetch_assoc()) {
        $check_in = date("g:i A", strtotime($row["check_in"]));
        $check_out = date("g:i A", strtotime($row["check_out"]));
        echo "<tr><td>" . $row["date"] . "</td><td>" . $check_in . "</td><td>" . $check_out . "</td><td>" . $row["status"] . "</td><td>" . $row["leave"] . "</td><td>" . $present_percentage . "%" . "</td></tr>";
    }
    echo "</table>";
}

$conn->close();
?>