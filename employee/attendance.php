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
            <button><a id="leave-apply" href="apply-leave.php">Apply for leave</a></button>
        </div>
        <?php include "../employee/checkinout.php" ?>
        <span id="check">Maybe, You forgot to mark attendance for the following days:</span>
        <?php include "../employee/attendance-form.php" ?>
        <ul>
            <?php
            $dates = [date("Y-m-d"), date("Y-m-d", strtotime("-1 days")), date("Y-m-d", strtotime("-2 days"))];

            foreach ($dates as $date) {
                $hasCheckOut = false;
                foreach ($attendance as $record) {
                    if ($record['date'] == $date && !empty($record['check_out'])) {
                        $hasCheckOut = true;
                        break;
                    }
                }
                if (!$hasCheckOut) {
                    echo "<li onclick=\"openForm('$date')\">$date<br></li>";
                }
            }
            ?>
        </ul>
    </div>
</body>

</html>