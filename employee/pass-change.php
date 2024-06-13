<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Employee</title>
    <link rel="icon" type="image/x-icon" href="public/iitspath.svg">
    <link rel="stylesheet" type="text/css" href="./css/add-employee.css">
</head>

<body>
    <button id="back"><a href="/employee/dashboard.php">Back</a></button>
    <?php
    include "../databases/db.php";
    $employees_sql = "SELECT * FROM employees";
    $employees_result = $conn->query($employees_sql);
    $employees = [];
    if ($employees_result->num_rows > 0) {
        while ($row = $employees_result->fetch_assoc()) {
            $employees[] = $row;
        }
    }
    ?>
    
    <?php
    include '../databases/db.php';
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM employees WHERE id=$id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "<script>alert('No employee found with the given ID'); window.location.href='/employee/dashboard.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('No ID provided'); window.location.href='/employee/dashboard.php';</script>";
        exit();
    }
    ?>
    <form method="POST" id="add-form">
        <label for="password">Employee Password:</label>
        <input type="password" name="password" id="password" required value="<?php echo htmlspecialchars($row['password']); ?>">
        <button type="submit" id="add-button">Update Employee</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $password = $_POST['password'];

        $sql = "UPDATE employees SET password='$password' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Employee password updated successfully'); window.location.href='?page=employees';</script>";
            exit();
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }
    ?>
</body>
</html>