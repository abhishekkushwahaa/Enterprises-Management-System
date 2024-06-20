<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="./css/chart.css" />
</head>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<body>
  <h1 id="heading">Your work percentage of previous 5 years!</h1>
  <div id="container-chart">
    <?php
    include "../databases/db.php";
    $sql = "SELECT COUNT(*) as total FROM work_updates WHERE employees_id = " . $_SESSION['employees_id']." AND date >= DATE_SUB(NOW(), INTERVAL 5 YEAR)";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $total_work_updates = $row['total'];

    $sql = "SELECT DISTINCT category FROM work_updates WHERE employees_id = " . $_SESSION['employees_id'];
    $result = $conn->query($sql);
    $categories = [];
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $categories[] = $row['category'];
      }
    }

    $work_percentages = [];
    foreach ($categories as $category) {
      $sql = "SELECT COUNT(*) as count FROM work_updates WHERE status='Accepted' AND category='" . $category . "' AND employees_id=" . $_SESSION['employees_id'] ;
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      $work_percentages[$category] = round($row['count'] / $total_work_updates * 100);
    }

    $conn->close();
    ?>
  </div>

  <script>
    google.charts.load("current", {
      packages: ["corechart"]
    });
    google.charts.setOnLoadCallback(activityChart);

    function activityChart() {
      const data = google.visualization.arrayToDataTable([
        ["Activity", "Percentage"],
        <?php
        foreach ($work_percentages as $category => $percentage) {
          echo '["' . $category . '", ' . $percentage . '],';
        }
        ?>
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