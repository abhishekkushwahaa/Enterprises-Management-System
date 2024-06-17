<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Side</title>
    <link rel="icon" type="image/x-icon" href="public/iitspath.svg">
    <link rel="stylesheet" type="text/css" href="./css/dashboard.css">
</head>
<body>
    <?php include "./manager-session.php" ?>
    <?php include "./navbar.php" ?>
    <?php include "./leave_approve.php";?>
    <?php include "./attendance.php" ?>
    <?php include "./manager.php" ?>
    <?php include "../employee/chart.php" ?>
    <?php include "./employee-session.php" ?>
    <?php if ($show_form) : ?>
        <div id="form-container">
            <?php
            include "../employee/before_upload.php"
            ?>
        </div>
    <?php else : ?>
        <?php include "../employee/after_upload.php" ?>
    <?php endif; ?>
    <?php include "./work.php" ?>
</body>

</html>