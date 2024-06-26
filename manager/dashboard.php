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
    <?php
    include "./manager-session.php";
    ?>
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
            } elseif ($page == "edit-employee") {
                include "edit-employee.php";
            } elseif ($page == "pass-change") {
                include "pass-change.php";
            } else {
                echo "<h1 id='box2-content'>You can't add employees, you can just take an action on their documents status.</h1>";
            }
            ?>
        </div>
    </div>
    <script>
        document.getElementById("navbar-icon").addEventListener("click", function() {
            var box1 = document.querySelector(".box1");
            if (box1.style.display === "none") {
                box1.style.display = "block";
            } else {
                box1.style.display = "none";
            }

            var logout = document.getElementById("logout");
            if (logout.style.display === "none") {
                logout.style.display = "block";
            } else {
                logout.style.display = "none";
            }
        });
    </script>
</body>

</html>