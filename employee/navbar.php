<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link rel="stylesheet" type="text/css" href="./css/dashboard.css">
</head>
<body>
    <?php
    include "../databases/db.php";

    if (!isset($_SESSION['employees_id'])) {
        header("Location: login.php");
        exit;
    }
    ?>
    <nav>
        <a href="/employee/dashboard.php">
            <img src="/public/iitspath.svg" alt="logo" id="logo">
        </a>
        <h2>Welcome, <span id="welcome"><?php echo $_SESSION['name']; ?></span>!</h2>
        <span><a id="change-pass" href='?page=pass-change&id=<?php echo $_SESSION['employees_id']; ?>'>Change Password</a></span>
        <button><a id="logout-button" href="/employee/login.php">Logout</a></button>
    </nav>
</body>

</html>