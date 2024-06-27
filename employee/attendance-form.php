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

<div class="form-popup" id="myForm">
    <form action="./forget-attendance.php" method="POST" class="form-container">
        <h1>Mark attendance for the selected date!</h1>
        <input type="hidden" name="status" value="Present">
        <input type="hidden" name="employees_id" value="<?php echo $_SESSION['employees_id']; ?>" readonly>
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