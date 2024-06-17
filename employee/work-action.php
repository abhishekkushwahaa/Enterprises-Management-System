<?php
include "../databases/db.php";
date_default_timezone_set('Asia/Kolkata');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_POST['employee_id'] ?? null;
    $date = $_POST['date'] ?? null;
    $work_categories = $_POST['work'] ?? [];

    foreach ($work_categories as $category) {
        $start_time = $_POST[$category . '-time'][0] ?? null;
        $end_time = $_POST[$category . '-time'][1] ?? null;
        $description = $_POST[$category . '-description'] ?? null;

        if ($start_time === null || $end_time === null || $description === null) {
            echo "<script>alert('All fields are required. Please fill out all fields.');</script>";
            return;
        }

        $sql = "INSERT INTO work_updates (employees_id, date, category, start_time, end_time, description) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssss", $employee_id, $date, $category, $start_time, $end_time, $description);
        $stmt->execute();
        echo "<script>alert('Work updated successfully');</script>";
        echo "<script>window.location = 'dashboard.php';</script>";
    }
    $stmt->close();
    $conn->close();
}
