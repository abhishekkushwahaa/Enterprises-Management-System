<?php
include "../databases/db.php";
$employee_id = $_SESSION['employees_id'];
$sql = "SELECT id, applied_date, start_date, days_of_leave, resume_date, status 
        FROM leave_applications 
        WHERE employees_id = $employee_id
        ORDER BY start_date DESC
        LIMIT 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<h3 id='leave-info'>Your leave Application is <a id='leave-status' href='apply-leave.php'>". $row["status"] . " </a>for " . $row["start_date"] . "</h3>";
    }
} else {
    echo "<h3 id='leave-info'>No leave applications found!</h3>";
}

$conn->close();
