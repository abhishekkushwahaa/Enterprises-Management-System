<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Manager</title>
   <link rel="icon" type="image/x-icon" href="public/iitspath.svg">
   <link rel="stylesheet" href="./css/employees.css">
</head>
<body>
   <div id="employees">
      <h1 id="emp">Managers</h1>
   </div>
   <?php
      include "../databases/db.php";
      $sql = "SELECT id, name, email, password, joining_date FROM managers";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
            echo "<div id='table-responsive'>";
          echo "<table><tr><th>Id</th><th>Name</th><th>Email</th><th>View info and employees under this manager</th><th>Joining Date</th><th>Remove Manager</th><th>Edit</th>";
          while($row = $result->fetch_assoc()) {
              echo "<tr><td>" . $row["id"]. "</td><td>" . $row["name"] . "</td><td>" . $row["email"]. "</td><td><a id='view' href='?page=view-manager&id=".$row["id"]."'>View</a></td><td>" . $row["joining_date"]. "</td><td><a id='delete' href='?page=remove-manager-employee&id=".$row["id"]."'>Remove From Manager</a></td><td><a id='edit' href='?page=edit-managers&id=".$row["id"]."'>Edit</a></td></tr>";
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