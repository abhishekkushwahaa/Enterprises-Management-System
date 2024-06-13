<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $manager_id = $_POST['managers'];

        $sql = "INSERT INTO employees (name, email, password, salary, joining_date, designation, manager_id) VALUES ('$name', '$email', '$password', '$salary', '$joining_date', '$designation', '$manager_id')";
    }
    ?>
    <form method="POST" id="add-form">
        <label for="name">Employee Full Name:</label>
        <input type="text" name="name" id="name" required>
        <label for="email">Employee Email:</label>
        <input type="email" name="email" id="email" required>
        <label for="password">Employee Password:</label>
        <input type="password" name="password" id="password" required>
        <label for="role">Employee Salary(in Rs.):</label>
        <input type="number" name="salary" id="salary" required>
        <label for="joining_date">Employee Joining Date:</label>
        <input type="date" name="joining_date" id="joining_date" required>
        <label for="designation">Employee Designation:</label>
        <input type="text" name="designation" id="designation" required>
        <label for="managers">Employee's manager:</label>
        <select name="managers" id="managers">
            <option value="">Select Manager</option>
            <?php foreach ($managers as $manager) : ?>
                <option value="<?php echo $manager['id']; ?>"><?php echo $manager['name']; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" id="add-button">Add Employee</button>
    </form>
    <?php
    include "../databases/db.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $salary = $_POST['salary'];
        $joining_date = $_POST['joining_date'];
        $designation = $_POST['designation'];
        $manager_name = $_POST['managers'];

        $sql = "INSERT INTO employees (name, email, password, salary, joining_date, designation, managers) VALUES ('$name', '$email', '$password', '$salary', '$joining_date', '$designation', '$manager_name')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Employee added successfully!');</script>";
            header("Location: ?page=employees");
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }
    ?>
</body>

</html>
