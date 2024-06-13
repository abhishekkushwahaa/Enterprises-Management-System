<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/work.css">
    <title>Work</title>
</head>
<?php
include "../databases/db.php";
if (isset($_SESSION['employees_id'])) {
    $employees_id = $_SESSION['employees_id'];
}

$sql = "SELECT * FROM employees WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $employees_id);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<body>
    <h1 id="workh1">Your work updates!</h1>
    <div id="work-update-project">
        <div id="house">
            <h2>In House</h2>
            <?php
            include "../databases/db.php";
            date_default_timezone_set('Asia/Kolkata');
            $employee_id = $_SESSION['employees_id'];
            $sql = "SELECT id, employees_id, category, date, description, DATE_FORMAT(start_time, '%l:%i %p') as start_time, DATE_FORMAT(end_time, '%l:%i %p') as end_time, status FROM work_updates WHERE employees_id = $employee_id ORDER BY category DESC";
            $result = $conn->query($sql);

            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if($row['category'] == 'inhouse'){
                    echo "<h2>" . $row["status"] . "</h2>";
                    echo "<p>" . $row['date'] . "," . $row['start_time'] . "-" . $row['end_time'] . ": " . $row['description'] . "</p>";
                    }
                }
            }
            $conn->close();
            ?>
        </div>
        <div id="client">
            <h2>Client Based</h2>
            <?php
            include "../databases/db.php";
            date_default_timezone_set('Asia/Kolkata');
            $employee_id = $_SESSION['employees_id'];

            $sql = "SELECT id, employees_id, category, date, description, DATE_FORMAT(start_time, '%l:%i %p') as start_time, DATE_FORMAT(end_time, '%l:%i %p') as end_time, status FROM work_updates WHERE employees_id = $employee_id ORDER BY category DESC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if($row['category'] == 'clientbased'){
                    echo "<h2>" . $row["status"] . "</h2>";
                    echo "<p>" . $row['date'] . "," . $row['start_time'] . "-" . $row['end_time'] . ": " . $row['description'] . "</p>";
                    }
                }
            }
            $conn->close();
            ?>
        </div>
        <div id="learning">
            <h2>Learning</h2>
            <?php
            date_default_timezone_set('Asia/Kolkata');
            include "../databases/db.php";
            $employee_id = $_SESSION['employees_id'];
            $sql = "SELECT id, employees_id, category, date, description, DATE_FORMAT(start_time, '%l:%i %p') as start_time, DATE_FORMAT(end_time, '%l:%i %p') as end_time, status FROM work_updates WHERE employees_id = $employee_id ORDER BY category DESC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if($row['category'] == 'learning'){
                    echo "<h2>" . $row["status"] . "</h2>";
                    echo "<p>" . $row['date'] . "," . $row['start_time'] . "-" . $row['end_time'] . ": " . $row['description'] . "</p>";
                    }
                }
            }
            $conn->close();
            ?>
        </div>
    </div>

    <?php
    include "../databases/db.php";
    date_default_timezone_set('Asia/Kolkata');
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $employees_id = $_POST['employees_id'] ?? null;
        $date = $_POST['date'] ?? null;
        $work_categories = $_POST['work'] ?? [];

        foreach ($work_categories as $category) {
            $start_time = $_POST[$category . '-time'][0] ?? null;
            $end_time = $_POST[$category . '-time'][1] ?? null;
            $description = $_POST[$category . '-description'] ?? null;

            if ($start_time === null || $end_time === null || $description === null) {
                echo "<script>alert('All fields are required. Please fill out all fields.');</script>";
                return;
            }

            $sql = "INSERT INTO work_updates (employees_id, date, category, start_time, end_time, description) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isssss", $employees_id, $date, $category, $start_time, $end_time, $description);
            $stmt->execute();
        }

        $stmt->close();
        $conn->close();
        echo "<script>alert('Work update submitted successfully');</script>";
    }
    ?>
    <div id="work-update">
        <h1>Provide Your Update</h1>
        <form action="" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="employees_id" value="<?php echo $employees_id ?>">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required><br><br>
            <label for="select-work">Work categories (You can select multiple):</label>
            <select name="work[]" id="select-work" multiple required>
                <option value="inhouse">In House</option>
                <option value="clientbased">Client Based</option>
                <option value="learning">Learning</option>
            </select><br><br>

            <div id="work-details-container"></div>

            <button type="submit" id="submit">Submit Update</button>
        </form>

    </div>
    <script>
        const selectWork = document.getElementById('select-work');
        const workDetailsContainer = document.getElementById('work-details-container');

        selectWork.addEventListener('change', () => {
            workDetailsContainer.innerHTML = '';
            Array.from(selectWork.selectedOptions).forEach(option => {
                const workDetails = document.createElement('div');
                workDetails.classList.add('work-details');
                workDetails.innerHTML = `
                    <div id='dynamic'>
                    <h3>${option.text}</h3>
                    <div id="work-time">
                        <label for="${option.value}-time">From</label>
                        <input type="time" id="${option.value}-time" name="${option.value}-time" required>
                        <label for="${option.value}-time">To</label>
                        <input type="time" id="${option.value}-time" name="${option.value}-time" required>
                    </div>
                    <textarea placeholder="Provide your work update for ${option.text} Project!" id="${option.value}-description" name="${option.value}-description" required></textarea><br>
                    </div>
                `;
                workDetailsContainer.appendChild(workDetails);
            });
        });
    </script>
</body>

</html>