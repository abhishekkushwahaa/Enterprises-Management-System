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
    $managers_sql = "SELECT * FROM managers";
    $managers_result = $conn->query($managers_sql);
    $managers = [];
    if ($managers_result->num_rows > 0) {
        while ($row = $managers_result->fetch_assoc()) {
            $managers[] = $row;
        }
    }
    $manager_email = 'N/A';
    ?>
    <div id="container">
        <h3>Your Name: <span id="name"><?php echo $_SESSION['name']; ?></span></h3>
        <h3>Your Manager Email: <span id="name"><?php foreach ($managers as $manager) {
                                                    echo $manager['email'];
                                                } ?></span></h3>
        <h3>Your Email: <span id="name"><?php echo $_SESSION['email']; ?></span></h3>
    </div>
</body>

</html>