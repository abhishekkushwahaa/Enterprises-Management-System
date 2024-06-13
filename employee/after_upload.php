<div>
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

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Employee Information</title>
        <style>
            .info-container {
                background-color: white;
                max-width: 980px;
                margin: 0 auto;
                margin-top: 30px;
                margin-bottom: 30px;
                padding: 20px;
                border: 1px solid white;
                border-radius: 4px;
            }

            .info-container h1 {
                text-align: center;
            }

            .info-container label {
                font-weight: bold;
            }

            .info-container p {
                margin: 5px 0 15px 0;
            }

            .documents {
                margin-bottom: 20px;
            }

            .documents ul {
                list-style: none;
                padding: 0;
            }

            .documents li {
                margin: 5px 0;
            }

            .manager-notice {
                font-size: 14px;
                color: red;
                text-align: center;

            }

            label {
                margin-left: 10px;
            }

            .documents ul li {
                margin-left: 10px;
            }

            a {
                text-decoration: none;
                color: black;
            }

            a:hover {
                color: blue;
            }
        </style>
    </head>

    <body>
        <div class="info-container">
            <?php include "./approve_docs.php" ?>
            <img src="/public/avatar.svg" alt="photo" style="width: 100px; height: 100px; margin:0 auto; display: block;">
            <p><label>Your Name:</label> <?php echo $employee['name']; ?></p>
            <p><label>Your E-Mail:</label> <?php echo $employee['email']; ?></p>
            <p><label>Your Phone Number:</label> <?php echo $employee['phone']; ?></p>
            <p><label>Your Date Of Birth:</label> <?php echo $employee['date_of_birth']; ?></p>
            <p><label>Your Salary:</label> <?php echo $employee['salary']; ?></p>
            <p><label>Your Joining Date:</label> <?php echo $employee['joining_date']; ?></p>
            <p><label>Your Designation:</label> <?php echo $employee['designation']; ?></p>

            <p><label>Your Educational Documents:</label> <a href="<?php echo '/employee/uploads/' . $employee['educational_document']; ?>" target="_blank"><?php echo $employee['educational_document']; ?></a> </p>
            <p><label>Your Previous Organization Certificates:</label> <a href="<?php echo '/employee/uploads/' . $employee['previous_certificate']; ?>" target="_blank"><?php echo $employee['previous_certificate']; ?></a> </p>
            <p><label>Your Photo:</label> <a href="<?php echo '/employee/uploads/' . $employee['photo']; ?>" target="_blank"><?php echo $employee['photo']; ?></a> </p>
            <p class="manager-notice">If you want to edit your documents, please mail your manager.</p>
        </div>

    </body>

    </html>

</div>