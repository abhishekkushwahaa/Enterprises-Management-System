<?php
include "../databases/db.php";
date_default_timezone_set('Asia/Kolkata');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employees_id = $_POST['employees_id'] ?? null;
    $status = $_POST['status'] ?? 'Absent';
    $date = date('Y-m-d');
    $current_datetime = date('Y-m-d H:i:s');
    $check_in = null;
    $check_out = null;

    $sql_check = "SELECT * FROM attendance WHERE employees_id = ? AND date = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("is", $employees_id, $date);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $row = $result_check->fetch_assoc();

        if ($status == 'Present') {
            $check_in = $current_datetime;
            $sql_update = "UPDATE attendance SET check_in = ?, status = ? WHERE employees_id = ? AND date = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("ssis", $check_in, $status, $employees_id, $date);
            $stmt_update->execute();
        } else {
            $sql_check = "SELECT status FROM attendance WHERE employees_id = ? AND date = ?";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bind_param("is", $employees_id, $date);
            $stmt_check->execute();
            $stmt_check->bind_result($existing_status);
            $stmt_check->fetch();
            $stmt_check->close();

            $check_out = $current_datetime;

            if ($existing_status == 'Present') {
                $sql_update = "UPDATE attendance SET check_out = ? WHERE employees_id = ? AND date = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("sis", $check_out, $employees_id, $date);
                $stmt_update->execute();
            } else {
                $status = 'Present';
                $sql_update = "UPDATE attendance SET check_out = ?, status = ? WHERE employees_id = ? AND date = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("ssis", $check_out, $status, $employees_id, $date);
                $stmt_update->execute();
            }
        }
        echo "Attendance updated successfully";
    } else {
        $status = 'Absent';
        $sql_insert = "INSERT INTO attendance (employees_id, date, check_in, status) VALUES (?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("isss", $employees_id, $date, $current_datetime, $status);
        $stmt_insert->execute();
        echo "Attendance recorded successfully";
    }
    if (isset($stmt_update)) {
        $stmt_update->close();
    }
    if (isset($stmt_insert)) {
        $stmt_insert->close();
    }
}

$conn->close();
