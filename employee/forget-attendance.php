<?php
include "../databases/db.php";
date_default_timezone_set('Asia/Kolkata');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employees_id = $_POST['employees_id'] ?? null;
    $status = $_POST['status'] ?? 'Present';
    $date = $_POST['date'] ?? date('Y-m-d');
    $check_in = $_POST['checkin'] ?? null;
    $check_out = $_POST['checkout'] ?? null;

    $sql = "SELECT * FROM attendance WHERE employees_id = ? AND date = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $employees_id, $date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sql = "UPDATE attendance SET check_out = ? WHERE employees_id = ? AND date = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sis", $check_out, $employees_id, $date);
        $stmt->execute();
        echo "<script>alert('Attendance updated successfully');</script>";
    } else {
        $sql = "INSERT INTO attendance (employees_id, date, check_in, check_out, status)
            VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $employees_id, $date, $check_in, $check_out, $status);
        $stmt->execute();
        echo "<script>alert('Attendance recorded successfully');</script>";
    }
    echo "<script>window.location.href = 'dashboard.php';</script>";
}
