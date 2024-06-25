<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Details</title>
    <link rel="stylesheet" type="text/css" href="./css/dashboard.css">
</head>

<body>
    <?php
    $page = isset($_GET['page']) ? $_GET['page'] : '';
    if ($page == "pass-change") {
        include "pass-change.php";
        exit();
    }
    include "../databases/db.php";
    $employees_sql = "SELECT * FROM employees WHERE id = $employee_id";
    $employees_result = $conn->query($employees_sql);
    if ($employees_result && $employees_result->num_rows > 0) {
        $employee = $employees_result->fetch_assoc();
        $manager_id = $employee['managers'] ?? '0';

        if ($manager_id !== '0') {
            $stmt = $conn->prepare("SELECT * FROM managers WHERE id = ?");
            $stmt->bind_param("i", $manager_id); 
            $stmt->execute();
            $manager_result = $stmt->get_result();

            if ($manager_result && $manager_result->num_rows > 0) {
                $manager = $manager_result->fetch_assoc();
                $manager_email = $manager['email'];
            } else {
                $manager_email = "N/A";
            }
        } else {
            $manager_email = "No Manager Assigned";
        }
    } else {
        echo "Employee not found or query failed.";
        $manager_email = "N/A"; 
    }
    ?>
    <div id="container">
        <h3>Your Name: <span id="name"><?php echo $_SESSION['name']; ?></span></h3>
        <h3>Your Email: <span id="name"><?php echo $_SESSION['email']; ?></span></h3>
        <?php
        echo "<h3>Manager Email: <span id='name'>$manager_email</span></h3>";
        ?>
    </div>
</body>

</html>