<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Documents</title>
    <style>
        #Docs-info {
            text-align: center;
        }
    </style>
</head>

<body>
    <?php
    include "../databases/db.php";
    $employee_id = $_SESSION['employees_id'];

    $sql = "SELECT * FROM employees WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<h3 id='Docs-info'>Your Documents is " . $row["status"] . ", Your information and documents are given below. " . "</h3>";
        }
    }
    $stmt->close();
    $conn->close();
    ?>

    <?php
    if ($employee['status'] == 'Rejected') {
        echo "<div style='background-color: #f2f2f2; padding: 20px; margin-top: 20px; border-radius: 5px;'>";
        include "../employee/reject_docs.php";
        echo "</div>";
    }
    ?>

</body>

</html>