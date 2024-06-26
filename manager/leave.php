<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Leave Request</title>
   <link rel="icon" type="image/x-icon" href="public/iitspath.svg">
   <link rel="stylesheet" href="./css/employees.css">
</head>

<body>
   <div id="employees">
      <h1 id="emp">Leave Request</h1>
   </div>
   <?php
   include "../databases/db.php";

   if (isset($_POST['accepted'])) {
      $id = $_POST['id'];
      $sql = "UPDATE leave_applications SET status='Accepted' WHERE id=$id";
      $result = $conn->query($sql);
   }
   if (isset($_POST['rejected'])) {
      $id = $_POST['id'];
      $sql = "UPDATE leave_applications SET status='Rejected' WHERE id=$id";
      $result = $conn->query($sql);
   }

   $sql = "SELECT * FROM leave_applications INNER JOIN employees ON leave_applications.employees_id = employees.id WHERE employees.managers IS NOT NULL";
   $result = $conn->query($sql);

   if ($result->num_rows > 0) {
      echo "<div id='table-responsive'>";
      echo "<table><tr><th>Sr.no.</th><th>Leave applied date</th><th>Leave start date</th><th>Days of leave</th><th>Resume date</th><th>Leave of employee</th><th>Status</th><th class='action-column'>Action</th>";
      while ($row = $result->fetch_assoc()) {
         $manager_id = $row["managers"];
         $id = $_SESSION['id'];
         if($manager_id == $id) {
         echo "<tr><td>" . $row["id"] . "</td><td>" . $row["applied_date"] . "</td><td>" . $row["start_date"] . "</td><td>" . $row["days_of_leave"] . "</td><td>" . $row["resume_date"] . "</td><td>" . $row["employee_name"] . "</td><td>" . $row["status"] . "</td><td class='action-column'>";
         echo "<form method='post'>";
         echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
         echo "<button name='accepted' type='submit' id='accept'>Accept</button>";
         echo "<button name='rejected' type='submit' id='reject'>Reject</button>";
         echo "</form>";
         echo "</td></tr>";
      }
   }
      echo "</table>";
      echo "</div>";
   } else {
      echo "<h3 id='NoRecord'>No Record Found!</h3>";
   }

   $conn->close();
   ?>

</body>

</html>