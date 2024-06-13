<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>attendance</title>
</head>

  <body>
    <?php
    include "../databases/db.php";
    date_default_timezone_set('Asia/Kolkata');
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $employees_id = $_POST['employees_id'] ?? null;
      $status = $_POST['status'] ?? 'Absent';
      $date = date('Y-m-d');
      $current_datetime = date('Y-m-d H:i:s');
      $check_in = null;
      $check_out = null;

      $sql_check = "SELECT * FROM attendance WHERE employees_id = ? AND date = ?";
      $stmt_check = $conn->prepare($sql_check);
      $stmt_check->bind_param("is", $employees_id, $date);
      $stmt_check->execute();
      $result_check = $stmt_check->get_result();

      if ($result_check->num_rows > 0) {
        $row = $result_check->fetch_assoc();
        if ($status == 'Present') {
          $check_in = $current_datetime;
          $sql_update = "UPDATE attendance SET check_in = ?, status = ? WHERE employees_id = ? AND date = ?";
          $stmt_update = $conn->prepare($sql_update);
          $stmt_update->bind_param("ssis", $check_in, $status, $employees_id, $date);
          $stmt_update->execute();
        } else {
          $sql_check = "SELECT status FROM attendance WHERE employees_id = ? AND date = ?";
          $stmt_check = $conn->prepare($sql_check);
          $stmt_check->bind_param("is", $employees_id, $date);
          $stmt_check->execute();
          $stmt_check->bind_result($existing_status);
          $stmt_check->fetch();
          $stmt_check->close();

          $check_out = $current_datetime;

          if ($existing_status == 'Present') {
            $sql_update = "UPDATE attendance SET check_out = ? WHERE employees_id = ? AND date = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("sis", $check_out, $employees_id, $date);
            $stmt_update->execute();
          } else {
            $sql_update = "UPDATE attendance SET check_out = ?, status = ? WHERE employees_id = ? AND date = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("ssis", $check_out, $status, $employees_id, $date);
            $stmt_update->execute();
          }
        }
        echo "<script>alert('Attendance updated successfully');</script>";
      } else {
        $sql_insert = "INSERT INTO attendance (employees_id, date, check_in, check_out, status)
        VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("issss", $employees_id, $date, $check_in, $check_out, $status);
        $stmt_insert->execute();
        echo "<script>alert('Attendance recorded successfully');</script>";
      }

      if (isset($stmt_insert)) {
        $stmt_insert->close();
      }
    }

    $conn->close();
    ?>

    <form id="attendanceForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <div id="check">
        <input type="hidden" name="employees_id" value="<?php echo $_SESSION['employees_id']; ?>">
        <input type="hidden" id="statusField" name="status">
        <span id="checkStatus">Check out</span>
        <label class="switch">
          <input type="checkbox" id="statusSwitch">
          <span class="slider round"></span>
        </label>
        <span id="checkStatus">Check in</span>
        <button id="attendbtn" type="submit">Submit</button>
      </div>
    </form>
    <script>
      document.getElementById("attendbtn").addEventListener("click", function() {
        var status = document.getElementById("statusSwitch").checked ? "Present" : "Absent";
        document.getElementById("statusField").value = status;
        console.log("Submitting form");
        document.getElementById("attendanceForm").submit();
      });
    </script>
  </body>

  </html>
</body>