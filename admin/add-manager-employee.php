<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Manager</title>
</head>

<body>
    <?php
    include '../databases/db.php';
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM employees WHERE id=$id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $name = $row['name'];
            $email = $row['email'];
            $phone = $row['phone'];
            $password = $row['password'];
            $salary = $row['salary'];
            $joining_date = $row['joining_date'];
            $designation = $row['designation'];
            $photo = $row['photo'];
            $educational_document = $row['educational_document'];
            $previous_certificate = $row['previous_certificate'];
            $sql = "INSERT INTO managers (id, name, email, phone, password, salary, joining_date, designation, photo, educational_document, previous_certificate) VALUES ($id, '$name', '$email', '$phone', '$password', $salary, '$joining_date', '$designation', '$photo', '$educational_document', '$previous_certificate')";
            if ($conn->query($sql) === TRUE) {
                echo "Record added successfully";
                header("Location: /admin/dashboard.php?page=employees");
                exit();
            } else {
                echo "<script>alert('Error: " . $conn->error . "');</script>";
            }
        }
    }
    ?>
</body>

</html>