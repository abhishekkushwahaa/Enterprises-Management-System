<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Manager</title>
    <link rel="icon" type="image/x-icon" href="public/iitspath.svg">
    <link rel="stylesheet" type="text/css" href="./css/add-employee.css">
</head>

<body>
    <a id="back" href="/manager/dashboard.php" role="button">Back</a>
    <?php
    include "../databases/db.php";
    $managers_sql = "SELECT * FROM managers";
    $managers_result = $conn->query($managers_sql);
    $managers = [];
    if ($managers_result->num_rows > 0) {
        while ($row = $managers_result->fetch_assoc()) {
            $managers[] = $row;
        }
    }
    ?>
    
    <?php
    include '../databases/db.php';
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM managers WHERE id=$id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "<script>alert('No manager found with the given ID'); window.location.href='/manager/dashboard.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('No ID provided'); window.location.href='/manager/dashboard.php';</script>";
        exit();
    }
    ?>
    <form method="POST" id="add-form">
        <label for="password">Manager Password:</label>
        <input type="password" name="password" id="password" required value="<?php echo htmlspecialchars($row['password']); ?>">
        <label for="new-password">New Password:</label>
        <input type="new-password" name="new-password" id="new-password" required>
        <button type="submit" id="add-button">Change Password</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $password = $_POST['password'];
        $new_password = $_POST['new-password'];
        $sql = "UPDATE managers SET password='$new_password' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Password updated successfully'); window.location.href='/manager/dashboard.php';</script>";
        } else {
            echo "<script>alert('Error updating password: " . $conn->error . "'); window.location.href='/manager/dashboard.php';</script>";
        }
    }
    ?>
</body>
</html>