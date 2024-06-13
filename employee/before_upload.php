<h1 id="fill-info">Now, fill in your information.</h1>
<div id="form-container">
    <?php
    $employee_id = $_SESSION['employees_id'];

    include "../databases/db.php";
    $sql = "SELECT * FROM employees WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $employee = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    ?>
    <form method="POST" id="info-form" enctype="multipart/form-data">
        <label for="name">Your Full Name:</label>
        <input type="text" name="name" id="full_name" required value="<?php echo $employee['name'] ?>" readonly><br><br>

        <label for="email">Your Email:</label>
        <input type="email" name="email" id="email" required value="<?php echo $employee['email'] ?>" readonly><br><br>

        <label for="phone">Your Phone Number:</label>
        <input type="text" name="phone" id="phone" required value="<?php echo $employee['phone'] ?>"><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required value="<?php echo $employee['password'] ?>" readonly><br><br>
        
        <label for="date_of_birth">Your DOB:</label>
        <input type="date" name="password" id="password" required value="<?php echo $employee['date_of_birth'] ?>"><br><br>

        <label for="salary">Your Salary:</label>
        <input type="number" name="salary" id="salary" step="0.01" required value="<?php echo $employee['salary'] ?>" readonly><br><br>

        <label for="joining_date">Your Joining Date:</label>
        <input type="date" name="joining_date" id="joining_date" required value="<?php echo $employee['joining_date'] ?>" readonly><br><br>

        <label for="designation">Your Designation:</label>
        <input type="text" name="designation" id="designation" required value="<?php echo $employee['designation'] ?>" readonly><br><br>

        <label for="photo">Your Passport size photo:</label>
        <input type="file" name="photo" id="photo" required><br><br>

        <label for="edu_document">Educational documents:</label>
        <input type="file" name="edu_document" id="edu_document" required><br><br>

        <label for="prev_certificate">Previous Organization Certificates:</label>
        <input type="file" name="prev_certificate" id="prev_certificate" required><br><br>

        <label for="managers_name">Manager's Name:</label>
        <input type="text" name="managers_name" id="managers_name" required value="<?php echo $employee['managers'] ?>" readonly><br><br>

        <button type="submit">Save Info</button>
    </form>
</div>

<div id="details-container" style="display:none;">
    <h3>Employee Details:</h3>
    <p id="employee-details"></p>
</div>

<?php
include "../databases/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $upload_dir = '../employee/uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    } else {
        chmod($upload_dir, 0777);
    }

    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $date_of_birth = $_POST['date_of_birth'] ?? null;
    $password = $_POST['password'] ?? null;
    $salary = $_POST['salary'] ?? null;
    $joining_date = $_POST['joining_date'] ?? null;
    $designation = $_POST['designation'] ?? null;
    $managers_name = $_POST['managers_name'] ?? null;

    $photo = $_FILES['photo']['name'] ?? null;
    $edu_document = $_FILES['edu_document']['name'] ?? null;
    $prev_certificate = $_FILES['prev_certificate']['name'] ?? null;

    if ($name && $email && $phone && $password && $salary && $joining_date && $designation && $managers_name) {
        $photo_target = $upload_dir . basename($photo);
        $edu_document_target = $upload_dir . basename($edu_document);
        $prev_certificate_target = $upload_dir . basename($prev_certificate);

        if (
            move_uploaded_file($_FILES['photo']['tmp_name'], $photo_target) &&
            move_uploaded_file($_FILES['edu_document']['tmp_name'], $edu_document_target) &&
            move_uploaded_file($_FILES['prev_certificate']['tmp_name'], $prev_certificate_target)
        ) {
            $sql = "UPDATE employees SET email=?, phone=?, date_of_birth=?, password=?, salary=?, joining_date=?, designation=?, photo=?, educational_document=?, previous_certificate=?, managers_name=? WHERE name=?";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($conn->error));
            }

            $stmt->bind_param("sssdsssssss", $email, $phone, $date_of_birth, $password, $salary, $joining_date, $designation, $photo, $edu_document, $prev_certificate, $managers_name, $name);

            if ($stmt->execute()) {
                echo "<script>
                    document.getElementById('form-container').style.display = 'none';
                    document.getElementById('details-container').style.display = 'block';
                    document.getElementById('employee-details').innerHTML = `
                        Name: " . htmlspecialchars($name) . "<br>
                        Email: " . htmlspecialchars($email) . "<br>
                        Phone: " . htmlspecialchars($phone) . "<br>
                        Date of Birth: " . htmlspecialchars($date_of_birth) . "<br>
                        Salary: " . htmlspecialchars($salary) . "<br>
                        Joining Date: " . htmlspecialchars($joining_date) . "<br>
                        Designation: " . htmlspecialchars($designation) . "<br>
                        Manager's Name: " . htmlspecialchars($managers_name) . "<br>
                        Photo: <a href='$photo_target' target='_blank'>" . htmlspecialchars($photo) . "</a><br>
                        Educational Document: <a href='$edu_document_target' target='_blank'>" . htmlspecialchars($edu_document) . "</a><br>
                        Previous Certificate: <a href='$prev_certificate_target' target='_blank'>" . htmlspecialchars($prev_certificate) . "</a><br>
                    `;
                </script>";
            } else {
                echo "<script>alert('Error: " . htmlspecialchars($stmt->error) . "');</script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('File upload failed.');</script>";
        }
    }

    $conn->close();
}
?>