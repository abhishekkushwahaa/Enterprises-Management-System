<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="./css/chart.css" />
</head>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<body>
  <h1 id="heading">Your work percentage of previous 5 years!</h1>
  <div id="container-chart"></div>
  <?php
  include "../databases/db.php";
  $sql = "SELECT * FROM attendance WHERE employees_id = " . $_SESSION['employees_id'];
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $attendance = $row;
    }
  }

  $sql = "SELECT ROUND((SELECT COUNT(*) FROM attendance WHERE status='present' AND employees_id=" . $_SESSION['employees_id'] . ") / (SELECT COUNT(*) FROM attendance WHERE employees_id=" . $_SESSION['employees_id'] . ") * 100) AS present_percentage";
  $result_percentage = $conn->query($sql);
  $present_percentage = 0;
  if ($result_percentage->num_rows > 0) {
    $row_percentage = $result_percentage->fetch_assoc();
    $present_percentage = $row_percentage['present_percentage'];
  }

  $conn->close();
  ?>
  
  <script>
    google.charts.load("current", {
      packages: ["corechart"]
    });
    google.charts.setOnLoadCallback(activityChart);

    function activityChart() {
      const data = google.visualization.arrayToDataTable([
         ["Activity", "Percentage"],
         ["Present", <?php echo $present_percentage; ?>],
         ["Absent", <?php echo 100 - $present_percentage; ?>],
      ]);

      const options = {
        title: "My Daily Activities",
      };

      const chart = new google.visualization.PieChart(
        document.getElementById("container-chart")
      );
      chart.draw(data, options);
    }
  </script>
</body>

</html>