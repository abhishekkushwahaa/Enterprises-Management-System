<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Manager</title>
    <link rel="stylesheet" href="./css/view-employee.css">
</head>

<body>
    <div id="under-manager">
        <h1>Employees</h1>
        <div id="employees">
            <?php
            include '../databases/db.php';
            $sql = "SELECT * FROM employees WHERE managers=$id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "<table><tr><th>Id</th><th>Name</th><th>Email</th><th>View Employee</th><th>Joining Date</th><th>Edit</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    $id = $row["id"];
                    $sql_manager = "SELECT id FROM managers WHERE id=$id";
                    $result_manager = $conn->query($sql_manager);
                    $is_manager = $result_manager->num_rows > 0 ? true : false;
                    echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["email"] . "</td><td><a id='view' href='?page=view-employee&id=" . $row["id"] . "'>View</a></td><td>" . $row["joining_date"] . "</td>";

                    echo "</td><td><a id='edit' href='?page=edit-employee&id=" . $row["id"] . "'>Edit</a></td></tr>";
                }
                echo "</table>";
            } else {
                echo "<h3 id='NoRecord'>No Record Found!</h3>";
            }

            $conn->close();
            ?>
        </div>
    </div>

</body>

</html>