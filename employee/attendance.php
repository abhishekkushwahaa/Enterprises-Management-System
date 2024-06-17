<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/dashboard.css">
    <title>Attendance</title>
</head>

<body>
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
        <form action="" method="POST" class="form-container">
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