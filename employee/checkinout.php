<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attendance</title>
</head>

<body>
  <?php
  include "../databases/db.php";
  error_reporting(0);
  session_start(); 
  $sql = "SELECT * FROM attendance WHERE employees_id = ? AND date = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("is", $_SESSION['employees_id'], date('Y-m-d'));
  $stmt->execute();
  $result = $stmt->get_result();
  $checked_in = false;

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['check_in'] != null) {
      $checked_in = true;
    }
    if ($row['check_out'] != null) {
      $checked_in = false;
    }
  }
  ?>

  <div id="check">
    <input type="hidden" name="employees_id" id="employees_id" value="<?php echo $_SESSION['employees_id']; ?>">
    <span id="checkStatus"><?php echo $checked_in ? 'Check in' : 'Check out'; ?></span>
    <label class="switch">
      <input type="checkbox" id="statusSwitch" <?php echo $checked_in ? 'checked' : ''; ?>>
      <span class="slider round"></span>
    </label>
    <span id="checkStatus"><?php echo $checked_in ? 'Check out' : 'Check in'; ?></span>
  </div>

  <script>
    document.getElementById("statusSwitch").addEventListener("change", function () {
      var employees_id = document.getElementById("employees_id").value;
      var status = this.checked ? "Present" : "Absent";

      var xhr = new XMLHttpRequest();
      xhr.open("POST", "update_attendance.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
          alert(xhr.responseText);
        }
      };
      xhr.send("employees_id=" + employees_id + "&status=" + status);
    });
  </script>

</body>

</html>
