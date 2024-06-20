<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../employee/css/view-employee.css">
    <title>Leave Status</title>
</head>

<body>
    <?php
    include "../databases/db.php";
    $sql = "SELECT * FROM leave_applications WHERE employees_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['employees_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    echo "<table>";
    echo "<tr>";
    echo "<th>Start Date</th>";
    echo "<th>End Date</th>";
    echo "<th>Reason</th>";
    echo "<th>Status</th>";
    echo "<th>Applied Date</th>";
    echo "<th>Days of Leave</th>";
    echo "<th>Resume Date</th>";
    echo "</tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['start_date'] . "</td>";
        echo "<td>" . $row['end_date'] . "</td>";
        echo "<td>" . $row['reason'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "<td>" . $row['applied_date'] . "</td>";
        echo "<td>" . $row['days_of_leave'] . "</td>";
        echo "<td>" . $row['resume_date'] . "</td>";
        echo "</tr>";
    }
    ?>

</body>

</html>