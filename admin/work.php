<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee's Work</title>
    <style>
        #reject {
            background-color: red;
        }

        #projectname {
            font-size: 18px;
        }
    </style>
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
    ?>
    <?php
    include "../databases/db.php";
    if (isset($_POST['accepted'])) {
        $id = $_POST['id'];
        $sql = "UPDATE work_updates SET status='Accepted' WHERE id=$id";
        $result = $conn->query($sql);
    }
    if (isset($_POST['rejected'])) {
        $id = $_POST['id'];
        $sql = "UPDATE work_updates SET status='Rejected' WHERE id=$id";
        $result = $conn->query($sql);
    }

    $sql = "SELECT work_updates.id, category, description, start_time, end_time, work_updates.status FROM  work_updates INNER JOIN employees ON work_updates.employees_id = employees.id WHERE work_updates.status='Pending' AND employees.id=$id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<form id='works' method='post'>";
            echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
            echo "<p id='projectname'>Project Name: " . $row["description"] . "(" . $row['category'] . ")" . "</p>";
            echo "<button id='accept' name='accepted' type='submit' id='accept'>Accept</button>";
            echo "<button id='reject' name='rejected' type='submit' id='reject'>Reject</button>";
            echo "</form>";
        }
    }
    echo "<script>
        document.getElementById('accept').onclick = function() {
            alert('Accepted');
        }
        document.getElementById('reject').onclick = function() {
            alert('Rejected');
        } 
            </script>"
    ?>
</body>

</html>