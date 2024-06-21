<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Employee</title>
    <link rel="stylesheet" href="./css/view-employee.css">
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
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['accepted'])) {
            $id = $_POST['id'];
            $sql = "UPDATE employees SET status='Accepted' WHERE id=$id";
            $result = $conn->query($sql);
        }
        if (isset($_POST['rejected'])) {
            $id = $_POST['id'];
            $sql = "UPDATE employees SET status='Rejected' WHERE id=$id";
            $result = $conn->query($sql);
        }
    }
    ?>

    <div id="file_panding">
            <?php
            if($row['status'] == 'Pending'){
            echo "<h3>This Employee Doc's Status is". " ". $row['status'] . ", You can contact with thier Manager!"."</h3>";
            } else {
            echo "<h3>Employee All Documents uploaded, You can check!</h3>";
            }
            ?>
    </div>

    <div id="Info">
        <h1>Employee's Info</h1>
        <h3>Name: <span><?php echo htmlspecialchars($row['name']); ?></span></h3>
        <h3>Designation: <span><?php echo htmlspecialchars($row['designation']); ?></span></h3>
        <h3>E-mail: <span><?php echo htmlspecialchars($row['email']); ?></span></h3>
        <h3>Phone: <span><?php echo htmlspecialchars($row['phone']); ?></span></h3>
        <h3>DOB: <span><?php echo htmlspecialchars($row['date_of_birth']); ?></span></h3>
        <h3>Salary: <span><?php echo htmlspecialchars($row['salary']); ?></span></h3>
        <h3>Joininig Date: <span><?php echo htmlspecialchars($row['joining_date']); ?></span></h3>
    </div>

    <div id="Info-Docs">
        <h1>Employee's Documents</h1>
        <?php 
        if($row['photo'] == null){
            echo "<img src='../public/avatar.svg' alt='photo'>";
        } else {
            echo "<img src='/employee/uploads/" . $row['photo'] . "' alt='photo'>";
        }
        ?>
        <p><label>Your Educational Documents:</label> <a href="<?php echo '/employee/uploads/' . $row['educational_document']; ?>" target="_blank"><?php echo $row['educational_document']; ?></a> </p>
        <p><label>Your Previous Organization Certificates:</label> <a href="<?php echo '/employee/uploads/' . $row['previous_certificate']; ?>" target="_blank"><?php echo $row['previous_certificate']; ?></a> </p>
        <p><label>Your Photo:</label> <a href="<?php echo '/employee/uploads/' . $row['photo']; ?>" target="_blank"><?php echo $row['photo']; ?></a> </p>
    </div>
    
    <h1 id="attendance-h1">Employee's Attendance

        <?php include "./attendance.php" ?>
    </h1>
    <h1 id="attendance-h1">Employee's Works
        <?php include "./work.php" ?>
    </h1>

</body>

</html>