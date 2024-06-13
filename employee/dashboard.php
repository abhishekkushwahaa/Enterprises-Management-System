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

    <?php
    $page = isset($_GET['page']) ? $_GET['page'] : '';
    if ($page == "pass-change") {
        include "pass-change.php";
        exit();
    }
    ini_set('session.save_path', realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/tmp'));
    ini_set('session.gc_probability', 1);
    session_start();
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
        <button><a href="/employee/login.php">Logout</a></button>
    </nav>


    <?php
    include "../employee/leave_approve.php";
    ?>

    <?php
    include "../databases/db.php";
    $sql = "SELECT * FROM attendance WHERE employees_id = " . $_SESSION['employees_id'];
    $result = $conn->query($sql);
    $attendance = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $attendance[] = $row;
        }
    }
    $conn->close();
    ?>
    <div id="attandance-info">
        <div id="attandance">
            <h2>Attendance's Info</h2>
            <button><a href="apply-leave.php">Apply for leave</a></button>
        </div>
        <?php include "../employee/checkinout.php" ?>
        <span id="check">Maybe, You forgot to mark attendance for the following days:</span>
        <ul>
            <li onclick="openForm('<?php echo date("Y-m-d"); ?>')"><?php echo "" . date("Y-m-d") . "<br>"; ?></li>
            <li onclick="openForm('<?php echo date("Y-m-d", strtotime("-1 days")); ?>')"><?php echo "" . date("Y-m-d", strtotime("-1 days")) . "<br>"; ?></li>
            <li onclick="openForm('<?php echo date("Y-m-d", strtotime("-2 days")); ?>')"><?php echo "" . date("Y-m-d", strtotime("-2 days")) . "<br>"; ?></li>
        </ul>
    </div>

    <div class="form-popup" id="myForm">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form-container">
            <h1>Mark attendance for the selected date!</h1>
            <input type="hidden" name="status" value="Present">
            <input type="text" name="employees_id" value="<?php echo $_SESSION['employees_id']; ?>" readonly>
            <br>
            <label for="date"><b>Date</b></label>
            <input type="date" id="dateInput" name="date" required readonly> <br>
            <label for="checkin"><b>Check-in time</b></label>
            <input type="time" name="checkin">

            <label for="checkout"><b>Check-out time</b></label>
            <input type="time" name="checkout">
            <button type="submit" class="btn">Submit</button>
            <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
        </form>
    </div>

    <div id="container">
        <h3>Your Name: <span id="name"><?php echo $_SESSION['name']; ?></span></h3>
        <h3>Your Manager Email: <span id="name"><?php foreach ($managers as $manager) {
                                                    echo $manager['email'];
                                                } ?></span></h3>
        <h3>Your Email: <span id="name"><?php echo $_SESSION['email']; ?></span></h3>
    </div>
    <?php include "../employee/chart.php" ?>
    <?php
    $employee_id = $_SESSION['employees_id'];

    include "../databases/db.php";
    $sql = "SELECT photo, educational_document, previous_certificate FROM employees WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $employee = $result->fetch_assoc();

    $show_form = is_null($employee['photo']) && is_null($employee['educational_document']) && is_null($employee['previous_certificate']);

    $stmt->close();
    $conn->close();
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Fill Information</title>
    </head>

    <body>

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
    <script>
        function openForm(date) {
            document.getElementById('dateInput').value = date;
            document.getElementById("myForm").style.display = "block";
        }

        function closeForm() {
            document.getElementById("myForm").style.display = "none";
        }
    </script>
</body>

</html>