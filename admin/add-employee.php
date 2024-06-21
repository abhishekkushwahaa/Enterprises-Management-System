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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isValidate = true;
    $name = $_POST['name'];
    if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
        echo "<script>alert('Only letters and white space allowed in name');</script>";
        $isValidate = false;
    }
    $email = $_POST['email'];
    $pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    if (!preg_match($pattern, $email)) {
        echo "<script>alert('Invalid email format');</script>";
        $isValidate = false;
    }
    $password = $_POST['password'];
    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
    if (!preg_match($pattern, $password)) {
        echo "<script>alert('Password must contain at least one number, one uppercase letter, one lowercase letter, one special character and at least 8 characters long');</script>";
        $isValidate = false;
    }
    $salary = $_POST['salary'];
    $joining_date = $_POST['joining_date'];
    $designation = $_POST['designation'];
    $manager_id = $_POST['managers'];

    if ($isValidate) {
        $sql = "INSERT INTO employees (name, email, password, salary, joining_date, designation, managers) 
            VALUES ('$name', '$email', '$password', '$salary', '$joining_date', '$designation', '$manager_id')";
        if ($conn->query($sql) === TRUE) {
            include "mail.php";
            $message = "Dear $name, you have been added as an employee in our company. Your login credentials are: \nEmail: $email \nPassword: $password";
            sendEmail($env, $email, $message);
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Validation failed');</script>";
    }
}

$conn->close();
?>
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
    <form method="POST" id="add-form">
        <label for="name">Employee Full Name:</label>
        <input type="text" name="name" id="name" required>
        <label for="email">Employee Email:</label>
        <input type="email" name="email" id="email" required>
        <label for="password">Employee Password:</label>
        <input type="password" name="password" id="password" required>
        <label for="salary">Employee Salary(in Rs.):</label>
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
</body>

</html>