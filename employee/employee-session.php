<?php
$employee_id = $_SESSION['employees_id'];

include "../databases/db.php";
$sql = "SELECT photo, educational_document, previous_certificate FROM employees WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();

$show_form = is_null($employee['photo']) && is_null($employee['educational_document']) && is_null($employee['previous_certificate']);

$stmt->close();
$conn->close();
?>