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
    <button id="back"><a href="?page=employees">Back</a></button>
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
        $sql = "SELECT * FROM employees WHERE id=$id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "<script>alert('No employee found with the given ID'); window.location.href='?page=employees';</script>";
            exit();
        }
    } else {
        echo "<script>alert('No ID provided'); window.location.href='?page=employees';</script>";
        exit();
    }
    ?>
    <form method="POST" id="add-form">
        <label for="name">Employee Full Name:</label>
        <input type="text" name="name" id="name" required value="<?php echo htmlspecialchars($row['name']); ?>">
        <label for="email">Employee Email:</label>
        <input type="email" name="email" id="email" required value="<?php echo htmlspecialchars($row['email']); ?>">
        <label for="password">Employee Password:</label>
        <input type="password" name="password" id="password" required value="<?php echo htmlspecialchars($row['password']); ?>">
        <label for="salary">Employee Salary(in Rs.):</label>
        <input type="number" name="salary" id="salary" required value="<?php echo htmlspecialchars($row['salary']); ?>">
        <label for="joining_date">Employee Joining Date:</label>
        <input type="date" name="joining_date" id="joining_date" required value="<?php echo htmlspecialchars($row['joining_date']); ?>">
        <label for="designation">Employee Designation:</label>
        <input type="text" name="designation" id="designation" required value="<?php echo htmlspecialchars($row['designation']); ?>">
        <label for="managers">Employee's manager:</label>
        <select name="managers" id="managers">
            <option value=""><?php echo htmlspecialchars($row['name']); ?></option>
            <?php foreach ($managers as $manager) : ?>
                <option value="<?php echo $manager['id']; ?>"><?php echo $manager['name']; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" id="add-button">Update Employee</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $salary = $_POST['salary'];
        $joining_date = $_POST['joining_date'];
        $designation = $_POST['designation'];
        $managers = $_POST['managers'];

        $sql = "UPDATE employees SET name='$name', email='$email', password='$password', salary='$salary', joining_date='$joining_date', designation='$designation', managers='$managers' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Employee updated successfully'); window.location.href='?page=employees';</script>";
            exit();
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }
    ?>

</body>
</html>