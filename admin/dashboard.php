<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Side</title>
    <link rel="icon" type="image/x-icon" href="public/iitspath.svg">
    <link rel="stylesheet" type="text/css" href="./css/dashboard.css">
</head>

<body>
    <nav>
        <a href="/admin/dashboard.php">
            <img src="/public/iitspath.svg" alt="logo" id="logo">
        </a>
        <h2>Welcome, Admin!</h2>
        <img src="../public/menu.svg" alt="menu" id="navbar-icon">
        <button id="logout"><a href="/admin/login.php">Logout</a></button>
    </nav>
    <div class="container">
        <div class="box1">
            <ul><a href="?page=dashboard">Dashboard</a></ul>
            <ul><a href="?page=managers">Managers</a></ul>
            <ul><a href="?page=employees">Employees</a></ul>
            <ul><a href="?page=leave">Leave Request</a></ul>
            <ul><a href="?page=profile">Edit Profile</a></ul>
            <ul><a href="?page=updates">Updates</a></ul>
        </div>
        <div class="box2">
            <?php
            $page = isset($_GET['page']) ? $_GET['page'] : '';
            if ($page == "dashboard") {
                echo "<h1 id='box2-content'>You have all the rights to add employees and managers.</h1>";
            } elseif ($page == "managers") {
                include "managers.php";
            } elseif ($page == "employees") {
                include "employees.php";
            } elseif ($page == "leave") {
                include "leave.php";
            } elseif ($page == "profile") {
                include "profile.php";
            } elseif ($page == "add-employee") {
                include "add-employee.php";
            } elseif ($page == "edit-employee") {
                include "edit-employee.php";
            } elseif ($page == "delete-employee") {
                include "delete-employee.php";
            } elseif ($page == "view-employee") {
                include "view-employee.php";
            } elseif ($page == "view-manager") {
                include "view-manager.php";
            } elseif ($page == "add-manager-employee") {
                include "add-manager-employee.php";
            } elseif ($page == "remove-manager-employee") {
                include "remove-manager-employee.php";
            } elseif ($page == "edit-managers") {
                include "edit-manager.php";
            } elseif ($page == "updates") {
                include "updates.php";
            } elseif ($page == "file-delete") {
                include "file-delete.php";
            } else {
                echo "<h1 id='box2-content'>You have all the rights to add employees and managers.</h1>";
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