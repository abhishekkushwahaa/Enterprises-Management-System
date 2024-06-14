<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Side</title>
    <link rel="icon" type="image/x-icon" href="public/iitspath.svg">
    <link rel="stylesheet" type="text/css" href="./css/dashboard.css">
</head>

<body>
    <nav>
        <?php
        include "../databases/db.php";
        $sql = "SELECT id, name, email, password FROM managers";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '
        <nav>
            <a href="/manager/dashboard.php">
                <img src="/public/iitspath.svg" alt="logo" id="logo">
            </a>
            <h2>Welcome, <span id="welcome">' . (isset($row['name']) ? $row['name'] : 'Guest') . '</span>!</h2>
            <span><a id="change-pass" href="?page=pass-change&id=' . (isset($row['id']) ? $row['id'] : '') . '">Change Password</a></span>
            <button><a href="/manager/login.php">Logout</a></button>
        </nav>';
            }
        } else {
            echo "<script>alert('No manager found!')</script>";
        }
        ?>
    </nav>
    <div class="container">
        <div class="box1">
            <ul><a href="?page=dashboard">Dashboard</a></ul>
            <ul><a href="?page=employees">Employees</a></ul>
            <ul><a href="?page=leave">Leave Request</a></ul>
        </div>
        <div class="box2">
            <?php
            $page = isset($_GET['page']) ? $_GET['page'] : '';
            if ($page == "dashboard") {
                echo "<h1 id='box2-content'>You can't add employees, you can just take an action on their documents status.</h1>";
            } elseif ($page == "employees") {
                include "employees.php";
            } elseif ($page == "leave") {
                include "leave.php";
            } elseif ($page == "profile") {
                include "profile.php";
            } elseif ($page == "view-employee") {
                include "view-employee.php";
            } elseif ($page == "pass-change") {
                include "pass-change.php";
            } else {
                echo "<h1 id='box2-content'>You can't add employees, you can just take an action on their documents status.</h1>";
            }
            ?>
        </div>
    </div>

</body>

</html>