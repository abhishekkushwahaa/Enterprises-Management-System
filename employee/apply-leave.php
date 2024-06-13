<?php
ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/tmp'));
ini_set('session.gc_probability', 1);
session_start();

include "../databases/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = $_POST["leave_date"];
    $days_of_leave = $_POST["leave_days"];
    $reason = $_POST["leave_reason"];
    $resume_date = $_POST["resume_date"];
    $applied_date = date("Y-m-d");
    $status = "Pending";

    $end_date = date('Y-m-d', strtotime($start_date . ' + ' . $days_of_leave . ' days'));

    if (isset($_SESSION['employees_id']) && isset($_SESSION['name'])) {
        $employee_id = $_SESSION['employees_id'];
        $employee_name = $_SESSION['name'];

        $sql = "INSERT INTO leave_applications (employees_id, start_date, end_date, reason, status, applied_date, days_of_leave, resume_date, employee_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssssiss", $employee_id, $start_date, $end_date, $reason, $status, $applied_date, $days_of_leave, $resume_date, $employee_name);

        if ($stmt->execute()) {
            echo "<script>alert('Leave application submitted successfully!'); window.location.href = '/employee/dashboard.php';</script>";
        } else {
            echo "<script>alert('Error submitting leave application: " . htmlspecialchars($stmt->error) . "');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Please try again.'); window.location.href = '/employee/dashboard.php';</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Apply for Leave</title>
    <link rel="stylesheet" href="../employee/css/leave.css">
</head>

<body>
    <button id="back"><a href="/employee/dashboard.php">Back</a></button>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h1 id="H1leave">Apply for Leave</h1>
        <label for="leave_date">Select leave date:</label><br>
        <input type="date" id="leave_date" name="leave_date" required><br>
        <label for="leave_days">How many days of leave?</label><br>
        <input type="number" id="leave_days" name="leave_days" required><br>
        <label for="leave_reason">Reason for leave:</label><br>
        <textarea id="leave_reason" name="leave_reason" required></textarea><br>
        <label for="resume_date">When will you resume?</label><br>
        <input type="date" id="resume_date" name="resume_date" required><br>
        <input type="submit" value="Submit">
    </form>
</body>

</html>
